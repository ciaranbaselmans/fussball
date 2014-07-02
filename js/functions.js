function sendAJAX(form) {
	$(form).delegate('.menu','change', function() {
		$('.error').remove();
		$('.found').remove();
		
		//responsible for hiding menus that are being altered
		var retur = 0;
		var main = $(this).attr('id').replace('menu', '');
			$('select').each( function() {
				if($(this).val() == 'Select') 
					retur = 1;
				if($(this).attr('id').replace('menu', '') > main) {
					$(this).parent().remove();
				}
			});
		if(retur == 1)
			return;
		
		var values = $(form).serialize();
		//send the data using post and put the results in a div
		$.ajax({
			url:  "AJAXpage.php",
			type: "post",
			data: values,
			success: function(data){
				$(form).append(data);
			},
			error:   function(){
				$(form).html('<div class="error"> An error took place whilst submitting</div>');
			}   
		}); 
	});
}
