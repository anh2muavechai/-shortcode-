<?php
//1
function addDataAttr( $items, $args ) {
  $dom = new DOMDocument();
  $dom->loadHTML($items);
  $find = $dom->getElementsByTagName('a');
  foreach ($find as $item ) :
      $item->setAttribute('data-scroll-to','s1');
  endforeach;
  return $dom->saveHTML();
}
add_filter('wp_nav_menu_items', 'addDataAttr', 10, 2);