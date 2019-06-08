<?php 
$rand=rand();
 ?>
 
<label for="modal-trigger-<?php echo $rand; ?>" class="listpress_modal <?php echo $class; ?>"><?php echo $button_label; ?></label>

      <!-- Top modal -->
      <div class="modal">
        <input id="modal-trigger-<?php echo $rand; ?>" class="checkbox" type="checkbox">
        <div class="modal-overlay">
          <label for="modal-trigger-<?php echo $rand; ?>" class="o-close"></label>
          <div class="modal-wrap small from-top">
            <label for="modal-trigger-<?php echo $rand; ?>" class="close">✖</label>
            <h2><?php echo $form_title; ?></h2>
            <p>
                <div class="contact-msg" id="contact-msg-<?php echo $rand; ?>"></div>
	   
   <form id="contactform-<?php echo $rand; ?>" name="contactform-<?php echo $rand; ?>" method="post" class="pure-form pure-form-stacked">
				  <div id="hide_me-<?php echo $rand; ?>">
				  <fieldset>
        <legend><?php echo $form_info; ?></legend>
			<?php 
			//include(listpress_BASE_DIR."/layout/form/basic/basic_form.php");
			include(listpress_BASE_DIR."/layout/form/basic/".get_current_blog_id()."_basic_form.php");
			?>
			
									 
					 <?php echo listpress_get_post_detail($plugin,$params); ?>
					   
					 <input type="button" value="Submit" id="listpress_<?php echo $rand; ?>" />
					 
					
				</fieldset>	 
			 </div>
			 

			 </form>
            </p>
          </div>
        </div>
      </div>
      <!-- End Modal -->
	  <?php 
			include(listpress_BASE_DIR."/layout/form/javascript.php");
			?>