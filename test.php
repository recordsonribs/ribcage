<?php
// Bring in the database settings from Wordpress.
require_once(dirname(__FILE__) . '/wp-config.php');

$user = DB_USER;
$password = DB_PASSWORD;
$database = DB_NAME;
$server = DB_HOST;

?>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Add Release</title>
</head>
<body>	
		<h1>Add Release</h1>
	<?php
	if (isset($_POST['musicbrainz_id'])) {
		require_once dirname(__FILE__) . '/wp-content/plugins/ribcage/ribcage-includes/phpbrainz/phpBrainz.class.php';
		?>
		<p>Looking up Musicbrainz ID</p> 
		<?php
		global $release;
		
		$mbid = $_POST['musicbrainz_id'];
		
		mysql_connect($server,$user,$password);
		@mysql_select_db($database) or die(mysql_error());
		
		if ($_POST['release_slug'] != NULL) {
			$release['release_slug'] = $_POST['release_slug'];
		}
		
		if ($_POST['release_id'] != NULL) {
			$release['release_id'] = $_POST['release_id'];
		}

		mb_get_release($mbid);
		
		$artist_slug = get_artist_slug_by_id($release['release_artist']);
		
		echo "<p>Guessing a load of stuff.</p>";
		
		// Guess where all the other stuff is.
		$release = array_merge($release,array(
			'release_cover_image_tiny' => 'http://recordsonribs.com/images/covers/tiny/'.$release['release_slug'].'.jpg',
			'release_cover_image_large' => 'http://recordsonribs.com/images/covers/large/'.$release['release_slug'].'.jpg',
			'release_cover_image_huge' => 'http://recordsonribs.com/images/covers/huge/'.$release['release_slug'].'.jpg',
			'release_mp3' => '/files/audio/'.$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-mp3.zip',
			'release_ogg' => '/files/audio/'.$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-ogg.zip',
			'release_flac' => '/files/audio/'.$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-flac.zip',
			));
		
		// Add the other submitted fields.
		$release['release_torrent_mp3'] = $_POST['release_torrent_mp3'];
		$release['release_torrent_ogg'] = $_POST['release_torrent_ogg'];
		$release['release_torrent_flac'] = $_POST['release_torrent_flac'];
		
		// Don't worry. addslashes is run automatically on $_POST
		$release['release_blurb_short'] = $_POST['release_blurb_short'];
		$release['release_blurb_long'] = $_POST['release_blurb_long'];
		
		$tracks = $release['release_tracks'];
		unset($release['release_tracks']);
		
		$release['release_title'] = mysql_real_escape_string($release['release_title']);
		
		print_r($release);
		$string_keys = implode(array_keys($release),",");
		$string_values = "'".implode(array_values($release),"','")."'";
		
		$query =" 
		INSERT INTO wp_ribcage_releases 
		($string_keys)
		VALUES
		($string_values)
		";
		
		mysql_query($query) or die(mysql_error());
		
		foreach ($tracks as $tr) {
			$tr['track_title'] = mysql_real_escape_string($tr['track_title']);
			$string_keys = implode(array_keys($tr),",");
			$string_values = "'".implode(array_values($tr),"','")."'";
			
			$query =" 
			INSERT INTO wp_ribcage_tracks 
			($string_keys)
			VALUES
			($string_values)
			";
			
			mysql_query($query) or die(mysql_error());
		}
		
		mysql_close();
		
		echo "<p>Done</p>";
		
		?>
		<pre><?php print_r($release)?>
		<?php print_r($tracks)?></pre>
		<?php
		
	}

	else {
	?>
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<p>Please enter the <a href="http://musicbrainz.org">Musicbrainz</a> ID and Ribcage will lookup the release and fill in the details automatically. This should be the Musicbrainz ID of the specific release, not the release group.</p>
		<p>Use with extreme caution. There is no error protection.</p>
		<table>
		<tr valign="top">
		<th scope="row"><label for="musicbrainz">Musicbrainz ID</label></th>
		<td><input type="text" name="musicbrainz_id" value="" class="regular-text code"/></td>
		</tr>
		<tr>
		<th scope="row"><label for="release_slug">Release Slug (if you don't want it automatically detected)</label></th>
		<td><input type="text" name="release_slug" value="" class="regular-text code"/></td>
		</tr>
		<tr>
			<tr>
			<th scope="row"><label for="release_id">Release ID (if you don't want it automatically detected)</label></th>
			<td><input type="text" name="release_id" value="" class="regular-text code"/></td>
			</tr>
			<tr>
		<th scope="row"><label for="release_torrent_mp3">Torrent MP3</label></th>
		<td><input type="text" name="release_torrent_mp3" value="" class="regular-text code"/></td>
		</tr>
		<tr>
		<th scope="row"><label for="release_torrent_ogg">Torrent Ogg</label></th>
		<td><input type="text" name="release_torrent_ogg" value="" class="regular-text code"/></td>
		</tr>
		<tr>
		<th scope="row"><label for="release_torrent_flac">Torrent FLAC</label></th>
		<td><input type="text" name="release_torrent_flac" value="" class="regular-text code"/></td>
		</tr>
		<tr>
		<th scope="row"><label for="release_blurb_short">Release Blurb Short</label></th>
		<td><textarea rows="10" cols="100" name="release_blurb_short" value="" class="regular-text code"/></textarea></td>
		</tr>
		<tr>
		<th scope="row"><label for="release_blurb_long">Release Blurb Long</label></th>
		<td><textarea rows="10" cols="100" name="release_blurb_long" value="" class="regular-text code"/></textarea></td>
		</tr>
		</table>
		<p class="submit">
		<input type="submit" name="lookup" value="Lookup" />
		</p>
		</form>
	<?php
	}
	?>
</body>

<?php
/**
 * Gets a release from Musicbrainz then puts the values of it into the global $release variable.
 * Uses a simple XML get to avoid the bloat of loading huge Musicbrainz object infested libraries.
 *
 * @author Alexander Andrews
 * @return array The details of the release.
 */
function mb_get_release ($mbid)
{
	global $release, $artist;
	
	$request_url = "http://musicbrainz.org/ws/1/release/$mbid?type=xml&inc=release-events+tracks+artist";
	$xml = simplexml_load_file($request_url) or die ('Fucked up, bailing'); 
	$xml = object_to_array($xml);
	
	$release_physical = NULL;
	$release_physical_id = NULL;
	
	if (count($xml['release']['release-event-list']['event']) > 1){
		foreach ($xml['release']['release-event-list']['event'] as $release_event) {
			if ($release_event['@attributes']['format'] == 'Digital') {
				$release_id = cat_to_release_id($release_event['@attributes']['catalog-number']);
				$release_date = $release_event['@attributes']['date'];
			}
			else {
				// I'm assuming here that you aren't going to have loads of release events for CDs etc, but just one.
				$release_physical = 1;
				$release_physical_id = cat_to_release_id($release_event['@attributes']['catalog-number']);
			}
		}
	}
	else {
		$release_id = cat_to_release_id($xml['release']['release-event-list']['event']['@attributes']['catalog-number']);
		$release_date = $xml['release']['release-event-list']['event']['@attributes']['date'];
	}
	$release_artist_id = slug_to_artist_id(ribcage_slugize($xml['release']['artist']['name']));
	
	
	$release_slug = ribcage_slugize($xml['release']['title']);	
	$artist_slug = ribcage_slugize($xml['release']['artist']['name']);
	
	$track_no = 1;
	$total_time = 0;
	
	// Add tracks to $release
	foreach ($xml['release']['track-list']['track'] as $track) {
		$total_time = $total_time + $track['duration'];
		$tracks [] = array (
			'track_title'=> $track['title'],
			'track_time' => miliseconds_to_sql($track['duration']),
			'track_release_id' => $release_id,
			'track_mbid' => $track['@attributes']['id'],
			'track_slug' => ribcage_slugize($track['title']),
			'track_number' => $track_no,
			'track_stream' => 'http://recordsonribs.com/files/audio/'.$artist_slug.'/'.$release_slug.'/stream/'.str_pad($track_no,2, "0", STR_PAD_LEFT).'.mp3'
		);		
		++$track_no;
	}
	
	$release = array(
		'release_id'=> $release_id,
		'release_tracks_no' => $track_no-1,
		'release_artist' => $release_artist_id,
		'release_date' => $release_date,
		'release_title' => $xml['release']['title'],
		'release_slug' => $release_slug,
		'release_time' => miliseconds_to_sql($total_time),
		'release_mbid' => $xml['release']['@attributes']['id'],
		'release_physical' => $release_physical,
		'release_physical_cat_no' => $release_physical_id,
		'release_tracks' => $tracks
	);
	
	return($release);
}

/**
 * Makes a ribcage style slug for a track, artist or release.
 *
 **/
function ribcage_slugize ($to_slug)
{
	$table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
    );
   
    $slug = strtr($to_slug, $table);
	$slug = strtolower($slug);
	$slug = preg_replace('/\s+/', '', $slug);
	$slug = preg_replace('/\W/', '', $slug);
	
	return ($slug);
}
/**
 * Converts a slug to an artist ID.
 *
 * @author Alexander Andrews
 * @param string $slug Slug of the release.
 * @return The artist_id
 */
function slug_to_artist_id ($slug)
{
 	$query = "SELECT artist_id FROM wp_ribcage_artists WHERE artist_slug = '$slug' LIMIT 1";
	$result = mysql_query($query) or die(mysql_error());
	return(mysql_result($result,0));
}

/**
 * Converts miliseconds to SQL time format.
 *
 * @author Alexander Andrews
 * @param int Time in miliseconds
 * @return string Time formatted in an SQL format.
 **/
function miliseconds_to_sql ($milsec)
{	
	$sec = (int) $milsec / 1000;
	$hours = floor ($sec / 3600);
	$mins = floor ($sec / 60);
	$secs = $sec % 60;
	return(str_pad($hours,2, "0", STR_PAD_LEFT).':'.str_pad($mins,2, "0", STR_PAD_LEFT).':'.str_pad($secs,2, "0", STR_PAD_LEFT));
}

/**
 * Converts and object to an array.
 * 
 * @author Alex Andrews
 * @param object An object.
 * @return array An array.
 **/
function object_to_array( $object )
{
        if(!is_object($object) && !is_array($object))
        {
            return $object;
        }
        if(is_object($object))
        {
            $object = get_object_vars( $object );
        }
        return array_map('object_to_array', $object );
}

/**
 * Converts a catalogue number to a release number.
 *
 * @return void
 * @author Alexander Lazarus
 **/
function cat_to_release_id ($cat)
{
	global $release;
	
	if ($release['release_id'] != NULL){
		return $release['release_id'];
	}
	else {
	$release_id = preg_replace('/ROR/', '', $cat);
	$release_id = ltrim($release_id,'0');
	}
	
	return($release_id);
}

// BORROWED

function get_artist_slug_by_id ($artist_id) {
	$query = "SELECT artist_slug FROM wp_ribcage_artists WHERE artist_id = $artist_id LIMIT 1";
	$result = mysql_query($query) or die(mysql_error());
	return(mysql_result($result,0));
}


?>
</pre>