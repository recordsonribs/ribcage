<?php get_header(); ?>
<!-- Add a microformats dumb ass!!!-->
<div id="container">
	<div id="content">
		<h2><a href="<?php echo ARTISTS_PLUGIN; ?>" title="Return to all our artists.">Artists</a></h2>
<?php while ( have_artists () ) : the_artist(); ?>	
		<a href="<?php echo ARTISTS_PLUGIN; ?><?php artist_slug(); ?>" title="<?php artist_name(); ?>"><h1><?php artist_name(); ?></h1></a>
		<p><?php artist_blurb_tiny(); ?></p>
<?php endwhile; ?>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>