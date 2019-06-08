<?php
function listpress_post_types()
{   
	 $labels = array(
    'name'               => __('ListPress Inbox', 'listpress'), 
    'singular_name'      => __('Entry', 'listpress'),
    'add_new'            => __('Add New', 'listpress'),
    'add_new_item'       => __('Add New Entry', 'listpress'),
    'edit_item'          => __('Edit Entry', 'listpress'),
    'new_item'           => __('New Entry', 'listpress'),
    'all_items'          => __('Inbox', 'listpress'),
    'view_item'          => __('View Entry', 'listpress'),
    'search_items'       => __('Search Entry', 'listpress'),
    'not_found'          => __('No Entries Found', 'listpress'),
    'not_found_in_trash' => __('No Entries Found in Trash', 'listpress'),
    'parent_item_colon'  => '',   
    'menu_name'          => __('ListPress', 'listpress')
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => false,
    'show_ui'            => true,
    'show_in_menu'       => true,  
    'show_in_nav_menus'  => true,
    'show_in_admin_bar'   => false,
    'query_var'          => false,
    'rewrite'            => array( 'slug' =>  _x( 'form-entries', 'URL slug'),  'with_front' => false ),
    'capability_type'    => 'post',
    'capabilities' => array(
        'create_posts' => 'do_not_allow',
    ),
    'map_meta_cap'       => true,      
    'has_archive'        => false,
    'hierarchical'       => false,
    'menu_position'      => 2,
    'exclude_from_search' => true,
    'supports'           => array( 
        'title', 
        'editor',
        'thumbnail', 
    ),       
  );

  register_post_type( 'listpress', $args );
    
}


function listpress_install()
{
	
	listpress_post_types();
    flush_rewrite_rules(); 
}

function listpress_drop()
{
	
	//Function during uninstall
		
}

?>