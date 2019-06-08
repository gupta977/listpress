<?php
function listpress_layout_edit()
{
	
	$options = get_option('listpress_settings');
	$current_page=admin_url( 'edit.php?post_type=listpress&page=layout');
	$current_page=add_query_arg( 'file', '', $current_page );
	//echo $current_page;
	
	if(isset($options['RE']))
	{
		
		if(isset($_GET['file']))
		{
			$global_layout=$_GET['file'];
		}
		else
		{
			if(isset($options['global_layout']))
				$global_layout=$options['global_layout'];
			else
				$global_layout="basic";
		}
		$settings = array(
				    'wpautop'          => false,  // enable rich text editor
				    'media_buttons'    => false,  // enable add media button
				    'textarea_rows'    => '15',  // number of textarea rows
				    'tabindex'         => '',    // tabindex
				    'editor_css'       => '',    // extra CSS
				    'editor_class'     => 'usp-rich-textarea', // class
				    'teeny'            => false, // output minimal editor config
				    'dfw'              => false, // replace fullscreen with DFW
				    'tinymce'          => false,  // enable TinyMCE
				    'quicktags'        => true,  // enable quicktags
				    'drag_drop_upload' => false, // enable drag-drop
					
				);	
				
	?>
	<div class="wrap">
	<h2>Form Layouts</h2>
	
	<br>
	
	<script>
jQuery(document).ready(function($){
       $("#tabs").tabs();
});

  </script>
  	<div id="tabs">
	<ul>
	<li><a href="#tab-1"><?php echo __("Layout Editor","listpress");?></a></li>
	 </ul>
	 <div id="tab-1">
	 <form  id="listpressForm">
	 <table border="0"><tr><td><b>Select form layout to edit</b>: </td><td>
<?php echo listpress_layout_list($global_layout,"listpress_settings[global_layout]"); ?></td></tr></table>
</form>
<script>
var sz = document.forms['listpressForm'].elements['listpress_settings[global_layout]'];
// loop through list
for (var i=0, len=sz.length; i<len; i++) {
    sz[i].onclick = function() { // assign onclick handler function to each
        // put clicked radio button's value in total field
        //this.form.elements.total.value = this.value;
		var link='<?php echo $current_page; ?>='+this.value;
		window.location.href = link;
		//alert(link);
    };
}
</script>

	 <?php
	if(listpress_get_layout_code($global_layout))
	{
		
	?>	 
	<form class="pure-form" method="post" action="">
	<table border='0' width='99%'>
	<tr><td valign="top" width="70%">
	<h2><?php echo $global_layout. " layout"; ?></h2>
	
	<br>
	
	<?php
	if(isset($_POST['personal']))
	{
		echo listpress_save_layout_code($_POST['personal'],$global_layout);
	}
	$content_pick=listpress_get_layout_code($global_layout);
	wp_editor( $content_pick, 'personal', $settings );
	
	?>
	
	</td>
	<td valign='top' style="background-color:#eeeeee ;">
	<b>Tips / Tricks</b><hr>
	You can create your own custom fields using simple HTML code. This form will update personal layout.<br>
	See documentation at <a href="https://www.w3schools.com/html/html_form_elements.asp" target="_blank">w3schools</a><hr>
	
	<b>Reserved name of input fields</b><br>
	Some of the fields are already assigned and use it accordingly where appropriate.
	<br>
	<ul>
	<li>sender_name
	<li>sender_email
	<li>subject
	<li>message
	<li>to
	<li> 
	</ul>
	<b>Below input names are strictly prohibited to use. </b>
	<ul>
	<li>referrer_title
	<li>referrer_URL
	<li>_acf_nonce
	<li>captcha
	<li>thumbnail
	<li>post_title
	<li>post_id
	<li>plugin
	<li>Don't use submit , file buttons. 
	<li>Don't use form tag.
	</ul>
	</td></tr></table>
	<br>
	<input type="submit" name="submit" id="submit" class="button button-primary" value="Update Layout">
	</form>
	 <?php
	}
	else
	{
		echo "Layout not found: ".$global_layout;
	}
?>	 
	 </div>
	
	
	 </div>
	
	</div>
	
	<?php
	
	
	}
	else
	{
		echo "<h2>";
		echo __('Save ListPress settings with required information.','listpress');
		echo "</h2>";
	}
}

 function listpress_get_layout_code($layout_name)
 {
	 listpress_auto_create_personal($layout_name);
	 
	 $filename=dirname(__FILE__)."/form/".$layout_name."/".get_current_blog_id()."_".$layout_name."_form.php";
	 
	 if( file_exists( $filename ) )
	{
		$content =  file_get_contents($filename);
		return $content;
	}
	else
	{
		return false;
	}
 }
 
 function listpress_save_layout_code($content,$layout_name)
 {
	 $upload_dir = wp_upload_dir();
	 $user_dirname = $upload_dir['basedir'].'/'.get_current_blog_id().'_listpress_'.$layout_name.'.php';
	 $filename=dirname(__FILE__)."/form/".$layout_name."/".get_current_blog_id()."_".$layout_name."_form.php";
	 
	if ( is_writeable($filename) ) 
		{
			//Save inside plugin path
			$file = fopen($filename,"w+");
			fwrite($file, wp_unslash($content));
			
			//save inside upload path
			$file = fopen($user_dirname,"w+");
			fwrite($file, wp_unslash($content));
			
			return $layout_name." layout updated.".$user_dirname;
			
		}
		else
		{
			return "File is not writable: ".$filename;
		}
		
			
 } 
?>