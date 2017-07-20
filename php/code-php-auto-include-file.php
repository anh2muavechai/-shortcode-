<?php
/**
 * Auto include php file
 * @param  [string]  $path  [Đường dẫn file]
 * @param  integer $level [Cấp thư mục]
 */
function _lmh_dirToOptions($path = SYSTEM_DIR, $level = 0) {
    $items = scandir($path);
    foreach($items as $item) {
        // ignore items strating with a dot (= hidden or nav)
        if (strpos($item, '.') === 0) {
            continue;
        }

        $fullPath = $path . DIRECTORY_SEPARATOR . $item;
        // add some whitespace to better mimic the file structure
        // file
        if (is_file($fullPath)) {
            if( pathinfo($fullPath, PATHINFO_EXTENSION) == 'php' || pathinfo($fullPath, PATHINFO_EXTENSION) == 'PHP' ){
                require( "$fullPath" );
            }
        }
        // dir
        else if (is_dir($fullPath)) {
            // immediatly close the optgroup to prevent (invalid) nested optgroups
            // recursive call to self to add the subitems
            _lmh_dirToOptions($fullPath, $level + 1);
        }
    }

}
_lmh_dirToOptions();