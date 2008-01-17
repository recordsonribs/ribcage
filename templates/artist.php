<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><h2 class="entry-title"><?php artist_name(); ?></h2></a>
				<div class="entry-content">
					<p><img src="<?php artist_picture_1(); ?>" style="border: 1px solid #000;" alt="<?php artist_name(); ?>" /><?php artist_bio(); ?></p>
					<p>
					<?php if (artist_website_link(0)) : ?><a href="<?php artist_website_link(); ?>">Offical Webpage</a><br /><?php endif ?>
					<?php if (artist_myspace_link(0)) : ?><a href="<?php artist_myspace_link(); ?>">My Space</a><br /><?php endif ?>
					<?php if (artist_facebook_link(0)) : ?><a href="<?php artist_facebook_link(); ?>">Facebook</a><br /><?php endif ?>
					<a href="<?php artist_lastfm_link(); ?>">Last.fm</a><br />
					<a href="<?php artist_press_link(); ?>">Press Photos and Information</a></p>
					</div>
					<div class="entry-content">
					<?php if (have_releases() ) : ?>
					<h3>Releases</h3>
						<?php while ( have_releases () ) : the_release() ; ?>
						<div class="ribcage-release">
							<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img src="<?php release_cover_tiny ();?>" align="right" style="margin-left: 20px; border: 1px solid #000;" alt="<?php release_title(); ?>" /></a>
						<?php $artist = get_artist($release['release_artist']); ?>
						<h3><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h3>
						<p><?php release_blurb_short(); ?></p>
						<p><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>">More Information</a> - <a href="javascript:popUp('<?php release_player_link (); ?>')">Listen Now</a> - <a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/">Free Download</a><?php if (release_physical()) : ?> - <a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>">Buy</a><?php endif; ?></p></div>
						<?php endwhile; ?>
					<?php endif; ?>
					<p><a href="#" onclick="history.back();" >&larr; Back</a></p>
				</div><!-- .entry-content-->
			</div><!-- .post -->
		</div><!-- #content -->
	</div><!-- #container -->
<?php get_sidebar() ?>
<?php get_footer() ?>