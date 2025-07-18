<?php

$domains = ['www.nwda.gov.in'];
/* if ( !in_array($_SERVER['SERVER_NAME'], $domains)) {
   header('HTTP/1.1 403 Forbidden'); die('Unknown Host.'); 
} */

if(isset($_SERVER['HTTP_REFERER'])) {
	if (strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)) != strtolower($_SERVER['HTTP_HOST'])) {
		if ($domains[0] != strtolower('www.'.$_SERVER['HTTP_HOST'])) {
			header('HTTP/1.1 403 Forbidden'); die('Unknown Host....');
		}
	}
}

header("Location: /content");
exit();


?>