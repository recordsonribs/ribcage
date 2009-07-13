<?php

function ribcage_admin_index ()
{	
	?>
	<div class="wrap">
		<h2>Log</h2>
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
		<h2>Add Artist</h2>
			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_add_artist" name="add_artist"> 
				<fieldset>
					<legend>Basic Details</legend>
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
								<?php echo ribcage_cc_dropdown(); ?>
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
								<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
							</p>
							</td>
						</tr>
					</table>
				</fieldset>								
			</form>
            </div>
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

function ribcage_options($value='')
{
	?>
	<div class="wrap">
		<h2>Ribcage Options</h2>
	</div>
	<?php
}
?>