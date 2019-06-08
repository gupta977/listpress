<?php
/*-------------------------------------------------------------------------------
	Custom Columns
-------------------------------------------------------------------------------*/

function my_listpress_columns($columns)
{
	$columns = array(
		'cb'	 	=> '<input type="checkbox" />',
		'thumbnail' => '<span class="dashicons dashicons-format-image"></span>',
		'title' 	=> 'Subject',
		'sender_name' 	=> 'Sender Name',
		'sender_email' 	=> 'Sender Email',
		'IP' 	=> 'IP Address',
		'date'		=>	'Date',
	);
	return $columns;
}
add_filter("manage_edit-listpress_columns", "my_listpress_columns");

function listpress_custom_columns($column)
{
	global $post;
	
	if($column == 'thumbnail')
	{
		//echo listpress_get_thumbnail($post);
		echo "<img src='".listpress_form_value($post,'thumbnail')." 'width='40'>";
	}
	elseif($column == 'sender_name')
	{
		echo listpress_get_value($post,'sender_name');
	}
	elseif($column == 'sender_email')
	{
		echo listpress_get_value($post,'sender_email');
	}
	elseif($column == 'IP')
	{
		echo listpress_get_value($post,'IP');
	}
}

add_action("manage_listpress_posts_custom_column", "listpress_custom_columns");


function listpress_column_register_sortable( $columns )
{
	$columns['sender_name'] = 'sender_name';
	$columns['sender_email'] = 'sender_email';
	$columns['IP'] = 'IP';
	return $columns;
}

add_filter("manage_edit-listpress_sortable_columns", "listpress_column_register_sortable" );

?>