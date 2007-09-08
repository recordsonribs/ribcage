<?php header('Content-Type: application/xspf+xml'); ?>
<?php header("Content-disposition: attachment; filename=".release_slug(1).".m3u".";"); ?>
<?php while ( have_tracks () ) : the_track() ; ?>
<?php track_stream(); ?>
<?php echo "\n"; ?>
<?php endwhile; ?>
