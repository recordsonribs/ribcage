<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title">Downloading <a href="<?php get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> - <a href="<?php get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2>
				<div class="entry-content">
					<p>Thanks for your interest in <a href="<?php get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a>'s record <a href="<?php get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a>.</p>
					<p> While all our downloads are available for free and licensed under a <a href="#">Creative Commons License</a>, running this site does cost us money. Also, artists like <?php artist_name(); ?> work extremely hard on producing music for you to enjoy. So if you'd like to donate some money to them and to the up keep of this site, that would be great. </p>
					<p>
						<a href="">Sure thing, send me to Paypal to donate some cash-money and then to the download.</a><br />
						<a href="<?php release_download_link (); ?>">Not right now thanks, just send me straight to the download.</a>
					</p>
			</div><!-- .entry-content-->
		</div><!-- .post -->
	</div><!-- #content -->
</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer();?>