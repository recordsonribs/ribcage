<?php get_header(); ?>

	<div id="left">
		<div class="mod page">
			<div class="entry">
				<?php release_blurb_long(); ?>
				
				<h3>Track List</h3>
 				<ul class="tracklist">
 				<?php while ( have_tracks () ) : the_track() ; ?>
 					<li><?php track_no(); ?>. <?php track_title(); ?> (<?php track_time(); ?>)</li>
 				<?php endwhile; ?>
 				</ul>
			</div> <!-- end div.entry -->
		</div> <!-- end div.page mod.1 -->
	<?php if (have_reviews()) : ?>
		<div class="mod page">
			<div class="entry">
					<h3>Reviews</h3>
					<?php while ( have_reviews () ) : the_review() ; ?>
						<blockquote><p><?php review_text(); ?></p></blockquote>
						<p class="review_author"><em>&mdash;<a href="<?php review_link(); ?>"><?php review_author(); ?></a></em></p>
					<?php endwhile; ?>
			</div> <!-- end div.entry -->
		</div> <!-- end div.page mod.2 -->
	<?php endif; ?>
		<div class="mod post cc">
			<div class="mod-meta">
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" src="<?php bloginfo('stylesheet_directory'); ?>/images/release_cc.png" /></a>
			</div>
			<div class="mod-body">
				<p><small>This release is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License</a>. Essentially, this means you can give it to your friends if you like, as long as you aren't charging for it.</small></p>
			</div>
		</div> <!-- end div.page mod.3 -->
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
	<?php if (isset($wp_query->query_vars['artist_slug'])) { 
				global $releases, $artist, $release;
				$releases = list_artist_releases ($artist['artist_id']);

				foreach ($releases as $r => $value) {
					if (strcmp($release['release_title'], $value['release_title']) === 0) {
						unset($releases[$r]);
					}
				}

 		?>
 		<?php if (count($releases) > 0 ) : ?>
 		<div class="mod">
 			<h3>More by <?php artist_name() ?></h3>
 			<ul class="albums-list">
 				<?php foreach ($releases as $release) : ?>
 				<li>
 					<a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img class="album_picture" src="<?php release_cover_large(); ?>"></a>
 					<h3><a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h3>
 					<?php
 					$blurb = strip_tags(release_blurb_short( false ));
 					$position = stripos($blurb, '.');

 					$first_sentence = substr($blurb, 0, $position + 1);
 					?>
 					<?php echo $first_sentence; ?>
 					<div>
	 					<ul>
	 						<li><a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>">More</a></li>
							<li><a href="javascript:popUp('<?php release_player_link (); ?>')">Listen</a></li>
							<?php if (release_physical()) : ?>
								<li><a href="<?php echo home_url(); ?>/download/<?php release_slug(); ?>/" title="Free Download">Download</a></li>
								<li><a href="<?php echo home_url(); ?>/buy/<?php release_product_id(); ?>">Buy</a></li>
							<?php else: ?>
								<li><a href="<?php echo home_url(); ?>/download/<?php release_slug(); ?>/" title="Free Download">Download</a></li>
							<?php endif; ?>
						</ul>
					</div>
 				</li>
 				<?php endforeach; ?>
 			</ul>
 		</div>
 		<?php endif; ?>
 	<?php } ?>
</div>

<?php get_footer();?>