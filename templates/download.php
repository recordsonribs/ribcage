<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title">Downloading <a href="<?php get_option('siteurl')?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> - <a href="<?php get_option('siteurl')?>/artists/<?php artist_slug() ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2>
			<div class="entry-content">
				<img src="<?php release_cover_large (); ?>" style="margin-bottom: 20px; border: 1px solid #000;" alt="<?php release_title(); ?>" />
				<p>Thanks for your interest in <a href="<?php get_option('siteurl')?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> and <a href="<?php get_option('siteurl');?>">Records On Ribs</a>!</p>
		<p>
		<a href="<?php release_download_link_mp3 (); ?>">Download</a> Zipped High Quality MP3 Files (<?php release_download_size_mp3() ?>).<br />
		<a href="<?php release_download_link_ogg (); ?>">Download</a> Zipped Ogg Files (<?php release_download_size_ogg() ?>).<br />
		<a href="<?php release_download_link_flac (); ?>">Download</a> Zipped Flac Files (<?php release_download_size_flac() ?>).
		</p>
		<?php if (release_bittorrent()) : ?>
		<h3>Bittorrent</h3>
		<p>
			The above files are also avaliable for download via Bittorrent. If you don't know what Bittorrent is, don't worry just use the links above. But if you do, please use Bittorrent as it will likely make your download considerably faster particularly at busy times, as well as lightening the load on our server. Once your download is completed, please continue to seed it as long as is possible.</p>
		</p>
		<p>
		<?php if (release_download_link_bittorrent_mp3 (0)) : ?><a href="<?php release_download_link_bittorrent_mp3 (); ?>">Download Torrent</a> For High Quality MP3 Files.<br /><?php endif ?>
		<?php if (release_download_link_bittorrent_ogg (0)) : ?><a href="<?php release_download_link_bittorrent_ogg (); ?>">Download Torrent</a> For Ogg Files.<br /><?php endif ?>
		<?php if (release_download_link_bittorrent_flac (0)) : ?><a href="<?php release_download_link_bittorrent_flac (); ?>">Download Torrent</a> For Flac Files.<?php endif ?>
		</p>
		<p>Torrent services provided by <a href="http://beta.legaltorrents.com/">LegalTorrents</a>.</p>
		<?php endif ?>
		<p>		<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">
				<img alt="Creative Commons License" style="border-width:0; float:right;margin-left:20px;" src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" />
				</a>This release is licensed under a 
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License</a>. Essentially, this means you can give it to your friends if you like, as long as you aren't charging for it.</p>
	</div><!-- .entry-content-->
</div><!-- .post -->
</div><!-- #content -->
</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer();?>