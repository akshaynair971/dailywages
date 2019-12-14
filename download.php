<?php
$file_url = $_GET['file_url'];
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
readfile($file_url); // do the double-download-dance (dirty but worky)
//header('location:'.$_SERVER['HTTP_REFERER']);
?>