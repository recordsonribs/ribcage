<?php header('Content-Type: application/xspf+xml'); ?>
<? echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<playlist version="1" xmlns="http://xspf.org/ns/0/">
	<trackList>
<?php while ( have_tracks () ) : the_track() ; ?>
		<track>
			<creator><?php artist_name(); ?></creator>
			<location><?php track_stream(); ?></location>
			<title><?php track_title(); ?></title>
			<image><?php release_cover_tiny(); ?></image>
			<id><?php track_id(); ?></id>
		</track>
<?php endwhile; ?>
	</trackList>
</playlist>
