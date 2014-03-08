<?php get_header(); ?>
<?php global $release; ?>
	<div id="left">
		<div class="mod page">
			<div class="entry">
				<p>Thanks for your interest in <a href="<?php get_option('home')?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> and <a href="<?php get_option('home');?>">Records On Ribs</a>!</p>
				<ul class="download">
					<li><a href="<?php get_option('siteurl');?><?php echo $release['release_mp3'];?>">Download</a> Zipped High Quality MP3 Files</li>
					<li><a href="<?php get_option('siteurl');?><?php echo $release['release_ogg'];?>">Download</a> Zipped Ogg Vorbis Files</li>
 					<li><a href="<?php get_option('siteurl');?><?php echo $release['release_flac'];?>">Download</a> Zipped FLAC Fles</li>
				</ul>
			</div> <!-- end div.entry -->
		</div> <!-- end div.page mod.1 -->

		<div class="mod post cc">
			<div class="mod-meta">
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" src="<?php bloginfo('stylesheet_directory'); ?>/images/release_cc.png" alt="Creative Commons" /></a>
			</div>
			<div class="mod-body">
				<p><small>This release is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License</a>. Essentially, this means you can give it to your friends if you like, as long as you aren't charging for it.</small></p>
			</div>
		</div> <!-- end div.page mod.2 -->
	</div> <!-- end #left -->

<div id="right">
	<div class="mod album_release">
		<img class="album_picture" src="<?php release_cover_large (); ?>" alt="<?php release_title(); ?>" />
	</div>
</div>

<?php get_footer(); ?>