<?php
$options = get_option('listpress_settings');

if(isset($params['layout']))
		$layout=trim($params['layout']);
	else
		$layout=$options['global_layout'];

if(isset($params['label']))
		$button_label=trim($params['label']);
	else
		$button_label=$options['label'];
	
	if(isset($params['title']))
		$form_title=trim($params['title']);
	else
		$form_title=$options['title'];
	
	if(isset($params['info']))
		$form_info=trim($params['info']);
	else
		$form_info=$options['info'];
	
	if(isset($params['plugin']))
		$plugin=trim($params['plugin']);
	else
		$plugin="";
	
	if(isset($params['class']))
		$class=trim($params['class']);
	else
		$class=listpress_settings('class','pure-button');

$put="";
ob_start ();

if(isset($options['RE']))
{
	listpress_auto_create_personal($layout);

	if(file_exists(listpress_BASE_DIR."/layout/form/".$layout."/".$layout."_config.php"))
		include(listpress_BASE_DIR."/layout/form/".$layout."/".$layout."_config.php");

	
		if(file_exists(listpress_BASE_DIR."/layout/form/".$layout."/".$layout.".php"))
			include(listpress_BASE_DIR."/layout/form/".$layout."/".$layout.".php");
		else
			echo __('Layout Not Found. Check Settings and save update again.','listpress').": ".$layout;
	
}
else
{
	echo "<h2>";
	echo __('Save ListPress settings with required information.','listpress');
	echo "</h2>";
}
$put=ob_get_clean (); 
wp_reset_query();
return $put;
?>