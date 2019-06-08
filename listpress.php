<?php
/*
Plugin Name: ListPress Contact
Plugin URI: http://odude.com/
Description: Dynamic popup contact button
Version: 1.7
Author: ODude Network
Author URI: http://odude.com/
License: GPLv2 or later
Text Domain: listpress
*/

	define('listpress_PLUGIN_VERSION', '1.7');

	define('listpress_ROOT_URL', plugin_dir_url( __FILE__ ) );
	define('listpress_FOLDER',dirname(plugin_basename( __FILE__ )));
	define('listpress_BASE_DIR',WP_CONTENT_DIR.'/plugins/'.listpress_FOLDER.'/');
	define('listpress_PLUGIN_URL',content_url('/plugins/'.listpress_FOLDER));
	
	include(dirname(__FILE__)."/libs/lib.php");
	include(dirname(__FILE__)."/libs/hooks.php");
	include(dirname(__FILE__)."/libs/install.php");
	include(dirname(__FILE__)."/libs/custom_column.php");
	include(dirname(__FILE__)."/setting.php");
	include(dirname(__FILE__)."/inbox.php");
	include(dirname(__FILE__)."/layout/edit.php");
	include(dirname(__FILE__)."/addon/plugins.php");
	include(dirname(__FILE__)."/classes/listpress_FormEntries.class.php");
	

	//Generate listpress button with shortcode
	function listpress_button($params)
	{
	  
    $abc=include(listpress_BASE_DIR.'layout/catalog.php');
	return $abc;
	 
	}
	
	 function listpress_enqueue_scripts()
	{
		//wp_enqueue_script('jquery');
			 
		wp_enqueue_style('listpress-style', plugins_url() .'/'. listpress_FOLDER.'/css/style.css'); 
		wp_enqueue_style('pure-forms', plugins_url() .'/'. listpress_FOLDER.'/css/forms-min.css'); 
		//wp_enqueue_script('jquery-min', plugins_url() .'/'.listpress_FOLDER.'/js/jquery.min.js');
	
		  
	}
	function listpress_admin_enqueue_scripts()
	{
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_style('aristo', plugins_url() .'/'. listpress_FOLDER.'/css/aristo.css');
		wp_enqueue_style('listpress-admin', plugins_url() .'/'. listpress_FOLDER.'/css/admin.css'); 
		if(get_current_screen()->base=="listpress_page_layout")
		{
			//Include for layout edit page only
		}
		
	}
	
	function ajax_contactform_action_callback() 
	{
 $error = '';
 $status = 'error';
 $options = get_option('listpress_settings');
 
 if (empty($_POST['sender_email'])) 
 {
	$error = 'Email address cannot be left empty.'.get_the_title();
 } 
 else 
 {
	 if (!wp_verify_nonce($_POST['_acf_nonce'], $_POST['action'])) 
	 {
		$error = 'Verification error, try again.';
	 }
	else if(empty($_POST['captcha']) || $_POST['captcha']!="1" )
	{
		$error = 'Verification error, try again !';
	}
	 else 
	 {
		$status = 'success';
		
		if(isset($_POST['plugin']))
			$plugin=$_POST['plugin'];
		else
			$plugin="";

		if(isset($_POST['subject']))
			$title=$_POST['subject'];
		else
			$title=$options['subject'];

		if(isset($_POST['message']))
			$message = stripslashes($_POST['message']);
		else
			$message="";
		
		if(isset($_POST['sender_name']))
			$sender_name=$_POST['sender_name'];
		else
			$sender_name="";
		
		if(isset($_POST['sender_email']))
			$sender_email=$_POST['sender_email'];
		else
			$sender_email="";

			
		
		
		listpress_insert($title,$message,$sender_name,$sender_email);
		
		//Send email only if enabled at settings
		if($options['email']=="1")
		listpress_sendmail();
		
	 }
 }
 
 $resp = array('status' => $status, 'errmessage' => $error);
 header( "Content-Type: application/json" );
 echo json_encode($resp);
 die();
}
add_action( 'wp_ajax_contactform_action', 'ajax_contactform_action_callback' );
add_action( 'wp_ajax_nopriv_contactform_action', 'ajax_contactform_action_callback' );
?>