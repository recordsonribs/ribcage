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
	<script type="text/javascript" charset="utf-8">
		function removejscssfile(filename, filetype){
		 var targetelement=(filetype=="js")? "script" : (filetype=="css")? "link" : "none"
		 var targetattr=(filetype=="js")? "src" : (filetype=="css")? "href" : "none"
		 var allsuspects=document.getElementsByTagName(targetelement)
		 for (var i=allsuspects.length; i>=0; i--){
		  if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
		   allsuspects[i].parentNode.removeChild(allsuspects[i])
		 }
		}
		
		removejscssfile("index.include.778216415.css", "css")
		removejscssfile("default.include.866590059.js", "js")
	</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>ROR Player</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.1/build/reset/reset-min.css">
</head>
<body>
<object height="300" width="300" style="float:left;"> <param name="movie" value="http://player.soundcloud.com/player.swf?url=<?php echo $url ?>&amp;auto_play=true&amp;player_type=artwork&amp;color=ff0004&amp;buying=false&amp;show_playcount=false&amp;download=false&amp;text_buy_set='Free Download'"></param> <param name="allowscriptaccess" value="always"></param> <embed allowscriptaccess="always" height="300" src="http://player.soundcloud.com/player.swf?url=<?php echo $url ?>&amp;auto_play=true&amp;player_type=artwork&amp;color=ff0004&amp;buying=false&amp;show_playcount=false&amp;download=false&amp;text_buy_set='Free Download" type="application/x-shockwave-flash" width="300"></embed> </object>  
</body>
</html>
<?php
	return (0);	
}

?>