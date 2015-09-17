<?php

/*
 * funções para gerar arquivos csv
 * thanks to Alain Tiemblo! (http://stackoverflow.com/questions/4249432/export-to-csv-via-php)
 */

function array2csv($array)
{
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   
   foreach ($array as $row) {
       fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}

function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    $output = fopen("php://output",'w') or die("Can't open php://output");
    
    // force download
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    
    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
}

$filename = $_GET['filename'];
$data_csv = $_GET['data_csv'];

$filename = ($_GET['filename']) ? $_GET['filename'] : "relatorio";

if ($data_csv != '') {
    $data_csv = json_decode($data_csv);
    download_send_headers($filename . "_" . date("Y-m-d") . ".csv");
    echo array2csv($data_csv);
    die();
}

?>