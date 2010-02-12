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
 * @author Alexander Andrews
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
<embed src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/ribcage/flash/mp3player.swf" width="320" height="140" allowfullscreen="true" allowscriptaccess="always" flashvars="&file=<?php echo get_option('siteurl').'/stream/'.$release_slug.'/xspf/'; ?>&height=140&width=320&displaywidth=120&showicons=false&repeat=list&autostart=true&shuffle=false&callback=<?php echo get_option('siteurl'); ?>/player/stats/" />
</body>
</html>
<?php
	return (0);	
}

?>