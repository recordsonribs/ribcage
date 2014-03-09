<?php get_header(); ?>
<?php global $release, $artist, $wp_query; ?>
	<div id="left">
		<div class="mod page">
			<div class="entry download-page">
				<p>Thanks for downloading <a href="<?php get_option('home')?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> - <a href="<?php get_option('home')?>/artists/<?php artist_slug(); ?>/<?php release_slug() ?>"><?php release_title() ?></a> as <?php echo strtoupper($wp_query->query_vars['format']); ?> files - your download should start in just a moment.</p>
				<h2>Get the word out!</h2>
				<p>While you are waiting for it to download why not let people know about <?php release_title() ?>?</p>
				<p>It's one of the only ways we get the word out, so we'd really appreciate it.</p>
				<p><a href="<?php release_twitter_promotional_tweet(); ?>" target="_blank">Tweet Now On Twitter</a></p> 
				<p><a href="<?php release_facebook_share_link() ?>" target="_blank">Share Now On Facebook</a></p>
				<?php if (artist_has_twitter()) : ?>
				<h2>Follow <?php artist_name(); ?> on Twitter</h2>
				<p>Find out what <?php artist_name() ?> is up to on Twitter.</p>
				<p>
					<?php artist_twitter_follow_link(); ?>
				</p>
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
	</div>
</div>
<?php
// Cope with legacy downloads before they were hosted on S3 and CloudFront.
$download_url = $release['release_' . $wp_query->query_vars['format']];

if (strcmp(substr($download_url, 0, 1), '/') == 0) {
	$download_url = 'http://recordsonribs.com/' . $download_url;
}
?>
<script>
jQuery(window).load(function() {
   window.location = '<?php echo $download_url;?>';
});
</script>
<?php get_footer(); ?>
