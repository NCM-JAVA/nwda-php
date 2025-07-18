<?php ob_start();
include("../../includes/config.inc.php");
require_once "../../includes/connection.php";
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
require_once("../../includes/ps_pagination.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();

    if($_REQUEST['pid']=='')
	{
	$sql = $conn->query("SELECT * FROM appform_detail ORDER BY app_id DESC");
	}
	else
	{
    $poid=$_REQUEST['pid'];
    $sql = $conn->query("SELECT * FROM appform_detail where post='".$poid."' ORDER BY app_id DESC");
	}
	$no = 1;
?>
<table border="1">

				<tr>
				
				<th width="118">Application No</th>
				<th width="127">Applicant Name </th>
				<th width="127">Post Applied </th>
				<th width="127">Preferred Place</th>
				<th width="127">Category </th>
				<th width="154">TransactionID</th>
				<th width="154">Transaction Status </th>
				<th width="127">Date</th>
				<th width="127">Image</th>
				<th width="127">Signature</th>
			
			</tr>
	<?php
	
	while($data = $sql->fetch_array()){
	@extract($data);
	 $img_path = $HomeURL.'/upload/advertise/'.$image_name;
     $sig_path = $HomeURL.'/upload/advertise/'.$signature;
							
?>
<tr>
				
				<td><?php echo $app_no; ?></td>
				<td><?php echo $name; ?></td>
				<td><?php $postid=$post;
				$sqlpost="select postname from post_mst where post_id='".$postid."'";
				$respost=$conn->query($sqlpost);
				$rowpost=$respost->fetch_array();
				echo $rowpost['postname']."<br>";
				
				?></td>
				<td><?php echo $inter_place;?></td>
				<td><?php $catid=$category;
                $sqlcat="select c_name from category_master where c_id='".$catid."'";
				$rescat=$conn->query($sqlcat);
				$rowcat=$rescat->fetch_array();
                echo $rowcat['c_name'];
				?></td>
				<td><?php echo "TransactionID";?></td>
				<td><?php echo "Transaction Status";?></td>
			    <td><?php 
				if($i_date=='0000-00-00')
				{
				  echo "N/A";
				}
				else
				{
				echo date("d-m-Y", strtotime($i_date));
                }
				?></td>
				<td>
				<?php  if($image_name!='') { echo  $img_path;  }  else {  ?>
				No image available
				<?php  }  ?>
				</td>
				<td>
				<?php  if($signature!='') {  echo  $sig_path;  }  else {  ?>
				No signature available
				<?php  }  ?>
				</td>

			</tr>
			<?php




	}
	?>
</table>
 <?php
header("Content-type: application/vnd-ms-excel");
$fileName = "applicants_export";
header("Content-Disposition: attachment; filename=".$fileName.".xls");

?>