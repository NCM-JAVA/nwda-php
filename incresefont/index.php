<?php ob_start();
session_start();
function fontsize($val)
{
 if($val=='-A')
    {
	 $fontsize = "<style type='text/css' media='screen'>html, body{font-size: 90%;}</style>";
	}
   if($val=='A')
    {
	$fontsize="<style type='text/css' media='screen'>html, body{font-size: 100%;}</style>";
	}
	if($val=='A+')
    {	$fontsize="<style type='text/css' media='screen'>html, body{font-size: 106%;}</style>";
	}	
 return $fontsize;
}
if($_SERVER['REQUEST_URI'])
		{
					$urlpath=$_SERVER['REQUEST_URI'];  
					$val=explode('//', $urlpath);
					$urlpath=$val['1'];
					$url=$val['0'];
					$url=explode('/', $url);
					$url=$url['3']; 
				
					
					if($url=='decrease')
					{ 
					unset($_SESSION['fontsize']); 
					$font='-A';
					$val=fontsize($font);
					$_SESSION['fontsize']=$val;
					echo $_SESSION['fontsize'];
					} 
					else if($url=='normal')
					{
					unset($_SESSION['fontsize']); 
					$font='A';
				$val=fontsize($font);
					$_SESSION['fontsize']=$val;
					echo $_SESSION['fontsize'];
					}
					else if($url=='increase')
					{
					unset($_SESSION['fontsize']); 
					$font='A+';
					$val=fontsize($font);
					$_SESSION['fontsize']=$val;
					echo $_SESSION['fontsize'];
					}
					if($url=='highcontrast')
					{ 
					unset($_SESSION['name_css']); 
				 	$name='highcontrast'; 
					$_SESSION['name_css']=$name;
					echo $_SESSION['name_css'];
					} 
					if($url=='default')
					{ 
					unset($_SESSION['name_css']); 
					$name='blue';
					$_SESSION['name_css']=$name;
					echo $_SESSION['name_css'];
					} 
					if($url=='blue')
					{ 
					unset($_SESSION['name_css']); 
					$name='blue';
					$_SESSION['name_css']=$name;
					echo $_SESSION['name_css'];
					} 
					
					if($url=='green')
					{ 
					unset($_SESSION['name_css']); 
					$name='green';
					$_SESSION['name_css']=$name;
					echo $_SESSION['name_css'];
					} 
					
					if($url=='orange')
					{ 
					unset($_SESSION['name_css']); 
					$name='orange';
					$_SESSION['name_css']=$name;
					echo $_SESSION['name_css'];
					} 				


					$test = 'http://'.$_SERVER["HTTP_HOST"].'/'.$urlpath; 
					
					header('Location:'.$test);
					exit();
										
		}
		
?>


			
