<?php
function create_folder($path) {

	if($path == '') return NULL;
	$file_ctl = new FileWindows_lib();
	$path_revert = str_replace(ACW_ROOT_DIR."/", '', $path);

	$tmp_array = explode("/", $path_revert);
	//D:/htdocs/lixil_dev/dtp_if/Typesetting/Approved/LIXD01/91/JPN/79
	//D:/htdocs/lixil_dev
	if(count($tmp_array) > 0) {
		$path_exe = ACW_ROOT_DIR;
		foreach($tmp_array as $folder) {
			$path_exe .= "/".$folder;
			if($file_ctl->FolderExists($path_exe) == false) {
				$file_ctl->CreateFolder($path_exe);
			}
		}
	}
}