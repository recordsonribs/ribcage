<?php get_header(); ?>

	<div id="left">
		<div class="mod page">
			<!--<h2>Thanks <?php echo $_POST['first_name'];?>!</h2>-->
			<div class="entry">
				<img src="<?php release_cover_large (); ?>" alt="<?php release_title(); ?>"/>
				<p>Thanks for your kind donation! Don't those downloads just sound so much better! We'd hug you if it wasn't for the restraining order!</p>
				<p><a href="<?php release_download_link_mp3 (); ?>">Download</a> Zipped <a href="<?php get_option('home')?>/help/formats/mp3">High Quality MP3</a> Files (<?php release_download_size_mp3() ?>).<br /><a href="<?php release_download_link_ogg (); ?>">Download</a> Zipped <a href="<?php get_option('home')?>/help/formats/ogg">Ogg</a> Files (<?php release_download_size_ogg() ?>).<br /><a href="<?php release_download_link_flac (); ?>">Download</a> Zipped <a href="<?php get_option('home')?>/help/formats/flac">Flac</a> Files (<?php release_download_size_flac() ?>).</p>
			</div> <!-- end div.entry -->
		</div> <!-- end div.page -->
	</div> <!-- end #left -->

<?php get_sidebar(); ?>

<?php get_footer();?>