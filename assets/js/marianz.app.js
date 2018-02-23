var PCM = (function (){	
	"use strict";

    var $this = {};
	
	$this.setUrl = function(url) {
		$this.url = '';
		if(url && typeof url !=='undefined'){
			$this.url = url; 
		}
    };
	
	$this.setForm = function(form_id) {
		$this.form_id = '#dummy_form';
		if(form_id && typeof form_id !=='undefined'){
			if(form_id.indexOf('#')===0){
				$this.form_id = form_id;
			}else{
				$this.form_id = "#"+form_id;
			}
		}
    };
	
	$this.execute = function(options) {
		$this.setUrl(options.ajax_url);
		$this.setForm(options.form_id);
		$this.action =TITLE.default_title;
		if(options.action && typeof options.action !=='undefined'){
			$this.action = options.action;
		}
		
		if(options.clear && typeof options.clear !=='undefined'){
			$this.clear = options.clear;
		}
		
		$this.params ='';
		if(options.params && typeof options.params !=='undefined'){
			$this.params = '&' + $.param(options.params);
		}
		
		// Get all serialized input inside form id
		var $serialize_data = $($this.form_id).serialize()+$this.params;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: $this.url,
			data: $serialize_data,
			success: function(response){
				//var response = $.parseJSON(JSON.stringify(response));
				if(response.error){						
					var $errors='';
					if(typeof response.message ==='undefined'){											
						/* Then add (form-group-red) class in which input contains error */
						$.map(response, function(val, key) {														
							$('#'+key).parent().closest(".form-group").addClass('form-group-red');
							if(key!='error'){
								//console.log(val+'     '+key);
								$errors += (val+'<br>');
							}
							$('#'+key).after('<span class="form-help form-help-msg text-red">'+val+'<i class="form-help-icon icon icon-error animated infinite flash"></i></span>');
							
						});
					}else{
						$errors += (response.message+'<br>');
						$this.set_errors({'errors':$errors});
					}				
				}else{
					
					if(response.message){
						if(typeof options.showMessage !=='undefined' && options.showMessage ===false){
						}else{
							//$this.set_errors({'errors':response.message});
						}
					}
					
					if(options.redirect_url && typeof options.redirect_url !=='undefined'){
						setTimeout(function(){
							window.location=options.redirect_url;
						}, 100);
					}else{
						if(response.url){
							window.location=response.url;
						}else{
							if(typeof options.reload !=='undefined' && options.reload ===true){
								location.reload();
							}else{
                                if(options.focusto && typeof options.focusto !=='undefined'){
                                    $(options.focusto).focus();
                                }
                            }
						}
					}
				}
			},
			beforeSend:function(){
				/* Remove class (form-group-red) which stands for error highlighting*/				
				$this.clear_errors($this.form_id);
			}
		});
	};
	$this.set_errors = function(err_opts) {			
		if(err_opts.errors && typeof err_opts.errors !=='undefined'){
			var $elems = (err_opts.elem && typeof err_opts.elem !=='undefined')? err_opts.elem:'.errors-messages';
			//console.log($elems);
			if($elems==='.errors-messages'){
				$($elems).append('<span class="form-help form-help-msg text-red">'+err_opts.errors+'<i class="form-help-icon icon icon-error"></i></span>');
			}else{
				$($elems).after('<span class="form-help form-help-msg text-red">'+err_opts.errors+'<i class="form-help-icon icon icon-error"></i></span>');
			}
		}
	};
		
	$this.clear_errors = function(form_id) {
		$(".errors-messages span").remove();
		
		if(form_id && typeof form_id !=='undefined'){
			$this.form_id = form_id;			
		}
		
		$($this.form_id+' .form-group').each(function(){
			$(this).removeClass('form-group-red');
		});	
		
		$('input, textarea, select').each(function(){
			//$(this).next("span").remove();
			$(this).next(".form-help").remove();
		});
		
	};
	
	return $this;	
}());

var Cookies = (function (){	
	"use strict";

    var $coo = {};
	
	$coo.checkCookie = function() {	
		var username	= $coo.getCookie('Username');
		var userid		= $coo.getCookie('UserId'); 
		var authID		= $coo.getCookie('authID'); 
		console.log(username+' '+ userid);
		if (authID ==="" || userid ==="" || username ===""){
			$coo.clearAllcookies();
			//location.reload();
			window.location ='logout.php';
		}
	};
	
	$coo.getCookie = function(cookie_name) {		
		if(cookie_name && typeof cookie_name !=='undefined'){
			var name = cookie_name + "=";
			var ca = document.cookie.split(';');
			for(var i = 0; i <ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0) {
					return c.substring(name.length,c.length);
				}
			}			
		}
		return "";
    };	
	$coo.deleteCookie = function (cookie_name){
		if(cookie_name && typeof cookie_name !=='undefined'){
			var d = new Date();
			d.setDate(d.getDate() - 1);
			var expires = ";expires="+d;
			var name=cookie_name;
			var value="";
			document.cookie = name + "=" + value + expires + "; path=/acc/html";
		}		
    }
	$coo.clearAllcookies = function(){
		var cookies = document.cookie.split(";");
		for (var i = 0; i < cookies.length; i++){
			var spcook =  cookies[i].split("=");
			$coo.deleteCookie(spcook[0]);
		}
	}
	return $coo;	
}());

		
//window.onbeforeunload = function() { return "You work will be lost."; };
		
$(document).ready(function(){
	/* Check LOCAL cookies every 1 second */
	//setInterval(Cookies.checkCookie, 1000);
	$( "body" ).mousemove(function( event ) {
		//Cookies.checkCookie();
	});
	//Cookies.checkCookie();

    function isNull(obj){
        obj = $.trim(obj);
        if(obj && obj !==null && typeof obj !=='undefined'){
            return false;
        }
        return true;
    }
	//$('.footable').footable();
	$('.footable').each(function(){
		$(this).footable();
	});
	
	$('#attach_file').hide();
    $('#attach_capture').hide();
	$('#progress_div').each(function(){
		$(this).hide();
	});
	$('#group_div').each(function(){
		$(this).hide();
	});
	$('.group-repaired_portion').each(function(){
        if($('#unit_status').length &&
            $('#unit_status').find('option:selected').text().toUpperCase()!=='REPAIRED'){
            $(this).hide();
        }
	});
	setInterval(cl, 1000);	
	function cl() {
		$.ajax({url: 'c.php',method: 'GET',dataType: 'json',success: function(data) {
			var c = localStorage.getItem('c');if(typeof c ==='undefined' || c==null){localStorage.setItem('c','0');}
			/*console.log(c+' '+data.isLogin);*/if(data.isLogin==false){Cookies.clearAllcookies();if(c=='1'){localStorage.setItem('c','0');window.location='index.php';}}else{localStorage.setItem('c','1');}
		}});
	}

    setInterval(notif, 2000);
    function notif(){
        $.ajax({url: 'c.php?t=OGkybDI4enVKU3dSWWI4UXp1RFYwZz09',method: 'GET',dataType: 'json',success: function(data) {
            var cn = localStorage.getItem('cn');
            if(typeof cn ==='undefined' || cn===null){
                localStorage.setItem('cn','0');
            }
            if(data.count > parseInt(cn)){
                localStorage.setItem('cn',data.count);
                $('.notif-icon').addClass('animated infinite flash').addClass('text-red');
            }else{
                $('.notif-icon').removeClass('animated infinite flash').removeClass('text-red');
            }
        }});
    }

	findFootable();
	function findFootable(){
		for (i = 0; i < 10; i++) {
			if($('#table_'+i).length){
				$('#table_'+i).footable();
			}
		}
	}
	/*
	$('select').each(function () {
		$(this).change(function () {
			var $val = $(this).val();
			if($val && typeof $val !=='undefined'){
				$(this).css("color",'#151515');
			}else{
				$(this).css("color", '#D8D8D8');
			}			
		});
	});
	*/
	var app = {};
	app.color_enabled = '#151515';
	app.color_disabled = '#D8D8D8';
	
	function toggle_color_options(){
		$('option').each(function () {
			var $val = $(this).val();
			if($val && typeof $val !=='undefined'){
				$(this).css("color",app.color_enabled);
			}else{
				$(this).css("color", app.color_disabled);
			}
		});
	}
	
	$('select').each(function () {
		var $val = $(this).val();
		if($val && typeof $val !=='undefined'){
			$(this).css("color",app.color_enabled);
		}else{
			$(this).css("color", app.color_disabled);
		}
		toggle_color_options();		
	});
	
	$('select').change(function () {
		var $val = $(this).val();
		if($val && typeof $val !=='undefined'){
			$(this).css("color",app.color_enabled);
		}else{
			$(this).css("color", app.color_disabled);
		}
		toggle_color_options();
	});
	
	$('input[type="checkbox"]').each(function () {
		var $val = $(this).is(":checked")?'1':'0';
		$('#'+this.id).after('<input hidden type="hidden" id="chk_'+this.id+'" name="chk_'+this.id+'" value="'+$val+'">');
	
	});
	
	$('input[type="checkbox"]').change(function () {
		var $val = $(this).is(":checked")?'1':'0';
		$('#chk_'+this.id).val($val);
	
	});
	
	$('#unit_type').change(function(){
		$('#unit_attachments').val('');
		$('#unit_url').val('');
		$('#display_file').val('No chosen file');
		
		var $val = $(this).val();
        if($val==='link'){
            $('#attach_file').hide();
            $('#attach_capture').hide();
            $('#attach_link').show();
        }else if($val==='file') {
            $('#attach_link').hide();
            $('#attach_capture').hide();
            $('#attach_file').show();
        }else{
			$('#attach_link').hide();
			$('#attach_file').hide();
            $('#attach_capture').show();
		}
	});
	
	$('#unit_attachments').change(function () {
		var $val = $(this).val().replace('C:\\fakepath\\', '');
		$('#display_file').val($val);
	});
	
	
	$(document).on('click', '.update_sn_status', function (e) {
		e.preventDefault();
        var i = $(this).attr('id').replace('st_', '');
		var sn = $(this).attr('sn');
		var s = $(this).attr('s');
		var r = $(this).attr('rp');
		var d = $(this).attr('dr');
		
		var $dialog = $($(MODAL.update_status))
		$dialog.find('.inner-title').html('Please select new Status for <strong class="text-alt">'+ sn+'</strong>');
		$dialog.find('.modal-inner input[id="i"]').val(i);
		$dialog.find('.modal-inner input[id="unit_status"]').val(s);
		$dialog.find('.modal-inner input[id="unit_repaired_portion"]').val(r);
		$dialog.modal('show');
		
        return false;
    });
	
	$(FORM.changestatus+' select[name=unit_status]').change(function () {
		var $val = $(this).children("option:selected").text();
		if($val.toUpperCase()==='REPAIRED'){
            $('.group-repaired_portion').each(function(){
                $(this).show();
            });
		}else{
            $('.group-repaired_portion').each(function(){
                $(this).hide();
            });
		}
		
	});
	
	$("#update_status_button").click(function(){
		var $r = $('#r').val();
		PCM.execute({
			action : 'Update Status',
			form_id: FORM.changestatus,
			ajax_url: URL.entry,
			redirect_url: $r
			//reload : true
		});
		return false;
	});	
	
	
	
	$("#save_entry_button").click(function(){	
		PCM.execute({
			action : 'Save Entry',
			form_id: FORM.entry,
			ajax_url: URL.entry,
            reload: true
		});

       // $("#unit_serial").focus();

		return false;
	});	
		
	$("#update_entry_button").click(function(){	
		PCM.execute({
			action : 'Update Entry',
			form_id: FORM.entry,
			ajax_url: URL.entry,
			reload: true
		});
		return false;
	});	
	$("#delete_entry_button").click(function(){	
		var $r = $('#r').val();
		PCM.execute({
			action : 'Delete Entry',
			form_id: FORM.entry,
			ajax_url: URL.entry,
			redirect_url : $r
		});
		return false;
	});	
	
	$("#next_add_button").click(function(){	
		PCM.execute({
			action : 'Next Page',
			form_id: FORM.entry,
			ajax_url: URL.entry,
			reload: false
		});
		return false;
	});	

    $("#unit_serial").keydown(function(e){
        if(e.keyCode == 13 || e.which==13){
            if($('#auto_save').is(":checked")){
                $("#save_entry_button").click();
            }else{

            }
        }
    });
	
	$("#save_log_button").click(function(){	
		PCM.execute({
			action : 'Add Repair Log',
			form_id: FORM.logs,
			ajax_url: URL.log,
			reload: true
		});
		return false;
	});
	
	$(document).on('click', '.delete_log', function (e) {
		e.preventDefault();
        var i = $(this).attr('id').replace('log_', '');
		var $query	= $.param({'s':'d','i':i});
		$.confirm({
			text: MSG.confirm_delete_log,
			confirm: function() {
				PCM.execute({
					action : 'Delete Log',
					ajax_url: URL.log+'?'+$query,
					reload: true
				});
			},
			cancel: function() {}
		});
        return false;
    });

    $('#generate_random_parts').click(function(){
        generate_parts({form: FORM.logs,elem:'#unit_repair_done'});
    });

    $('#generate_parts').click(function(){
        generate_parts({form: FORM.changestatus,elem:'#unit_replaced_parts'});
    });

    function generate_parts(opts){
        var $form_data = $(opts.form).serialize();
        $.ajax({
            url: URL.gen_parts,
            type: "POST",
            data: $form_data,
            dataType:'json',
            success: function(data){
                if(data.error){
                    PCM.set_errors({'errors':data.message});
                }else{
                    $(opts.elem).val(data.parts);
                }
            },
            error: function() {
            },
            beforeSend: function(){
                $(opts.elem).val('');
                PCM.clear_errors(opts.form);
            }
        });
    }
	$("#save_attach_button").click(function(){
		var $type = $('#unit_type').val();
		if($type==='link'){
			PCM.execute({
				action : 'Add Attachment',
				form_id: FORM.attachment,
				ajax_url: URL.attachments,
				reload: true
			});
		}else{
			var $this =$(FORM.attachment);
			var $form_data = new FormData($this[0]);
			$.ajax({
				url: URL.upload,
				dataType: "json",
				type: "POST",
				data: $form_data,
				contentType: false,
				cache: false,
				processData:false,
				success: function(response){
					if(response.error){
						var $errors='';
						if(typeof response.message ==='undefined'){
							$.map(response, function(val, key) {														
								$('#'+key).parent().closest(".form-group").addClass('form-group-red');
								if(key!='error'){
									$errors += (val+'<br>');
								}
								PCM.set_errors({'elem':'#'+key,'errors':$errors});
							});
						}else{
							$errors += (response.message+'<br>');
							PCM.set_errors({'errors':$errors});
						}		
					}else{
						PCM.execute({
							action : 'Add Attachment',
							form_id: FORM.attachment,
							ajax_url: URL.attachments,
							reload: true
						});
					}
				},
				beforeSend: function(){
					PCM.clear_errors(FORM.attachment);
				}
			});
		}
		return false;
	});	
	
	$(document).on('click', '.change_state', function (e) {
		e.preventDefault();
        var i = $(this).attr('id').replace('att_', '');
		var s = $(this).attr('state');
		var m = $(this).attr('msg');
		var $query	= $.param({'s':s,'i':i});
		$.confirm({
			text: MSG.confirm_state+m,
			confirm: function() {
				PCM.execute({
					action : 'Change State',
					ajax_url: URL.state+'?'+$query,
					reload: true
				});
			},
			cancel: function() {}
		});
        return false;
    });

    $(document).on('click', '.unlock_delivery', function (e) {
        e.preventDefault();
        var i = $(this).attr('id').replace('del_', '');
        var s = $(this).attr('state');
        var $query	= $.param({'s':s,'i':i});
        $.confirm({
            text: MSG.confirm_unlock,
            confirm: function() {
                PCM.execute({
                    action : 'Unlock Delivery',
                    ajax_url: URL.locking+'?'+$query,
                    reload: true
                });
            },
            cancel: function() {}
        });
        return false;
    });


    $("#save_mainten_button").click(function(){
		PCM.execute({
			action : 'Save Maintenance',
			form_id: FORM.mainten,
			ajax_url: URL.maintenance,
			reload: true
		});
		return false;
	});	
		
	$("#update_mainten_button").click(function(){
		var $url = $('#r').val();
		PCM.execute({
			action : 'Update Maintenance',
			form_id: FORM.mainten,
			ajax_url: URL.maintenance,
			redirect_url: $url
		});
		return false;
	});	
	$("#delete_mainten_button").click(function(){
		var $url = $('#r').val();
		
		PCM.execute({
			action : 'Delete Maintenance',
			form_id: FORM.mainten,
			ajax_url: URL.maintenance,
			redirect_url: $url
		});
		return false;
	});	
	
	$('#req_image').change(function () {
		var $val = $(this).val().replace('C:\\fakepath\\', '');
		var $this =$(FORM.mainten);
		var $form_data = new FormData($this[0]);
		$.ajax({
        	url: "upload.php",
			type: "POST",
			data: $form_data,
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data){
				if(data.error){
					PCM.set_errors({'errors':data.message});
				}else{
					$('#display_file').val($val);
				}
		    },
		  	error: function() {
	    	} 	        
	   });
	});

    $('.brand_capture').hide();
    $('input[name="unit_capture_photo"]').change(function () {
        if($(this).is(":checked")){
            $('.brand_upload').hide();
            $('.brand_capture').show();
        }else{
            $('.brand_capture').hide();
            $('.brand_upload').show();
        }
    });

    setInterval(checkEmptyBrand, 1000);
	function checkEmptyBrand(){
        var $b = $('#unit_brand').val();
        if($.trim($b).length>2){
            $('.show_capture').prop( "disabled", false );
            $('.show_capture').prop( "href", "#modal_take_photo" );
        }else{
            $('.show_capture').prop( "disabled", true );
            $('.show_capture').prop( "href", null );
        }

    }

    function showCapture(){
        var $b = $('#unit_brand').val();
        var $cr = $('#cru').val();
        if(isNull($b)){
            PCM.set_errors({'elem':'#unit_brand','errors':data.message});

        }else{
            window.location = $cr+$b;
        }
    }


	$("input#color_status").change(function(){
		var $val = $(this).val();
		$('#unit_color').val($val);
    });
	
	
	$("input#unit_color").click(function(){	
		$('#color_status').click();
    });
	
	var options_matcode = {
		url: function(q) {
			return URL.autocomplete+"matcode"+"&q=" + q + "&format=json";
		},
		getValue: "name"
	};
	
	var options_ref_no = {
		url: function(q) {
			return URL.autocomplete+"reference_no"+"&q=" + q + "&format=json";
		},
		getValue: "name"
	};
	
	var options_repaired_portion = {
		url: function(q) {
			return URL.autocomplete+"repaired_portion"+"&q=" + q + "&format=json";
		},
		getValue: "name"
	};
	
	//$("#unit_matcode").easyAutocomplete(options_matcode);	
	//$("#unit_reference_no").easyAutocomplete(options_ref_no);
	$("#unit_matcode").each(function(){
		$(this).easyAutocomplete(options_matcode);
	});	
	$("#unit_reference_no").each(function(){
		$(this).easyAutocomplete(options_ref_no);
	});	
	
	$("#unit_repaired_portion").each(function(){
		//$(this).easyAutocomplete(options_repaired_portion);
	});	
	
	
	$("#unit_deliver_serial").each(function(){
		
		var $st= $('.form input[id="st"]').val();
		var $bt= $('.form input[id="bt"]').val();
		var $rt= $('.form input[id="rt"]').val();
		var $query	= $.param({'st':$st,'bt':$bt,'rt':$rt,'format':'json'});
		var options_serial = {
			url: function(q) {
				return URL.autocomplete+"delivery"+"&q=" + q +"&"+ $query;
			},
			getValue: "name"
		};
		$(this).easyAutocomplete(options_serial);
	});	
	
	//init_dateDeliver();
	function init_dateDeliver(){
		var dd = localStorage.getItem('dd');
		var re = localStorage.getItem('re');
		if(dd && typeof dd !=='undefined'){
			$("#unit_deliver_date").val(dd);
		}else{			
			$("#unit_deliver_date").val(getCurrentDate());
		}
		if(re && typeof re !=='undefined'){
			//$("#unit_deliver_date").val(dd);
		}
		
	}
	
	$("#create_delivery_button").click(function(){
		var $url = $('#r').val();
		PCM.execute({
			action : 'Create Delivery',
			form_id: FORM.delivery,
			ajax_url: URL.change_date,
			redirect_url: $url
		});
		return false;
	});	
	
	$('input[name="unit_check_split"]').change(function () {
		if($(this).is(":checked")){
			$('#group_div').show();
		}else{
			$('#group_div').hide();
		}
	});
	
	
	function getCurrentDate() {
		var date = new Date();
		var day = date.getDate();
		var month = date.getMonth();		
		var year = date.getFullYear();
		return year + "-" +( month+1) + "-" + day;
	}
	
	$('#unit_deliver_serial').keypress(function(e){
		var key = e.which || e.keyCode;
		if(key == 13){e.preventDefault(); e.stopPropagation();
			verify_serial();
		}
	});
	
	
	$('#verify_serial_button').click(function () {	
		verify_serial();
	});
	
	function verify_serial(){
		var $serialize_data = $(FORM.add_sn_del).serialize();
		$.ajax({
			type: "POST",
			dataType: "json",
			url: URL.verify,
			data: $serialize_data,
			success: function(response){				
				if(response.error){						
					var $errors='';
					if(typeof response.message ==='undefined'){					
						$.map(response, function(val, key) {														
							$('#'+key).parent().closest(".form-group").addClass('form-group-red');
							if(key!='error'){							
								$errors += (val+'<br>');
							}
							$('#'+key).after('<span class="form-help form-help-msg text-red">'+val+'<i class="form-help-icon icon icon-error"></i></span>');
							
						});
					}
					$('#verifier_div').show();
					$('#progress_div').hide();					
				}else{
					if(response.count >0){
						if(response.count >1){
							$('.errors-messages').append('<span><strong class="text-red">Opss! serial found more than one, please select 1 serial to add</strong></span>');
							$.map(response, function(val, key) {
								if(key!='error' && key!='count'){
									$('.errors-messages').append('<span><li><strong> '+val.serial+'</strong> date received on &nbsp;&nbsp;&nbsp;<strong class="text-blue">'+val.date_in+'</strong>'+val.add_ctrl+'</li></span>');
								}
							});
						}else{
							$.map(response, function(val, key) {
								if(key!='error' && key!='count'){								
									$('#i').val(val.id);
								}
							});
							PCM.execute({
								action : 'Add Serial Delivery',
								form_id: FORM.add_sn_del,
								ajax_url: URL.add_del_sn,
								reload: true
							});
						}
					}else{
						$('.errors-messages').append('<span class="form-help form-help-msg text-red">Serial not found<i class="form-help-icon icon icon-error"></i></span>');
					}
					setTimeout(function(){
						$('#verifier_div').show();
						$('#progress_div').hide();	
					}, 1000);
				}
				
			},
			beforeSend:function(){
				$('#verifier_div').hide();				
				$('#progress_div').show();
				PCM.clear_errors(FORM.add_sn_del);
			}
		});
	}
	
	$(document).on('click', '.add_serial_to', function (e) {
		e.preventDefault();
        var $i = $(this).attr('id').replace('add_', '');
		var $di= $('.form input[id="i"]').val('');
		var $ac= $('.form input[id="ac"]').val();
		var $dt= $('.form input[id="dt"]').val();
		var $st= $('.form input[id="st"]').val();
		var $bt= $('.form input[id="bt"]').val();
		var $rt= $('.form input[id="rt"]').val();
		var $sp= $('.form input[id="sp"]').val();		
		var $data	= $.param({'ac':$ac,'dt':$dt,'st':$st,'bt':$bt,'rt':$rt,'sp':$sp,'i':$i});
	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: URL.add_del_sn,
			data: $data,
			success: function(response){				
				if(response.error){
					PCM.setForm(FORM.add_sn_del);
					PCM.set_errors({'errors':response.message});
				}else{
					location.reload();
				}
			},
			beforeSend:function(){
				PCM.clear_errors(FORM.add_sn_del);
			}
		});
        return false;
    });
	
	$(document).on('click', '.delete_serial_to', function (e) {
		e.preventDefault();
        var $i = $(this).attr('id').replace('del_', '');
		var $ac ='ZzFYdUF6azA0RURVdVRrckRwZHBSZz09';
		var $dt= $('.form input[id="dt"]').val();
		var $st= $('.form input[id="st"]').val();
		var $bt= $('.form input[id="bt"]').val();
		var $rt= $('.form input[id="rt"]').val();
		var $sp= $('.form input[id="sp"]').val();		
		var $data	= $.param({'ac':$ac,'dt':$dt,'st':$st,'bt':$bt,'rt':$rt,'sp':$sp,'i':$i});
		
		
		$.ajax({
			type: "POST",
			dataType: "json",
			url: URL.add_del_sn,
			data: $data,
			success: function(response){				
				if(response.error){
					PCM.setForm(FORM.add_sn_del);
					PCM.set_errors({'errors':response.message});
				}else{
					location.reload();
				}
			},
			beforeSend:function(){
				PCM.clear_errors(FORM.add_sn_del);
			}
		});
        return false;
    });
	
	function tsr_create(kurl,type){
		var $serialize_data = $(FORM.create_tsr).serialize();
		$.ajax({
			type: "POST",
			dataType: "json",
			url: kurl,
			data: $serialize_data,
			success: function(response){				
				if(response.error){						
					var $errors='';
					if(typeof response.message ==='undefined'){					
						$.map(response, function(val, key) {														
							$('#'+key).parent().closest(".form-group").addClass('form-group-red');
							if(key!='error'){$errors += (val+'<br>');}
							$('#'+key).after('<span class="form-help form-help-msg text-red">'+val+'<i class="form-help-icon icon icon-error"></i></span>');							
						});
					}		
				}else{
					if(type==='c'){
						window.open(response.url, "_blank");
					}else{
						
					}			
					
				}
			},
			beforeSend:function(){
				PCM.clear_errors(FORM.create_tsr);
			}
		});
		return false;
	}
	$("#create_tsr_delivery_button").click(function(){
		tsr_create(URL.tsr,'c');
		return false;
	});	
	
	
	$("#update_delivery_info_button").click(function(){
		tsr_create(URL.tsr_updates,'u');
		return false;
	});	
	
	
		
	$(document).on('click', '.add_to_deliver', function (e) {
		e.preventDefault();
        var i = $(this).attr('id').replace('ad_', '');
		var s = $(this).attr('sn');
		
		var $dialog = $($(MODAL.add_todeliver))
		$dialog.find('.inner-title').html('Please select delivery date for <strong class="text-alt">'+ s+'</strong>');
		$dialog.find('.modal-inner input[id="i"]').val(i);
		$dialog.modal('show');
		
        return false;
    });
	
	$("#add_now_button").click(function(){		
		PCM.execute({
			action : 'Add to Deliver',
			form_id: FORM.add_sn_del_s,
			ajax_url: URL.add_del_sn_s,
			reload:true
		});
		return false;
	});	
	
	$('.test_tsr, input[type="checkbox"]').change(function () {
		var $val = $(this).is(":checked")?'OK':'NONE';
		console.log($val);
		$('.label_'+this.id).html($val);
	
	});
	
	$("#change_pwd").click(function(){
		var $r = $('#r').val();
		PCM.execute({
			action : 'Change Password',
			form_id: FORM.changepassword,
			ajax_url: URL.change_pwd,
			redirect_url: $r
		});
		return false;
	});	
	$("#save_settings").click(function(){
		var $r = $('#r').val();
		PCM.execute({
			action : 'Update Settings',
			form_id: FORM.update_settings,
			ajax_url: URL.settings,
			redirect_url: $r
		});
		return false;
	});	
	
	if ($(".success_settings" ).length ){
		setTimeout(function(){
			if ($(".password" ).length ){
				window.location='logout.php';
			}else{
				window.location='index.php';
			}
		}, 1000);
	}

    if($('#unit_serial').length){
        $('#unit_serial').focus();
    }

    if($('#data_table').length){
        $('#data_count').html($('#data_table >tbody >tr').length);
    }

});

