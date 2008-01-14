<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title"><a href="<?php get_option('siteurl') ?>/buy/<?php product_id(); ?>">Buying <?php product_name(); ?></a><h2>
				<div class="entry-content">
					<p><?php product_description(); ?></p>
					<h3>Pricing</h3>
					<p>CD Album & Postage (UK) - £<?php product_cost_uk(); ?><br />
						CD Album & Postage (Worldwide)- £<?php product_cost_ww(); ?></p>
					<p><a href="<?php get_option('siteurl') ?>/buy/<?php product_id(); ?>/go">Buy Now</a></p>
					<p><a href="#" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img  src="https://www.paypal.com/en_US/i/logo/PayPal_mark_50x34.gif" border="0" alt="Paypal" style="float: right; margin-left:20px;"></a>When you click Buy Now you will be redirected to Paypal for secure online payment. Then we'll send you back here.</p>
			</div><!-- .entry-content-->
		</div><!-- .post -->
	</div><!-- #content -->
</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer();?>