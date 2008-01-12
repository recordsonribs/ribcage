<?php
global $releases, $release;
?>
<?php get_header() ?>
	<div id="container">
		<div id="content">
			<div id="post-" class="<?php sandbox_post_class() ?>">
				<h2 class="entry-title">Releases</h2>
				<div class="entry-content">
					<?php while ( have_releases () ) : the_release() ; ?>
					<img src="<?php release_cover_tiny ();?>" align="right" />
					<h3><?php echo get_artistname_by_id($release['release_artist']); ?> - <?php release_title(); ?></h3>
					<p><?php release_blurb_short(); ?></p>
					<p><a href="javascript:popUp('<?php release_player_link (); ?>')">Listen Now</a></p>
					<?php endwhile; ?>
				</div>
			</div><!-- .post -->
		</div><!-- #content -->
	</div><!-- #container -->
<?php get_sidebar() ?>
<?php get_footer() ?>