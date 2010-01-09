<?php
/**
 * Template tags specific to Ribcage
 *
 *
 * @package Ribcage
 * @subpackage Template
 **/

/**
 * I learnt to code much of what is coded here from looking closely at the template source of Rob Miller's Now Reading Wordpress plugin.
 * This plugin can be found at http://robm.me.uk/projects/ - this is why we have the GPL!
 **/

$artists = null;
$artist = null;
$current_artist = 0;

$releases = null;
$release = null;
$current_release = 0;

$tracks = null;
$track = null;
$current_track = 0;

$reviews = null;
$review = null;
$current_review = 0;

$product = null;

/**
 * Loads a template for Ribcage specific output. 
 * There is one, a template from the currently being used theme is loaded, otherwise it is loaded from the plugin.
 * Owes a great deal to Rob Millers' Now Reading plugin. Thanks a great deal.
 *
 * @author Alex Andrews
 * @param string $filename Filename of template to be loaded.
 * @return void
 */
function ribcage_load_template ( $filename ) {
	$template = ABSPATH . TEMPLATEPATH ."/ribcage/$filename";
	
	if ( !file_exists($template) )
		$template = ABSPATH . PLUGINDIR ."/ribcage/templates/$filename";
	
	if ( !file_exists($template) )
		return new WP_Error('template-missing', sprintf(__("Oops! The template file %s could not be found in either the Ribcage template directory or your theme's Ribcage directory.", NRTD), "<code>$filename</code>"));
	
	load_template($template);
}

/**
 * Tells us if the page is an artist page or not.
 *
 * @author Alex Andrews
 * @return bool True if it is an artist page, false if it is not.
 */
function is_artist_page ()
{
	global $wp_query;
	
	if (isset($wp_query->query_vars['artist_page'])){
		return TRUE;
	}
	
	else {
		return FALSE;
	}
}


/**
 * Tells us if we are on a Ribcage page or not.
 *
 * @author Alex Andrews
 * @return bool True if we are on a Ribcage page, false if we are not.
 */
function is_ribcage_page() {
	global $wp_query, $ribcage_page;
	
	if (isset($ribcage_page)){
		return $ribcage_page;
	}
	
	$query_vars = ribcage_queryvars(array());
	
	foreach ($query_vars as $qvar) {
		if (isset($wp_query->query_vars["$qvar"])) {
			return TRUE;
		}
	}	
	return FALSE;
}

/**
 * Creates titles for Ribcage pages.
 *
 * @author Alex Andrews
 */
function ribcage_title (){
	global $wp_query;
	global $artist, $release, $releases;
	
	if ($wp_query->query_vars['pagename'] == 'artists'){
		echo 'Artists';
	}
	
	if ($wp_query->query_vars['pagename'] == 'releases'){
		echo 'Releases';
	}
	
	if (isset($wp_query->query_vars['artist_slug'])) {
		?><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/"><?php artist_name(); ?></a><?php
	}
	
	if (is_artist_page()){	
		switch ($wp_query->query_vars['artist_page']) {
			case 'press':
				?>
			&rsaquo; <a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/"><?php artist_name(); ?></a> 
				<?php
				break;

			case 'bio':
				$data .= ' &rsaquo; Biography';
				break;

			default :	
				?>
			&rsaquo; <a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug();?>"><?php release_title(); ?></a>
				<?php
		}
	}
}

/**
 * Outputs a number of recent albums in an unordered list of various kinds.
 *
 * @author Alex Andrews
 * @param int $amount The number of recent albums you want to output.
 * @param string $mode Different formats: 'list' simple list, 'covers' list of covers, similar to the sidebar widget.
 * @param bool $nav_bar Displays a navigation bar for each release.
 * @param string $css An optional css marker to put in the style of each element.
 */
function ribcage_albums ($amount = 5, $mode = 'list', $nav_bar = TRUE, $css = NULL) {
	global $releases, $release;
	global $artist;
	
	if ($releases == NULL) {
		$releases = list_recent_releases_blurb($amount);
	}
	
	?>
	<ul class="ribcage albums<?php if (isset($css)) { print " $css";}?>">
	<?php while ( have_releases () ) : the_release() ; ?>
	<?php $artist = get_artist($release['release_artist']); ?>
		<li class="ribcage albums<?php if (isset($css)) { print " $css";}?> <?php release_slug(); ?>">
			<ul class="ribcage albums<?php if (isset($css)) { print " $css";}?> <?php release_slug(); ?>">
				<?php if ($mode == 'covers') : ?>
				<li class="album_cover"><a class="ribcage albums album_cover" href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><img src="<?php release_cover_tiny ();?>" alt="<?php release_title(); ?>" /></a></li>
				<?php endif; ?>
				<li class="artist"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/"><?php artist_name(); ?></a></li>
				<li class="title"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>"><?php release_title(); ?></a></li>
				<?php if ($nav_bar) : ?>
				<li class="nav">
					<ul class="nav">
						<li class="more"><a href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/<?php release_slug(); ?>">More</a></li>
						<li class="listen"><a href="javascript:popUp('<?php release_player_link (); ?>')">Listen</a></li>
						<?php if (release_physical()) : ?>
						<li class="download"><a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/">Download</a></li>
							<li class="last buy"><a href="<?php get_option('siteurl'); ?>/buy/<?php release_product_id(); ?>">Buy</a></li>
						<?php else: ?>
						<li class="last download"><a href="<?php echo get_option('siteurl'); ?>/download/<?php release_slug(); ?>/">Download</a></li>
						<?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
			</ul>
		</li>
	<?php endwhile; ?>
	</ul>
	<?php
}

/**
 * Retrieve or display the name of the product.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the product.
 * @return string The name of the product.
 */
function product_name ( $echo = true ) {
	global $product;
	
	if ( $echo )
		echo wptexturize($product['product_name']);
	
	return $product['product_name'];
}

/**
 * Retrieve or display the description of the product.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the product description.
 * @return string The description of the product
 */
function product_description ( $echo = true ) {
	global $product;
	
	if ( $echo )
		echo wptexturize($product['product_description']);
	
	return $product['product_description'];
}

/**
 * Retrieve or display the cost of the product.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the cost of the product.
 * @return string The cost of the product.
 */
function product_cost_c ( $echo = true ) {
	global $product;
	
	if ( $echo )
		echo wptexturize($product['product_cost']+get_option('ribcage_postage_country'));
	
	return $product['product_cost']+get_option('ribcage_postage_country');
}

/**
 * Retrieve or display the cost of the product.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the cost of the product.
 * @return string The cost of the product.
 */
function product_cost_ww ( $echo = true ) {
	global $product;
	
	if ( $echo )
		echo wptexturize($product['product_cost']+get_option('ribcage_postage_worldwide'));
	
	return $product['product_cost']+get_option('ribcage_postage_worldwide');
}

/**
 * Retrieve or display the product ID number of the product.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the product ID number of the product.
 * @return string The product ID number of the product.
 */
function product_id ( $echo = true ) {
	global $product;
	
	if ( $echo )
		echo $product['product_id'];
	
	return $product['product_id'];
}

/**
 * Retrieve or display the title of the release.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the title of the release.
 * @return string The title of the release.
 */
function release_title ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo wptexturize($release['release_title']);
	
	return $release['release_title'];
}

/**
 * Retrieve or display the slug of the release.
 * Release slugs serve the same function as post slugs - they up part of the URL of the release.Ì
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the slug of the release.
 * @return string The slug of the release.
 */
function release_slug ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_slug'];
	
	return $release['release_slug'];
}

/**
 * Retrieve or display a very short, one sentence blurb for the release.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the tiny blurb of the release.
 * @return string The tiny blurb for the release.
 */
function release_blurb_tiny ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo wptexturize($release['release_blurb_tiny']);
	
	return $release['release_blurb_tiny'];
}

/**
 * Retrieve or display a short, paragraph long blurb for the release.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the short blurb of the release.
 * @return string The short blurb for the release.
 */
function release_blurb_short ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo wptexturize($release['release_blurb_short']);
	
	return $release['release_blurb_short'];
}

/**
 * Retrieve or display a long blurb for the release.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the long blurb of the release.
 * @return string The long blurb for the release.
 */
function release_blurb_long ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo wpautop(wptexturize($release['release_blurb_long']));
	
	return $release['release_blurb_long'];
}

/**
 * Retrieve or display the URL of the one sheet press release for the release.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the URL of the one sheet of the release.
 * @return string The URL of the one sheet of the release.
 */
function release_onesheet ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_one_sheet'];
	
	return $release['release_one_sheet'];
}

/**
 * Generate or display the URL for a download of a specific release.
 *
 * @author Alex Andrews
 * @param bool $echo When true we echo the download URL.
 * @return string The download URL of a release.
 */
function release_download_link ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/download/'.$release['release_slug'];
	
	return get_option('siteurl').'/download/'.$release['release_slug'];
}

function release_download_link_mp3 ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/download/'.$release['release_slug'].'/mp3';
	
	return get_option('siteurl').'/download/'.$release['release_slug'].'/mp3';
}

function release_download_size_mp3 ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo ribcage_format_filesize(filesize(ABSPATH.$release['release_mp3']));
	
	return filesize(ABSPATH.$release['release_mp3']);
}

function release_download_link_flac ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/download/'.$release['release_slug'].'/flac';
	
	return get_option('siteurl').'/download/'.$release['release_slug'].'/flac';
}

function release_download_size_flac ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo ribcage_format_filesize(filesize(ABSPATH.$release['release_flac']));
	
	return ribcage_format_filesize(filesize(ABSPATH.$release['release_flac']));
}

function release_download_link_ogg ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/download/'.$release['release_slug'].'/ogg';
	
	return get_option('siteurl').'/download/'.$release['release_slug'].'/ogg';
}

function release_download_size_ogg ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo ribcage_format_filesize(filesize(ABSPATH.$release['release_ogg']));
	
	return ribcage_format_filesize(filesize(ABSPATH.$release['release_ogg']));
}

function release_download_link_bittorrent_mp3 ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_torrent_mp3'];
	
	return $release['release_torrent_mp3'];
}

function release_download_link_bittorrent_ogg ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_torrent_ogg'];
	
	return $release['release_torrent_ogg'];
}

function release_download_link_bittorrent_flac ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_torrent_flac'];
	
	return $release['release_torrent_flac'];
}

function release_bittorrent () {
	global $release;
	
	if ($release['release_torrent_mp3'] or $release['release_torrent_ogg'] or $release['release_torrent_flac']) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function release_cover_huge ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_cover_image_huge'];
	
	return $release['release_cover_image_huge'];
}

function release_cover_large ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_cover_image_large'];
	
	return $release['release_cover_image_large'];
}

function release_cover_tiny ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_cover_image_tiny'];
	
	return $release['release_cover_image_tiny'];
}

function release_cat_no ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('ribcage_mark').str_pad($release['release_id'], 3, "0", STR_PAD_LEFT);
	
	return 	get_option('ribcage_mark').str_pad($release['release_id'], 3, "0", STR_PAD_LEFT);
}

function release_id ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo $release['release_id'];
	
	return 	$release['release_id'];
}

function release_player_link ( $echo = true ) {
	global $release;
	
	if ( $echo )
		echo get_option('siteurl').'/player/'.$release['release_slug'].'/';
	
	return get_option('siteurl').'/download/'.$release['release_slug'].'/';
}

function release_physical () {
	global $release;
	
	if ($release['release_physical']){
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function release_product_id ( $echo = TRUE ) {
	global $release;
	
	if ( $echo )
		echo $release['release_physical_cat_no'];
	
	return 	$release['release_physical_cat_no'];
}

function release_downloads ( $echo = TRUE ) {
	global $release;
	
	if ( $echo )
		echo number_format($release['release_downloads']);
	
	return 	$release['release_downloads'];
}

function artist_id ( $echo = true ) {
	global $artist;
	
	if ($echo) 
		echo $artist['artist_id'];

	return $artist['artist_id'];
}

function artist_name ( $echo = true ) {
	global $artist;
	
	if ($echo) 
		echo wptexturize($artist['artist_name']);

	return $artist['artist_name'];
}

function artist_name_sort ( $echo = true ) {
	global $artist;
	
	if ($echo) 
		echo wptexturize($artist['artist_name_sort']);

	return $artist['artist_name_sort'];
}

function artist_bio ( $echo = true ) {
	global $artist;
	
	if ($echo) {
		echo wpautop(wptexturize($artist['artist_bio']));
	}
	
	return $artist['artist_bio'];
}

function artist_slug ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_slug'];
	
	return $artist['artist_slug'];
}

function artist_press_link ( $echo = true ) {
	global $artist;
	$presslink = get_option('siteurl').'/artists/'.$artist['artist_slug'].'/press/';
	
	if ($echo)
		echo $presslink;
	
	return $presslink;
}

function artist_website_link ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_link_website'];
	
	return $artist['artist_link_website'];
}

function artist_myspace_link ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_link_myspace'];
	
	return $artist['artist_link_myspace'];
}

function artist_facebook_link ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_link_facebook'];
	
	return $artist['artist_link_facebook'];
}

function artist_lastfm_link ( $echo = true ) {
	global $artist;
	
	$lastfmlink = 'http://www.last.fm/music/'.str_replace(' ', '+',$artist['artist_name']);
	if ($echo)
		echo $lastfmlink;
	
	return $lastfmlink;
}

function artist_musicbrainz_link ( $echo = true ) {
	global $artist;
	
	$mblink = 'http://musicbrainz.org/artist/'.$artist['artist_mbid'].'.html';
	if ($echo)
		echo $mblink;
	
	return $mblink;
}

function artist_musicbrainz ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_mbid'];
		
	return $artist['artist_mbid'];
}

function artist_blurb_tiny ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo wptexturize($artist['artist_blurb_tiny']);
	
	return $artist['artist_blurb_tiny'];
}

function artist_blurb_short ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo wptexturize($artist['artist_blurb_short']);
	
	return $artist['artist_blurb_short'];
}

function artist_picture_1 ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_picture_1'];
	
	return $artist['artist_picture_1'];
}

function artist_picture_2 ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_picture_2'];
	
	return $artist['artist_picture_2'];
}

function artist_picture_3 ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_picture_3'];
	
	return $artist['artist_picture_3'];
}

function artist_picture_zip ( $echo = true ) {
	global $artist;
	
	if ( $echo )
		echo $artist['artist_picture_zip'];
	
	return $artist['artist_picture_zip'];
}


function artist_thumb ( $echo = true ) {
	global $artist;
	
	if ($echo)
		echo $artist['artist_thumb'];
	
	return $artist['artist_thumb'];
}

function have_artists () {
	global $artists, $current_artist;
	
	$have_artists = ( !empty($artists[$current_artist]) );

	if ( !$have_artists ) {
		$GLOBALS['artists']	= null;
		$GLOBALS['current_artist'] = 0;
	}
	return $have_artists;
}

function the_artist (){
	global $artists, $artist, $current_artist;

	$GLOBALS['artist'] = $artists [$current_artist];
	$GLOBALS['current_artist']++;
}

function track_title ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo wptexturize($track['track_title']);
	
	return $track['track_title'];
}

function track_stream ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo $track['track_stream'];
	
	return $track['track_stream'];
}

function track_no ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo $track['track_number'];
	
	return $track['track_number'];
}

function track_id ( $echo = true ) {
	global $track;
	
	if ($echo)
		echo $track['track_id'];
	
	return $track['track_id'];
}

function track_time ( $echo = true ) {
	global $track;
	
 	$split = explode (':', $track['track_time']);
	$str = str_split ($split[1]);
	
	if ($echo) {
		if ($str[0] == 0) {
			echo $str[1].'.'.$split[2];
		}
		else {
			echo $split[1].'.'.$split[2];
		}
	}
	
	return $split[1].'.'.$split[2];
}

function have_tracks () {
	global $tracks, $current_track;
	
	$have_tracks = ( !empty($tracks[$current_track]) );

	if ( !$have_tracks ) {
		$GLOBALS['tracks']	= null;
		$GLOBALS['current_track'] = 0;
	}
	return $have_tracks;
}

function the_track (){
	global $tracks, $track, $current_track;

	$GLOBALS['track'] = $tracks [$current_track];
	$GLOBALS['current_track']++;
}

function have_releases () {
	global $releases, $current_release;
	
	$have_releases = ( !empty($releases[$current_release]) );

	if ( !$have_releases ) {
		$GLOBALS['releases']	= null;
		$GLOBALS['current_release'] = 0;
	}
	return $have_releases;
}

function the_release (){
	global $releases, $release, $current_release, $tracks;

	$GLOBALS['release'] = $releases [$current_release];
	$GLOBALS['tracks'] = $release ['release_tracks'];
	$GLOBALS['current_release']++;
}

function have_reviews () {
	global $reviews, $current_review;
	
	$have_reviews = ( !empty($reviews[$current_review]) );

	if ( !$have_reviews ) {
		$GLOBALS['reviews']	= null;
		$GLOBALS['current_review'] = 0;
	}
	return $have_reviews;
}

function the_review (){
	global $reviews, $review, $current_review;

		$GLOBALS['review'] = $reviews [$current_review];
		$GLOBALS['current_review']++;
}

function review_text ( $echo=true ){
	global $review;
	
	if ($echo)
		echo $review['review_text'];
	
	return $review['review_text'];
}

function review_author ( $echo=true ){
	global $review;
	
	if ($echo)
		echo $review['review_author'];
	
	return $review['review_author'];
}

function review_link ( $echo=true ){
	global $review;
	
	if ($echo)
		echo $review['review_link'];
	
	return $review['review_link'];
}
?>