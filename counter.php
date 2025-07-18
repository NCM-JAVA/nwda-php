<?php
foreach($_SERVER as $key=>$val)
{
  	$_SERVER[$key] = content_desc(check_input($val));
}


		function getIp() {

		$ip = $_SERVER['REMOTE_ADDR'];



		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

		$ip = $_SERVER['HTTP_CLIENT_IP'];

		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

		}



		return $ip;

		}


		$visitors_ip=getIp($ip);

		$sql="SELECT * FROM visitors WHERE visitors_ip='".$visitors_ip."'";
		$result=mysql_query($sql);
		$rows=mysql_fetch_array($result);
		$count=mysql_num_rows($result);

		if($count >0)
		{
		$addcounter=$rows['visitors_count']+1;
		$sql2="update visitors set visitors_count='$addcounter'";
		$result2=mysql_query($sql2);
		}
		else
		{
		$date=date('Y-m-d');
		$visitors_count=1;
		$visitors_ip=getIp($ip);

		$sql1="INSERT INTO visitors (`visitors_ip` ,`visitors_count` , `page_name`,`visitors_date_time`) VALUES('$visitors_ip','$visitors_count' ,'$url','$date')";
		$result1=mysql_query($sql1);


		}

?>
