<?php
//User Post Gallery UPG Plugin
	add_action( 'listpress_plugin_setting_tab' , 'listpress_upg_settings', 10 , 2 );
		
		function listpress_upg_settings() 
		{
			$options = get_option('listpress_settings');
			
			if(isset($options['listpress_upg_preview_enable']))
				$listpress_upg_preview_enable=$options['listpress_upg_preview_enable'];
			else
				$listpress_upg_preview_enable='0';
			
			if(isset($options['listpress_upg_cc_enable']))
				$listpress_upg_cc_enable=$options['listpress_upg_cc_enable'];
			else
				$listpress_upg_cc_enable='0';
			
			if(isset($options['listpress_upg_shortcode']))
				$listpress_upg_shortcode=$options['listpress_upg_shortcode'];
			else
				$listpress_upg_shortcode='[listpress layout="product" label="Report Post" title="Report Content" info="We will take appropriate action." plugin="upg"]';
			
			?>
			<table border="0" width="100%">
			<tr><td colspan="2"><h2><a href="https://wordpress.org/plugins/wp-upg/">User Post Gallery</a> (UPG) Settings</h2></td></tr>
			<tr>
			<td >Enable ListPress at preview page </td>
			<td><input type="checkbox" name='listpress_settings[listpress_upg_preview_enable]' value='1' <?php if($listpress_upg_preview_enable=='1') echo 'checked="checked"'; ?> ></td>
			</tr>
			<tr>
			<td >Send Bcc mail to Author of UPG-Post </td>
			<td><input type="checkbox" name='listpress_settings[listpress_upg_cc_enable]' value='1' <?php if($listpress_upg_cc_enable=='1') echo 'checked="checked"'; ?> ></td>
			</tr>
			<tr>
			<td>Use Shortcode as: </td>
			<td><textarea rows="2" cols="75" name='listpress_settings[listpress_upg_shortcode]'><?php echo $listpress_upg_shortcode; ?></textarea><br>
			<small>Default: [listpress layout="product" label="Report Post" title="Report Content" info="We will take appropriate action." plugin="upg"]</small></td>
			</tr>
			</table>
			<hr>
			<?php
		}

if(isset($options['listpress_upg_preview_enable']) && $options['listpress_upg_preview_enable']=="1" )
{
	add_action( 'upg_layout_down' , 'lispress_generate_upg', 10 , 2 );
}	

function lispress_generate_upg()
{
	$options = get_option('listpress_settings');
	
	if(isset($options['listpress_upg_shortcode']))
		$shortcode=$options['listpress_upg_shortcode'];
	else
		$shortcode="";
	
	echo do_shortcode( stripslashes($shortcode));
}	

?>