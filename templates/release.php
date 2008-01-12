<?php get_header(); ?>
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
			<h2 class="entry-title"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> - <a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2>
			<div class="entry-content">
				<img src="<?php release_cover_large (); ?>" align="right" style="margin-left: 20px; border: 1px solid #000;" />
				<p>
				<?php while ( have_tracks () ) : the_track() ; ?>
				<?php track_no(); ?>. <?php track_title(); ?> (<?php track_time(); ?>)<br />
				<?php endwhile; ?>
				</p>
				<p>
					<a href="<?php release_download_link (); ?>">Free Download</a> - <a href="javascript:popUp('<?php release_player_link (); ?>')">Listen Now</a> - <a href="">Buy</a>
				</p>
				<?php release_blurb_long(); ?>
			</div><!-- .entry-content-->
		</div><!-- .post -->
	</div><!-- #content -->
</div><!-- #container -->

<?php get_sidebar (); ?>
<?php get_footer();?>