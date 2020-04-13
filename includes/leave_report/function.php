<?php 

function createPdf($db,$pdf_title,$content,$paper_size,$paper_orientation,$pdf_name)
{	
	// prnt($content);
	// die();
  include_once('./dompdf/dompdf_config.inc.php');
  $title =$db->get_row("SELECT * FROM general_setting WHERE gs_id=1");
  $html='';

  $html .='<style>
  p,h5
  {
    margin:0px;
    padding:0px;
  }

  .table strong {
    padding-top: 12px;
    padding-bottom: 12px;
    border-collapse: collapse;
    width: 100%;  
  }

  img
  {
    height:70px;
  }

  .table
  {
    cell-padding:0px;
    cell-spacing:0px;
    border-collapse:collapse;
    width:100%;
    border:1px solid #000000;
    font-size: 12px;
  }

  .table td,.table th
  {
    padding:5px;
    border:1px solid #000000;
  }

  p
  {
    font-size: 12px;
  }

  body
  {
    font-family:verdana;
  }

  @page {
    margin: 0.5cm;
  }

  .footer{
    position: absolute;
  }

  .footer{
    bottom:0;
    text-align:center;   
  }
  </style>';

  $html.='<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
  $html.='<div style="border: 1px solid;padding:2%;">
  <table style="width: 100%;border-bottom:1px solid;">
  <tr>
    <td><img src="images/logo/'.$title->inst_id.'.jpg"></td>
    <td><center><h5 style="color:#9c4d55; font-size:22px; font-weight:900;">'.$title->ins_name.'</h5><span>'.$title->ins_address.'</span><center></td>
    <td>'.date('d-M-Y').'</td>
  </tr>
  ';
  $html.='</table>';

  $html.='<p style="text-align: center; font-size: 12px;margin-top:4px;"> '.$pdf_title.' </p>';
  $html.='<hr>';
  $html.='<br>';

  $html .= $content;
  $dompdf = new DOMPDF();  
  $dompdf->set_paper($paper_size, $paper_orientation);  
  $dompdf->load_html($html);
  $dompdf->render();
  $pdf = $dompdf->output();  

  $fp = fopen("reports/".$pdf_name.".pdf", 'w');
  fclose($fp);
  chmod("reports/".$pdf_name.".pdf", 0777); 
  file_put_contents("reports/".$pdf_name.".pdf", $pdf);  
  
  header("location:download.php?file_url=reports/".$pdf_name.".pdf");
  
  if($pdf)
  {
  	return true;
  }
  else{
  	return false;
  }

}

 ?>