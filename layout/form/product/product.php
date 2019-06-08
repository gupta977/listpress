<?php 
$rand=rand();
 ?>

<label for="modal-trigger-<?php echo $rand; ?>" class="listpress_modal <?php echo $class; ?>"><?php echo $button_label; ?></label>

      <!-- Top modal -->
      <div class="modal">
        <input id="modal-trigger-<?php echo $rand; ?>" class="checkbox" type="checkbox">
        <div class="modal-overlay">
          <label for="modal-trigger-<?php echo $rand; ?>" class="o-close"></label>
          <div class="modal-wrap from-top">
            <label for="modal-trigger-<?php echo $rand; ?>" class="close">✖</label>
            <div class="listpress_title"><?php echo $form_title; ?></div>
           
                <div class="contact-msg" id="contact-msg-<?php echo $rand; ?>"></div>
	   
   <form id="contactform-<?php echo $rand; ?>" name="contactform-<?php echo $rand; ?>" method="post" class="pure-form pure-form-stacked">
				  <div id="hide_me-<?php echo $rand; ?>">
				  <fieldset>
        <legend><?php echo $form_info; ?></legend>
		
<div class="listpress_row">
  <div class="listpress_column_35">
  
<figure>
 <img src="<?php echo listpress_get_post_thumbnail('',$plugin); ?>">
  <figcaption><?php echo listpress_get_post_title(''); ?></figcaption>
</figure>


  
  <br><br>
  
  </div>
  <div class="listpress_column_65">
			<?php
			//include(listpress_BASE_DIR."/layout/form/product/product_form.php");
			include(listpress_BASE_DIR."/layout/form/product/".get_current_blog_id()."_product_form.php");
			?>
	</div>
</div>		
									 
					 <?php echo listpress_get_post_detail($plugin,$params); ?>
					   
					 <input type="button" value="Submit" id="listpress_<?php echo $rand; ?>" />
					 
					
				</fieldset>	 
			 </div>
			 

			 </form>
           
          </div>
        </div>
      </div>
      <!-- End Modal --> <?php 
			include(listpress_BASE_DIR."/layout/form/javascript.php");
			?>