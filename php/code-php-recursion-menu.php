<?php
$array = array(
    array(
        'id' => 1,
        'parent' => 0
    ),
    array(
        'id' => 2,
        'parent' => 0
    ),
    array(
        'id' => 3,
        'parent' => 0
    ),
    array(
        'id' => 4,
        'parent' => 1
    ),
    array(
        'id' => 5,
        'parent' => 4
    ),
    array(
        'id' => 6,
        'parent' => 4
    ),array(
        'id' => 7,
        'parent' => 2
    )
    ,array(
        'id' => 8,
        'parent' => 2
    ),
    array(
        'id' => 9,
        'parent' => 3
    ),
    array(
        'id' => 10,
        'parent' => 9
    ),
    array(
        'id' => 11,
        'parent' => 9
    ),
    array(
        'id' => 12,
        'parent' => 11
    ),
);

function menudequy($menus, $parent = 0){
    // b1
    $menu_tmp = array();
    foreach ($menus as $key =>$item) {
        if ($parent == $item['parent']) {
            $menu_tmp[] = (array)$item;
            // Sau khi thêm vào biên lưu trữ menu ở bước lặp
            // thì unset nó ra khỏi danh sách menu ở các bước tiếp theo
            unset($menus[$key]);
        }
    }
    // b2
    if ($menu_tmp) {
        foreach ($menu_tmp as $key => $value){
            $new_menu = menudequy( $menus, $value['id']);
            if( count( $new_menu['menu_tmp'] ) > 0 ){
                $menu_tmp[$key]['sub'] = $new_menu['menu_tmp'];
            }
        }
    }
    $return_menu['menus'] = $menus;
    $return_menu['menu_tmp'] = $menu_tmp;
    return $return_menu;
}

echo '<pre>';
    // var_export( $array );
    $data = menudequy($array);
    print_r($data['menu_tmp']);
echo '</pre>';