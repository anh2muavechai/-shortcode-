<?php
if( isset($_POST['download']) ){

    $the_folder = 'D:\Desktop\save';
    $zip_file_name = 'archived_name.zip';

    $download_file= true;
    //$delete_file_after_download= true; doesnt work!!

    class FlxZipArchive extends ZipArchive {
        /** Add a Dir with Files and Subdirs to the archive;;;;; @param string $location Real Location;;;;  @param string $name Name in Archive;;; @author Nicolas Heimann;;;; @access private  **/

        public function addDir($location, $name) {
            $this->addEmptyDir($name);

            $this->addDirDo($location, $name);
         } // EO addDir;

        /**  Add Files & Dirs to archive;;;; @param string $location Real Location;  @param string $name Name in Archive;;;;;; @author Nicolas Heimann
         * @access private   **/
        private function addDirDo($location, $name) {
            $name .= '/';
            $location .= '/';

            // Read all Files in Dir
            $dir = opendir ($location);
            while ($file = readdir($dir))
            {
                if ($file == '.' || $file == '..') continue;
                // Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
                $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
                $this->$do($location . $file, $name . $file);
            }
        } // EO addDirDo();
    }

    $za = new FlxZipArchive;
    $res = $za->open($zip_file_name, ZipArchive::CREATE);
    if($res === TRUE)
    {
        $za->addDir($the_folder, basename($the_folder));
        $za->close();
    }
    else  { echo 'Could not create a zip archive';}

    if ($download_file)
    {
        ob_get_clean();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=" . basename($zip_file_name) . ";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($zip_file_name));
        readfile($zip_file_name);

        //deletes file when its done...
        //if ($delete_file_after_download)
        //{ unlink($zip_file_name); }
    }

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <form action="" method="POST" role="form">
                    <legend>Click to download</legend>
                    <button type="submit" name="download" class="btn btn-success">Download</button>
                </form>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></script>
  </body>
</html>