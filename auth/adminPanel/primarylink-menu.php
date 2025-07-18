<?php 
ob_start();
include("../../includes/config.inc.php");
   require_once "../../includes/connection.php";
include("../../includes/useAVclass.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
$_SESSION['user'];
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<div class="frm_row"> <span class="label1">
                    <label for="menucategory">Primary Link:</label>
                    <span class="star">*</span></span> <span class="input1">
                    
            <?php 
			 $sql1 = "select * from menu where approve_status='3' and m_flag_id='0' and language_id=".$language."";
$nav_query = $conn->query($sql1);
$tree = "";                         // Clear the directory tree
$depth = 1;                         // Child level depth.
$top_level_on = 1;               // What top-level category are we on?
$exclude = array();               // Define the exclusion array
array_push($exclude, 0);     // Put a starting value in it
 $tree = '<option value ="0">It is Root Category</option>'; 
while ($nav_row = $nav_query->fetch_array() )
{
    $goOn = 1;               // Resets variable to allow us to continue building out the tree.
    for($x = 0; $x < count($exclude); $x++ )          // Check to see if the new item has been used
    {
        if($exclude[$x] == $nav_row['m_id'] )
        {
            $goOn = 0;
            break;                    // Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node
        }
    }
    if ( $goOn == 1 )
    {
	    $tree .= '<strong><option value="'.$nav_row['m_id'].'">&nbsp;'.$nav_row['m_name'].'</option></strong>';   
			array_push($exclude, $nav_row['m_id']);          // Add to the exclusion list
			if ( $nav_row['m_id'] < 6 )
			{ $top_level_on = $nav_row['m_id']; }
			$tree .= build_child($nav_row['m_id']);  		
	}

}

 function build_child($oldID)               // Recursive function to get all of the children...unlimited depth
{
	$tempTree='';
	$temp='';
	include "../../includes/connection.php";
	GLOBAL $exclude, $depth; 
	$sql = 'select * from menu where approve_status="3" and m_flag_id="'.$oldID.'"';
	$rs = $conn->query($sql);
	while ( $child = $rs->fetch_array() )
	{
		if ( $child['m_id'] != $child['m_flag_id'] )
        {
            for ( $c=0;$c<$depth;$c++ ){ $temp.= "&nbsp;&nbsp;&nbsp;"; }
		    $tempTree.='<option value="'.$child['m_id'].'">'.$temp.'--'.$child['m_name'].'</option>';
		    $depth++;          // Incriment depth b/c we're building this child's child tree  (complicated yet???)
		    $tempTree .= build_child($child['m_id']);          // Add to the temporary local tree
		    $depth--;  
		    $temp='';        // Decrement depth b/c we're done building the child's child tree.
		    array_push($exclude, $child['m_id']); 
		}
	}
	return $tempTree;
}


echo '<select name="menucategory" id="menucategory">'.$tree.'</select>';

?>

                    </span>
                    <div class="clear"></div>
                    </div>




					
					
