<?php get_header(); ?>
<div id="container">
		<div id="content">
	 
	<h2><a href="<?php echo ARTISTS_PLUGIN; ?>">Artists</a></h2>
	<a href="<?php echo ARTISTS_PLUGIN; ?><?php artist_slug(); ?>"><h1><?php artist_name(); ?> - <a href="<?php get_option('siteurl').'/artists/'.$artist['artist_slug'].release_slug(); ?>"><?php release_title(); ?></a></h1></a>
	<div><img src="<?php release_cover_large (); ?>" /></div>
	<div>
		<?php while ( have_tracks () ) : the_track() ; ?>
			<?php track_no(); ?>. <?php track_title(); ?> (<?php track_time(); ?>)<br />
		<?php endwhile; ?>
	</div>
	<div>
		<a href="<?php release_download_link (); ?>">Free Download</a> - <a href="">Listen</a> - <a href="">Buy</a>
	</div>
</div>
</div>
<?php get_footer();?>