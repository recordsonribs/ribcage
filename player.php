<?php

// show_player
// Outputs the correct XHTML for the flash player.
function show_player ($release_slug) {
	global $artists, $artist, $current_artist;
	global $releases, $release, $current_release;
	
	$release = get_release_by_slug ($release_slug, FALSE, FALSE);
	$artist['artist_name'] = get_artistname_by_id($release['release_artist']);

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ROR Player</title>
<style type="text/css" media="screen">
	* {
		margin: 0;
		padding: 0;
	}
</style>
<body>
<embed src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/ribcage/flash/mp3player.swf" width="320" height="140" allowfullscreen="true" allowscriptaccess="always" flashvars="&file=<?php echo get_option('siteurl').'/stream/'.$release_slug.'/xspf/'; ?>&height=140&width=320&displaywidth=120&showicons=false&autostart=false&shuffle=false" />
</body>
</html>
<?php
	return (0);	
}

?>