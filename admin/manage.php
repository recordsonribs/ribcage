<?php

function ribcage_manage_artists($value='')
{

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
#		echo "<pre>$sql</pre>"; exit();
		$results = $wpdb->query( $sql );
		$wpdb->hide_errors();

		//display snazzy update fade thing when they are added
		echo <<<EOT
			<div id="message" class="updated fade"><p><strong>Artist updated.</strong></p></div>
EOT;
	}

$artist = get_artist($_REQUEST['artist']);

$artist_name_val			= $artist['artist_name'];
$artist_name_sort_val		= $artist['artist_name_sort'];
$artist_slug_val			= $artist['artist_slug'];
$artist_mbid_val			= $artist['artist_mbid'];
$artist_signed_val			= $artist['artist_signed'];
$artist_license_val			= $artist['artist_license'];
$artist_bio_val				= $artist['artist_bio'];
$artist_picture1_val		= $artist['artist_picture1'];
$artist_picture2_val		= $artist['artist_picture2'];
$artist_picture3_val		= $artist['artist_picture3'];
$artist_picturezip_val		= $artist['artist_picturezip'];
$artist_contact_email_val	= $artist['artist_contact_email'];
$artist_contact_phone_val	= $artist['artist_contact_phone'];
$artist_blurb_tiny_val		= $artist['artist_blurb_tiny'];
$artist_blurb_short_val		= $artist['artist_blurb_short'];
$artist_link_website_val	= $artist['artist_link_website'];
$artist_link_myspace_val	= $artist['artist_link_myspace'];
$artist_link_facebook_val	= $artist['artist_link_facebook'];

?>
	<div class="wrap">
		<h2>Manage <em><?php echo $artist['artist_name']; ?></em> (#<?php echo $artist['artist_id']; ?>)</h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_edit_artist" name="edit_artist"> 
				<fieldset>
					<legend>Artist info</legend>
					<table class="optiontable">                     
						<tr valign="top">
							<th scope="row"><strong>Name: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_name_val; ?>" name="artist_name" id="artist_name" maxlength="200" />												
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Sort Name: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_name_sort_val; ?>" name="artist_name_sort" id="artist_name_sort" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Artist Slug: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_slug_val; ?>" name="artist_slug" id="artist_slug" />
							</td> 
						</tr>
						<!--<tr valign="top">
							<th scope="row"><strong>Starting hits: </strong></th> 
							<td>
								<input type="text" style="width:100px;" class="cleardefault" value="<?php echo $artist_hits_val; ?>" name="artist_hits" id="artist_hits" maxlength="50" />
							</td> 
						</tr>-->
						<tr valign="top">
							<th scope="row"><strong>Artist's Music Brainz ID: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_mbid_val; ?>" name="artist_mbid" id="artist_mbid" maxlength="50" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Signup Date: </strong></th> 
							<td>
								<input type="text" style="width:100px;" class="cleardefault" value="<?php echo $artist_signed_val; ?>" name="artist_signed" id="artist_signed" maxlength="50" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Creative Commons license: </strong></th> 
							<td>
								<?php echo ribcage_cc_dropdown($artist_license_val); ?>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Artist Biography: </strong></th> 
							<td>
								<textarea rows="5" cols="50" name="artist_bio" id="artist_bio"><?php echo $artist_bio_val; ?></textarea>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Artist Picture 1: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_picture_1_val; ?>" name="artist_picture_1" id="artist_picture_1" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Artist Picture 2: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_picture_2_val; ?>" name="artist_picture_2" id="artist_picture_2" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Artist Picture 3: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_picture_3_val; ?>" name="artist_picture_3" id="artist_picture_3" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Artist Picture HQ Zipfile URL: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_picture_zip_val; ?>" name="artist_picture_zip" id="artist_picture_zip" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Artist E-mail: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_contact_email_val; ?>" name="artist_contact_email" id="artist_contact_email" maxlength="150" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Artist Phone: </strong></th> 
							<td>
								<input type="text" style="width:100px;" class="cleardefault" value="<?php echo $artist_contact_phone_val; ?>" name="artist_contact_phone" id="artist_contact_phone" maxlength="20" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>One-sentence Description of Artist: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_blurb_tiny_val; ?>" name="artist_blurb_tiny" id="artist_blurb_tiny" maxlength="255" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>One-paragraph Description of Artist: </strong></th> 
							<td>
								<textarea rows="5" cols="50" name="artist_blurb_short" id="artist_blurb_short"><?php echo $artist_blurb_short_val; ?></textarea>
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Website URL: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_link_website_val; ?>" name="artist_link_website" id="artist_link_website" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>MySpace URL: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_link_myspace_val; ?>" name="artist_link_myspace" id="artist_link_myspace" maxlength="200" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Facebook URL: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $artist_link_facebook_val; ?>" name="artist_link_facebook" id="artist_link_facebook" maxlength="200" />
							</td> 
						</tr>
						<tr>
							<th scope="row"></th> 
							<td>
							<p class="submit">													
								<input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="<?php echo $button_name; ?>" />
								<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="M">
							</p>
							</td>
						</tr>
					</table>

				</fieldset>
			</form>
	</div>
<?php 	else:	?>
	<div class="wrap">
		<h2>Manage Artists</h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_manage_artists" name="manage_artists"> 
				<fieldset>
					<legend>Here's your label's Artists. Take care of them!</legend>
					<table class="optiontable">
						<thead>
						<tr valign="top">
							<td>#</td>
							<td>Name</td>
							<td>Sort Name</td>
							<td>Picture</td>
						</tr>
						</thead>                     
						<tbody>
							<?php
							$artists = list_artists_blurb();
							foreach($artists as $artist):
							?>
						<tr valign="top">
							<td><?php echo $artist['artist_id']; ?></td>
							<td><a href="?page=manage_artists&amp;artist=<?php echo $artist['artist_id']; ?>">
								<?php echo $artist['artist_name']; ?></a></td>
							<td><?php echo $artist['artist_name_sort']; ?></td>
							<td><?php echo $artist['artist_thumb']; ?></td>
						</tr>
							<?php
							endforeach;
							?>
						</tbody>
					</table>
				</fieldset>
			</form>
	</div>
	<?php
endif;
}

?>