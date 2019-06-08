 <script type="text/javascript">
jQuery(document).ready(function($) 
{
	$('#listpress_<?php echo $rand; ?>').click(function() 
	{
		//alert("basic form");
		if(listpress_validate_<?php echo $rand; ?>())
		{
		$('#contact-msg-<?php echo $rand; ?>').html('<img src="<?php echo plugins_url() .'/'.listpress_FOLDER.'/images/loading.gif'; ?>" alt="Loading...">');
		$('#hide_me-<?php echo $rand; ?>').hide();
			$.ajax({
							type: 'POST',
							url: '<?php echo admin_url( 'admin-ajax.php'); ?>',
							data: $('#contactform-<?php echo $rand; ?>').serialize(),
							dataType: 'json',
							success: function(response) 
							{
								if (response.status == 'success') 
								{
									$('#contactform-<?php echo $rand; ?>')[0].reset();
									$('#contact-msg-<?php echo $rand; ?>').html("Message Sent");
								}
								else
								{
									$('#hide_me-<?php echo $rand; ?>').show();
									$('#contact-msg-<?php echo $rand; ?>').html(response.errmessage);
								}
								
								
							}
						});
		}
	})
});
function listpress_validate_<?php echo $rand; ?>() 
{
	//alert("ready to validate basic form");
	var forms = document.getElementById('contactform-<?php echo $rand; ?>');
	 
	if(forms.checkValidity())
	{
		return true;
	}
	else
	{
		 forms.reportValidity();
		//document.getElementById("contact-msg").innerHTML = forms.validationMessage;
		document.getElementById("contact-msg-<?php echo $rand; ?>").innerHTML = "Submitted content is invalid or empty";
		return false;
	}
 		
	//var first_name = $('#name').val();
    //alert(first_name+" is my name");
}
</script>