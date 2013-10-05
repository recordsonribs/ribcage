<?php
/**
 * Product management
 *
 * @package Ribcage
 * @subpackage Administration
 */

/**
 * Manages products - adds, edits, deletes products.
 *
 * @return void
 */
function ribcage_manage_products () {
	global $wpdb;
	
	global $products, $product;
	global $releases, $release;
	global $artist;
	
	// Security check
	if (isset($_REQUEST['_wpnonce'])) {
            if (wp_verify_nonce($nonce, 'ribcage_manage_releases')) {
                die("Security check failed.");
            }
	}
	
	$nonce = wp_create_nonce ('ribcage_manage_products');
	
	if ($_REQUEST['ribcage_action']) {
		array_pop($_POST);

		$post_keys = array_keys($_POST);
		$post_vals = array_values($_POST);

		$string_keys = implode($post_keys,",");
		$string_vals = "'".implode($post_vals,"','")."'";

		$wpdb->show_errors();
		
		switch($_REQUEST['ribcage_action']) {
			case 'add':
				// Do we have all the fields we need to add something?
				if ($_POST['product_name'] == null) {
					$product = $_POST;
					ribcage_edit_product_form('Sorry you missed the name of your product.');
					return;
				}
				elseif ($_POST['product_cost'] == null) {
					$product = $_POST;
					ribcage_edit_product_form("Sorry you didn't set a cost for your product.");
					return;
				}
				elseif ($_POST['product_description'] == null) {
					$product = $_POST;
					ribcage_edit_product_form("Sorry you didn't write a description for your product.");
					return;
				}
				elseif (!is_numeric($_POST['product_cost'])){
					$product = $_POST;
					ribcage_edit_product_form("Sorry but that isn't a number for the cost of the product.");
					return;
				}
				
				// Do we already have a physical product for this release?
				if ($_POST['product_related_release']) {
					$sql = "SELECT release_physical FROM ".$wpdb->releases." WHERE release_id = ".$_POST['product_related_release'];
					$check = $wpdb->get_row($sql, ARRAY_A);
					
					if ($check['release_physical'] == 1) {
						$product = $_POST;
						ribcage_edit_product_form("Sorry but that release already has a physical product associated with it.");
						return;
					}
				}
				
				$sql = "INSERT INTO ".$wpdb->products."
						($string_keys)
						VALUES
						($string_vals)";
				$results = $wpdb->query($sql);
				$wpdb->hide_errors();
				
				// Update our _ribcage_releases data with the correct details if we are relating this to a release.
				if ($_POST['product_related_release']) {
					$sql = "SELECT product_id FROM ".$wpdb->products." ORDER BY product_id DESC LIMIT 0,1";
					$product = $wpdb->get_row($sql, ARRAY_A);
					
					$sql = "UPDATE ".$wpdb->releases." SET release_physical = 1, release_physical_cat_no ='".$product['product_id']."' WHERE release_id = ".$_POST['product_related_release'];
					
					$results = $wpdb->query($sql);
				}
				
				$message = ' added';
			break;
			
			case 'edit':
				ribcage_edit_product_form();
				return;
			break;
			
			case 'edited':
				// Do we have all the fields we need to add something?
				if ($_POST['product_name'] == null) {
					$product = $_POST;
					ribcage_edit_product_form('Sorry you missed the name of your product.');
					return;
				}
				elseif ($_POST['product_cost'] == null) {
					$product = $_POST;
					ribcage_edit_product_form("Sorry you didn't set a price for your product.");
					return;
				}
				elseif ($_POST['product_description'] == null) {
					$product = $_POST;
					ribcage_edit_product_form("Sorry you didn't set a price for your product.");
					return;
				}
				elseif (!is_numeric($_POST['product_cost'])){
					$product = $_POST;
					ribcage_edit_product_form("Sorry but that isn't a number for the cost of the product.");
					return;
				}
				
				$product_before = get_product($_REQUEST['product']);
				$sql = "UPDATE ".$wpdb->prefix."ribcage_products
						SET ";
				
				$i = 0;
				
				foreach($post_keys as $field):
						$sql .= $field ."='".$post_vals[$i]."', ";
						$i++;
				endforeach;
				
				$sql .= " product_id = ".$_REQUEST['product']." 
						WHERE product_id = ".$_REQUEST['product'];
					
				$results = $wpdb->query($sql);
				$wpdb->hide_errors();
				
				// Update our _ribcage_releases data if we have changed the associated product.
				if ($product_before['product_related_release'] != $_REQUEST['product_related_release']) {
					// Delete it from our previous holder of the release.
					$sql = "UPDATE ".$wpdb->prefix."ribcage_releases SET release_physical = 0, release_physical_cat_no = 0 WHERE release_id = ".$product_before['product_related_release'];
					$results = $wpdb->query($sql);
					
					// Add it to the current holder of the release.
					$sql = "UPDATE ".$wpdb->prefix."ribcage_releases SET release_physical = 1, release_physical_cat_no ='".$_REQUEST['product']."' WHERE release_id = ".$_POST['product_related_release'];	
					$results = $wpdb->query($sql);	
				}

				$message = ' updated';
			break;
			
			case 'delete':
				$product_before = get_product($_REQUEST['product']);
				delete_product($_REQUEST['product']);
				
				$sql = "UPDATE ".$wpdb->prefix."ribcage_releases SET release_physical = 0, release_physical_cat_no = 0 WHERE release_id = ".$product_before['product_related_release'];
				$results = $wpdb->query($sql);
				
				$message = " deleted";
			break;
		}
		
		if (isset($message)){
			echo '<div id="message" class="updated fade"><p><strong>Product '.$message.'.</strong></p></div>';
		}
	}
	
	register_column_headers('ribcage-manage-products',
	array (
		'cb'=>'<input type="checkbox" />',
		'product_name'=> 'Product',
		'local_downloads'=>'Related To Release'
		));
	
	$products = list_products();
	?>
		<div class="wrap">
			<div id="icon-plugins" class="icon32"><br /></div>
			<h2>Manage Products</h2>
				<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" id="ribcage_manage_products" name="manage_artists"> 
					<table class="widefat post fixed" cellspacing="0">
							<thead>
							<tr>
							<?php print_column_headers('ribcage-manage-products'); ?>			
							</tr>
							</thead>
							<tfoot>
							<tr>			
							<?php print_column_headers('ribcage-manage-products',FALSE); ?>	
							</tr>
							</tfoot>            
							<tbody>
								<?php while ( have_products () ) : the_product(); ?>
								<?php $release = get_release($product['product_related_release']); ?>
								<?php $artist['artist_name'] = get_artistname_by_id($release['release_artist']); ?>
								<?php echo ($alt % 2) ? '<tr valign="top" class="">' : '<tr valign="top" class="alternate">'; ++$alt; ?>		
								<th scope="row" class="check-column"><input type="checkbox" name="productcheck[]" value="2" /></th>
								<td class="column-name"><strong><a class="row-title" href="?page=manage_products&ribcage_action=edit&product=<?php product_id(); ?>&amp;_wpnonce=<?php echo $nonce ?>" title="<?php product_name(); ?>" ><?php product_name(); ?></strong></a><br /><div class="row-actions"><span class='edit'><a href="?page=manage_products&ribcage_action=edit&product=<?php product_id(); ?>&amp;_wpnonce=<?php echo $nonce ?>">Edit</a> | </span><span class='delete'><a class='submitdelete' href="?page=manage_products&ribcage_action=delete&product=<?php product_id(); ?>&amp;_wpnonce=<?php echo $nonce ?>" onclick="if ( confirm('You are about to delete the product \'<?php product_name(); ?>\'\n  \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;">Delete</a></span></div></td>
								<?php if ($product['product_related_release']) { ?>
								<td class="column-name"><?php artist_name(); ?> - <?php release_title(); ?></td>
								<?php } 
								else { ?>
								<td class="column-name">None.</td>
								<?php } ?>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
				</form>
		</div>
		<?php
}

/**
 * Displays a form used for editing or adding a product to database.
 *
 * @param string $error Error message from the manage_products form.
 * @param bool $related_to_release If true then we are passing from adding a release in general so we set the relation to this automatically
 * @return void
 */
function ribcage_edit_product_form ($error = 0, $related_to_release = 0) {
	global $artist;
	global $release, $releases;
	global $product;
	
	if (isset($_REQUEST['product'])) {
		$product = get_product($_REQUEST['product']);
	}

	$releases = list_recent_releases_blurb();
	
	if ($error) {
		echo '<div id="message" class="error"><p><strong>'.$error.'</strong></p></div>';
	}
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<?php if (isset($_REQUEST['product'])) { ?>
		<h2>Editing <?php product_name(); ?></h2>
		<form action="<?php echo home_url(); ?>/wp-admin/admin.php?page=manage_products&product=<?php product_id() ?>&ribcage_action=edited" method="post" id="ribcage_edit_artist" name="edit_artist">
		<?php } else { ?>
		<h2>Add A Product</h2>
		<form action="<?php echo home_url(); ?>/wp-admin/admin.php?page=manage_products&ribcage_action=add" method="post" id="ribcage_edit_artist" name="edit_artist">
		<?php }?>
				<table class="form-table">             
					<tr valign="top">
						<th scope="row"><label for="product_name">Name</label></th> 
						<td>
							<input type="text" value="<?php product_name(); ?>" name="product_name" id="product_name" class="regular-text"/>												
						</td> 
					</tr>
					<tr valign="top">
						<th scope="row"><label for="product_name">Price</label></th> 
						<td>
							<input type="text" value="<?php echo $product['product_cost']; ?>" name="product_cost" id="product_cost" class="regular-text"/>												
						</td> 
					</tr>
					<tr valign="top">
						<th scope="row"><label for="product_related_release">Related To Release</label></th> 
						<td>
							<select name="product_related_release" id="product_related_release">
								<option value = "">None</option>
								<?php while ( have_releases () ) : the_release(); ?>
								<?php $artist['artist_name'] = get_artistname_by_id($release['release_artist']); ?>
								<?php if ($release['release_id'] == $product['product_related_release']) { ?>
								<option selected value="<?php release_id();?>"><?php artist_name(); ?> - <?php release_title(); ?></option>
								<?php } 
								else { ?>
								<option value="<?php release_id();?>"><?php artist_name(); ?> - <?php release_title(); ?></option>
								<?php } ?>
								<?php endwhile; ?>
							</select>												
						</td> 
					</tr>
					<tr valign="top">
						<th scope="row"><label for="product_name">Product Description</label></th> 
						<td>
							<textarea rows="10" cols="100" name="product_description" id="product_description" class="regular-text"><?php product_description(); ?></textarea>					
						</td> 
					</tr>
				</table>
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
				</p>
		</form>
</div>
	<?php
}

?>
