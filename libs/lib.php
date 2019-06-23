<?php
//Get value from ListPress Settings or set default
function listpress_settings($param,$default)
{
	$options = get_option('listpress_settings');
	if(!isset($options[trim($param)]))
	{
		$options[$param]=$default;
		update_option( 'listpress_settings', $options );
		return $default;
	}
	else
	{
		return $options[trim($param)];
	}
}

function listpress_get_post_title($post)
{
	if($post=='')
		global $post;
	
	return $post->post_title;
}
function listpress_get_post_detail($plugin="",$params)
{
	global $post;
	$post_title=$post->post_title;
	$post_id=$post->ID;
	$current_post_type=get_post_type();
	$thumbnail=listpress_get_post_thumbnail($post,$plugin);
	
	if(isset($params['to']))
	{
		$to=trim($params['to']);
		?>
		<input type="hidden" name="to" value="<?php echo $to; ?>">
		
		<?php
	}
	
		?>

		<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
		<input type="hidden" name="post_title" value="<?php echo $post_title; ?>">
		<input type="hidden" name="plugin" value="<?php echo $plugin; ?>">
			
		<input type="hidden" name="thumbnail" value="<?php echo $thumbnail; ?>">
		<input type="hidden" name="referrer_title" value="<?php echo esc_html( get_the_title() ); ?>">
		<input type="hidden" name="referrer_URL" value="<?php echo esc_url( get_permalink() ); ?>">
		<input type="hidden" name="action" value="contactform_action" />
		<?php echo wp_nonce_field('contactform_action', '_acf_nonce', true, false); ?>
		<input type="text" name="captcha" value="1" style="display:none !important" tabindex="-1" autocomplete="off">			 
		
		<?php
			
}

function listpress_get_post_thumbnail($post,$plugin)
{
	if($post=='')
		global $post;

	if($plugin=="upg")
	{
		//if(upg_image_src($size,$post))
		return upg_image_src('thumbnail',$post);
	}
	else
	{
		$thumb_id = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail', true);
		return $thumb_url[0];
	}
}

//Insert into database
function listpress_insert($title,$message,$sender_name,$sender_email)
{
	$newPost = array('id' => false, 'error' => false);
	$newPost['error'][] ="";
	if (empty($title))    $newPost['error'][] = 'required-title';
	$newPost['error'][]=apply_filters('listpress_verify_submit', "");
	
	foreach ($newPost['error'] as $e) 
	{
		if (!empty($e)) 
		{
			unset($newPost['id']);
			return $newPost;
		}
	}
	$postData = array();
	$postData['post_title']   = $title;
	$postData['post_content'] = $message;
	$postData['post_type']  = 'listpress';
	$postData['post_status'] = 'unread';
	
	$newPost['id'] = wp_insert_post($postData);
	
			if ($newPost['id']) 
			{
				
				if(isset($_POST['referrer_title']))
					$referrer_title=$_POST['referrer_title'];
				else
					$referrer_title="";
				
				if(isset($_POST['referrer_URL']))
					$referrer_URL=$_POST['referrer_URL'];
				else
					$referrer_URL="";
				
				$IP = $_SERVER['REMOTE_ADDR'];
				
				//Attach extra custom fields
				add_post_meta($newPost['id'], 'form_data', $_POST);
				add_post_meta($newPost['id'], 'sender_name', $sender_name);
				add_post_meta($newPost['id'], 'sender_email', $sender_email);
				add_post_meta($newPost['id'], 'referrer_title', $referrer_title);
				add_post_meta($newPost['id'], 'referrer_URL', $referrer_URL);
				add_post_meta($newPost['id'], 'IP', $IP);
			}
			else 
			{
				$newPost['error'][] = 'post-fail';
				
			}
	
}


//Detail Layout List
	 function listpress_layout_list($param,$name)
	{
        $options = get_option('listpress_settings');
		$listpress_layout=$param;
		
		$dir    = listpress_BASE_DIR.'layout/form/';
		$filelist ="";
		$files = array_map("htmlspecialchars", scandir($dir));       

		foreach ($files as $file) 
		{
			if($listpress_layout==$file)
				$checked='checked=checked';
			else
				$checked="";
			
			if(!strpos($file, '.') && $file != "." && $file != "..")
			{				
				
					$filelist .= sprintf('<input type="radio" '.$checked.' name="'.$name.'" id="'.$name.'"  value="%s"/>%s layout<br>' . PHP_EOL, $file, $file );
				
			}
		}
echo $filelist;
   
	}
	
	
	function listpress_add_admin_menu(  ) 
	{ 

	add_submenu_page( 'edit.php?post_type=listpress', 'ListPress Settings', 'Settings', 'manage_options', 'listpress', 'listpress_options_page' );
	
	$count='<span class="update-plugins count-2"><span class="plugin-count">2</span></span>';
	
	add_submenu_page( null, 'ListPress Inbox', 'Inbox', 'read', 'view-entry', 'listpress_inbox' );
	
	add_submenu_page( 'edit.php?post_type=listpress', 'Form Editor', 'Form Layouts', 'manage_options', 'layout', 'listpress_layout_edit' );
	
	}
	
	function listpress_sendmail()
	{
		$options = get_option('listpress_settings');
		
		$name = filter_var($_POST['sender_name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	 $email = filter_var($_POST['sender_email'], FILTER_SANITIZE_EMAIL);
	 
	 $settings_SE=$options['SE'];
	 
	 if(isset($_POST['subject']))
		 $subject=$options['subject'].": ".$_POST['subject'];
	 else
		$subject = $options['subject'];
 
	 $message = stripslashes($_POST['message']);
	 $message .= PHP_EOL.PHP_EOL.'IP address: '.$_SERVER['REMOTE_ADDR'];
	 $message .= PHP_EOL.'Sender\'s name: '.$name;
	 $message .= PHP_EOL.'E-mail address: '.$email;
	 $message .= PHP_EOL.'Submitted at : '.$_POST['referrer_URL'].' @ '.$_POST['referrer_title'];
	 
				
	 
	 $to = $options['RE']; 
	 $header = 'From: '.get_option('blogname').' <'.$settings_SE.'>'.PHP_EOL;
	 $header.= 'Reply-To: '.$email.PHP_EOL;
	 
	 $post_id=$_POST['post_id'];
	 
	 $author_id = get_post_field ('post_author', $post_id);
	$author_email = get_the_author_meta( 'user_email' , $author_id ); 
	
	if(isset($_POST['plugin']))
	{

		if($_POST['plugin']=="upg" && isset($options['listpress_upg_cc_enable']) && $options['listpress_upg_cc_enable']=="1" )
		{
			$header.= "Bcc: ".$author_email.PHP_EOL;
			//error_log('BCC upg email:'.$header);
		}
		if($_POST['plugin']=="woocommerce" && isset($options['listpress_woocommerce_cc_enable']) && $options['listpress_woocommerce_cc_enable']=="1" )
		{
			$header.= "Bcc: ".$author_email.PHP_EOL;
			//error_log('BCC woocommerce email:'.$header);
		}
	}
	
	
	 
	 if(isset($_POST['to']))
	 $header .= "Bcc: ".$_POST['to'].PHP_EOL;
	 
	 
	 
		foreach ($_POST as $key => $value)
		$message .= "Field ".htmlspecialchars($key)." = ".htmlspecialchars($value)."<br>";

	 
	 wp_mail($to, $subject, $message, $header);
	
	}
	
	function listpress_sendmail_admin($to,$subject,$message)
	{
		$options = get_option('listpress_settings');
		$header = 'From: '.get_option('blogname').' <'.$options['RE'].'>'.PHP_EOL;
		wp_mail($to, $subject, $message, $header);	
	}
	
	// Only for extra custom fields
 function listpress_get_value($post,$field)
 {
	  $value= get_post_custom($post->ID);
	  if(isset($value[$field][0]))
		  return $value[$field][0];
	  else
		  return "";
	  
 }
 
  function listpress_get_thumbnail($post)
 {
	  $value= get_post_custom($post->ID);
	  if(isset($value['thumbnail'][0]))
		  return $value['thumbnail'][0];
	  else
		  return "";
	  
 }
 
  function listpress_form_data($post)
 {
	  $value= get_post_custom($post->ID);
	  if(isset($value['form_data'][0]))
	  {
		  $data=$value['form_data'][0];
		  $data = unserialize($data); 
		  
		  return $data;
	  }
	  else
	  {
		  return "";
	  }
	  
 }
 function listpress_form_value($post,$field)
 {
	 $form_data=listpress_form_data($post);
	
		foreach ($form_data as $k => $v) 
		{
			if($k==$field)
			return $v;
			
		}
 }
 
 
 function listpress_auto_create_personal($layout_name)
 {
	 $upload_dir = wp_upload_dir();
	 $user_dirname = $upload_dir['basedir'].'/'.get_current_blog_id().'_listpress_'.$layout_name.'.php';
	  $filename=listpress_BASE_DIR."layout/form/".$layout_name."/".get_current_blog_id()."_".$layout_name."_form.php";
	  
	  //If personal file not created before
    if( ! file_exists( $user_dirname ) )
	{
		
		$sample_filename=listpress_BASE_DIR."layout/form/".$layout_name."/sample.txt";
		$sample_content =  file_get_contents($sample_filename);
		
		$file = fopen($user_dirname,"w+");
		fwrite($file, $sample_content);
		
		$file = fopen($filename,"w+");
		fwrite($file, $sample_content);
		
		
	}
	 //If personal file exist but plugin updated
    if( file_exists( $user_dirname ) && !file_exists( $filename ))
	{
		
		$sample_content =  file_get_contents($user_dirname);
		
		//Get content from saved personal 
		$file = fopen($filename,"w+");
		fwrite($file, $sample_content);
	}
 }
 
 ?>