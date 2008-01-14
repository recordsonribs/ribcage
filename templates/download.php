<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title">Downloading <a href="<?php get_option('siteurl')?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?> - <a href="<?php get_option('siteurl')?>/artists/<?php artist_slug() ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2></a>
			<div class="entry-content">
				<img src="<?php release_cover_large (); ?>" style="margin-bottom: 20px; border: 1px solid #000;" />
				<p>Thanks for your interest in <a href="<?php get_option('siteurl')?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> and <a href="<?php get_option('siteurl');?>">Records On Ribs</a>!</p>
		<p>		<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">
				<img alt="Creative Commons License" style="border-width:0; float:right;margin-left:20px;" src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" />
				</a>This release is licensed under a 
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License</a>. Essentially, this means you can give it to your friends if you like, as long as you aren't charging for it.</p>
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