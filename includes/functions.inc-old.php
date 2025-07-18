<?php
//putenv("TZ=Asia/Calcutta");
function clean($str) 
{
		$str = @trim($str);
		if(get_magic_quotes_gpc()) 
		{
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
}
function check_input($data, $problem='')
{
    $data = trim($data);
	
	$data = stripslashes($data);
	$data=mysql_real_escape_string($data);
	 $data = htmlspecialchars($data); 
    if ($problem && strlen($data) == 0)
    {
        die($problem);
    }
    return $data;
}

function check_string($data)
{
    $data = trim($data);
	$data = stripslashes($data);
	$data=mysql_real_escape_string($data);
	 $data = htmlspecialchars($data); 
    if ($problem && strlen($data) == 0)
    {
        die($problem);
    }
    return $data;
}


function executeQuery($sql)
{
	$result = mysql_query($sql) or die(mysql_error(). " : ".$sql);
	return $result;
}

function getSingleResult($sql)
{
	$response="";	
	$result = mysql_query($sql) or die(mysql_error(). " : ".$sql);
	if($line=mysql_fetch_array($result))
	{
		$response=$line[0];
	}
	return $response;
}

function executeUpdate($sql)
{
	mysql_query($sql) or die(mysql_error(). " : ".$sql);
}

function uploadFile($PATH,$FILENAME,$FILEBOX)
{
	$file=$PATH.$FILENAME;
    $uploaded="TRUE";
	global $HTTP_POST_FILES;
    if (! @file_exists($file))
    {
		if ( isset($_FILES[$FILEBOX] ) )
        {
			if (is_uploaded_file($_FILES[$FILEBOX]['tmp_name']))
            {
	            copy($_FILES[$FILEBOX]['tmp_name'], $PATH.$FILENAME);



            }else{
				$uploaded="FALSE";
            }
        }
    } //end of if @fileexists
	return $uploaded;
}



function check_admin_login()
{	
	
	 $adminid = $_SESSION['admin_auto_id_sess'];


	if($adminid!='')
	{	
	}
	else
	{		
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:login.php");
		exit;	
	}
}


function qry_str($arr, $skip = '')
{
	$s = "?";
	$i = 0;
	foreach($arr as	$key =>	$value)	{
		if ($key !=	$skip) {
			if (is_array($value)) {
				foreach($value as $value2) {
					if ($i == 0) {
						$s .= $key . '[]=' . $value2;
						$i = 1;
					} else {
						$s .= '&' .	$key . '[]=' . $value2;
					}
				}
			} else {
				if ($i == 0) {
					$s .= "$key=$value";
					$i = 1;
				} else {
					$s .= "&$key=$value";
				}
			}
		}
	}
	return $s;
}


 
 function generate_image_thumbnail( $source_image_path, $thumbnail_image_path )
  {
 
    list( $source_image_width, $source_image_height, $source_image_type ) = getimagesize( $source_image_path );

    switch ( $source_image_type )
    {
      case IMAGETYPE_GIF:
        $source_gd_image = imagecreatefromgif( $source_image_path );
        break;

      case IMAGETYPE_JPEG:
        $source_gd_image = imagecreatefromjpeg( $source_image_path );
        break;

      case IMAGETYPE_PNG:
        $source_gd_image = imagecreatefrompng( $source_image_path );
        break;
    }

    if ( $source_gd_image === false )
    {
      return false;
    }

    $thumbnail_image_width = 150;
    $thumbnail_image_height = 100;

    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $thumbnail_image_width / $thumbnail_image_height;

    if ( $source_image_width <= $thumbnail_image_width && $source_image_height <= $thumbnail_image_height )
    {
      $thumbnail_image_width = 150;
      $thumbnail_image_height = 100;
    }
    elseif ( $thumbnail_aspect_ratio > $source_aspect_ratio )
    {
      $thumbnail_image_width = ( int ) ( $thumbnail_image_height * $source_aspect_ratio );
    }
    else
    {
      $thumbnail_image_height = ( int ) ( $thumbnail_image_width / $source_aspect_ratio );
    }

    $thumbnail_gd_image = imagecreatetruecolor( $thumbnail_image_width, $thumbnail_image_height );

    imagecopyresampled( $thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height );

    imagejpeg( $thumbnail_gd_image, $thumbnail_image_path, 90 );

    imagedestroy( $source_gd_image );

    imagedestroy( $thumbnail_gd_image );

    return true;
  }
  
function generate_image_frontthaumb($source_image_path,$thumbnail_image_path,$front_thumb_image_path)
  {
 
    list( $source_image_width, $source_image_height, $source_image_type ) = getimagesize( $source_image_path );

    switch ($source_image_type )
    {
      case IMAGETYPE_GIF:
        $source_gd_image = imagecreatefromgif( $source_image_path );
        break;

      case IMAGETYPE_JPEG:
        $source_gd_image = imagecreatefromjpeg( $source_image_path );
        break;

      case IMAGETYPE_PNG:
        $source_gd_image = imagecreatefrompng( $source_image_path );
        break;
    }

    if ( $source_gd_image === false )
    {
      return false;
    }

    $thumbnail_image_width = 475;
    $thumbnail_image_height = 285;

    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $thumbnail_image_width / $thumbnail_image_height;

    if( $source_image_width <= $thumbnail_image_width && $source_image_height <= $thumbnail_image_height )
    {
      $thumbnail_image_width = $source_image_width;
      $thumbnail_image_height = $source_image_height;
    }
    elseif ($thumbnail_aspect_ratio > $source_aspect_ratio )
    {
      $thumbnail_image_width = ( int ) ( $thumbnail_image_height * $source_aspect_ratio );
    }
    else
    {
      $thumbnail_image_height = ( int ) ( $thumbnail_image_width / $source_aspect_ratio );
    }

    $thumbnail_gd_image = imagecreatetruecolor( $thumbnail_image_width, $thumbnail_image_height );

    imagecopyresampled( $thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height );

    imagejpeg( $thumbnail_gd_image, $thumbnail_image_path, 90 );

    imagedestroy( $source_gd_image );

    imagedestroy( $thumbnail_gd_image );

    return true;
  }
  
 function check_unique($txtename,$field_name,$tableName_send)
	 {
    $sql="select * from ".$tableName_send." where ".$field_name."='".$txtename."'";
 	   $rs=mysql_query($sql);
	   $result_rows=mysql_num_rows($rs);
	   		if($result_rows >0){
			return 1;
		
		}else{
			return 0;

		}
	 }
	 
function edit_check_unique($tableName_send,$field_name,$txtename,$field_name1,$cid)
	 {
  $sql="select * from ".$tableName_send." where ".$field_name." ='".$txtename."' and ".$field_name1." !='".$cid."' ";
	   $rs=mysql_query($sql);
	   $result_rows=mysql_num_rows($rs);
	   	   		if($result_rows >0){
			return 1;
		
		}else{
			return 0;

		}
	 }

	function check_parent($flag_id,$field_name,$tableName_send)
	{
 $sql="Select * from ".$tableName_send." where ".$field_name." ='".$flag_id."' and flag_id !='0'";
		$rs=mysql_query($sql);
	   $result_rows=mysql_num_rows($rs);
	   	   		if($result_rows >0){
			return 1;
		
		}else{
			return 0;

		}

	}
	function check_child($flag_id,$field_name,$tableName_send)
	{
 $sql="Select * from ".$tableName_send." where ".$field_name." ='".$flag_id."' and flag_id !='0'";
		$rs=mysql_query($sql);
	   $result_rows=mysql_num_rows($rs);
	   	   		if($result_rows >0){
			return 1;
		
		}else{
			return 0;

		}

	}

function seo_url($seo_url){

$seo_url = str_replace('&','-',$seo_url);
$seo_url = str_replace('amp;','and',$seo_url);
$seo_url = str_replace('/','',$seo_url);
$seo_url = str_replace('%','',$seo_url);
$seo_url = str_replace('*','',$seo_url);
$seo_url = str_replace('(','',$seo_url);
$seo_url = str_replace(')','',$seo_url);
$seo_url = str_replace('!','',$seo_url);
$seo_url = str_replace('@','',$seo_url);
$seo_url = str_replace('#','',$seo_url);
$seo_url = str_replace('}','',$seo_url);
$seo_url = str_replace('{','',$seo_url);
$seo_url = str_replace(']','',$seo_url);
$seo_url = str_replace('[','',$seo_url);
$seo_url = str_replace(',','-',$seo_url);
$seo_url = str_replace('.','',$seo_url);
$seo_url = str_replace('?','',$seo_url);
$seo_url = str_replace("'",'',$seo_url);
$seo_url = str_replace(' ','-',$seo_url);
return strtolower($seo_url).'.php';
}

/*function content_desc($content_desc){
$placeholder=array('\'','onblur','onclick','ondatabinding','ondblclick','ondisposed','onfocus','oninit','onkeydown','onkeypress','onkeyup','onload','onmousedown','onmousemove','onmouseout','onmouseover','onmouseup','onprerender','onserverclick','onunload','document.getElementById','document.getElementsByName','document.documentElement','document.createComment','document.createDocumentFragment','document.createElement','document.createTextNode','document.writeln','document.write','alert','<script>','</script>','<script ','javascript','DROP','CREATE','<ScRiPt >','</ScRiPt>');
$remove=array('"',' ');
 $content_desc=str_replace($placeholder,$remove,$content_desc);
return $content_desc;
}*/

function content_desc($content_desc){
$content_desc = str_replace('\'','',$content_desc);
$content_desc = str_replace('&lt;script',' ',$content_desc);
$content_desc = str_replace('&lt;iframe',' ',$content_desc);
$content_desc = str_replace('&lt;script&gt;','',$content_desc);
$content_desc = str_replace('&lt;SCRIPT&gt;','',$content_desc);
$content_desc = str_replace('&lt;SCRIPT',' ',$content_desc);
$content_desc = str_replace('&lt;IFRAME',' ',$content_desc);
//$content_desc = str_replace('&lt;s','',$content_desc);
$content_desc = str_replace('iframe','',$content_desc);
$content_desc = str_replace('script','',$content_desc);
$content_desc = str_replace('window.','',$content_desc);
$content_desc = str_replace('prompt','',$content_desc);
$content_desc = str_replace('confirm','',$content_desc);
$content_desc = str_replace('CONTENT=','',$content_desc);
$content_desc = str_replace('HTTP-EQUIV','',$content_desc);
$content_desc = str_replace('&lt;meta','',$content_desc);
$content_desc = str_replace('&lt;META','',$content_desc);
$content_desc = str_replace('data:text/html','',$content_desc);
$content_desc = str_replace('document.','',$content_desc);
$content_desc = str_replace('url','',$content_desc);
$content_desc = str_replace('&lt;ScRiPt&gt','',$content_desc);
$content_desc = str_replace('&lt;ScRiPt &gt','',$content_desc);
$content_desc = str_replace('document.createTextNode','',$content_desc);
$content_desc = str_replace('document.writeln','',$content_desc);
$content_desc = str_replace('document.write','',$content_desc);
$content_desc = str_replace('alert','',$content_desc);
$content_desc = str_replace('javascript','',$content_desc);
$content_desc = str_replace('DROP','',$content_desc);
$content_desc = str_replace('CREATE','',$content_desc);
$content_desc = str_replace('onsubmit','',$content_desc);
$content_desc = str_replace('onblur','',$content_desc);
$content_desc = str_replace('onclick','',$content_desc);
$content_desc = str_replace('ondatabinding','',$content_desc);
$content_desc = str_replace('ondblclick','',$content_desc);
$content_desc = str_replace('ondisposed','',$content_desc);
$content_desc = str_replace('onfocus','',$content_desc);
$content_desc = str_replace('onkeydown','',$content_desc);
$content_desc = str_replace('onkeyup','',$content_desc);
$content_desc = str_replace('onload','',$content_desc);
$content_desc = str_replace('onmousedown','',$content_desc);
$content_desc = str_replace('onmousemove','',$content_desc);
$content_desc = str_replace('onmouseout','',$content_desc);
$content_desc = str_replace('onmouseover','',$content_desc);
$content_desc = str_replace('onmouseup','',$content_desc);
$content_desc = str_replace('onprerender','',$content_desc);
$content_desc = str_replace('onserverclick','',$content_desc);
return $content_desc;
}
 
 

function status($val)
	{
		if($val=='1')
		{
		echo "Draft";
		}
		else if($val=='2')
		{
		echo "For Approval";
		}
		else if($val=='3')
		{
		echo "Publish";
		}

		else
		  echo "Review";
     	}


function language($val)
{
if($val=='2')
echo "Hindi";
else if($val=='3')
	echo "Marathi";
else if($val=='4')
	echo "Gujarati";
else if($val=='5')
	echo "Telugu";
else if($val=='6')
	echo "Tamil";
else if($val=='7')
	echo "Kannada";
else
echo "English";
}





function pgdt2($pgid,$mode,$arr)
{
 	 $qry_pgdtl="SELECT * FROM menu_publish WHERE m_publish_id='$pgid'";  
	$rsl_pgdtl=mysql_query($qry_pgdtl); 	
	//$n_pgdtl = mysql_num_rows($rsl_pgdtl); 
	$arr_pgdtl =  mysql_fetch_row($rsl_pgdtl);
		if($mode=='0')
		{
		return($arr_pgdtl[$arr]);
		}
		elseif($mode=='1')
		{
		echo "$arr_pgdtl[$arr]";
		}

}

function pagebreadcrumb($pgid,$mode,$method,$act,$page)
{
$pgprntpgnam="";
//echo $pgid;
if($method=='mapping')
{
$symbol=" >> ";
}
if($page=='content')
	{
	while($pgid!='0')
	{
//echo "$pgid<br>";
	$parentspgid[]=$pgid;
	 $pgid=pgdt2($pgid,0,3);
	}
		$parentspgcount=count($parentspgid);
		//echo $parentspgcount;
		for($i=$parentspgcount-1; $i>=0; $i--)
		{
			 $pgnam=pgdt2($parentspgid[$i],0,6);
			$pgpath=pgdt2($parentspgid[$i],0,7);
			if($i!='0')
			{  if($act!='0')
				{
				$pgnam="<li>".$pgnam."</li>";	
				//$pgnam="<li><a href='#'>".$pgnam."</a></li>";	
				}
							
			}
			else
				{
				// $pgnam="<li>".$pgnam."</li>";
				 $pgnam="<li class='last'>".$pgnam."</li>";	
				}
			
		$prntpgnam=$prntpgnam.$pgnam;
		}
	}
if($mode=='0')
{
return($prntpgnam);
}
elseif($mode=='1')
{
//echo "$prntpgnam";
}

}

//page title bread crumb
function pagebreadcrumb1($pgid,$mode,$method,$act,$page)
{
$pgprntpgnam="";
//echo $pgid;
if($method=='mapping')
{
$symbol="-";
}
if($page=='content')
	{
	while($pgid!='0')
	{
	//echo "$pgid<br>";
	$parentspgid[]=$pgid;
	 $pgid=pgdt2($pgid,0,3);
	}
		$parentspgcount=count($parentspgid);
		for($i=$parentspgcount-1; $i>=0; $i--)
		{
			$pgnam=pgdt2($parentspgid[$i],0,6);
			//$pgsts=pgdtl($parentspgid[$i],0,1);
			$pgpath=pgdt2($parentspgid[$i],0,7);
			if($i!='0')
			{
				if($act=='1')
				{
				$pgnam=$pgnam.$symbol;	
				}
				else
				{
				$pgnam="$pgnam $symbol ";
				}
			}
		$prntpgnam=$prntpgnam.$pgnam;
		}

}

	if($mode=='0')
	{
	return($prntpgnam);
	}
	elseif($mode=='1')
	{
	echo "$prntpgnam";
	}

}

function pgdt3($pgid,$mode,$arr)
{
 	 $qry_pgdtl="SELECT * FROM airports_publish WHERE m_publish_id='$pgid'";  
	$rsl_pgdtl=mysql_query($qry_pgdtl); 	
	//$n_pgdtl = mysql_num_rows($rsl_pgdtl); 
	$arr_pgdtl =  mysql_fetch_row($rsl_pgdtl);
		if($mode=='0')
		{
		return($arr_pgdtl[$arr]);
		}
		elseif($mode=='1')
		{
		echo "$arr_pgdtl[$arr]";
		}

}

function pagebreadcrumb2($pgid,$mode,$method,$act,$page)
{
$pgprntpgnam="";
//echo $pgid;
if($method=='mapping')
{
$symbol=" >> ";
}
if($page=='content')
	{
	while($pgid!='0')
	{
//echo "$pgid<br>";
	$parentspgid[]=$pgid;
	 $pgid=pgdt3($pgid,0,3);
	}
		$parentspgcount=count($parentspgid);
		//echo $parentspgcount;
		for($i=$parentspgcount-1; $i>=0; $i--)
		{
			 $pgnam=pgdt3($parentspgid[$i],0,6);
			$pgpath=pgdt3($parentspgid[$i],0,7);
			if($i!='0')
			{  if($act!='0')
				{
				$pgnam="<li><a href='#'>".$pgnam."</a></li>";	
				//$pgnam="<li><a href='#'>".$pgnam."</a></li>";	
				}
							
			}
			else
				{
				// $pgnam="<li>".$pgnam."</li>";
				 $pgnam="<li class='last'>".$pgnam."</li>";	
				}
			
		$prntpgnam=$prntpgnam.$pgnam;
		}
	}
if($mode=='0')
{
return($prntpgnam);
}
elseif($mode=='1')
{
//echo "$prntpgnam";
}

}

function get_page($page_id) {
$parent =mysql_query("SELECT m_flag_id as page_id,m_publish_id,m_name FROM menu_publish where m_publish_id ='$page_id' and 	approve_status='3' ORDER BY page_postion ASC");  
//echo "SELECT m_flag_id as page_id,m_publish_id FROM schemes_publish where m_publish_id ='$page_id' and 	approve_status='3' ORDER BY page_postion ASC";
		$line =mysql_fetch_array($parent);
		$pag=$line['page_id'];
		$m_name=$line['m_name'];
	if ($pag==0) return $m_name;
	else return get_page($pag);
}


function get_root_parent($page_id) {
$parent =mysql_query("SELECT m_flag_id as page_id,m_publish_id FROM menu_publish where m_publish_id ='$page_id' and 	approve_status='3' ORDER BY page_postion ASC");  
		$line =mysql_fetch_array($parent);
		$pag=$line['page_id'];
		$m_publish_id=$line['m_publish_id'];
	if ($pag==0) return $m_publish_id;
	else return get_root_parent($pag);
}

function parentid($page_id) {
    
	//echo "SELECT m_flag_id as page_id,m_publish_id FROM menu_publish where m_url ='$page_id' and approve_status='3' ORDER BY page_postion ASC";
		$parent =mysql_query("SELECT m_flag_id as page_id,m_publish_id FROM menu_publish where m_publish_id ='$page_id' and approve_status='3' ORDER BY page_postion ASC");  
		$line =mysql_fetch_array($parent);
		$pag=$line['page_id'];

		$m_publish_id=$line['m_publish_id'];
	if ($pag==0) return $m_publish_id;
	else return parentid($pag);
}
function display_title($rootid)
{
	$sql =mysql_query("SELECT m_name FROM menu_publish where m_publish_id ='$rootid' and approve_status='3'");  
	$line =mysql_fetch_array($sql);
	 return $line['m_name'];
}

function validateURL($URL) {
    $v = "/^(http|https|ftp|):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
    return (bool)preg_match($v, $URL);
}
function urlread($val)
{
  $val=explode('.',$val);
  return $val['0'];
}

function summary($str, $limit) {
$str=html_entity_decode($str);
    $str = ($strip == true)?strip_tags($str):$str;
	    if (strlen ($str) > $limit) {
        $str = substr ($str, 0, $limit - 3);
        return (substr ($str, 0, strrpos ($str, ' ')).'...');
    }
    return trim($str);
}

function fontsize($val)
{
 if($val=='-A')
    {
	$fontsize="<style type='text/css' media='screen'>html, body{font-size: 90%;}</style>";
	
	}
   if($val=='A')
    {
	$fontsize="<style type='text/css' media='screen'>html, body{font-size: 100%;}</style>";
	}
	if($val=='A+')
    {	$fontsize="<style type='text/css' media='screen'>html, body{font-size: 110%;}</style>";
	}	
 return $fontsize;
}
function datfun($date)
	{
	  $d=explode('/',$date);
	 $date=$d['2'].'-'.$d['1'].'-'.$d['0'];
	 return $date;
 	}
       
function changeformate($date)
	{
	  $d=explode('-',$date);
	 $date=$d['2'].'-'.$d['1'].'-'.$d['0'];
	 return $date;
 	}
	
function showlistcontent($oldID) {

		$result = mysql_query("SELECT publish_id as page_id ,menu_name as title FROM latest_news_publish  where flag_id ='$oldID' and content_approve_status='5' ORDER BY menu_postion ASC");  
		while($line = mysql_fetch_array($result)) 
		{ 
		if($catlistids!="")
		{ 
		$catlistids.=','; 
		}
		$catlistids .= $line["page_id"];
		showlistcontent($line["page_id"]); 
		}
		return $catlistids;
}

			
			function switcmonth($mon)
					{
							switch($mon)
							 {
							case 1:
							$m="Jan";
							break;
							case "2":
							$m="Feb";
							break;
							case "3":
							$m="Mar";
							break;
							case "4":
							$m="Apr";
							break;
							case "5":
							$m="May";
							break;
							case "6":
							$m= "Jun";
							break;
							case "7":
							$m= "Jul";
							break;
							case "8":
							$m= "Aug";
							break;
							case "9":
							$m= "Sep";
							break;
							case "10":
							$m= "Oct";
							break;
							case "11":
							$m= "Nov";
							break;
							case "12":
							$m="Dec";
							break;
					
					}
					return $m;
				
				 }
				 
function bredtitel($val)
    {
	switch($val)
							 {
							case 1:
							$m="Jan";
							break;
							case "2":
							$m="Feb";
							break;
							case "3":
							$m="Mar";
							break;
							case "4":
							$m="Apr";
							break;
							case "5":
							$m="May";
							break;
							case "6":
							$m= "Jun";
							break;
							case "7":
							$m= "Jul";
							break;
							case "8":
							$m= "Aug";
							break;
							case "9":
							$m= "Sep";
							break;
							case "10":
							$m= "Oct";
							break;
							case "11":
							$m= "Nov";
							break;
							case "12":
							$m="Dec";
							break;
					
					}
					return $m;
	}		 
   
   function emailto($login_user,$login_email,$newname,$id_no){

			$salt =rand(19999, 29999);
			$salt1 =rand(31999, 59999);
			
			$sql_admin_email = "SELECT user_email FROM mol_admin_login ";
			$res_admin_email =mysql_query($sql_admin_email);
			$res_num_rows=mysql_num_rows($res_admin_email);
			$data=mysql_fetch_array($res_admin_email);
			@extract($data);

			$userid=$salt.$id_no.$salt1;
			$email_from = $user_email; // Who the email is from 
			$email_subject = "Congratulations! Your  Membership has been activated.";
			$email_to= $login_email;
			$headers = "From: ".$email_from."\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\n"; 
			$email_message.="<table width='100%'  border='0' cellspacing='0' cellpadding='2' align='left'>
			<tr><td colspan='3' align='left' class='text_mail' >Dear&nbsp;".$newname.",</td></tr>
			<tr><td colspan='3' class='text_mail'></td></tr>
			<tr><td colspan='3' class='text_mail'>Congratulation! Your  Membership has been activated.</td></tr>
			<tr><td colspan='3' class='text_mail'>Your login information is below:</td></tr>
			<tr><td colspan='3' class='text_mail'>Username&nbsp;:&nbsp;".$login_user."</td></tr>
			<tr><td colspan='3' class='text_mail'>Password&nbsp;:&nbsp;<a href='$HomeURL/content/reset_password.php?uid=$userid'> Reset your Password</a></td></tr>";
			$email_message.="<tr><td width='40%' colspan='3' >&nbsp;</td></tr>
			<tr><td class='text_mail' colspan='3'align='left'>Customer Support Team</td></tr>
			<tr><td class='text_mail' colspan='3'align='left'>National Shipping Board.</td></tr>
			</table>";
			$ok=@mail($email_to, $email_subject, $email_message, $headers);
}

function role_permission($user_id,$model_name)
	 {
	 		$user_id=$_SESSION['admin_auto_id_sess'];		
		     $query=mysql_query("select module_id from module where module_name='".$model_name."'");
			 //echo "select module_id from module where module_name='".$model_name."'"; 
		
			$result=mysql_fetch_array($query);
			 $sql="select * from map_role inner join role on map_role.role_type=role.role_id  where user_id=".$user_id." and module_id='".$result['module_id']."'";   
			$rs=mysql_query($sql);

			$count=mysql_num_rows($rs);
	   		if($count >0){
			return $role_map=mysql_fetch_array($rs);
			}
			else { 
			return $count;}
			
	 }


function role_permission1($role_super,$module_id)
	 {
		   
		 $sql="select * from map_role where role_id=".$role_super;
			$rs=mysql_query($sql);

			$count=mysql_num_rows($rs);
	   		if($count >0){
			return $role_map=mysql_fetch_array($rs);
			}
			else { 
			return $count;}
			
	 }


function lang($val)
{ 
	if($val=='EN')
		{
		return $eng='English';
		}
		else if($val=='HI')
		 {
		return $hin='Hindi';
		 }
 	} 
function active($val)
{ 
	if($val=='0')
		{
		return $eng='In Active';
		}
		else if($val=='1')
		 {
		return $hin='Active';
		 }
 	} 

function check_status($role_id,$txtstatus,$model_name)
{
    if($role_id >0)
	  {
				 $query=mysql_query("select module_id from module where module_name='".$model_name."'");

				// echo "select module_id from module where module_name='".$model_name."'";
				$result=mysql_fetch_array($query);
				$query1=mysql_query("select state_short from content_state where state_id='".$txtstatus."'");
				$result1=mysql_fetch_array($query1);
				if($result1['state_short']=='DR')
				   {
				    $status=" And draft='".$result1['state_short']."'" ;
				   }
				   if($result1['state_short']=='RV')
				   {
				    $status=" And review='".$result1['state_short']."'" ;
				   }
				   if($result1['state_short']=='PB')
				   {
				    $status=" And publish='".$result1['state_short']."'" ;
				   }
				   if($result1['state_short']=='AP')
				   {
				    $status=" And mapprove='".$result1['state_short']."'" ;
				   }
		
				    if($result1['state_short']=='ED')
				   {
				    $status=" And medit='".$result1['state_short']."'" ;
				   }
				    if($result1['state_short']=='DE')
				   {
				    $status=" And mdelete='".$result1['state_short']."'" ;
				   }
				   
		 $sql="select * from map_role where role_id=".$role_id." and module_id='".$result['module_id']."'".$status ; 
				
			$rs=mysql_query($sql);
			 $count=mysql_num_rows($rs);
		
			if($count >0){
			return  $count=1;
			}
			else {

			return $count=0;
			}
			
		}
		else
		 {
		 return  $count=1;
		 }	
			
}	

function check_status1($role_id,$txtstatus,$model_name)
{

    if($role_id>0)
	  {
				$query1=mysql_query("select state_short from content_state where state_id='".$txtstatus."'");
				$result1=mysql_fetch_array($query1);
				if($result1['state_short']=='DR')
				   {
				    $status=" And draft='".$result1['state_short']."'" ;
				   }
				   if($result1['state_short']=='RV')
				   {
				    $status=" And review='".$result1['state_short']."'" ;
				   }
				   if($result1['state_short']=='PB')
				   {
				    $status=" And publish='".$result1['state_short']."'" ;
				   }
				   if($result1['state_short']=='AP')
				   {
				    $status=" And mapprove='".$result1['state_short']."'" ;
				   }
				    if($result1['state_short']=='ED')
				   {
				    $status=" And medit='".$result1['state_short']."'" ;
				   }
				    if($result1['state_short']=='DE')
				   {
				    $status=" And mdelete='".$result1['state_short']."'" ;
				   }
				   
				   $sql="select * from map_role where role_id=".$role_id." and module_id=".$model_name."".$status ;
				
			$rs=mysql_query($sql);
			 $count=mysql_num_rows($rs);
		
			if($count >0){
			return  $count=1;
			}
			else {

			return $count=0;
			}
			
		}
		else
		 {
		 return  $count=1;
		 }	
			
}	
function check_delete($role_id,$txtstatus,$model_name)
{

 
    if($role_id < 0)
        
	  {
       			       $query=mysql_query("select module_id from module where module_name='".$model_name."'");
                               $result=mysql_fetch_array($query);
				  if($txtstatus=='ED')
				   {
				    $status=" And medit='".$txtstatus."'" ;
				   }
				    if(txtstatus=='DE')
				   {
				    $status=" And mdelete='".$txtstatus."'" ;
				   }
				   
				   $sql="select * from map_role where role_id=".$role_id." and module_id='".$result['module_id']."'".$status ;
				
			$rs=mysql_query($sql);
			 $count=mysql_num_rows($rs);
		
			if($count >0){
			return  $count=1;
			}
			else {

			return $count=0;
			}
			
		}
		else
		 {
		 return  $count=1;
		 }	
			
}	

function check_delete1($role_id,$txtstatus,$model_name)
{

    if($role_id>0)
	  {
					  if($txtstatus=='ED')
				   {
				    $status=" And medit='".$txtstatus."'" ;
				   }
				    if(txtstatus=='DE')
				   {
				    $status=" And mdelete='".$txtstatus."'" ;
				   }
				  				 echo $sql="select * from map_role where role_id=".$role_id." and module_id=".$model_name." ".$status ;
				
			$rs=mysql_query($sql);
			 $count=mysql_num_rows($rs);
		
			if($count >0){
			return  $count=1;
			}
			else {

			return $count=0;
			}
			
		}
		else
		 {
		 return  $count=1;
		 }	
			
}	


function format_size($size) {
      $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
      if ($size == 0) { return('n/a'); } else {
      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
}


function formatFilebytes($file, $type)
{
switch($type){
case "KB":
$filesize = filesize($file) * .0009765625; // bytes to KB
break;
case "MB":
$filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
break;
case "GB":
$filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
break;
}
if($filesize <= 0){
return $filesize = 'unknown file size';}
else{return round($filesize, 2).' '.$type;}
}
function word_limiter($str, $limit = 25, $end_char = '…') {

        if (trim($str) == '')
            return $str;

        preg_match('/\s*(?:\S*\s*){' . (int) $limit . '}/', $str, $matches);

        if (strlen($matches[0]) == strlen($str))
            $end_char = '';

        return rtrim($matches[0]) . $end_char;
    }



function role_admin($role_super)
	 {
		
		    $query=mysql_query("SELECT role_type FROM `admin_role` where role_id='".$role_super."'");
	//echo "SELECT role_type FROM `admin_role` where role_id='".$role_super."'";
			$result=mysql_fetch_array($query);
			//echo "<br />";
			$sqlnew="select role_name from admin_role where role_type ='".$result['role_type']."'";   
			$rs=mysql_query($sqlnew);
			$count=mysql_num_rows($rs);
			//echo $count;
	   		if($count >0){
			$role_map=mysql_fetch_array($rs);
			//print_r($role_map);
			return $name=$role_map['role_name'];
			}
			else { 
			return $name='Super Admin';}
			
	 }
	 
	 
	 function edit_root_org($tableName_send,$field_name,$txtename,$field_name1,$cid)
	 {
	    if($txtename >0)
		{
 	 $sql="select * from ".$tableName_send." where ".$field_name." ='".$txtename."'"; 
		}	
		else { $sql="select * from ".$tableName_send." where ".$field_name." ='".$txtename."' and ".$field_name1." !='".$cid."' "; }

	   $rs=mysql_query($sql);
	   $result_rows=mysql_num_rows($rs);
	   	   		if($result_rows >0){
			return 1;
		
		}else{
			return 0;

		}
	 }
	
	
	function showroot($oldID) {
	
	$result = mysql_query("SELECT * FROM menu where m_flag_id ='$oldID' and approve_status='3'"); 
				while($line = mysql_fetch_array($result)) 
		{ 
		if($catlistids!="")
		{ 
		$catlistids.=','; 
		}
		$catlistids .= $line["m_id"];
		showroot($line["m_id"]); 
		}
		return $catlistids;
}

function limit_words($string, $word_limit)
{
    $words = explode (" ",$string);
    return implode (" ",array_splice ($words,0,$word_limit));
}
	function hindimonth($val)
	{
	
	switch($val){
	case 1:
	$m="जनवरी";
	break;
	case "2":
	$m="फरवरी";
	break;
	case "3":
	$m="मार्च";
	break;
	case "4":
	$m="अप्रैल";
	break;
	case "5":
	$m="मई";
	break;
	case "6":
	$m= "जून";
	break;
	case "7":
	$m= "जुलाई";
	break;
	case "8":
	$m= "अगस्त";
	break;
	case "9":
	$m= "सितम्बर";
	break;
	case "10":
	$m= "अक्तूबर";
	break;
	case "11":
	$m= "नवम्बर";
	break;
	case "12":
	$m="दिसम्बर";
	break;
	
	}
	return $m;
	}
	
		function hindiday($val)
	{
	
	switch($val){
	case "Sunday":
	$m="रविवार";
	break;
	case "Monday":
	$m="सोमवार";
	break;
	case "Tuesday":
	$m="मंगलवार";
	break;
	case "Thursday":
	$m="बृहस्पतिवार";
	break;
	case "Friday":
	$m="शुक्रवार";
	break;
	case "Saturday":
	$m= "शनिवार";
	break;
	}
	return $m;
	}	



function statename($oldID) {
	
	$result = mysql_query("Select * from state where state_id='$oldID'"); 
		$line = mysql_fetch_array($result);
		return $line['state_name'];
}
function distictname($oldID) {
	
	$result = mysql_query("Select * from districts where dist_id ='$oldID'"); 
		$line = mysql_fetch_array($result);
		return $line['dist_name'];
}
function statenamehi($oldID) {
	
	$result = mysql_query("Select * from state where state_id='$oldID'"); 
		$line = mysql_fetch_array($result);
		return $line['state_hi_name'];
}
function distictnamehi($oldID) {
	
	$result = mysql_query("Select * from districts where dist_id ='$oldID'"); 
		$line = mysql_fetch_array($result);
		return $line['dist_hi_name'];
}

function func_org_designation($oldID) {
	$sql = mysql_query("select * from org_designation where approve_status='3' and deg_id='$oldID'");
	//echo "select * from org_designation where approve_status='3' and deg_id='$oldID'";
	$row = mysql_fetch_array($sql);
	return $row['designation'];
}

function func_org_status($oldID) {
	$sql = mysql_query("select * from organization_chart where approve_status='3' and id='$oldID'");
	//echo "select * from org_designation where approve_status='3' and deg_id='$oldID'";
	$row = mysql_fetch_array($sql);
	return $row['profile_status'];
}
 
 function check_home_page_unique($txtename,$field_name,$tableName_send,$txtlanguage)
	 {
     $sql="select * from ".$tableName_send." where ".$field_name."='".$txtename."' and language_id='".$txtlanguage."'"; 
 	   $rs=mysql_query($sql);
	   $result_rows=mysql_num_rows($rs);
	   		if($result_rows >0){
			return 1;
		
		}else{
			return 0;

		}
	 }
	 
function edit_check_home_page_unique($tableName_send,$field_name,$txtename,$field_name1,$cid,$txtlanguage)
	 {
  $sql="select * from ".$tableName_send." where ".$field_name." ='".$txtename."' and language_id='".$txtlanguage."' and ".$field_name1." !='".$cid."' ";
	   $rs=mysql_query($sql);
	   $result_rows=mysql_num_rows($rs);
	   	   		if($result_rows >0){
			return 1;
		
		}else{
			return 0;

		}
	 }
	function type_of_extention_size_file($body,$HomeURL,$path){
$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>"; 
							if(preg_match_all("/$regexp/siU", $body, $matches, PREG_SET_ORDER)) 
							{ 
								foreach($matches as $match) 
								{ 
								
				
								
								$phrase  = $match[2];
$extenM1=substr($match[2],7);
$healthy = array("@",".");
$yummy   = array("[at]","[dot]");
$newphrase = str_replace($healthy, $yummy, $extenM1);
$extenM=substr($match[2],0,6);
if($extenM=="mailto")
{
$body=str_replace($match[0],$newphrase,$body);
}
					
									 $exten=substr($match[2],-4);
									$startstr=substr($match[2],0,4);
								if($startstr=="http")
									{
										
											if($exten=='.pdf')
											{

											$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='$match[3]'>$match[3]&nbsp;<img src='$HomeURL/images/pdf_icon.png'></a>",$body);
											}

											if(($exten=='.doc') || ($exten=='docx'))
										   {

											$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='$match[3]'>$match[3]&nbsp;<img src='$HomeURL/images/word.jpeg'></a>",$body);

											}
											if(($exten=='xlsx') || ($exten=='.xls'))
										   {

											$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='$match[3]'>$match[3]&nbsp;<img src='$HomeURL/images/excel_icon.jpg'></a>",$body);

											}
											else
											{
											
												$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='$match[3]'>$match[3]&nbsp;<img src='$HomeURL/images/external_link_icon.png'></a>",$body);
											}
											

									} 
									else
									{
						
											if($exten=='.pdf')
											{
								
											//$f="../../upload/uploadfiles/files/sec_letter.pdf";
 $f=str_replace('/disability/',$path,$match[2]);
 $size =' size:( '.formatFilebytes($f,'MB'). ')';
											$body=str_replace($match[0],"<a  href='$match[2]' target='_blank'  title='$match[3]'>$match[3]&nbsp;<img src='$HomeURL/images/pdf_icon.png'>$size</a>",$body);
                                     		}
											if(($exten=='.doc') || ($exten=='docx'))
										   {
$f=str_replace('/disability/',$path,$match[2]);
 $size =' size:( '.formatFilebytes($f,'MB'). ')';
											$body=str_replace($match[0],"<a  href='$match[2]'  target='_blank'  title='$match[3]'>$match[3]&nbsp;<img src='$HomeURL/images/word.jpeg'>$size</a>",$body);
											}
											if(($exten=='xlsx') || ($exten=='.xls'))
										   {
										$f=str_replace('/disability/',$path,$match[2]);
 $size =' size:( '.formatFilebytes($f,'MB'). ')';
								$body=str_replace($match[0],"<a  href='$match[2]'  target='_blank'  title='$match[3]'>$match[3]&nbsp;<img src='$HomeURL/images/excel_icon.jpg'>$size</a>",$body);
																									}
										if(($exten=='pptx') || ($exten=='.ppt'))
										   {
										$f=str_replace('/disability/',$path,$match[2]);
 $size =' size:( '.formatFilebytes($f,'MB'). ')';
								$body=str_replace($match[0],"<a  href='$match[2]'  target='_blank'  title='$match[3]'>$match[3]&nbsp;<img src='$HomeURL/images/ppt.jpeg'>$size</a>",$body); }
									if(($exten=='.ZIP') || ($exten=='.zip') || ($exten=='.RAR') || ($exten=='.rar'))
										   {
										$f=str_replace('/disability/',$path,$match[2]);
 $size =' size:( '.formatFilebytes($f,'MB'). ')';
								$body=str_replace($match[0],"<a  href='$match[2]'  target='_blank'  title='$match[3]'>$match[3]&nbsp;<img src='$HomeURL/images/zips.jpeg'>$size</a>",$body); }
									}
								} 
							}
return $body;

}
function change_date_full_formate($date)
	{
	  $d=explode(' ',$date);
	   $d=explode('-',$d['0']);
	 $date=$d['2'].'-'.$d['1'].'-'.$d['0'];
	 return $date;
 	}
	function user_name($oldID) {
	$result = mysql_query("select * from  signup where  user_status='1'  and id='$oldID'"); 
	$line = mysql_fetch_array($result);
	return $line['user_name'];
	}
?>





