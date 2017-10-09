<?php
function export_csv($filepath)
    {
        /*header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename('file.csv'));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('file.csv'));
        readfile( $filepath );
        exit;*/

        $yourFile = $filepath;
        $file = @fopen($yourFile, "rb");

        header('Content-Description: File Transfer');
        // header('Content-Type: application/octet-stream');
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=TheNameYouWant.csv');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($yourFile));
        while (!feof($file)) {
            print(@fread($file, 1024 * 8));
            ob_flush();
            flush();
        }
    }