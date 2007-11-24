<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class="post">
	 
	<h2><a href="<?php echo ARTISTS_PLUGIN; ?>">Artists</a></h2>
	<a href="<?php echo ARTISTS_PLUGIN; ?><?php artist_slug(); ?>"><h1><?php artist_name(); ?></h1></a>
	<?php if (is_artist_page()) : ?>
	<h2>Press</h2>
	<p></p>
	<p><?php echo $wp_query->query_vars['artist_page']; ?></p>
	<?php else : ?>
		<p><?php artist_bio(); ?></p>
		<p>
		<?php if (artist_website_link(0)) : ?><a href="<?php artist_website_link(); ?>">Offical Webpage</a><br /><?php endif ?>
		<?php if (artist_myspace_link(0)) : ?><a href="<?php artist_myspace_link(); ?>">My Space</a><br /><?php endif ?>
		<?php if (artist_facebook_link(0)) : ?><a href="<?php artist_facebook_link(); ?>">Facebook</a><br /><?php endif ?>
		<a href="<?php artist_lastfm_link(); ?>">Last.fm</a><br />
		<a href="<?php artist_press_link(); ?>">Press Photos and Information</a></p>
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