<?php
$menuItems = getMenuItems();
$parents = array();
if( count($menuItems) > 0 ){ ?>
    <div class="inner-left">
        <ul class="nav-mainmenu-content">
            <?php foreach ($menuItems as $item) {
                if ($item->menu_item_parent == 0) {
                    array_push($parents, $item);
                }
            }
            if( count($parents) > 0 ){
                foreach( $parents as $item ) : ?>
                <li class=" level_1  dropdown">
                    <a href="<?php echo($item->url) ?>" title="<?php echo($item->title) ?>" rel="dofollow">
                        <?php
                            $menu_icon = get_post_meta( $item->ID, 'ken_MenuIcon', true );;
                        ?>
                        <?php if( $menu_icon != "" ) : ?>
                            <span class="btn-info iconbox">
                                <img class="grayscale"  src="<?php echo get_template_directory_uri();?>/assets/images/templates/menus/icon_accessory_1437384313.png">
                            </span>
                        <?php endif; ?>
                        <?php echo($item->title) ?>
                    </a>
                    <?php $childMenu = getChild($item->ID); ?>
                    <?php if(count($childMenu) > 0): ?>
                        <ul role="menu" class="dropdown-menu">
                            <?php foreach($childMenu as $k => $v): ?>
                                <li>
                                    <a href="<?php echo($v['url']) ?>" title="<?php echo($v['title']) ?>" rel="dofollow"><?php echo($v['title']) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
                <?php endforeach;
            } ?>
        </ul>
    </div>
<?php }

function menudequy($menus, $id_parent = 0){
   	// b1
    $menu_tmp = array();
	foreach ($menus as $key =>$item) {
		if ($id_parent == $item->menu_item_parent) {
			$menu_tmp[] = $item;
			// Sau khi thêm vào biên lưu trữ menu ở bước lặp
			// thì unset nó ra khỏi danh sách menu ở các bước tiếp theo
			unset($menus[$key]);
		}
	}
    // b2
	if ($menu_tmp) {
        foreach ($menu_tmp as $key => $value){
            $new_menu = menudequy( $menus, $value->menu_item_parent);
            if( count( $new_menu['menu_tmp'] ) > 0 ){
                $menu_tmp[$key]['sub'] = $new_menu['menu_tmp'];
            }
        }
	}
    // $return_menu['menus'] = $menus;
    $return_menu['menu_tmp'] = $menu_tmp;
	return $return_menu['menu_tmp'];
}

function getChild($parent_id) {
	$childs = array();
	$menus = getMenuItems();
	$childs = menudequy($menus,$parent_id);
	return $childs;
}

function getMenuItems($menu_location = 'primary'){
    $locations = get_nav_menu_locations();
    $menu = null;
    if ($locations && isset($locations[$menu_location])) {
        $menu = wp_get_nav_menu_object($locations[$menu_location]);
    }
    $menuItems = wp_get_nav_menu_items($menu);
    return $menuItems;
}