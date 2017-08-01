<?php 
$content = 'abc';
$setting = array(
	'wpautop' => false,
	'textarea_rows' => 5,
	'tinymce' => true,
	'teeny' => true,
	);
wp_editor($content , 'nganluong_caption',$setting );
?>
add_filter( 'teeny_mce_buttons', 'my_editor_buttons', 10, 2 );
function my_editor_buttons( $buttons, $editor_id ) {
	return array( 'formatselect', 'bold', 'italic' );
}
bold
italic
underline
blockquote
separator
strikethrough
bullist
numlist
justifyleft
justifycenter
justifyright
undo
redo
link
unlink
fullscreen