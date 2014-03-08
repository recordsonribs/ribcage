<?php get_header(); ?>
<?php global $release;?>
	<div id="left">
		<div class="mod page">
			<!--<h2>Thanks <?php echo $_POST['first_name'];?>!</h2>-->
			<div class="entry">
				<img src="<?php release_cover_large (); ?>" alt="<?php release_title(); ?>"/>
				<p>Thanks for your kind donation! Don't those downloads just sound so much better! We'd hug you if it wasn't for the restraining order!</p>
				<ul class="download">
 					<li><a href="<?php get_option('siteurl');?><?php echo $release['release_mp3'];?>">Download</a> Zipped High Quality MP3 Files (<?php release_download_size_mp3(); ?>).</li>
 					<li><a href="<?php get_option('siteurl');?><?php echo $release['release_ogg'];?>">Download</a> Zipped Ogg Files (<?php release_download_size_ogg(); ?>).</li>
 					<li><a href="<?php get_option('siteurl');?><?php echo $release['release_flac'];?>">Download</a> Zipped Flac Files (<?php release_download_size_flac(); ?>).</li>
 				</ul>
			</div> <!-- end div.entry -->
		</div> <!-- end div.page -->
	</div> <!-- end #left -->

<?php get_sidebar(); ?>

<?php get_footer();?>