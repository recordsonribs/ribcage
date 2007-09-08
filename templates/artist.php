<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="container">
	<h2><a href="<?php echo ARTISTS_PLUGIN; ?>">Artists</a></h2>
	<a href="<?php echo ARTISTS_PLUGIN; ?><?php artist_slug(); ?>"><h1><?php artist_name(); ?></h1></a>
	<?php if (is_artist_page()) : ?>
	<h2>Biography</h2>
	<p><?php artist_bio(); ?></p>
	<?php else : ?>
		<p><?php artist_blurb_short(); ?></p>
	<?php endif; ?>
	<?php if (!is_artist_page() && have_releases() ) : ?>
	<h2>Releases</h2>
	<?php while ( have_releases  () ) : the_release (); ?>
	<div>
	<h3><?php release_title(); ?></h3>
	<ol>
		<?php while ( have_tracks () ) : the_track() ; ?>
			<li><?php track_title(); ?></li>
		<?php endwhile; ?>
	</ol>
	</div>
	<?php endwhile; ?>
	<?php endif; ?>
</div>
	<?php get_footer();?>