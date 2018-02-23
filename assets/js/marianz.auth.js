var URL_AUTH ="includes/actions/auth.php?a=";
var Authentication = (function (){
	return {
		validate: function(options){
			var $this = {};
			if(options.action && typeof options.action !=='undefined'){
				$this.action = options.action;
			}
			
			$this.title = ($this.action ==='login') ? 'Login' : 'Register';
			
			if(options.button_id && typeof options.button_id !=='undefined'){
				$this.button_id = options.button_id;
			}
			
			if(options.form_id && typeof options.form_id !=='undefined'){
				if(options.form_id.indexOf('#')===0){
					$this.form_id = options.form_id;
				}else{
					$this.form_id = "#"+options.form_id;
				}
			}else{
				$this.form_id = "#dummy_form";
			}

			var $serialize_data = $($this.form_id).serialize();
			
			$.ajax({
				type: "POST",
				dataType: "json",
				url: URL_AUTH+$this.action,
				data: $serialize_data,
				success: function(response){
					if(response.error){						
						var $errors='';
						if(typeof response.message =='undefined'){
							/* Remove class (form-group-red) which stands for error highlighting*/
							$($this.form_id+' .form-group').each(function(){
								$(this).removeClass('form-group-red');
							});							
							/* Then add (form-group-red) class in which input contains error */
							$.map(response, function(val, key) {														
								$('#'+key).parent().closest(".form-group").addClass('form-group-red');
								if(key!='error'){
									$errors += (val+'<br>');
								}
								$('#'+key).after('<span class="form-help form-help-msg text-red">'+val+'<i class="form-help-icon icon icon-error"></i></span>');
							});
						}else{
							$errors += (response.message+'<br>');
							$('.errors-messages').append('<span class="form-help form-help-msg text-red">'+$errors+'<i class="form-help-icon icon icon-error"></i></span>');
						}
					}else{
						if(options.redirect_url && typeof options.redirect_url !=='undefined'){
							setTimeout(function(){
								window.location=options.redirect_url;
							}, 1000);
						}else{
							if(typeof options.reload !=='undefined' && options.reload ===true){
								location.reload();
							}
						}
					}
				},
				beforeSend:function(){
					$($this.form_id+' .form-group').each(function(){
						$(this).removeClass('form-group-red');
					});	
					$('input, select').each(function(){
						$(this).next("span").remove();
					});
					$('input, textarea, select').each(function(){
						$(this).next(".form-help").remove();
					});
					
					$(".errors-messages span").remove();
				}
			});			
		}		
	};
}());


$(document).ready(function()
{	
	$("#signin_button").click(function(){
		
		Authentication.validate({
			form_id: 'signin_form',
			action : 'login',
			reload: true
		});
		return false;
	});	
	
	$("#signup_button").click(function(){	
		var $r = $('#r').val();
		Authentication.validate({
			form_id: 'signup_form',
			redirect_url: $r,
			action : 'register'
		});
		return false;
	});
	
	
	
});