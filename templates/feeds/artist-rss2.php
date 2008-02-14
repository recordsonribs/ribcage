<?php
global $releases, $release, $artist;

header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
$more = 1;

?>
<?php echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>
<!-- generator="wordpress/<?php bloginfo_rss('version') ?>/Ribcage" -->
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	<?php do_action('rss2_ns'); ?>
>
<channel>
	<title><?php bloginfo_rss('name'); ?> - <?php artist_name(); ?> - Releases</title>
	<link><?php bloginfo_rss('url') ?>/<?php artist_slug(); ?>/</link>
	<description><?php bloginfo_rss('name'); ?> Release Feed for <?php artist_name(); ?></description>
	<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', $releases[0]['release_date'], false); ?></pubDate>
	<generator>http://wordpress.org/?v=<?php bloginfo_rss('version'); ?></generator>
	<language><?php echo get_option('rss_language'); ?></language>
	<?php while ( have_releases () ) : the_release() ; ?>
	<item>
		<title><?php release_title(); ?></title>
		<link><?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>/</link>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', $release['release_date'], false); ?></pubDate>
		<dc:creator>Records On Ribs</dc:creator>
		<category><![CDATA[Releases]]></category>
		<guid isPermaLink="false"><?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>/</guid>
		<description><![CDATA[<?php release_blurb_short(); ?>]]></description>
		<content:encoded><![CDATA[<img src="<?php release_cover_tiny (); ?>" align="right" style="margin-left: 20px; border: 1px solid #000;" alt="<?php release_title(); ?>"/><?php release_blurb_long() ?><p><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>">More Information</a> - <a href="<?php release_player_link (); ?>">Listen Now</a> - <a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/">Free Download</a><?php if (release_physical()) : ?> - <a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>">Buy</a><?php endif; ?></p>	<p><em>This release is licensed under a 
					<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License</a>.</p></em>]]></content:encoded>
	</item>
	<?php endwhile; ?>
</channel>
</rss>