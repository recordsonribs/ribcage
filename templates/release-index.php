<?php $pageArray = query_posts('pagename=releases'); ?>

<?php
global $releases, $release, $artist;
?>

<?php get_header() ?>

	<div id="left">
		<?php while ( have_releases () ) : the_release() ; ?>
			<div class="mod post release toggler">
				<div class="mod-meta artist_slug">
					<a href="<?php release_cover_large(); ?>" rel="lightbox" title="'<?php release_title(); ?>' Cover Artwork"><img src="<?php release_cover_tiny ();?>" alt="<?php release_title(); ?>" /><?php if (release_physical()) : ?><img class="case" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/case.png" alt="CD Available for Purchase" title="CD Available for Purchase" /><?php endif; ?></a>
				</div>
				<div class="mod-body">
					<div class="entry">
						<?php $artist = get_artist($release['release_artist']); ?>
						<div class="ribcage-release">
							<small class="artist"><strong><a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/"><?php artist_name(); ?></a></strong></small>
							<h2 class="album"><a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2>
							<p><?php release_blurb_short(); ?></p>
						</div> <!-- end div.ribcage-release -->
					</div> <!-- end div.entry -->
					<div class="menu element">
						<ul class="artist_slug_meta">
							<li class="more"><a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>">More</a></li>
							<li class="listen"><a href="javascript:popUp('<?php release_player_link (); ?>')">Listen</a></li>
						<?php if (release_physical()) : ?>
							<li class="download"><a href="<?php echo home_url(); ?>/download/<?php release_slug(); ?>/">Download</a></li>
							<li class="last buy"><a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>">Buy</a></li>
						<?php else: ?>
							<li class="last download"><a href="<?php echo home_url(); ?>/download/<?php release_slug(); ?>/">Download</a></li>
						<?php endif; ?>
						</ul>
					</div> <!-- end div.menu -->
					<div class="clear"></div>
				</div> <!-- end div.mod-body -->
			<div class="clear"></div>
			</div> <!-- end div.post -->
		<?php endwhile; ?>
	</div> <!-- end #left -->

<?php get_sidebar() ?>

<?php get_footer() ?>