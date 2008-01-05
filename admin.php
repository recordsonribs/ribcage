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
	?>
	<div class="wrap">
		<h2>Add Artist</h2>
			<form action="?page=ribcage/ribcage.php" method="post" id="ribcage_add_artist" name="add_artist"> 
				<fieldset>
					<legend>Basic Details</legend>
					<table class="optiontable">                     
						<tr valign="top">
							<th scope="row"><strong>Name: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $title; ?>" name="title" id="dltitle" maxlength="200" />												
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Sort Name: </strong></th> 
							<td>
								<input type="text" style="width:320px;" class="cleardefault" value="<?php echo $dlversion; ?>" name="dlversion" id="dlversion" />
							</td> 
						</tr>
						<tr valign="top">
							<th scope="row"><strong>Starting hits: </strong></th> 
							<td>
								<input type="text" style="width:100px;" class="cleardefault" value="<?php echo $dlhits; ?>" name="dlhits" id="dlhits" maxlength="50" />
							</td> 
						</tr>
						<tr>
							<th scope="row"></th> 
							<td>
							<p class="submit">													
								<input type="submit" class="btn" name="save" style="padding:5px 30px 5px 30px;" value="Upload &amp; save" />
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
?>