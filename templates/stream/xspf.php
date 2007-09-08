<?php header('Content-Type: application/xspf+xml'); ?>
<?php header("Content-disposition: attachment; filename=".release_slug(1).".xspf".";"); ?>
<?phpxml version="1.0" encoding="UTF-8"?>
<playlist version="1" xmlns="http://xspf.org/ns/0/">
	<trackList>
<?php while ( have_tracks () ) : the_track() ; ?>
		<track>
			<location><?php track_stream(); ?></location>
			<creator><?php artist_name (); ?></creator>
			<album><?php release_title(); ?></album>
			<title><?php track_title(); ?></title>
			<trackNum><?php track_number(); ?></trackNum>
			<annotation>Provided by Records On Ribs, released under the Creative Commons License.</annotation>
			<duration>271066</duration>
			<image>http://images.amazon.com/images/P/B000002J0B.01.MZZZZZZZ.jpg</image>
			<info>http://recordsonrib.com/releases/<?php release_slug(); ?></info>
		</track>
<?php endwhile; ?>
	</trackList>
</playlist>