<?php
foreach($_SERVER as $key=>$val)
{
  	$_SERVER[$key] = content_desc(check_input($val));
}
 
 $sql="SELECT * FROM visitors WHERE visitors_ip='".$_SERVER['REMOTE_ADDR']."'";
$result=mysqli_query($conn, $sql);
$rows=mysqli_fetch_array($result);
$count=mysqli_num_rows($result);
if($count >0)
  {

	 $addcounter=$rows['visitors_count']+1;
	$sql2="update visitors set visitors_count='$addcounter'  WHERE visitors_ip='".$_SERVER['REMOTE_ADDR']."'";
	$result2=mysqli_query($conn, $sql2);
  }
else
{
$visitors_count=1;
$visitors_ip=$_SERVER['REMOTE_ADDR'];
 $sql1="INSERT INTO visitors (visitors_ip,visitors_count,visitors_date_time) VALUES('$visitors_ip','$visitors_count','')";
$result1=mysqli_query($conn, $sql1);
}
?>