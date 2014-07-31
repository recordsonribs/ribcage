<?php
/**
 * Ribcage Widgets
 *
 * Registers all the widgets used by Ribcage.
 *
 * @package Ribcage
 * @subpackage Widgets
 **/

class Recent_Releases extends WP_Widget {
	function __construct(){
		parent::__construct(
			'ribcage_recent_releases',
			'Recent Releases',
			array( 'description' => 'Show recent releases.')
		);	
	}

	/**
	 * Displays recent releases widget.
	 */
	public function widget ($args, $instance) {
		global $releases, $release, $artist;
	
	    extract($args);
		$releases = list_recent_releases_blurb('16');
		$artists = list_artists_blurb();
	?>
	        <?php echo $before_widget; ?>
	            <?php echo $before_title.'Recent Releases'.$after_title; ?>
				<div class="textwidget" align="left">
	            <?php while ( have_releases () ) : the_release() ; ?>	
				<?php $artist = get_artist($release['release_artist']); ?>
				<div class="artist_slug">
					<a class="slug" href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img src="<?php release_cover_tiny ();?>" alt="<?php release_title(); ?>" /></a>
					<div class="artist_slug_info">
						<ul class="artist_slug_main">
							<li class="artist"><a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/"><?php artist_name(); ?></a><h2><a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></h2></li>
						</ul>
						<ul class="artist_slug_meta">
							<li class="more"><a href="<?php echo home_url(); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>">More</a></li>
							<li class="listen"><a href="javascript:popUp('<?php release_player_link (); ?>')">Listen</a></li>
						<?php if (release_physical()) : ?>
							<li class="download"><a href="<?php echo home_url(); ?>/download/<?php release_slug(); ?>/">Free Download</a></li>
							<li class="last buy"><a href="<?php echo home_url(); ?>/buy/<?php release_product_id(); ?>">Buy</a></li>
						<?php else: ?>
							<li class="last download"><a href="<?php echo home_url(); ?>/download/<?php release_slug(); ?>/">Free Download</a></li>
						<?php endif; ?>
						</ul>
					</div> <!-- end div.artist_slug_info -->
					<div class="clear"></div>
				</div> <!-- end div.artist_slug -->
				<?php endwhile; ?>
				<div class="clear"></div>
				<p class="more_link"><a href="<?php echo home_url(); ?>/releases/">more releases &rsaquo;</a></p>
			</div>
	        <?php echo $after_widget; ?>
	<?php
	}
}

function ror_register_widgets() {
    register_widget( 'Recent_Releases' );
}

add_action( 'widgets_init', 'ror_register_widgets' );