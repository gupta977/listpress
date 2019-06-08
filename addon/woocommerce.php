<?php
//WooCommerce Plugin
	add_action( 'listpress_plugin_setting_tab' , 'listpress_woocommerce_settings', 10 , 2 );
		
		function listpress_woocommerce_settings() 
		{
			$options = get_option('listpress_settings');
			
			if(isset($options['listpress_woocommerce_enable']))
				$listpress_woocommerce_enable=$options['listpress_woocommerce_enable'];
			else
				$listpress_woocommerce_enable=0;
			
			if(isset($options['listpress_woocommerce_cc_enable']))
				$listpress_woocommerce_cc_enable=$options['listpress_woocommerce_cc_enable'];
			else
				$listpress_woocommerce_cc_enable=0;
			
			if(isset($options['listpress_woocommerce_product']))
				$listpress_woocommerce_product=$options['listpress_woocommerce_product'];
			else
				$listpress_woocommerce_product='after_add_cart';
			
			if(isset($options['listpress_woocommerce_shortcode']))
				$listpress_woocommerce_shortcode=$options['listpress_woocommerce_shortcode'];
			else
				$listpress_woocommerce_shortcode='[listpress layout="product" label="click for Inquiry" title="Inquiry Form" info="You can call us at +1-00-00-000" plugin="woocommerce"]';
			
			?>
			<table border="0" width="100%">
			<tr><td colspan="2"><h2><a href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a> Settings</h2></td></tr>
			<tr><td>Enable ListPress for WooCommerce:</td>
			<td><input type="checkbox" name='listpress_settings[listpress_woocommerce_enable]' value='1' <?php if($listpress_woocommerce_enable=='1') echo 'checked="checked"'; ?> >
			</td></tr>
			
				<tr><td>Send BCC mail to product owner:</td>
			<td><input type="checkbox" name='listpress_settings[listpress_woocommerce_cc_enable]' value='1' <?php if($listpress_woocommerce_cc_enable=='1') echo 'checked="checked"'; ?> >
			</td></tr>
			
			<tr>
			<td >Button Location at Product Page </td>
			<td>
			
			<input type="radio" name='listpress_settings[listpress_woocommerce_product]' value="after_add_cart" <?php if ( $listpress_woocommerce_product =='after_add_cart' ) echo 'checked="checked"'; ?>> After add to cart button  
			<input type="radio" name='listpress_settings[listpress_woocommerce_product]' value="after_product_summary" <?php if ( $listpress_woocommerce_product == 'after_product_summary' ) echo 'checked="checked"'; ?>> After single product summary
			</td>
			</tr>
			<tr>
			<td>Use Shortcode as: </td>
			<td><textarea rows="2" cols="75" name='listpress_settings[listpress_woocommerce_shortcode]'><?php echo $listpress_woocommerce_shortcode; ?></textarea><br>
			<small>Default: [listpress layout="product" label="click for Inquiry" title="Inquiry Form" info="You can call us at +1-00-00-000" plugin="woocommerce"]</small></td>
			</tr>
			</table>
			<hr>
			<?php
		}

if(isset($options['listpress_woocommerce_enable']) && $options['listpress_woocommerce_enable']=="1" )
{
	//show button after add to cart
	if ( $options['listpress_woocommerce_product'] =='after_add_cart' )
	add_action( 'woocommerce_single_product_summary' , 'lispress_generate_woocommerce', 10 , 2 );
	//show button after summary
	if ( $options['listpress_woocommerce_product'] =='after_product_summary' )
	add_action( 'woocommerce_after_single_product_summary' , 'lispress_generate_woocommerce', 10 , 2 );
}	

function lispress_generate_woocommerce()
{
	$options = get_option('listpress_settings');
	
	if(isset($options['listpress_woocommerce_shortcode']))
		$shortcode=$options['listpress_woocommerce_shortcode'];
	else
		$shortcode="";
	
	echo do_shortcode( stripslashes($shortcode));
}	

?>