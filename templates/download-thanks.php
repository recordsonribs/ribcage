<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title">Thanks <?php echo $_POST['first_name'];?>!</h2></a>
			<div class="entry-content">
				<img src="<?php release_cover_large (); ?>" style="margin-bottom: 20px; border: 1px solid #000;" alt="<?php release_title(); ?>"/>
	<p>Thanks for your kind donation! Don't those downloads just sound so much better! We'd hug you if it wasn't for the restraining order!</p>
		<p>
		<a href="<?php release_download_link_mp3 (); ?>">Download</a> Zipped <a href="<?php get_option('siteurl')?>/help/formats/mp3">High Quality MP3</a> Files (<?php release_download_size_mp3() ?>).<br />
		<a href="<?php release_download_link_flac (); ?>">Download</a> Zipped <a href="<?php get_option('siteurl')?>/help/formats/ogg">Ogg</a> Files (<?php release_download_size_ogg() ?>).<br />
		<a href="<?php release_download_link_flac (); ?>">Download</a> Zipped <a href="<?php get_option('siteurl')?>/help/formats/flac">Flac</a> Files (<?php release_download_size_flac() ?>).
		</p>
	</div><!-- .entry-content-->
</div><!-- .post -->
</div><!-- #content -->
</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer();?>