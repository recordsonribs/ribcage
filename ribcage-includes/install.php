<?php 		
/**
 * Ribcage installation functions.
 *
 * @author Paolo Tresso of Pixline (supporto@pixline.net), Alex Andrews (alex@recordsonribs.com)
 * @package Ribcage
 * @subpackage Installation
 **/

if (!empty($wpdb->charset)) { 
	$charset = "$wpdb->charset";
}
else {
	$charset = "utf8";
}

if (!empty($wpdb->collate)) {	
	$collate = "$wpdb->collate";
}
else {
	$collate = "utf8_unicode_ci";
}

// Ribcage database schema

$ribcage_schema = "
	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_artists." (
	  `artist_id` bigint(20) NOT NULL auto_increment COMMENT 'Unique artist ID.',
	  `artist_name` text collate ".$collate." NOT NULL COMMENT 'The artist''s name.',
	  `artist_name_sort` text collate ".$collate." NOT NULL COMMENT 'The name the artist is sorted by eg Butterfly, The.',
	  `artist_slug` tinytext collate ".$collate." NOT NULL COMMENT 'The name of the artist without punctuation, for a link. http://recordsonribs.com/artists/{artist_slug}',
	  `artist_mbid` tinytext collate ".$collate." NOT NULL COMMENT 'Artist''s Music Brainz ID.',
	  `artist_signed` date NOT NULL COMMENT 'The date the artist signed with us.',
	  `artist_license` enum('by-nc-sa','by','by-nc','by-nd','by-sa','by-nc-nd') collate ".$collate." NOT NULL COMMENT 'Creative Commons license for artist (default) see http://en.wikipedia.org/wiki/Creative_Commons_licenses',
	  `artist_bio` text collate ".$collate." NOT NULL COMMENT 'A long biography of the artist.',
	  `artist_thumb` tinytext collate ".$collate." NOT NULL,
	  `artist_picture_1` tinytext collate ".$collate." NOT NULL COMMENT 'A URL of a fairly large picture of the artist (1-3).',
	  `artist_picture_2` tinytext collate ".$collate." NOT NULL COMMENT 'A URL of a fairly large picture of the artist (2-3).',
	  `artist_picture_3` tinytext collate ".$collate." NOT NULL COMMENT 'A URL of a fairly large picture of the artist (3-3).',
	  `artist_picture_zip` tinytext collate ".$collate." NOT NULL COMMENT 'A file location of a zip file containing high quality images of the artists for the press.',
	  `artist_contact_email` tinytext collate ".$collate." NOT NULL COMMENT 'E-mail address of the artist',
	  `artist_contact_phone` tinytext collate ".$collate." NOT NULL COMMENT 'Phone number of the artist',
	  `artist_blurb_tiny` text collate ".$collate." NOT NULL COMMENT 'A very short description of the artist (one sentence)',
	  `artist_blurb_short` text collate ".$collate." NOT NULL COMMENT 'Short description of the artist (one paragraph).',
	  `artist_link_website` tinytext collate ".$collate." NOT NULL COMMENT 'The artist''s website.',
	  `artist_link_myspace` tinytext collate ".$collate." NOT NULL COMMENT 'The artist''s myspace link.',
	  `artist_link_facebook` tinytext collate ".$collate." NOT NULL COMMENT 'URL of Facebook Group',
	  PRIMARY KEY  (`artist_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=".$charset." COLLATE=".$collate." AUTO_INCREMENT=17 ;

	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_donations." (
	  `donate_id` bigint(20) NOT NULL auto_increment,
	  `donate_ipn` mediumtext collate ".$collate." NOT NULL,
	  PRIMARY KEY  (`donate_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=".$charset." COLLATE=".$collate." AUTO_INCREMENT=43 ;

	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_log_download_releases." (
	  `download_id` bigint(20) NOT NULL auto_increment,
	  `download_release_id` bigint(20) NOT NULL,
	  `download_time` datetime NOT NULL,
	  `download_user` tinytext collate ".$collate." NOT NULL,
	  `download_ip` varchar(15) collate ".$collate." NOT NULL,
	  `download_format` varchar(4) collate ".$collate." NOT NULL,
	  PRIMARY KEY  (`download_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=".$charset." COLLATE=".$collate." AUTO_INCREMENT=97592 ;

	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_log_download_tracks." (
	  `download_id` bigint(20) NOT NULL auto_increment,
	  `download_track_id` bigint(20) NOT NULL,
	  `download_time` datetime NOT NULL,
	  `download_user` tinytext collate ".$collate." NOT NULL,
	  `download_ip` varchar(15) collate ".$collate." NOT NULL,
	  `download_format` varchar(4) collate ".$collate." NOT NULL,
	  PRIMARY KEY  (`download_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=".$charset." COLLATE=".$collate." AUTO_INCREMENT=1 ;

	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_log_stream." (
	  `stream_id` bigint(20) NOT NULL auto_increment,
	  `stream_track_id` bigint(20) NOT NULL,
	  `stream_time` datetime NOT NULL,
	  `stream_duration` bigint(20) NOT NULL,
	  `stream_state` varchar(5) collate ".$collate." NOT NULL,
	  `stream_user` tinytext collate ".$collate." NOT NULL,
	  `stream_ip` varchar(15) collate ".$collate." NOT NULL,
	  PRIMARY KEY  (`stream_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=".$charset." COLLATE=".$collate." AUTO_INCREMENT=16453 ;

	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_orders." (
	  `order_id` bigint(20) NOT NULL auto_increment COMMENT 'ID of the order for tracking purposes',
	  `order_product` bigint(20) NOT NULL COMMENT 'Product ID of the order',
	  `order_paid` tinyint(1) NOT NULL default '0' COMMENT 'Has this been paid for?',
	  `order_ipn` longtext collate ".$collate." NOT NULL,
	  PRIMARY KEY  (`order_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=".$charset." COLLATE=".$collate." COMMENT='Ribcage database to handle incoming orders from the shop.' AUTO_INCREMENT=1 ;

	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_products." (
	  `product_id` bigint(20) NOT NULL auto_increment COMMENT 'ID of the actual product',
	  `product_related_release` bigint(20) NOT NULL COMMENT 'Release that this product is related to, if neccesary.',
	  `product_name` tinytext collate ".$collate." NOT NULL COMMENT 'Name of the product',
	  `product_description` longtext collate ".$collate." NOT NULL COMMENT 'Description of product.',
	  `product_cost` float NOT NULL COMMENT 'Cost of product in pounds stirling.',
	  PRIMARY KEY  (`product_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=".$charset." COLLATE=".$collate." AUTO_INCREMENT=28 ;

	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_releases." (
	  `release_id` bigint(20) NOT NULL auto_increment COMMENT 'A unique ID for the release.',
	  `release_artist` bigint(20) NOT NULL COMMENT 'The artist ID related to the release - this is then looked up in the artists database.',
	  `release_date` date NOT NULL COMMENT 'The release date.',
	  `release_title` text collate ".$collate." NOT NULL COMMENT 'The title of the release.',
	  `release_slug` text collate ".$collate." NOT NULL,
	  `release_time` time NOT NULL COMMENT 'The total time of the release.',
	  `release_mbid` tinytext collate ".$collate." NOT NULL COMMENT 'Musicbrainz ID of the release.',
	  `release_blurb_tiny` text collate ".$collate." NOT NULL COMMENT 'A very short (one sentence) blurb for the release.',
	  `release_cover_image_tiny` tinytext collate ".$collate." NOT NULL,
	  `release_cover_image_large` tinytext collate ".$collate." NOT NULL COMMENT 'A URL of a large image of the cover.',
	  `release_cover_image_huge` tinytext collate ".$collate." NOT NULL COMMENT 'Huge version of the cover, for press use.',
	  `release_one_sheet` tinytext collate ".$collate." NOT NULL COMMENT 'The URL of the onesheet of the release.',
	  `release_blurb_short` text collate ".$collate." NOT NULL COMMENT 'A short blurb about the release.',
	  `release_blurb_long` text collate ".$collate." NOT NULL COMMENT 'A long blurb about the release.',
	  `release_tracks_no` bigint(20) NOT NULL COMMENT 'How many tracks are on the release?',
	  `release_mp3` tinytext collate ".$collate." NOT NULL COMMENT 'File location of the MP3 zip file.',
	  `release_ogg` tinytext collate ".$collate." NOT NULL COMMENT 'File location of the Ogg Vobris zip file.',
	  `release_flac` tinytext collate ".$collate." NOT NULL COMMENT 'File location of the FLAC zip file.',
	  `release_torrent_mp3` tinytext collate ".$collate." NOT NULL COMMENT 'URL of a torrent for the complete release.',
	  `release_downloads` bigint(20) NOT NULL COMMENT 'How many times has the complete release been downloaded?',
	  `release_physical` tinyint(1) NOT NULL COMMENT 'Do we have a physical as well?',
	  `release_physical_cat_no` smallint(6) NOT NULL COMMENT 'The catalogue number of the physical release. (Normally one greater than the download release ID)',
	  `release_torrent_ogg` tinytext collate ".$collate." NOT NULL,
	  `release_torrent_flac` tinytext collate ".$collate." NOT NULL,
	  PRIMARY KEY  (`release_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=".$charset." COLLATE=".$collate." AUTO_INCREMENT=30 ;

	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_reviews." (
	  `review_id` bigint(20) NOT NULL auto_increment,
	  `review_release_id` bigint(20) NOT NULL,
	  `review_text` text collate ".$collate." NOT NULL,
	  `review_date` date NOT NULL,
	  `review_link` tinytext collate ".$collate." NOT NULL,
	  `review_author` tinytext collate ".$collate." NOT NULL,
	  `review_weight` smallint(4) NOT NULL,
	  PRIMARY KEY  (`review_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=".$charset." COLLATE=".$collate." AUTO_INCREMENT=58 ;

	CREATE TABLE IF NOT EXISTS ".$wpdb->ribcage_tracks." (
	  `track_id` bigint(20) NOT NULL auto_increment COMMENT 'Unique track ID.',
	  `track_release_id` bigint(20) NOT NULL COMMENT 'The release the track is attached to.',
	  `track_mbid` tinytext collate ".$collate." NOT NULL COMMENT 'Track''s Musicbrainz ID.',
	  `track_title` text collate ".$collate." NOT NULL COMMENT 'The title of the track.',
	  `track_slug` tinytext collate ".$collate." NOT NULL,
	  `track_number` bigint(20) NOT NULL COMMENT 'The track number on the release.',
	  `track_time` time NOT NULL COMMENT 'The length of time of the track.',
	  `track_mp3` tinytext collate ".$collate." NOT NULL COMMENT 'A file location of the track as MP3.',
	  `track_ogg` tinytext collate ".$collate." NOT NULL COMMENT 'A file location of the track as Ogg Vobris.',
	  `track_flac` tinytext collate ".$collate." NOT NULL COMMENT 'A file location of the track as FLAC.',
	  `track_stream` tinytext collate ".$collate." NOT NULL COMMENT 'A file location of the track to stream (generally a 128 kbps CBR MP3)',
	  PRIMARY KEY  (`track_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=".$charset." COLLATE=".$collate." AUTO_INCREMENT=200 ;

";

?>