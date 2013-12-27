<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title"><a href="<?php get_option('home') ?>/buy/<?php product_id(); ?>">Thanks <?php echo $_POST['first_name'];?></a><h2>
				<div class="entry-content">
					<p>Thanks very much for your order. We'll get back to you as soon as possible.</p>
					<h3>Details</h3>
					<p>
					<?php echo $_POST['quantity'] ?> x <?php echo $_POST['item_name'] ?> (<?php echo $_POST['item_number'] ?>)<br />
					Paid by <?php echo $_POST['first_name'];?> <?php echo $_POST['last_name'];?> <?php echo $_POST['payer_business_name'];?> (<?php echo $_POST['payer_email'] ?>)
					</p>
		
					<p><a href="#" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img  src="https://www.paypal.com/en_US/i/logo/PayPal_mark_50x34.gif" border="0" alt="Paypal" style="float: right; margin-left:20px;"></a>When you click Buy Now you will be redirected to Paypal for secure online payment. Then we'll send you back here.</p>
			</div><!-- .entry-content-->
		</div><!-- .post -->
	</div><!-- #content -->
</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer();?>