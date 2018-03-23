<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$attachments = get_posts(array(
    'posts_per_page' => - 1,
    'post_status' => 'any',
    'post_type' => 'attachment' ,
));
foreach($attachments as $attachment) {
	if (false === wp_delete_attachment($attachment->ID)) {
		// Log failure to delete attachment.
    }
}