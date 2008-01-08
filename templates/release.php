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
	 
	<h2><a href="<?php echo get_option('siteurl'); ?>/artists/">Artists</a></h2>
	<h1><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> - <a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h1>
	<div><img src="<?php release_cover_large (); ?>" /></div>
	<div>
		<?php while ( have_tracks () ) : the_track() ; ?>
			<?php track_no(); ?>. <?php track_title(); ?> (<?php track_time(); ?>)<br />
		<?php endwhile; ?>
	</div>
		<?php release_blurb_long(); ?>
	<div>
		<a href="<?php release_download_link (); ?>">Free Download</a> - <a href="javascript:popUp('<?php release_player_link (); ?>')">Listen Now</a> - <a href="">Buy</a>
	</div>
</div>
</div>
<?php get_footer();?>