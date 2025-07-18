<?php 
ob_start();
include("../../includes/config.inc.php");
?>

	<option value="">Select</option>
<?php 
foreach($important_link_cat_english as $key=>$value)
{
	?>
<option value="<?php echo $key; ?>" <?php if($key==$texttype){ echo 'selected="selected"'; } else { }?>><?php echo $value; ?></option>
<?php }
 ?>
</select>				
					
