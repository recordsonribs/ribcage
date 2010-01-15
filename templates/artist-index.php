<?php $pageArray = query_posts('pagename=artists'); ?>

<?php get_header(); ?>

	<div id="left">
		<?php while ( have_artists () ) : the_artist(); ?>
			<div class="mod post artist">
				<div class="mod-meta">
					<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>" title="<?php artist_name(); ?>"><img src="<?php artist_thumb ();?>" alt="<?php artist_name() ?>"/></a>
				</div>
				<div class="mod-body">
					<div class="entry">
						<div class="ribcage-artist">
							<h1><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>" title="<?php artist_name(); ?>"><?php artist_name(); ?></a></h1>
							<p><?php artist_blurb_tiny(); ?></p>
						</div> <!-- end div.ribcage-artist -->
					</div> <!-- end div.entry -->
				</div> <!-- end div.mod-body -->
			</div> <!-- end div.post -->
		<?php endwhile; ?>
	</div> <!-- end #left -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>