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
			<?php if (release_bittorrent()) : ?>
				<h3>BitTorrent</h3>
				<p>The above files are also avaliable for download via Bittorrent. If you don't know what Bittorrent is, don't worry just use the links above. But if you do, please use Bittorrent as it will likely make your download considerably faster particularly at busy times, as well as lightening the load on our server. Once your download is completed, please continue to seed it as long as is possible.</p>
				<ul class="bittorrent">
					<?php if (release_download_link_bittorrent_mp3(0)) : ?><li><a href="<?php release_download_link_bittorrent_mp3 (); ?>">Download Torrent</a> For High Quality MP3 Files.</li><?php endif; ?>
					<?php if (release_download_link_bittorrent_ogg (0)) : ?><li><a href="<?php release_download_link_bittorrent_ogg (); ?>">Download Torrent</a> For Ogg Files.</li><?php endif; ?>
					<?php if (release_download_link_bittorrent_flac (0)) : ?><li><a href="<?php release_download_link_bittorrent_flac (); ?>">Download Torrent</a> For Flac Files.</li><?php endif; ?>
				</ul>
				<p>Torrent services provided by <a href="http://beta.legaltorrents.com/">LegalTorrents</a>.</p>
			<?php endif; ?>
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
		<div class="album_slug_info">
			<ul class="album_slug_meta">
				<li class="listen"><a href="javascript:popUp('<?php release_player_link (); ?>')">Listen</a></li>
				<?php if (release_physical()) : ?>
					<li class="download"><a href="<?php echo home_url(); ?>/download/<?php release_slug(); ?>/" title="Free Download">Download</a></li>
					<li class="last buy"><a href="<?php echo home_url(); ?>/buy/<?php release_product_id(); ?>">Buy</a></li>
				<?php else: ?>
					<li class="download"><a href="<?php echo home_url(); ?>/download/<?php release_slug(); ?>/" title="Free Download">Download</a></li>
					<li class="last buy disabled"><span class="buy">Buy</span></li>
				<?php endif; ?>
			</ul>
		<div class="clear"></div>
		</div> <!-- end div.artist_slug_info -->
	</div>
</div>

<?php get_footer(); ?>