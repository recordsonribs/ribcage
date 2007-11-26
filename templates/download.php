<?php get_header(); ?>
<div id="container">
		<div id="content">
	 
	<h2>Download</h2>
	<a href="<?php echo ARTISTS_PLUGIN; ?><?php artist_slug(); ?>"><h1><?php artist_name(); ?> - <a href="<?php get_option('siteurl').'/artists/'.$artist['artist_slug'].release_slug(); ?>"><?php release_title(); ?></a></h1></a>
	<p>Thanks for your interest...</p>
	<div>
		<p><a href="#">Download Artwork ( MB)</a></p>
		<p>
		<a href="<?php release_download_link_mp3 (); ?>">Download</a> Zipped High Quality MP3 Files ( MB).<br />
		<a href="<?php release_download_link_flac (); ?>">Download</a> Zipped Ogg Files ( MB).<br />
		<a href="<?php release_download_link_flac (); ?>">Download</a> Zipped Flac Files ( MB).
		</p>
	</div>
</div>
</div>
<?php get_footer();?>