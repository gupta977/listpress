<?php
function listpress_settings_init(  ) 
{ 
	
	
	//Basic Setting
	register_setting( 'ListPressSettingPage', 'listpress_settings' );
	

	add_settings_section(
		'listpress_ImageSettingPage_section', 
		__( 'Settings', 'listpress' ), 
		'listpress_settings_section_callback', 
		'ListPressSettingPage'
	);
	add_settings_field( 
		'upg_select_pickup_field', 
		__( 'Important Settings', 'listpress' ), 
		'listpress_imp_settings', 
		'ListPressSettingPage', 
		'listpress_ImageSettingPage_section' 
	);

	
	//End Basic Setting
	
	
	//UPG Setting
	register_setting( 'PluginsSettingPage', 'listpress_settings' );
	

	add_settings_section(
		'Plugins_section', 
		__( 'Othre\'s Plugin Settings', 'listpress' ), 
		'listpress_settings_section_callback', 
		'PluginsSettingPage'
	);
	add_settings_field( 
		'upg_select_pickup_field', 
		__( 'Supported Plugins Settings', 'listpress' ), 
		'listpress_plugin_settings', 
		'PluginsSettingPage', 
		'Plugins_section' 
	);

	
	//End Basic Setting
	
	
}

function listpress_plugin_settings()
{
		
		do_action( "listpress_plugin_setting_tab");
	
}

 
 function listpress_imp_settings() 
 {
$options = get_option('listpress_settings');


	if(!isset($options['archive']))
		$options['archive']="0";
	
	if(isset($options['RE']))
		$RE=$options['RE'];
		else
		$RE="sales@domain.com";
	
	if(isset($options['SE']))
		$SE=$options['SE'];
		else
		$SE=get_option('admin_email');
	
	if(isset($options['subject']))
		$sub=$options['subject'];
		else
		$sub="Sub: ";
	
	if(isset($options['label']))
		$label=$options['label'];
		else
		$label="Contact Us";
	
	$class=listpress_settings('class','pure-button');
	
	if(isset($options['title']))
		$title=$options['title'];
		else
		$title="Contact Form";
	
		if(isset($options['info']))
		$info=$options['info'];
		else
		$info="Address1, City, Country.";
	
	if(isset($options['email']))
		$email=$options['email'];
		else
		$email=1;
	
	if(isset($options['global_layout']))
		$global_layout=$options['global_layout'];
		else
		$global_layout="basic";
	
	?>
	<table class="form-table">
	<tbody>
	<tr><td>Email Option</td><td>
		<a href="#" title="<?php echo __( 'No emails will be sent but stores all submitted entries in database.', 'listpress' ); ?>" class="upg_tooltip"><?php echo '<img src="'.listpress_PLUGIN_URL.'/images/info.png">'; ?></a> 
	Disable Email: <input type="checkbox" name='listpress_settings[email]' value='1' <?php if($email=='1') echo 'checked="checked"'; ?> >
	</td></tr>
	
	<tr><td>From Email Address: </td><td><?php echo get_option('blogname'); ?> - <input type="email" name='listpress_settings[SE]' value='<?php echo $SE; ?>'  size="20" class="regular-text">
	</td></tr>
	<tr><td>
	Recipient's Email Address : </td><td>
	<a href="#" title="<?php echo __( 'From and Recipient email address shouldn\'t be same to prevent from spam.', 'listpress' ); ?>" class="upg_tooltip"><?php echo '<img src="'.listpress_PLUGIN_URL.'/images/info.png">'; ?></a> 
	<input type="email" name='listpress_settings[RE]' value='<?php echo $RE; ?>'  size="20" class="regular-text"></td></tr>
	<tr><td>Prefix for email subject : </td><td>
	
	<input type="text" name='listpress_settings[subject]' value='<?php echo $sub; ?>'  size="20" class="regular-text"></td></tr>
	
	<tr><td>Default Button Label : <br><i><small>label="<?php echo $label; ?>"</small></i></td><td><input type="text" name='listpress_settings[label]' value='<?php echo $label; ?>'  size="20" class="regular-text"></td></tr>
	
	<tr><td>Button CSS Class : <br><i><small>class="<?php echo $class; ?>"</small></i></td><td><input type="text" name='listpress_settings[class]' value='<?php echo $class; ?>'  size="20" class="regular-text"></td></tr>
	
	<tr><td>Default form Title :
	<br><i><small>title="<?php echo $title; ?>"</small></i> </td><td><input type="text" name='listpress_settings[title]' value='<?php echo $title; ?>'  size="20" class="regular-text"></td></tr>
	
	<tr><td>Default form Information :
 <br><i><small>info="<?php echo $info; ?>"</small></i>
 </td><td><input type="text" name='listpress_settings[info]' value='<?php echo $info; ?>' size="20" class="regular-text"></td></tr>
	
	<tr><td>Default Form Layout Name :
	 <br><i><small>layout="<?php echo $global_layout; ?>"</small></i>
	 </td><td>
	<?php echo listpress_layout_list($global_layout,"listpress_settings[global_layout]"); ?></td></tr>
	
	<?php

	//**************

	do_action( "listpress_imp_settings_tab");
?>
</tbody>
	</table>
<?php	
	
	}

function listpress_settings_section_callback(  ) 
{ 

echo "Use shortcode as <b>[listpress]</b> at page or post. The below settings will be applied if no parameters is being supplied.";
	
}


function listpress_options_page(  ) 
{ 

?>
	
	<script>
jQuery(document).ready(function($){
       $("#tabs").tabs();
});
  </script>
  
<div class="wrap">
	

	<form action='options.php' method='post'>
		
		<h2>ListPress Settings</h2>
		<div id="tabs">
	<ul>
		
        <li><a href="#tab-1"><?php echo __("Basic Settings","listpress");?></a></li>
      <li><a href="#tab-2"><?php echo __("Plugins","listpress");?></a></li>
	      <li><a href="#tab-3"><?php echo __("Help","listpress");?></a></li>
		<?php
		do_action( "listpress_setting_tab_title" , $listpress_tab_title_id="", $listpress_tab_title_label="" );
		?>
				
	</ul>
	 <div id="tab-1">
     <?php
	 settings_fields( 'ListPressSettingPage' );
	do_settings_sections( 'ListPressSettingPage' );
	 ?>
    </div>
		 <div id="tab-2">
     <?php
	 settings_fields( 'PluginsSettingPage' );
	do_settings_sections( 'PluginsSettingPage' );
	 ?>
    </div>
    <div id="tab-3">
     <?php include(listpress_BASE_DIR."/help.php"); ?>
    </div>

		
	
	<?php
		do_action( "listpress_setting_tab_body" , $upg_tab_title_id="");
		?>
	
	</div>
		
		<?php
		flush_rewrite_rules();
		submit_button();
		?>
		
	</form>
</div>
	<?php

}
?>