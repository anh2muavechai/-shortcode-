<?php
$pages = get_posts(array(
  'post_type' => 'page',
  'numberposts' => -1,
  'tax_query' => array(
    array(
      'taxonomy' => 'taxonomy-name',
      'field' => 'id',
      'terms' => 1, // Where term_id of Term 1 is "1".
      'include_children' => false
    )
  )
));