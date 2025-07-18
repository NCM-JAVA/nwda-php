<?php
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");
include ("../mpdf/mpdf.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);

/* pdf generate */
$mpdf=new mPDF('win-1252','A4','','',20,15,10,5,10,10);
$mpdf->useOnlyCoreFonts = true;   
$mpdf->SetWatermarkText("NWDA");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');
        ob_start(); // Start output buffer capture.
        include("vacancy_form.php"); // Include your template.
        $html = ob_get_contents(); // This contains the output of yourtemplate.php
        // Manipulate $output...
        ob_end_clean(); // Clear the buffer.
        $randNo = rand(10,60).date('disy');
        $target = "Application_preview.pdf";      
        $mpdf->WriteHTML($html); $mpdf->setFooter('Page {PAGENO}'); 
        $mpdf->Output($target,'D');
        /* pdf generate */
        ?>

