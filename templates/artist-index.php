<?php get_header(); ?>
<!-- Add a microformats dumb ass!!!-->
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
		<h2><a href="<?php echo get_option('siteurl'); ?>/artists/" title="Return to all our artists.">Artists</a></h2>
		<div class="entry-content">
<?php while ( have_artists () ) : the_artist(); ?>	
		<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>" title="<?php artist_name(); ?>"><h3><?php artist_name(); ?></h3></a>
		<p><?php artist_blurb_tiny(); ?></p>
<?php endwhile; ?>
</div>
</div>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>