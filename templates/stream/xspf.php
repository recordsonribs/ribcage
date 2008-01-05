<?php //header('Content-Type: application/xspf+xml'); ?>
<?php //header("Content-disposition: attachment; filename=".release_slug(1).".xspf".";"); ?>
<playlist version="1" xmlns="http://xspf.org/ns/0/">
	<trackList>
<?php while ( have_tracks () ) : the_track() ; ?>
		<track>
			<creator><?php artist_name(); ?></creator>
			<location><?php track_stream(); ?></location>
			<title><?php track_title(); ?></title>
			<image><?php release_cover_tiny(); ?></image>
		</track>
<?php endwhile; ?>
	</trackList>
</playlist>