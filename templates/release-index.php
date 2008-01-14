<?php
global $releases, $release, $artist;
?>
<?php get_header() ?>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=320,height=140,left = 560,top = 410');");
}
// End -->
</script>
	<div id="container">
		<div id="content">
			<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
				<h2 class="entry-title"><a href="<?php echo get_option('siteurl'); ?>/releases/" title="Releases">Releases</a></h2>
				<div class="entry-content">
					<?php while ( have_releases () ) : the_release() ; ?>
					<?php $artist = get_artist($release['release_artist']); ?>
					<div class="ribcage-release">
					<a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img src="<?php release_cover_tiny ();?>" align="right" style="margin-left: 20px; border: 1px solid #000;" /></a>
					<h3><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/"><?php artist_name(); ?></a> - <a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h3>
					<p><?php release_blurb_short(); ?></p>
					<p><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>">More Information</a> - <a href="javascript:popUp('<?php release_player_link (); ?>')">Listen Now</a> - <a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/">Free Download</a><?php if (release_physical()) : ?> - <a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>">Buy</a><?php endif; ?></p>
					</div>
					<?php endwhile; ?>
				</div><!-- .entry-content-->
			</div><!-- .post -->
		</div><!-- #content -->
	</div><!-- #container -->
<?php get_sidebar() ?>
<?php get_footer() ?>