<?php

function ribcage_admin_index ()
{	
	?>
	<div class="wrap">
		<h2>Ribcage</h2>
	</div>	
	<?php
}

/**
 * Administration panel for adding a release.
 *
 * @return void
 * @author Alex Andrews
 */
function ribcage_add_release()
{
	global $release, $artist, $tracks, $track;
	
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Add Release</h2>
	<?php
	$release = $_POST['release'];
	$release = stripslashes($release);
	$release = unserialize($release);
	
	unset($_POST['release']);
	unset($_POST['Submit']);
	
	// Stage 3 - Add the release to the database.
	if ($_REQUEST['ribcage_action'] == 'add_release' && $_REQUEST['ribcage_step'] == '2'){	
		$total_tracks = $release['release_tracks_no'];
		$t = 1;
		
		while (count($tracks) != $total_tracks){
			$tracks [] = array(
				'track_number'=>$_POST["track_number_$t"],
				'track_title'=>$_POST["track_title_$t"],
				'track_time'=>$_POST["track_time_$t"],
				'track_release_id' => $release['release_id'],
				'track_mbid' => $_POST["track_mbid_$t"],
				'track_slug' => ribcage_slugize($_POST["track_title_$t"]),
				'track_stream' => get_option('siteurl').get_option('ribcage_file_location').'audio'.ribcage_slugize($_POST['track_title_$t']).'/'.ribcage_slugize($release['release_title']).'/stream/'.str_pad($t,2, "0", STR_PAD_LEFT).'.mp3'
				);
			$t++;
		}
		
		//$release['release_tracks'] = $tracks;
		
		?>
		<h3>Stage 3 of 3</h3>
		<p>Added <?php artist_name(); ?> - <?php release_title(); ?> to the database.</p>
		<p>It will be live on the site on </p>
		<?php
		global $wpdb;
			
		$wpdb->show_errors();
		
		$string_keys = implode(array_keys($release),",");
		$string_values = "'".implode(array_values($release),"','")."'";
		
		$sql = "INSERT INTO ".$wpdb->prefix."ribcage_releases
					($string_keys)
					VALUES
					($string_values)";
		$results = $wpdb->query( $sql );
		$wpdb->hide_errors();
		
		echo '<pre>';
		print_r($release);
		echo '</pre>';
		return 0;
	}
	
	// Stage 2 - Check release tracks are correct.
	elseif ($_REQUEST['ribcage_action'] == 'add_release') {
		// Get the tracks we have been sent, if we have been sent any.
		if (isset($_POST['release_tracks'])){
			$tracks = $_POST['release_tracks'];
			$tracks = stripslashes($tracks);
			$tracks = unserialize($tracks);
		}
		
		$artist = get_artist($_POST['release_artist']);
		$release['release_artist'] = $_POST['release_artist'];
		$release['release_tracks'] = $tracks;
		
		// Whack all the inputed variables into $release
		foreach ($_POST as $key => $var) {
			$release[$key] = $var;
		}
		?>
		<h3>Stage 2 of 3</h3>
		<p>Please check the following details of the release.</p>
		<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&ribcage_step=2" method="post" id="ribcage_add_release" name="add_release">
		<table class="form-table">  
			<tr>
				<th scope="row"><strong><?php artist_name(); ?> - <?php release_title(); ?></strong></th>
			</tr>
			<?php $track_count = 1;?>
			<?php while ( have_tracks () ) : the_track() ; ?>
			<tr>
				<th scope="row">
					<input type="text" style="width:30px;" class="regular-text" value="<?php track_no(); ?>" name="track_number_<?php echo $track_count; ?>" id="track_number_<?php echo $track_count; ?>" maxlength="200" />
				</th>
				<td>
					<input type="text" style="width:320px;" class="regular-text" value="<?php track_title(); ?>" name="track_title_<?php echo $track_count; ?>" id="track_title_<?php echo $track_count; ?>" maxlength="200" />						
				</td>
				<td>
					<input type="text" style="width:40px;" class="regular-text" value="<?php echo $track['track_time']; ?>" name="track_time_<?php echo $track_count; ?>" id="track_time_<?php echo $track_count; ?>" maxlength="200" />
					<input type="hidden" name="track_mbid_<?php echo $track_count; ?>" value='<?php echo $track['track_mbid'] ?>' />											
				</td>
			</tr>
			<?php $track_count++;?>
			<?php endwhile; ?>      
		</table>
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
		</p>
		<?php
		echo '<pre>';
		print $sql;
		print_r($release);
		echo '</pre>';
		// All the other variables as hidden.
		unset($release['release_tracks']);
		$release = serialize($release); ?>
		<input type="hidden" name="release" value='<?php print_r($release); ?>' />
		</form>
		</div>
		<?php
		return 0;
	}
	else {
	if ($_POST['lookup'] != '') {
		if ($_POST['lookup'] == 'Lookup')	{
			$mbid = $_POST['musicbrainz_id'];		
			$result = mb_get_release($mbid);

			if (is_wp_error($result)){
				?>
				<?php
				switch ($result->get_error_code()){
					case 'mb_not_found': ?>
						<p>Ribcage could not find a release with a MBID of <?php echo $mbid; ?> in the Musicbrainz database.</p>
						<p>Please enter the release manually, but don't forget to add it to Musicbrainz afterwards.</p>
						<?php
					break;
					case 'artist_not_found': ?>
						<p><?php echo $artist; ?> is not an artist in the Ribcage database. Yet.</p>
						<p>You need to <a href="admin.php?page=add_artist">add an artist</a> before you can add their releases.</p>
						<?php
						return (1);
					break;
				}
				
				?>
				</div>
				<?php
			}
			
			$artist_slug = $artist['artist_slug'];
			
			// Guess some things about our release.
			$release = array_merge($release,array(
				'release_cover_image_tiny' => get_option('siteurl').get_option('ribcage_image_location').'covers/tiny/'.$release['release_slug'].'.jpg',
				'release_cover_image_large' => get_option('siteurl').get_option('ribcage_image_location').'covers/large/'.$release['release_slug'].'.jpg',
				'release_cover_image_huge' =>get_option('siteurl').get_option('ribcage_image_location').'covers/huge/'.$release['release_slug'].'.jpg',
				'release_mp3' => get_option('ribcage_file_location').$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-mp3.zip',
				'release_ogg' => get_option('ribcage_file_location').$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-ogg.zip',
				'release_flac' => get_option('ribcage_file_location').$artist_slug.'/'.$release['release_slug'].'/download/zip/'.$release['release_slug'].'-flac.zip',
			));
		}
		
		$tracks = serialize($release['release_tracks']);
		
		// If we haven't got an artist from Musicbrainz then we need to display a drop down of all the artists so they can choose.
		// Stage 1 - Add the details of the release or correct those from Musicbrainz
		?>
		<h3>Stage 1 of 3</h3>
		<p>Add the following details for the release, then you will be able to add tracks.</p>
		<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&ribcage_action=add_release" method="post" id="ribcage_add_release" name="add_release">
		<table class="form-table">             
			<tr valign="top">
				<th scope="row"><label for="artist_name">Artist</label></th> 
				<td>
					<?php artist_name(); ?>												
				</td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="release_title">Release Name</label></th> 
				<td>
					<input type="text" style="width:320px;" class="regular-text code" value="<?php release_title(); ?>" name="release_title" id="release_title" maxlength="200" />										
				</td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="release_title">Release Slug</label></th> 
				<td>
					<input type="text" style="width:320px;" class="regular-text code" value="<?php release_slug(); ?>" name="release_slug" id="release_slug" maxlength="200" /><span class="description">The URL you want for the release after the artist name, for example <?php echo get_option('siteurl'); ?>/artist_name/release_slug</span>										
				</td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="release_title">Release Date</label></th> 
				<td>
					<input type="text" style="width:320px;" class="regular-text code" value="<?php echo $release['release_date']; ?>" name="release_date" id="release_date" maxlength="200" /><span class="description">When is the record going to come out?</span>										
				</td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="release_id">Catalogue Number</label></th> 
				<td>
					<?php echo get_option('ribcage_mark'); ?><input type="text" style="width:30px;" class="regular-text code" value="<?php echo $release['release_id']; ?>" name="release_id" id="release_id" maxlength="10" /><span class="description">This will be padded to be three digits</span>									
				</td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="release_tracks_no">Number Of Tracks</label></th> 
				<td>
					<input type="text" style="width:30px;" class="regular-text code" value="<?php echo $release['release_tracks_no']; ?>" name="release_tracks_no" id="release_tracks_no" />									
				</td> 
			</tr>
			<?php
			// Rough way of doing this until I have set each of the elements by hand, as it were.
			foreach ($release as $key => $val){
				?>
				<tr valign="top">
					<th scope="row"><label for="<?php echo "$key"; ?>"><?php echo "$key"; ?></label></th> 
					<td>
						<input type="text" style="width:300px;" class="regular-text code" value="<?php echo "$val"; ?>" name="<?php echo "$key"; ?>" id="<?php echo "$key"; ?>" />									
					</td> 
				</tr>
				<?php
			}
			?>
		</table>
		<input type="hidden" name="release_mbid" value="<?php echo $release['release_mbid']; ?>" />
		<input type="hidden" name="release_artist" value="<?php echo $release['release_artist']; ?>" />
		<input type="hidden" name="release_tracks" value='<?php print_r($tracks); ?>' />
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="Next" />
		</p>
		</form>
		<pre><?php print_r($release); ?></pre>
		<?php
	}
	// Display the start with the Musicbrainz lookup form.
	else {
	?>
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<p>Please enter the <a href="http://musicbrainz.org">Musicbrainz</a> ID and Ribcage will lookup the release and fill in the details automtically. This should be the Musicbrainz ID of the specific release, not the release group.</p> <p>If your release does not have a Musicbrainz ID, or if you wish to enter the release entirely manually, click on Skip.</p>
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="musicbrainz_id">Musicbrainz ID</label></th>
		<td><input type="text" name="musicbrainz_id" value="bce40d0a-6b5f-4d75-97c7-916d67d584f6" class="regular-text code"/></td>
		</tr>
		</table>
		<p class="submit">
		<input type="submit" name="lookup" class="button-primary" value="<?php _e('Lookup') ?>" /><input type="submit" name="lookup" class="button-secondary" value="<?php _e('Skip') ?>" />
		</p>
		</form>
	<?php
	}
}
	?>
	</div>
	<?php
	
}

function ribcage_add_review($value='')
{
	global $releases, $release,$artist, $tracks, $track;
	
	$releases = list_recent_releases_blurb();
	
	?>
	<div class="wrap">
		<h2>Add Review</h2>
		<?php
		if (isset($_POST['release_id'])){
			$release = get_release($_POST['release_id']);
			$artist = get_artist($release['release_artist']);
			?>
			<h3>Stage 2 of 2</h3>
			<form>
			<p>Add a review of <strong><?php artist_name(); ?> - <?php release_title(); ?></strong></p>
			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="Add Review" />
			</p>
			</form>
			<?php
		}
		else {
		?>
		<h3>Stage 1 of 2</h3>
		<p>Add a review of one of your releases.</p>
		<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_add_review" name="add_review">
		<select name="release_id" id="release_id">
			<?php while ( have_releases () ) : the_release() ; ?>
			<?php $artist = get_artist($release['release_artist']); ?>
			<option value="<?php release_id (); ?>"><?php artist_name(); ?> - <?php release_title(); ?></option>
			<?php endwhile; ?>
		</select>
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="Next" />
		</p>
		</form>
	<?php
	}
	?>
	</div>
	<?php
}
function ribcage_add_press($value='')
{
	?>
	<div class="wrap">
		<h2>Add Press</h2>
		
	</div>
	<?php
}

/**
 * Displays form for changing Ribcage options.
 *
 * @return void
 **/
function ribcage_options()
{
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Ribcage</h2>
		<form method="post" action="options.php">
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="ribcage_paypal_email">Paypal E-mail Address</label></th>
		<td><input type="text" name="ribcage_paypal_email" value="<?php echo get_option('ribcage_paypal_email'); ?>" class="regular-text code"/><span class="description">E-mail to send money to from donations and purchases via Paypal</span></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="ribcage_image_location">Image Location</label></th>
		<td><input type="text" name="ribcage_image_location" value="<?php echo get_option('ribcage_image_location'); ?>" class="regular-text code"/><span class="description">The directory to begin the directory tree of images for artists and release covers</class></td>
		</tr>
		<tr valign="top">
		<th scope="row">File Location</th>
		<td><input type="text" name="ribcage_file_location" value="<?php echo get_option('ribcage_file_location'); ?>" class="regular-text code"/><span class="description">The directory to begin the directory tree of files for audio and one sheets</class></td>
		</tr>
		<tr valign="top">
		<th scope="row">Record Label Mark</th>
		<td><input type="text" name="ribcage_mark" value="<?php echo get_option('ribcage_mark'); ?>" class="regular-text code"/><span class="description">The record label mark, Records On Ribs uses ROR, for example</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Default Postage Within Your Country</th>
		<td><input type="text" name="ribcage_postage_country" value="<?php echo get_option('ribcage_postage_country'); ?>" class="regular-text"/><span class="description">The default postage for a purchased item within the country you are in</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Default Postage Worldwide</th>
		<td><input type="text" name="ribcage_postage_worldwide" value="<?php echo get_option('ribcage_postage_worldwide'); ?>" class="regular-text"/><span class="description">The default postage for a purchased item worldwide</span></td>
		</tr>
		<tr valign="top">
		<th scope="row">Press Contact</th>
		<td><input type="text" name="ribcage_press_contact" value="<?php echo get_option('ribcage_press_contact'); ?>" class="regular-text code"/><span class="description">E-mail address people should contact for press enquires</span></td>
		</tr>
		</table>
		<?php settings_fields('ribcage'); ?>
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
		</div>
	</div>
	<?php
}
?>