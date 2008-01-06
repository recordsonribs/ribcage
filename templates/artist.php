<?php get_header(); ?>
<div id="container">
		<div id="content">
	 
	<h2><a href="<?php echo get_option('siteurl'); ?>/artists/">Artists</a></h2>
	<a href="<?php echo get_option('siteurl'); ?>/<?php artist_slug(); ?>"><h1><?php artist_name(); ?></h1></a>
		<p><img src="<?php artist_picture_1(); ?>" /><?php artist_bio(); ?></p>
		<p>
		<?php if (artist_website_link(0)) : ?><a href="<?php artist_website_link(); ?>">Offical Webpage</a><br /><?php endif ?>
		<?php if (artist_myspace_link(0)) : ?><a href="<?php artist_myspace_link(); ?>">My Space</a><br /><?php endif ?>
		<?php if (artist_facebook_link(0)) : ?><a href="<?php artist_facebook_link(); ?>">Facebook</a><br /><?php endif ?>
		<a href="<?php artist_lastfm_link(); ?>">Last.fm</a><br />
		<a href="<?php artist_press_link(); ?>">Press Photos and Information</a></p>
	<?php if (have_releases() ) : ?>
	<?php if (!is_artist_page() ) : ?><h2>Releases</h2><?php endif; ?>
	<?php while ( have_releases  () ) : the_release (); ?>
	<div>
	<h3><a href="<?php get_option('siteurl').'/artists/'.$artist['artist_slug'].release_slug(); ?>"><?php release_title(); ?></a></h3>
	</div>
	<?php endwhile; ?>
	<?php endif; ?>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer();?>