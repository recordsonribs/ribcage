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

	$url = release_soundcloud_url( false );
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>ROR Player</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.1/build/reset/reset-min.css">
</head>
<body>
<iframe width="100%" height="465" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $url ?>"></iframe>
</iframe>
</body>
</html>
<?php
	return (0);
}

?>
