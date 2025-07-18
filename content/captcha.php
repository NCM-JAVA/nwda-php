<?php
/* 	session_start();
	include("phptextClass.php");	
	$phptextObj = new phptextClass();	
	$phptextObj->phpcaptcha('#162453','#fff',120,40,10,25);	 */

	session_start();
	$permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	 $captcha_string='';
	function generate_string($input, $strength = 10) {
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	 
		return $random_string;
	}

	$image = imagecreatetruecolor(190, 50);
	imageantialias($image, true);
	$colors = [];
	$red = rand(225, 225);
	$green = rand(225, 225);
	$blue = rand(225, 225);
	for($i = 0; $i < 5; $i++) {
	  $colors[] = imagecolorallocate($image, $red - 20*$i, $green - 20*$i, $blue - 20*$i);
	}
	imagefill($image, 0, 0, $colors[0]);
	for($i = 0; $i < 10; $i++) {
	  imagesetthickness($image, rand(2, 10));
	  $line_color = $colors[rand(1, 4)];
	  imagerectangle($image, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $line_color);
	}
	$black = imagecolorallocate($image, 0, 0, 0);
	$white = imagecolorallocate($image, 255, 255, 255);
	$textcolors = [$black, $white];
	 $fonts = dirname(__FILE__).'/font/monofont.ttf';
	$string_length = 6;
	$captcha_string = generate_string($permitted_chars, $string_length);
	$_SESSION['captcha_text'] = $captcha_string;

	for($i = 0; $i < $string_length; $i++) {
	  $letter_space = 150/$string_length;
	  $initial = 25;
	  
	  imagettftext($image, 35, 15, $initial + $i*$letter_space, 38, $textcolors[0], $fonts, $captcha_string[$i]);
	}

	header('Content-type: image/png');
	imagepng($image);
	imagedestroy($image);

 ?>