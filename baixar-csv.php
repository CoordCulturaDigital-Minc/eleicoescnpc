<?php

/*
 * funções para gerar arquivos csv
 * thanks to Alain Tiemblo! (http://stackoverflow.com/questions/4249432/export-to-csv-via-php)
 */

function array2csv($array, $output_path = 'php://output')
{
   if (count($array) == 0) {
     return null;
   }

   ob_start();
   $df = fopen($output_path, 'w');
   
   foreach ($array as $row) {
       fputcsv($df, $row);
   }
   fclose($df);
   
   return ob_get_clean();
}

function download_send_headers($filename, $output_path = '') {
    // disable caching
    
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");
      
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");
    
    // force download
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    
    // abre arquivo e cospe saida
    if ($output_path == '') {
        $handle = fopen('php://output','w') or die("Can't open php://output");
        fclose($handle);
        
        header("Content-Disposition: attachment;filename={$filename}");           
    } else {
        header("Content-Disposition: attachment;filename={$filename}");           
        header('Content-Length: ' . filesize($output_path));
        readfile($output_path);
    }   
}


// controlador

// recebeu POST, pega dados do formulario
if (!empty($_POST)) {
    $data_csv = $_POST['data_csv'];
    $output_path = $_POST['output_path'];
    $filename = $_POST['filename'];
    $filename = $filename . ".csv";
    
    // caso receba a requisicao de saida em arquivo
    if ($output_path == 'arquivo') {
        $output_path = __DIR__ . '/relatorios/arquivos/';
    }
}


if ($data_csv != '') {
    $data_csv = json_decode($data_csv);

    // se nao receber path, gera php
    if ($output_path == '') {
        download_send_headers($filename);
        print array2csv($data_csv);
    } else {
        // se receber, gera arquivo e baixa
        //
        $output_web = "http://" . $_SERVER['HTTP_HOST'] . explode('baixar-csv.php', $_SERVER['PHP_SELF'])[0] . 'relatorios/arquivos/' . $filename;
        print array2csv($data_csv, $output_path . $filename);
        //print "<script>window.location='" . $output_web . "';</script>";
        //print "<a href='" . $output_web . "'><h3 id='exportarCSVPost' class='csv' data_filename='relatorio_inscritos_setorial_estado'></h3></a>";
        download_send_headers($filename, $output_path . $filename);
    }
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
            output_path = $("#iframeExportar", parent.document.body).attr('data_output_path');        
        
        $('#data_csv').val(data_csv);
        $('#filename').val(filename);
        $('#output_path').val(output_path);

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
    <input id="filename" type="hidden" name="filename">
    <input id="output_path" type="hidden" name="output_path">
    <p style="font-family: sans-serif; font-weight: bold">Gerar CSV</p>
    <h3 id="exportarCSVPost" class="csv" data_filename='relatorio_inscritos_setorial_estado'></h3>
</form>
</body>
</html>
<?php } ?>