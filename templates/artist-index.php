<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title"><a href="<?php echo get_option('siteurl'); ?>/artists/" title="Artists.">Artists</a></h2>
			<div class="entry-content">
<?php while ( have_artists () ) : the_artist(); ?>
		<div class="ribcage-artist">
		<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>" title="<?php artist_name(); ?>"><img src="<?php artist_thumb ();?>" style="float: right; margin-left: 20px; border: 1px solid #000;" /></a>
		<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>" title="<?php artist_name(); ?>"><h3><?php artist_name(); ?></h3></a>
		<p><?php artist_blurb_tiny(); ?></p>
		</div>
<?php endwhile; ?>
			</div><!-- .entry-content -->
		</div><!-- .post -->
	</div><!-- #content -->
</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>