<?php
/**
 * Displays a XHTML file that shows the Flash MP3 player
 *
 * @package Ribcage
 * @subpackage Streaming
 **/

/**
 * Shows the Flash MP3 Player
 *
 * @param string $release_slug The release_slug of the release to display a player for.
 * @return void
 * @author Alex Andrews <alex@recordsonribs.com>
 **/
function show_player ($release_slug) {
	global $artists, $artist, $current_artist;
	global $releases, $release, $current_release;
	
	$release = get_release_by_slug ($release_slug, FALSE, FALSE);

	if (is_wp_error($release)){
		ribcage_404();
	}

	$artist['artist_name'] = get_artistname_by_id($release['release_artist']);

    if (is_wp_error($artist)){
    	ribcage_404();
    }
	
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

	$url = $artist['artist_name']." ".$release['release_title'];
	$url = preg_replace('/ /', '-', $url);
	$url = strtr($url, $table);
	$url = strtolower($url);
	$slug = preg_replace('/\s+/', '', $slug);
	$url = preg_replace('/\p{P}(?<!-)/', '', $url);
	$url = urlencode("http://soundcloud.com/records-on-ribs/sets/".$url);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>ROR Player</title>
<style type="text/css" media="screen">
	* {
		margin: 0;
		padding: 0;
	}
</style>
</head>
<body>
<object height="300" width="300"> <param name="movie" value="http://player.soundcloud.com/player.swf?url=<?php echo $url ?>&amp;auto_play=true&amp;player_type=artwork&amp;color=ff0004&amp;buying=false&amp;show_playcount=false&amp;download=false&amp;text_buy_set='Free Download'"></param> <param name="allowscriptaccess" value="always"></param> <embed allowscriptaccess="always" height="300" src="http://player.soundcloud.com/player.swf?url=<?php echo $url ?>&amp;auto_play=true&amp;player_type=artwork&amp;color=ff0004&amp;buying=false&amp;show_playcount=false&amp;download=false&amp;text_buy_set='Free Download" type="application/x-shockwave-flash" width="300"></embed> </object>  
</body>
</html>
<?php
	return (0);	
}

?>