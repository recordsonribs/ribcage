<?php

$wpdb->ribcage_artists = $wpdb->prefix."ribcage_artists";
$wpdb->ribcage_releases = $wpdb->prefix."ribcage_releases";
$wpdb->ribcage_tracks = $wpdb->prefix."ribcage_tracks";
$wpdb->ribcage_reviews = $wpdb->prefix."ribcage_reviews";
$wpdb->ribcage_clippings = $wpdb->prefix."ribcage_clippings";

$wpdb->ribcage_log_stream = $wpdb->prefix."ribcage_log_stream";

$wpdb->ribcage_log_download_releases = $wpdb->prefix."ribcage_log_download_releases";
$wpdb->ribcage_log_download_tracks = $wpdb->prefix."ribcage_log_download_tracks";

$wpdb->ribcage_products = $wpdb->prefix."ribcage_products";
$wpdb->ribcage_orders = $wpdb->prefix."ribcage_orders";

$wpdb->ribcage_donations = $wpdb->prefix."ribcage_donations";

function ribcage_release_feeds(){
	global $wp_query;
	
	?>
	<link rel="alternate" type="application/rss+xml" href="<?php echo get_option('siteurl'); ?>/releases/feed" title="<?php echo get_option('blogname'); ?> Releases RSS feed" />
	<?php
	
	if (isset($wp_query->query_vars['artist_slug'])){
		?>
		<link rel="alternate" type="application/rss+xml" href="<?php echo get_option('siteurl'); ?>/artists/<?php artist_slug(); ?>/feed" title="<?php artist_name(); ?> Releases RSS feed" />
		<?php	
	}
}

// is_ribcage_page
// No input.
// Returns true if we are on a Ribcage page, and false otherwise.
function is_ribcage_page() {
	global $wp_query;
	
	$qvars = ribcage_queryvars(array());
	
	foreach ($qvars as $qvar) {
		if (isset($wp_query->query_vars["$qvar"])) {
			return TRUE;
		}
	}	
	return FALSE;
}

// list_recent_releases_blurb
// Input amount of releases you want back.
// Returns recent releases as associative array.
function list_recent_releases_blurb ( $amount = 0 )
{
	global $wpdb;
	
	$now_date = gmdate('Y-m-d');
	if ($amount) {
		$releases = $wpdb->get_results("SELECT release_id FROM $wpdb->ribcage_releases WHERE release_date <= '$now_date' ORDER BY release_id DESC LIMIT $amount ", ARRAY_A);
	}
	else {
		$releases = $wpdb->get_results("SELECT release_id FROM $wpdb->ribcage_releases WHERE release_date <= '$now_date' ORDER BY release_id DESC", ARRAY_A);
	}
	
	if (isset($releases)) {
		foreach ($releases as $release){
			$return[] = get_release($release['release_id']);		
		}
	}	
	return $return;
}

// list_artists
// No input. 
// Returns a list of artists (their name, their blurb_short, their press photo) as an associative array, sorted by alphabetically by their name.
function list_artists_blurb (){
	global $wpdb;	
	$querystr = "
	SELECT artist_name, artist_slug, artist_id, artist_name_sort, artist_picture_1, artist_thumb, artist_blurb_short, artist_blurb_tiny FROM $wpdb->ribcage_artists
	ORDER BY `artist_name_sort`";
	$return = $wpdb->get_results($querystr, ARRAY_A);
	return $return;
}

// list_artist_releases
// Input the artist id.
// Returns an associative array of their releases.
function list_artist_releases ($artist_id){
	global $wpdb;
	
	$now_date = gmdate('Y-m-d');
	$releases = $wpdb->get_results("SELECT release_id FROM $wpdb->ribcage_releases WHERE release_artist = $artist_id AND release_date <= '$now_date' ORDER BY release_id DESC", ARRAY_A);
	
	if (isset($releases)) {
		foreach ($releases as $release){
			$return[] = get_release($release['release_id']);		
		}
	}
	
	return $return;
}

// get_*
// -------
// The following functions fetch various things from the database.
// or maybe just don't bother appending fullstop?? We'll see.
// TODO Errors, bailing out if we can't find the artist, track, etc.

// get_product 
// Input product id
// Returns product as associative array.
function get_product ($product_id) {
	global $wpdb;
	
	$return = $wpdb->get_row("SELECT * FROM $wpdb->ribcage_products WHERE product_id = $product_id", ARRAY_A);
	
	return $return;
}


// get_release
// Input the release id.
// Returns release as associative array.
// TODO: Inefficent to get the reviews and the tracks as well - implement the same method as get_release_by_slug
function get_release ($release_id, $tracks = true, $reviews = true){
	global $wpdb;
	
	$now_date = gmdate('Y-m-d');	
	$return = $wpdb->get_row("SELECT * FROM $wpdb->ribcage_releases WHERE release_id = $release_id AND release_date <= '$now_date'", ARRAY_A);
	
	if ($tracks == true){
		$return['release_tracks'] = get_tracks ($return['release_id']);
	}
	
	if ($reviews == true){		
		$return['release_reviews'] = get_reviews ($return['release_id']);
	}
	
	return $return;
}

// get_release_by_slug
// Input the release slug and noextras if you don't want the tracks or reviews appended.
// Returns release as associative array.
function get_release_by_slug ($release_slug, $tracks = true, $reviews = true){
	global $wpdb;
	
	$now_date = gmdate('Y-m-d');
	
	$return = $wpdb->get_row("SELECT * FROM $wpdb->ribcage_releases WHERE release_slug = '$release_slug' AND release_date <= '$now_date'", ARRAY_A);
	
	if ($tracks == true){
		$return['release_tracks'] = get_tracks ($return['release_id']);
	}
	
	if ($reviews == true){		
		$return['release_reviews'] = get_reviews ($return['release_id']);
	}
	
	return $return;
}

function get_releasename_by_slug ($release_slug){
	global $wpdb;
	$return = $wpdb->get_var("SELECT release_title FROM $wpdb->ribcage_releases WHERE release_slug = '$release_slug'");
	
	return $return;
}

// get_artist
// Input the artist id.
// Returns artist information as associative array.
function get_artist ($artist_id){
	global $wpdb;
	$return = $wpdb->get_row("SELECT * FROM $wpdb->ribcage_artists WHERE artist_id = $artist_id", ARRAY_A);	
	return $return;
}

// get_artist_by_slug
// Input the artist id.
// Returns artist information as associative array.
function get_artist_by_slug ($artist_slug){
	global $wpdb;
	$querystr = "SELECT * FROM $wpdb->ribcage_artists WHERE artist_slug = '$artist_slug'";
	$return = $wpdb->get_row($querystr, ARRAY_A);	
	return $return;
}
// get_tracks
// Input the release id.
// Returns tracks on release as an associative array.
function get_tracks ($release_id){
	global $wpdb;
	$querystr = "
	SELECT * FROM $wpdb->ribcage_tracks WHERE track_release_id = $release_id
	ORDER BY track_number
	";
	$return = $wpdb->get_results($querystr, ARRAY_A);
	return $return;	
}

//get_reviews
// Input the release id.
// Returns reviews of the release as an associative array.
function get_reviews ($release_id){
	global $wpdb;
	$querystr = "
	SELECT * FROM $wpdb->ribcage_reviews WHERE review_release_id = $release_id
	ORDER BY review_date
	";
	$return = $wpdb->get_results($querystr, ARRAY_A);
	return $return;
}

// get_track_by_slug
// Input the track slug.
// Returns track as an associative array.
function get_track_by_slug ($track_slug) {
	global $wpdb;
	$querystr = "SELECT * FROM $wpdb->ribcage_tracks WHERE track_slug = '$track_slug'";
	$return = $wpdb->get_row($querystr, ARRAY_A);
	return ($return);
}

// get_artistname_by_id
// Input artist id.
function get_artistname_by_id ($artist_id) {
	global $wpdb;
	$return = $wpdb->get_var("SELECT artist_name FROM $wpdb->ribcage_artists WHERE artist_id = $artist_id");	
	return $return;
}

// get_artistname_by_id
// Input artist id.
function get_artistname_by_slug ($artist_slug) {
	global $wpdb;
	$return = $wpdb->get_var("SELECT artist_name FROM $wpdb->ribcage_artists WHERE artist_slug = '$artist_slug'");	
	return $return;
}


// from wp-download manager by Lester 'GaMerZ' Chan (http://lesterchan.net/portfolio/programming.php)
function ribcage_format_filesize($rawSize) {
	if($rawSize / 1099511627776 > 1) {
		return round($rawSize/1099511627776, 1) . ' TB';
	} elseif($rawSize / 1073741824 > 1) {
		return round($rawSize/1073741824, 1) . ' GB';
	} elseif($rawSize / 1048576 > 1) {
		return round($rawSize/1048576, 1) . ' MB';
	} elseif($rawSize / 1024 > 1) {
		return round($rawSize/1024, 1) . ' KB';
	} elseif($rawSize > 1) {
		return round($rawSize, 1) . ' bytes';
	} else {
		return __('unknown', 'ribcage');
	}
}

?>