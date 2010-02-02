<?php get_header(); ?>

	<div id="left">
		<div class="mod page">
			<!--<h2><a href="<?php get_option('siteurl') ?>/buy/<?php product_id(); ?>">Buying <?php product_name(); ?></a><h2>-->
				<div class="entry">
					<p><?php product_description(); ?></p>
					<h3>Pricing</h3>
					<p>CD Album & Postage (UK) - &pound;<?php product_cost_c(); ?><br /><a href="<?php get_option('siteurl') ?>/buy/<?php product_id(); ?>/go-uk">Buy Now</a></p>
					<p>CD Album & Postage (Worldwide) - &pound;<?php product_cost_ww(); ?><br /><a href="<?php get_option('siteurl') ?>/buy/<?php product_id(); ?>/go-ww">Buy Now</a></p>
			</div> <!-- end div.entry -->
		</div> <!-- end div.page -->
		<div class="mod post paypal">
			<div class="mod-meta">
				<a href="#" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img alt="Make a Donation!" src="<?php bloginfo('stylesheet_directory'); ?>/images/release_paypal-m.png" alt="Make a Donation!" /></a>
			</div>
			<div class="mod-body">
				<p><small>When you click Buy Now you will be redirected to Paypal for secure online payment. Then we'll send you back here.</small></p>
			</div>
		</div> <!-- end div.post div.paypal -->
	</div> <!-- end #left -->

<div id="right">
	<div class="mod">
		<h3>Album Info</h3>
		<div class="album_slug_more">
			<small class="artist"><strong><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/"><?php artist_name(); ?></a></strong></small>
			<h2 class="album"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2>
		</div>
	</div>
	<div class="mod album_release">
		<img class="album_picture" src="<?php release_cover_large (); ?>" alt="<?php release_title(); ?>" />
		<div class="album_slug_info">
			<ul class="album_slug_meta">
				<li class="listen"><a href="javascript:popUp('<?php release_player_link (); ?>')">Listen</a></li>
				<?php if (release_physical()) : ?>
					<li class="download"><a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/" title="Free Download">Download</a></li>
					<li class="last buy"><a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>">Buy</a></li>
				<?php else: ?>
					<li class="download"><a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/" title="Free Download">Download</a></li>
					<li class="last buy disabled"><span class="buy">Buy</span></li>
				<?php endif; ?>
			</ul>
		<div class="clear"></div>
		</div> <!-- end div.artist_slug_info -->
	</div>
</div>

<?php get_footer();?>