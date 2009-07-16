<?php

function ribcage_admin_index ()
{	
	?>
	<div class="wrap">
		<h2>Ribcage</h2>
	</div>	
	<?php
}

function ribcage_add_artist()
{
	global $wpdb;
	$hidden_field_name = 'ribcage_artist_submit';
	$button_name = 'Add Artist';

	if($_POST[$hidden_field_name] == 'Y'){ // an artist is posted
		
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
		$sql = "INSERT INTO ".$wpdb->prefix."ribcage_artists
				($string_keys)
				VALUES
				($string_vals)";
		//echo "<pre>$sql</pre>";
		$results = $wpdb->query( $sql );
		$wpdb->hide_errors();

		//display snazzy update fade thing when they are added
		echo <<<EOT
			<div id="message" class="updated fade"><p><strong>Artist added.</strong></p></div>
EOT;
	}
    ?>
	<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Add Artist</h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_add_artist" name="add_artist">
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
	<?php
}

function ribcage_add_release($value='')
{
	?>
	<div class="wrap">
		<h2>Add Release</h2>
	</div>
	<?php
}

function ribcage_add_review($value='')
{
	?>
	<div class="wrap">
		<h2>Add Review</h2>
		<p>Add a review of one of your releases.</p>
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