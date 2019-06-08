<?php
function listpress_inbox()
{
		$options = get_option('listpress_settings');
		
	if (!empty($_GET['post']))
    $post = get_post($_GET['post']);
	//print_r($post);
	?>
	
<div class="wrap">
    <h2><?php echo $post->post_name; ?></h2>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content" style="position: relative;">
                <div id="wp-content-editor-container" class="wp-editor-container">
                    <table class="view-entry-table widefat listpress-view-table">
                       
                                <tr class="view-entry-header alternate">
                                    <td><span class="dashicons dashicons-email-alt"></span>  <strong>Message</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars($post->post_content); ?>
                                    </td>
                                </tr>
                           
                    </table>
                </div>
            </div>
			
            <div id="postbox-container-1" class="postbox-container">
                <div id="submitdiv" class="postbox ">
                    <h3 class="hndle"><span class="dashicons 
dashicons-businessman"></span>  Sender Details</h3>
                    <div class="inside">
                        <div id="submitpost" class="submitbox">
                            <div id="minor-publishing">
                                <div id="misc-publishing-actions">
                                    <div class="misc-pub-section"><b>Name</b>: <?php echo listpress_get_value($post,'sender_name'); ?> </div>
									 <div class="misc-pub-section"><b>Email</b>: <?php echo listpress_get_value($post,'sender_email'); ?> </div>
									 
									 <div class="misc-pub-section"><b>IP Address</b>: 
										<?php echo listpress_get_value($post,'IP'); ?>
										</div>
										
                                    <div class="misc-pub-section">
                                        <?php
                                            $d = get_option( 'date_format' ); 
                                            $t = get_option( 'time_format' );
                                            $post_date = get_gmt_from_date($post->post_date, $d );
                                            $post_time = get_gmt_from_date($post->post_date, $t);
                                            echo "<b>Submitted on</b>: " . $post_date . " at " . $post_time;
                                        ?>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div id="major-publishing-actions">
                                <?php if ( current_user_can( 'delete_post', $post->ID ) ) :  ?>
                                <div id="delete-action">
                                    <a class="submitdelete deletion" href="<?php print get_delete_post_link($post->ID);?>"> Move to Trash</a>
                                    <?php 
                                        if( !$post->ID ){
                                            redirect( admin_url( "edit.php?post_type=listpress" ) );
                                        }
                                    ?>
                                </div>
                                <?php endif; ?>
                                <div id="publishing-action">
								
								&nbsp;						
								   
                                </div>    
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			 <div id="postbox-container-2" class="postbox-container">
                <div id="submitdiv" class="postbox ">
                    <h3 class="hndle">Extra submitted form details</h3>
                    <div class="inside">
                        <div id="submitpost" class="submitbox">
                            <div id="minor-publishing">
                                <div id="misc-publishing-actions">
                                    
									<?php 
									$form_data=listpress_form_data($post);
									foreach ($form_data as $k => $v) 
									{
										if($k=="sender_name" || $k=="sender_email" || $k=="subject" || $k=="message" || $k=="action" || $k=="_acf_nonce" || $k=="_wp_http_referer" || $k=="referrer_title" || $k=="referrer_URL" || $k=="captcha" || $k=="post_id" || $k=="post_title" || $k=="plugin" || $k=="thumbnail")
										continue;
										?>
										<div class="misc-pub-section">
										<?php echo "<b>$k </b>: $v.\n"; ?>
										</div>
										<?php
											
										}
									?>
									<div class="misc-pub-section">
										<b>Submitted at</b>: <a href="<?php echo listpress_get_value($post,'referrer_URL'); ?>" target="_blank"><?php echo listpress_get_value($post,'referrer_title'); ?></a>
										</div>
									
										
                                   
                                </div>
                                <div class="clear"></div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
			
			  <div id="post-body-content" style="position: relative;">
                <div id="wp-content-editor-container" class="wp-editor-container">
                    <table class="view-entry-table widefat scfp-view-table">
                       
                                <tr class="view-entry-header alternate">
                                    <td><span class="dashicons 
dashicons-welcome-write-blog"></span> <strong>Reply</strong></td>
                                </tr>
                                <tr>
                                    <td> 
									<?php
									if(isset($_POST['RE']))
									{
										echo "<h1 style='text-align:center'>Message Sent</h1>";
										listpress_sendmail_admin($_POST['RE'],$_POST['subject'],$_POST['message']);
									}
									
									?>
	<form id="listpress_reply" method="post" action="">
	From: <?php echo get_option('blogname'); ?> (<?php echo $options['RE']; ?>)<br>
	To: <input type="email" name="RE" value="<?php echo listpress_get_value($post,'sender_email'); ?>"><br>
	Subject: <input type="text" name="subject" value="Re: <?php echo $post->post_name; ?>"><br>
	<textarea name="message" style="border:1px solid #999999; width:98%; margin:5px 0;padding:1%;text-align: left;" rows="10">

										
										
================================== 
<?php echo $post->post_content; ?></textarea><br>
	<input type="submit" value="Send" name="btn_send">
										
	</form>
                                    </td>
                                </tr>
                           
                    </table>
                </div>
            </div>
			
			
        </div>
    </div>
</div>	
	
	<?php
}
?>