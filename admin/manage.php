<?php
/**
 * Manages an individual artist
 *
 * @return void
 * @param mixed $value What the hell does this do?
 **/
function ribcage_manage_artists () {

global $artist;

if(isset($_REQUEST['artist'])):
	global $wpdb;
	$artist_id = (int) $_REQUEST['artist'];
	$hidden_field_name = 'ribcage_artist_edit';
	$button_name = 'Edit Artist';

	if($_POST[$hidden_field_name] == 'M'){ // an artist is posted
		
		//slice off two variables at the end to prepare for implodes
		array_pop($_POST); // hidden var
		array_pop($_POST); // submit button var

		//split apart associative array into different parts to prepare for implodes
		$post_keys = array_keys($_POST);
		$post_vals = array_values($_POST);
		
		//construct field name list and vals to post
		$string_keys = implode($post_keys,",");
		$string_vals = "'".implode($post_vals,"','")."'";

		$wpdb->show_errors();
		//construct query
		$sql = "UPDATE ".$wpdb->prefix."ribcage_artists
				SET ";
				$i = 0;
				foreach($post_keys as $field):
					$sql .= $field ."='".$post_vals[$i]."', ";
					$i++;
				endforeach;
		$sql .= " artist_id = ".$artist_id." 
				WHERE artist_id = ".$artist_id;
				
		$results = $wpdb->query( $sql );
		$wpdb->hide_errors();

		//display snazzy update fade thing when they are added
		echo <<<EOT
			<div id="message" class="updated fade"><p><strong>Artist updated.</strong></p></div>
EOT;
	}

$artist = get_artist($_REQUEST['artist']);
?>
	<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Managing <?php artist_name(); ?></h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_edit_artist" name="edit_artist">
					<table class="form-table">             
						<tr valign="top">
							<th scope="row"><label for="artist_name">Name</label></th> 
							<td>
								<input type="text" value="<?php artist_name(); ?>" name="artist_name" id="artist_name" class="regular-text"/>												
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Sort Name</th> 
							<td>
								<input type="text" value="<?php artist_name_sort(); ?>" name="artist_name_sort" id="artist_name_sort" class="regular-text" />
								<span class="description">The name of the artist to be alphabetized. For example, 'Butterfly, The'.</span>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Slug</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_slug(); ?>" name="artist_slug" id="artist_slug" /><span class="description">The URL you want for the artist - for example <?php echo get_option('siteurl'); ?>/artists/artist_slug</span>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Signup Date</th> 
							<td>
								<input type="text" style="width:100px;" class="regular-text code" value="<?php echo $artist['artist_signed']; ?>" name="artist_signed" id="artist_signed" maxlength="50" /><span class="description">The date the artist signed for your label</span>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Creative Commons license</th> 
							<td>
								<?php echo ribcage_cc_dropdown($artist_license_val); ?>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist's Music Brainz ID</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_musicbrainz (); ?>" name="artist_mbid" id="artist_mbid" maxlength="50" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Website URL</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_website_link(); ?>" name="artist_link_website" id="artist_link_website" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">MySpace URL</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_myspace_link(); ?>" name="artist_link_myspace" id="artist_link_myspace" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Facebook URL</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_facebook_link(); ?>" name="artist_link_facebook" id="artist_link_facebook" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Biography</th> 
							<td>
								<textarea rows="5" cols="50" name="artist_bio" id="artist_bio" class="regular-text"><?php echo $artist['artist_bio']; ?></textarea>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Short One Paragraph Description of Artist</th> 
							<td>
								<textarea rows="5" cols="50" name="artist_blurb_tiny" id="artist_blurb_tiny" class="regular-text"><?php echo $artist['artist_blurb_tiny']; ?></textarea>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Picture 1</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php artist_picture_1(); ?>" name="artist_picture_1" id="artist_picture_1" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Picture 2</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php echo $artist_picture_2_val; ?>" name="artist_picture_2" id="artist_picture_2" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Picture 3</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php echo $artist_picture_3_val; ?>" name="artist_picture_3" id="artist_picture_3" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row">Artist Picture HQ Zipfile URL</th> 
							<td>
								<input type="text" style="width:320px;" class="regular-text code" value="<?php echo $artist_picture_zip_val; ?>" name="artist_picture_zip" id="artist_picture_zip" maxlength="200" />
							</td> 
						</tr>
					</table>
					<p class="submit">
						<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
						<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="M">
					</p>
			</form>
	</div>
<?php 	else:	?>
	<div class="wrap">
		<div id="icon-plugins" class="icon32"><br /></div>
		<h2>Manage Artists</h2>
		<p>Edit the details of your artists.</p>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_manage_artists" name="manage_artists"> 
				<table class="widefat post fixed" cellspacing="0">
						<thead>
						<tr>
						<th scope="col" id="title" class="manage-column column-title" style="">Name</th>
						</tr>
						</thead>

						<tfoot>
						<tr>
						<th scope="col"  class="manage-column column-title" style="">Name</th>
						</tr>
						</tfoot>            
						<tbody>
							<?php
							$artists = list_artists_blurb();
							$alternate = 1;
							foreach($artists as $artist):
							if ($alternate == 1){
								?><tr valign="top" class="alternate"><?php
								$alternate = 0;
							}
							else {
								?><tr valign="top" class=""> <?php
								$alternate = 1;
							}
							?>
							<td><a href="?page=manage_artists&amp;artist=<?php echo $artist['artist_id']; ?>">
								<?php echo $artist['artist_name']; ?></a></td>
						</tr>
							<?php
							endforeach;
							?>
						</tbody>
					</table>
			</form>
	</div>
	<?php
endif;
}

?>