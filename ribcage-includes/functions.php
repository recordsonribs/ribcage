<?php

$wpdb->ribcage_artists = $wpdb->prefix."ribcage_artists";
$wpdb->ribcage_releases = $wpdb->prefix."ribcage_releases";
$wpdb->ribcage_tracks = $wpdb->prefix."ribcage_tracks";
$wpdb->ribcage_reviews = $wpdb->prefix."ribcage_reviews";
$wpdb->ribcage_clippings = $wpdb->prefix."ribcage_clippings";

$wpdb->ribcage_log_stream = $wpdb->prefix."ribcage_log_stream";

$wpdb->ribcage_log_download_releases = $wpdb->prefix."ribcage_log_download_releases";
$wpdb->ribcage_log_download_tracks = $wpdb->prefix."ribcage_log_download_tracks";

$wpdb->ribcage_products = $wpdb->prefix."ribcage_products";
$wpdb->ribcage_orders = $wpdb->prefix."ribcage_orders";

$wpdb->ribcage_donations = $wpdb->prefix."ribcage_donations";

function ribcage_release_feeds(){
	global $wp_query;
	
	?>
	<link rel="alternate" type="application/rss+xml" href="<?php echo get_option('siteurl'); ?>/releases/feed" title="<?php echo get_option('blogname'); ?> Releases RSS feed" />
	<?php
	
	if (isset($wp_query->query_vars['artist_slug'])){
		?>
		<link rel="alternate" type="application/rss+xml" href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/feed" title="<?php artist_name(); ?> Releases RSS feed" />
		<?php	
	}
}

// is_ribcage_page
// No input.
// Returns true if we are on a Ribcage page, and false otherwise.
function is_ribcage_page() {
	global $wp_query;
	
	$qvars = ribcage_queryvars(array());
	
	foreach ($qvars as $qvar) {
		if (isset($wp_query->query_vars["$qvar"])) {
			return TRUE;
		}
	}	
	return FALSE;
}

// list_recent_releases_blurb
// Input amount of releases you want back.
// Returns recent releases as associative array.
function list_recent_releases_blurb ( $amount = 0, $forthcoming = FALSE )
{
	global $wpdb;
	
	$now_date = gmdate('Y-m-d');
	
	if ($amount) {
		$releases = $wpdb->get_results("SELECT release_id FROM $wpdb->ribcage_releases WHERE release_date <= '$now_date' ORDER BY release_id DESC LIMIT $amount ", ARRAY_A);
	}
	else {
		$releases = $wpdb->get_results("SELECT release_id FROM $wpdb->ribcage_releases WHERE release_date <= '$now_date' ORDER BY release_id DESC", ARRAY_A);
	}
	
	if (isset($releases)) {
		foreach ($releases as $release){
			$return[] = get_release($release['release_id']);		
		}
	}	
	return $return;
}

// list_artists
// No input. 
// Returns a list of artists (their name, their blurb_short, their press photo) as an associative array, sorted by alphabetically by their name.
function list_artists_blurb (){
	global $wpdb;	
	$querystr = "
	SELECT artist_name, artist_slug, artist_id, artist_name_sort, artist_picture_1, artist_thumb, artist_blurb_short, artist_blurb_tiny FROM $wpdb->ribcage_artists
	ORDER BY `artist_name_sort`";
	$return = $wpdb->get_results($querystr, ARRAY_A);
	return $return;
}

// list_artist_releases
// Input the artist id and a bool of if you want forthcoming releases as well.
// Returns an associative array of their releases.
function list_artist_releases ($artist_id, $forthcoming = FALSE ) {
	global $wpdb;
	
	if ($forthcoming == TRUE) {
		$releases = $wpdb->get_results("SELECT release_id FROM $wpdb->ribcage_releases WHERE release_artist = $artist_id ORDER BY release_id DESC", ARRAY_A);
	}
	else {
		$now_date = gmdate('Y-m-d');
		$releases = $wpdb->get_results("SELECT release_id FROM $wpdb->ribcage_releases WHERE release_artist = $artist_id AND release_date <= '$now_date' ORDER BY release_id DESC", ARRAY_A);
	}
	
	if (isset($releases)) {
		foreach ($releases as $release){
			$return[] = get_release($release['release_id']);		
		}
	}
	
	return $return;
}

// get_*
// -------
// The following functions fetch various things from the database.
// or maybe just don't bother appending fullstop?? We'll see.
// TODO Errors, bailing out if we can't find the artist, track, etc.

// get_product 
// Input product id
// Returns product as associative array.
function get_product ($product_id) {
	global $wpdb;
	
	$return = $wpdb->get_row("SELECT * FROM $wpdb->ribcage_products WHERE product_id = $product_id", ARRAY_A);
	
	return $return;
}

// get_release
// Input the release id.
// Returns release as associative array.
// TODO: Inefficent to get the reviews and the tracks as well - implement the same method as get_release_by_slug
function get_release ($release_id, $tracks = true, $reviews = true){
	global $wpdb;
	
	$return = $wpdb->get_row("SELECT * FROM $wpdb->ribcage_releases WHERE release_id = $release_id", ARRAY_A);
	
	if ($tracks == true){
		$return['release_tracks'] = get_tracks ($return['release_id']);
	}
	
	if ($reviews == true){		
		$return['release_reviews'] = get_reviews ($return['release_id']);
	}
	
	return $return;
}

// get_release_by_slug
// Input the release slug and noextras if you don't want the tracks or reviews appended.
// Returns release as associative array.
function get_release_by_slug ($release_slug, $tracks = true, $reviews = true){
	global $wpdb;
	
	$now_date = gmdate('Y-m-d');
	
	$return = $wpdb->get_row("SELECT * FROM $wpdb->ribcage_releases WHERE release_slug = '$release_slug' AND release_date <= '$now_date'", ARRAY_A);
	
	if ($tracks == true){
		$return['release_tracks'] = get_tracks ($return['release_id']);
	}
	
	if ($reviews == true){		
		$return['release_reviews'] = get_reviews ($return['release_id']);
	}
	
	return $return;
}

function get_releasename_by_slug ($release_slug){
	global $wpdb;
	$return = $wpdb->get_var("SELECT release_title FROM $wpdb->ribcage_releases WHERE release_slug = '$release_slug'");
	
	return $return;
}

// get_artist
// Input the artist id.
// Returns artist information as associative array.
function get_artist ($artist_id){
	global $wpdb;
	$return = $wpdb->get_row("SELECT * FROM $wpdb->ribcage_artists WHERE artist_id = $artist_id", ARRAY_A);	
	return $return;
}

// get_artist_by_slug
// Input the artist id.
// Returns artist information as associative array.
function get_artist_by_slug ($artist_slug){
	global $wpdb;
	$querystr = "SELECT * FROM $wpdb->ribcage_artists WHERE artist_slug = '$artist_slug'";
	$return = $wpdb->get_row($querystr, ARRAY_A);	
	return $return;
}

// get_tracks
// Input the release id.
// Returns tracks on release as an associative array.
function get_tracks ($release_id){
	global $wpdb;
	$querystr = "
	SELECT * FROM $wpdb->ribcage_tracks WHERE track_release_id = $release_id
	ORDER BY track_number
	";
	$return = $wpdb->get_results($querystr, ARRAY_A);
	return $return;	
}

//get_reviews
// Input the release id.
// Returns reviews of the release as an associative array.
function get_reviews ($release_id){
	global $wpdb;
	$querystr = "
	SELECT * FROM $wpdb->ribcage_reviews WHERE review_release_id = $release_id
	ORDER BY review_weight DESC
	";
	$return = $wpdb->get_results($querystr, ARRAY_A);
	return $return;
}

// get_track_by_slug
// Input the track slug.
// Returns track as an associative array.
function get_track_by_slug ($track_slug) {
	global $wpdb;
	$querystr = "SELECT * FROM $wpdb->ribcage_tracks WHERE track_slug = '$track_slug'";
	$return = $wpdb->get_row($querystr, ARRAY_A);
	return ($return);
}

// get_artistname_by_id
// Input artist id.
function get_artistname_by_id ($artist_id) {
	global $wpdb;
	$return = $wpdb->get_var("SELECT artist_name FROM $wpdb->ribcage_artists WHERE artist_id = $artist_id");	
	return $return;
}

// get_artistname_by_id
// Input artist id.
function get_artistname_by_slug ($artist_slug) {
	global $wpdb;
	$return = $wpdb->get_var("SELECT artist_name FROM $wpdb->ribcage_artists WHERE artist_slug = '$artist_slug'");	
	return $return;
}


// from wp-download manager by Lester 'GaMerZ' Chan (http://lesterchan.net/portfolio/programming.php)
function ribcage_format_filesize($rawSize) {
	if($rawSize / 1099511627776 > 1) {
		return round($rawSize/1099511627776, 1) . ' TB';
	} elseif($rawSize / 1073741824 > 1) {
		return round($rawSize/1073741824, 1) . ' GB';
	} elseif($rawSize / 1048576 > 1) {
		return round($rawSize/1048576, 1) . ' MB';
	} elseif($rawSize / 1024 > 1) {
		return round($rawSize/1024, 1) . ' KB';
	} elseif($rawSize > 1) {
		return round($rawSize, 1) . ' bytes';
	} else {
		return __('unknown', 'ribcage');
	}
}

// dropdown to display CC licenses. accepts license slug as argument (to select that option)
// license list: http://creativecommons.org/about/licenses/meet-the-licenses
function ribcage_cc_dropdown($selected = false){
	$cclist = array(
		'by-nc-nd'	=> 'Attribution Non-commercial No Derivatives (by-nc-nd)',
		'by-nc-sa'	=> 'Attribution Non-commercial Share Alike (by-nc-sa)', 
		'by-nc'		=> 'Attribution Non-commercial (by-nc)',
		'by-nd'		=> 'Attribution No Derivatives (by-nd)',
		'by-sa'		=> 'Attribution Share Alike (by-sa)',
		'by' 		=> 'Attribution (by)'
	);

	$output = "<select name='artist_license' id='artist_license'>\n";
	foreach($cclist as $lic => $desc):
	if($selected == $lic) { $flag="selected='selected'"; } else { $flag = ""; }
	$output .= "<option id='".str_replace("-","",$lic)."' name='".str_replace("-","",$lic)."' value='".$lic."' label='".$desc."'".$flag.">".$desc."</option>\n";
	endforeach;
	$output .= "</select>\n";
	return $output;
}

/**
 * Delete an artist from the database
 * 
 * @param int $artist_id Artist ID for deletion.
 * @return bool True if this worked, false if it didn't.
 * @author Alexander Andrews
 **/
function delete_artist($artist_id)
{
	global $wpdb;
	
	$result = $wpdb->query("DELETE FROM `$wpdb->ribcage_artists` WHERE `artist_id` = $artist_id LIMIT 1;");
	
	return ($result);
}

/**
 * Gets a release from Musicbrainz then puts the values of it into the global $release variable.
 * Uses a simple XML get to avoid the bloat of loading huge Musicbrainz object infested libraries.
 *
 * @author Alexander Andrews
 * @return array The details of the release.
 */
function mb_get_release ($mbid)
{
	global $release;
	
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
 * @author Alexander Andrews
 * @param string Convert this to a slug
 * @return string The slug
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
	$release_id = preg_replace('/ROR/', '', $cat);
	$release_id = ltrim($release_id,'0');
	
	return($release_id);
}
?>