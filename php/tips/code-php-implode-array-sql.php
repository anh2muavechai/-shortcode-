<?php
$category_list = trim("('".implode("','", $category_list)."')");
//or
$category_list = trim("('".implode("','", array_map(array($this, 'implode_category'), $category_list))."')");

public function implode_category($entry){

    return $entry['ctg_id'];
}