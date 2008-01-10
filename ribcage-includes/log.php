<?php

// Log a download or stream.
function ribcage_log ( $t = FALSE){
	global $wpdb, $wp_query;
	global $userdata;
	global $release, $track;
	
	get_currentuserinfo();
	
	// Download mode, single track
	if ($t == TRUE) {		
		$log = sprintf("
		INSERT INTO  `%s` (
		`download_id` ,
		`download_track_id` ,
		`download_time` ,
		`download_user` ,
		`download_ip` ,
		`download_format`
		)
		VALUES (
		NULL ,  '%s',  '%s',  '%s',  '%s',  '%s'
		);
		",
		$wpdb->ribcage_log_download_tracks,
		$track['track_id'],
		date("Y-m-d H:i:s"),
		$userdata->user_login,
		$_SERVER['REMOTE_ADDR'],
		$wp_query->query_vars['format']
		);
	}
	
	// Download mode, whole release
	else {	
		ribcage_log_release_plus();
		
		$log = sprintf("
		INSERT INTO  `%s` (
		`download_id` ,
		`download_release_id` ,
		`download_time` ,
		`download_user` ,
		`download_ip` ,
		`download_format`
		)
		VALUES (
		NULL ,  '%s',  '%s',  '%s',  '%s',  '%s'
		);
		",
		$wpdb->ribcage_log_download_releases,
		$release['release_id'],
		date("Y-m-d H:i:s"),
		$userdata->user_login,
		$_SERVER['REMOTE_ADDR'],
		$wp_query->query_vars['format']
		);	
	}	
	
	$wpdb->query("$log");
	
	return (0);
}

// ++ the download counter of a release in our database.
function ribcage_log_release_plus(){	
	global $wpdb;
	global $release;
	
	$total = $release['release_downloads'] + 1;
	
	$log = 'UPDATE '.$wpdb->ribcage_releases.' SET release_downloads ='.$total.' WHERE release_id ='.$release['release_id'];
	$wpdb->query("$log");
	
	return(0);
}

// Player mode log, this information comes directly from the player callback.
//
// The callback consist of the POST variables file, title, id, state and duration. 
// The first three are item properties, the state is either "start" (when an item starts) 
// or "stop" (when an item has ended or the user switched to a new item). The duration comes
// only with a stop and contains the time for which the item has been played in seconds.
function ribcage_log_play () {
	global $wpdb, $wp_query;
	
	get_currentuserinfo();

	// If the state is stop then someone has actually played something. Log it.
		
		$log = sprintf("
			INSERT INTO  `%s` (
			`stream_id` ,
			`stream_track_id` ,
			`stream_time` ,
			`stream_duration`,
			`stream_user` ,
			`stream_ip`
			)
			VALUES (
			NULL ,  '%s',  '%s',  '%s',  '%s',  '%s'
			);
			",
			$wpdb->ribcage_log_stream,
			$_POST['id'],
			date("Y-m-d H:i:s"),
			$_POST['duration'],
			$userdata->user_login,
			$_SERVER['REMOTE_ADDR']
			);
			
			$wpdb->query("$log");

			return (0);
}
?>