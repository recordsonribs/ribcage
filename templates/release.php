<?php get_header(); ?>
<div id="container">
	<div id="content">
		<div id="post-17" class="hentry p1 page publish author-alex category-uncategorized tag- y2007 m07 d19 h23">
			<h2 class="entry-title"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>"><?php artist_name(); ?></a> - <a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2>
			<div class="entry-content">
				<img src="<?php release_cover_large (); ?>" align="right" style="margin-left: 20px; border: 1px solid #000;" />
				<p>
				<?php while ( have_tracks () ) : the_track() ; ?>
				<?php track_no(); ?>. <?php track_title(); ?> (<?php track_time(); ?>)<br />
				<?php endwhile; ?>
				</p>
				<p>
					<a href="<?php release_download_link (); ?>">Free Download</a> - <a href="javascript:popUp('<?php release_player_link (); ?>')">Listen Now</a><?php if (release_physical()) : ?> - <a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>">Buy</a><?php endif; ?>
				</p>
				<?php release_blurb_long(); ?>
				<p>		<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">
						<img alt="Creative Commons License" style="border-width:0; float:right;margin-left:20px;" src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" />
						</a>This release is licensed under a 
						<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License</a>. Essentially, this means you can give it to your friends if you like, as long as you aren't charging for it.</p>
				<p><a href="#" onclick="history.back();" >&larr; Back</a></p>
			</div><!-- .entry-content-->
		</div><!-- .post -->
	</div><!-- #content -->
</div><!-- #container -->

<?php get_sidebar (); ?>
<?php get_footer();?>