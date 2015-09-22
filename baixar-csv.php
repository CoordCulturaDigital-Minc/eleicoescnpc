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

if (!empty($_POST)) {
    $filename = $_POST['filename'];
    $data_csv = $_POST['data_csv'];
}

if ($data_csv != '') {
    $data_csv = json_decode($data_csv);
    download_send_headers($filename . "_" . date("Y-m-d") . ".csv");
    echo array2csv($data_csv);
    die();
} else {
?><!doctype html>
<html lang="pt-BR">
<head>
<title></title>
<link rel="stylesheet" href="admin.css">  
<script type="text/javascript" src="../../../wp-includes/js/jquery/jquery.js?ver=1.11.1"></script>
<script type="text/javascript">
(function($) {
    $(document).ready(function(e) {
        // quando carregar, puxa dados do iframe parent
        var data_csv = $("#iframeExportar", parent.document.body).attr('data_csv'),
            filename = $("#iframeExportar", parent.document.body).attr('data_filename');
        
        $('#data_csv').val(data_csv);
        $('#data_filename').val(filename);

        $('#exportarCSVPost').click(function() {
            $('#exportCSVForm').submit();
        });
    });
})(jQuery); 
    </script>
</head>
<body>
<form id="exportCSVForm" action="baixar-csv.php" method="post">
    <input id="data_csv" type="hidden" name="data_csv">
    <input id="data_filename" type="hidden" name="data_filename">
    <h3 id="exportarCSVPost" class="csv" data_filename='relatorio_inscritos_setorial_estado'></h3>
</form>
</body>
</html>
<?php } ?>