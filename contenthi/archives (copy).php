<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");

if($_SERVER['REQUEST_URI'])
		{
		 $url=mysql_real_escape_string($_SERVER['REQUEST_URI']); 
		 $val=explode('/', $url);
		 $url=$val['4'];
		$open=$val['3'];
		
		if($url !='')
		{
		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='1' and approve_status='3' and m_url='$url' ";
		}
		else {
		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='1' and approve_status='3'";
		}
		
						
						
			$sql=mysql_query($sql);
			 $count=mysql_num_rows($sql); 
			 if($count=='0')
				{
                header("Location:".$HomeURL."/content/error.php");
						exit(); 
				}
				
				
				
				

			$row=mysql_fetch_array($sql);
			$page_id=$row['page_id'];
			 $page_name=$row['m_name'];
			 $position=$row['menu_positions'];
			 $rootid=get_root_parent($page_id);
			 $parentid=parentid($page_id);
			 $m_name=get_page($page_id);
			 $m_url=$row['m_url'];
			 $sub_flag_id=$row['m_id'];
			 $m_flag_id = $row['m_flag_id'];
			 
	
		
			
			$page='content';
			if($page_id!='0' && $page_id!='')
			{
			$method="mapping";
		   $pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
			$btitle=pagebreadcrumb1($page_id,0,$method,1,$page);
			}		
		 $title=$row['m_name'];
		 $btitle=''.$btitle.' : Police in India';
		 $body=stripslashes(html_entity_decode($row['content'])); 	
		
 
		 
		}
		$m_keyword=$row['m_keyword'];
		$m_description=$row['m_description'];
?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>National Water Development Agency</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
	
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
		
		
			     <link rel="stylesheet" type="text/css"  href="<?php echo $HomeURL;?>/jquery-ui/jquery-ui.min.css" media="all">
    <script type="text/javascript" src="<?php echo $HomeURL;?>/jquery-ui/jquery-ui.js"></script>
	 
	
		
<script>
  $(function() {
	$( "#startdate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate:0,
	  dateFormat: "dd-mm-yy"
	});
});

$(function() {
	$( "#expairydate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate:0,
	  dateFormat: "dd-mm-yy"
	});
});
</script>		
	</head>
	
	<body id="fontSize">
			<header>
			<?php include("top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="images/toogle.png" alt="toogle" title="toogle">
				</div>
		<nav>
		<div class="container">
			<?php include("header.php");?>
		</div>	
		</nav>
	<section>
		
			
			<div class="container">
				<div class="row">
					<div class="col-sm-3 left-navigation">
						
							<?php include("leftmenu.php");?>
						
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li>Archices</li>
						</ul>
					</div>
					
					
						<h2>Archices</h2>
									<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data">

  <div class="form-group"> <span class="label1">
<label for="texcat">Category Type :</label>
<span class="star">*</span></span> <span class="input1">
<select class="form-control" name="txtcategory" id="texcat" autocomplete="off"  >
<option value="">Select</option>
<?php 
foreach($cat_type as $key=>$value)
{
  ?>
<option value="<?php echo $key; ?>" <?php if($key==$rr['whatsNew_cat'] || $key==$txtcategory){ echo 'selected="selected"'; } else { }?>><?php echo $value; ?></option>
<?php }
 ?>
</select></span>
<div class="clear"></div>
</div>



 <div class="form-group">
                        <span class="label1"><label for="startdate">From Date: </label></span>
                        <span class="input1">
                      <input type="text" class="form-control" name="startdate"  autocomplete="off" id="startdate" value="<?php echo content_desc(htmlspecialchars($startdate));?>"  size="10"  onKeyPress="return isNumberKey(event)"/>
</span>
                        <div class="clear"></div>
                        </div>

   <div class="form-group">
                        <span class="label1"><label for="expairydate">To Date : </label></span>
                        <span class="input1">
                      <input type="text" class="form-control" name="expairydate" autocomplete="off" id="expairydate" value="<?php echo content_desc(htmlspecialchars($expairydate));?>" size="10"   onKeyPress="return isNumberKey(event)"/>
                      </span>                       
                    </div> 


    <div class="form-group">
                   <div class="submit_block_row">
                      <input  class="btn btn-success" type="submit"  name="cmdsubmit"  id="cmdsubmit" value="Go" >
                   </div>
                 </div>



   </form>
								<div class="col-sm-12">
   <?php 
if(isset($cmdsubmit))
{
$cat_id= check_input($_POST['txtcategory']);
$sta=split('-',$startdate);
$startdate1=$sta['2']."-".$sta['1']."-".$sta['0'];
$startdate1=content_desc(htmlspecialchars($startdate1));
$exp=split('-',$expairydate);
$expairydate1=$exp['2']."-".$exp['1']."-".$exp['0'];
$expairydate1=content_desc(htmlspecialchars($expairydate1));

if(trim($cat_id)=="")
    {
      $errmsg .="Please Select Category Type."."<br>";
    }

if($startdate !='' && $expairydate !="")
{
    if($exp['2'] < $sta['2'])
    {
    $errmsg =" From Date should be lesser than To Date."."<br>";
    } 
    else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])) 
    {
    $errmsg .=" From Date should be lesser than To Date."."<br>";
    } 
    else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])) 
    {
    $errmsg .="Please enter From Date less then To Date."."<br>";
    }
    
    $startdate1=changeformate($startdate);
    $startdate1=content_desc(htmlspecialchars($startdate1));
    $expairydate1=changeformate($expairydate);
    $expairydate1=content_desc(htmlspecialchars($expairydate1));
    $querywhere ="and end_date between '$startdate1' and '$expairydate1' "; 

}


}
else
{    
  
         $query="SELECT * from combine_publish where `cat_id`='2' and `approve_status`=3 and `language_id`=1 $querywhere   ";
         $res=mysql_query($query) or die(mysql_error());

        while($row=mysql_fetch_array($res)) 
        {
            if($row['content_type']==2)
                     {

                                    $date = strtotime($row['create_date']);
                  $s="/upload";   
                  $source=$HomeURL.$s."/".$row['docs_file'];
                  ?>
                         <li class="list-group-item"><a href="<?php echo $source ;?>" target="_blank"><?php echo $row['m_name'] ;?><img src="<?php echo $HomeURL;?>/images/pdf_icon.png" width="12" height="16" alt="<?php echo $row['m_name'];?>" /></a></li>
                     <?php
                     }
                     else if($row['content_type']==3)
                     {

?>
                         <li class="list-group-item"><a href="<?php echo $row['ext_url'] ;?>" target="_blank" title="<?php echo $row['ext_url'].','.$row['m_name']  ;?>: External website that opens in a new window" onclick="return sitevisit();"><?php echo $row['m_name'] ;?></a></li>
                     <?php

                     }

else
{
?>
             <li class="list-group-item"><span><img src="../images/thamb-img.jpg" width="51" height="44" alt=""></span><a href="media/<?php echo $row['page_url'] ;?>"><?php echo $row['m_name'] ;?></a></li>
        
            <?php

}
        }






}

if($errmsg == '')
  {
    $date=date('Y-m-d');

        $query="SELECT * from combine_publish where `cat_id`='$cat_id' and `approve_status`=3 and `language_id`=1 $querywhere   ";
         $res=mysql_query($query) or die(mysql_error());

        while($row=mysql_fetch_array($res)) 
        {
            if($row['content_type']==2)
                     {

                                    $date = strtotime($row['create_date']);
                  $s="/upload";   
                  $source=$HomeURL.$s."/".$row['docs_file'];
                  ?>
                         <li class="list-group-item"><a href="<?php echo $source ;?>" target="_blank"><?php echo $row['m_name'] ;?><img src="<?php echo $HomeURL;?>/images/pdf_icon.png" width="12" height="16" alt="<?php echo $row['m_name'];?>" /></a></li>
                     <?php
                     }
                     else if($row['content_type']==3)
                     {

?>
                         <li class="list-group-item"><a href="<?php echo $row['ext_url'] ;?>" target="_blank" title="<?php echo $row['ext_url'].','.$row['m_name']  ;?>: External website that opens in a new window" onclick="return sitevisit();"><?php echo $row['m_name'] ;?></a></li>
                     <?php

                     }

else
{
?>
             <li class="list-group-item"><span><img src="../images/thamb-img.jpg" width="51" height="44" alt=""></span><a href="news-details.php?nid=<?php echo $row['m_id'] ;?>"><?php echo $row['m_name'] ;?></a></li>
        
            <?php

}
        }





  }
  else
  {
    echo $errmsg;
  }



   ?>

</div>
					</div>
				</div>
				</div>
			
		
		
		</section>
	<footer>
			<?php include("footer.php");?>
		</footer>
	

	</body>
	
</html>
