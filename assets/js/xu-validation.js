/**
Core script to handle form validation
**/
var xu_validation = function () {
	var prefix = '/eagle';
	var form_validation = function(form_id, success_function){
		var error=0;
		$('form'+form_id+' :input, form'+form_id+' :input[type="textarea"], form'+form_id+' :input[type="checkbox"], form'+form_id+' :input[type="radio"]').each(function(data){
			var err_parent = $(this).parent();
			var err_msg    = '';
			if($(this).attr('va_err_msg')){err_msg = $(this).attr('va_err_msg')};
			if($(this).attr('va_err')){err_parent = $('#'+$(this).attr('va_err'));}
			err_parent.find('.va_error').remove();
			
			//for checking radio and checkbox values
			if($(this).attr('type') == 'checkbox' || $(this).attr('type') == 'radio'){
				var name = $(this).attr('name');
				//for checking any checkbox checked based on name
				if($(this).attr('va_req')){
					if($(this).attr('va_child_of')){
						if($('#'+$(this).attr('va_child_of')).val() == $(this).attr('va_match')){
							if(!$('input:checkbox[name='+name+']').is(':checked')){
								if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
								else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
								err_parent.append(element);
								error++;
							}
						}
					}
					else if(!$('input:checkbox[name='+name+']').is(':checked')){
						if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
						else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
						err_parent.append(element);
						error++;
					}
				}
				//for checking multiple check (more than one field need to be checked)
				else if($(this).attr('va_req_multi')){
					if($(this).attr('va_child_of')){
						if($('#'+$(this).attr('va_child_of')).val() == $(this).attr('va_match')){
							var check_count = 0;
							$('input:checkbox[name='+name+']').each(function(data){
								if($(this).is(':checked'))
									check_count++;
							});
							if(check_count < 2){
								if(err_msg==''){var element = "<span class='text-danger va_error'>Need more than one field to be checked</span>";}
								else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
								err_parent.find('.va_error').remove();
								err_parent.append(element);
								error++;
							}
						}
					}
					else{
						err_parent.find('.va_error').remove();
						var check_count = 0;
						$('input:checkbox[name='+name+']').each(function(data){
							if($(this).is(':checked'))
								check_count++;
						});
						if(check_count < 2){
							if(err_msg==''){var element = "<span class='text-danger va_error'>Need more than one field to be checked</span>";}
							else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
							err_parent.append(element);
							error++;
						}
					}
				}
			}
			else{ //for checking rest of input type(text, textarea, file, dropdown)
				//for checking required field (min one char has to be present)
				
				if($(this).attr('va_req')){
					//check for string starts with space
					var mystring = "-";
					if($(this).val()){mystring = (($(this).val()).toString()).substring(0,1);}
					if($(this).attr('va_child_of')){
						if($('#'+$(this).attr('va_child_of')).val() == $(this).attr('va_match')){
							if($(this).val()=='' || $(this).val()=='undefined' || !$(this).val()){
								if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
								else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
								err_parent.append(element);
								error++;
							}
						}
					}
					else if($(this).attr('va_isset') && !$(this).attr('va_tinymce')){
						if($('#'+$(this).attr('va_isset')).is(':checked')){
							if($(this).val()=='' || $(this).val()=='undefined' || !$(this).val()){
								if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
								else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
								err_parent.append(element);
								error++;
							}
						}
					}
					else if($(this).attr('va_tinymce')){
						if($(this).attr('va_isset')){
							if($('#'+$(this).attr('va_isset')).is(':checked')){
								if(tinyMCE.get($(this).attr('id')).getContent()==''){
									if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
									else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
									err_parent.append(element);
									error++;
								}
							}
						}
						else if(tinyMCE.get($(this).attr('id')).getContent()==''){
							if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
							else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
							err_parent.append(element);
							error++;
						}
					}
					else if($(this).attr('va_email')){
						var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
						if(!regex.test($(this).val())){
							if(err_msg==''){var element = "<span class='text-danger va_error'>Please provide valid Email</span>";}
							else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
							err_parent.append(element);
							error++;
						}
					}
					else if($(this).val()=='' || $(this).val()=='undefined' || !$(this).val()){
						if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
						else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
						err_parent.append(element);
						error++;
					}
					else if(mystring==' '){
						if(err_msg==''){var element = "<span class='text-danger va_error'>This field should not start with space</span>";}
						else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
						err_parent.append(element);
						error++;
					}
				}
				//TO CHECK minimum number of character
				if($(this).attr('va_min') && ($(this).val()!='')){
					var length = parseInt($(this).attr('va_min'));
					if($(this).attr('va_tinymce')){
						var con_length = (tinyMCE.get($(this).attr('id')).getContent()).length;
						if(con_length < length){
							if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
							else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
							err_parent.append(element);
							error++;
						}
					}
					else if(($(this).val()).length < length){
						if(err_msg==''){var element = "<span class='text-danger va_error'>Minimum "+length+" character required</span>";}
						else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
						err_parent.append(element);
						error++;
					}
				}
				var value = parseInt($(this).val());
				if($(this).attr('va_num_egt') || $(this).attr('va_num_egt') || $(this).attr('va_num_gt') || $(this).attr('va_num_elt')|| $(this).attr('va_num_lt') || $(this).attr('va_num_eq')){
					var element = '';
					if(err_msg != ''){element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
					if(!isNaN(value)){
						//To check value is equal or grater than
						if($(this).attr('va_num_egt')){
							var limit = parseInt($('#'+$(this).attr('va_num_egt')).val());
							if(value < limit){
								$(this).val('');element = "<span class='text-danger va_error'>Required greater/equal value then "+limit+"</span>";
								err_parent.append(element);error++;
							}
						}
						//To check value is grater than
						if($(this).attr('va_num_gt')){
							if(value <= limit){
								$(this).val('');element = "<span class='text-danger va_error'>Required greater value then "+limit+"</span>";
								err_parent.append(element);error++;
							}
						}
						//To check value is equal or less than
						if($(this).attr('va_num_elt')){
							if(value > limit){
								$(this).val('');element = "<span class='text-danger va_error'>Required lesser/equal value then "+limit+"</span>";
								err_parent.append(element);error++;
							}
						}
						//To check value is less than
						if($(this).attr('va_num_lt')){
							if(value >= limit){
								$(this).val('');element = "<span class='text-danger va_error'>Required lesser value then "+limit+"</span>";
								err_parent.append(element);error++;
							}
						}
						//To check value is equal
						if($(this).attr('va_num_eq')){
							if(value != limit){
								$(this).val('');element = "<span class='text-danger va_error'>Required equal value to "+limit+"</span>";
								err_parent.append(element);error++;
							}
						}
					}
					else{
						$(this).val(limit);
						element = "<span class='text-danger va_error'>Need a numeric data</span>";
						err_parent.append(element);
						error++;
					}
				}
				//TO CHECK maximum number of character
				//if($(this).attr('va_max') && ($(this).val()!='' || tinyMCE.get($(this).attr('id')).getContent()!='')){
				if($(this).attr('va_max') && $(this).val()!=''){
					var length = parseInt($(this).attr('va_max'));
					if($(this).attr('va_tinymce')){
						var con_length = (tinyMCE.get($(this).attr('id')).getContent()).length;
						if(con_length > length){
							if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
							else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
							err_parent.append(element);
							error++;
						}
					}
					else if(($(this).val()).length > length){
						if(err_msg==''){var element = "<span class='text-danger va_error'>Maximum "+length+" character allowed</span>";}
						else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
						err_parent.append(element);
						error++;
					}
				}
				//TO CHECK for minimum value
				if($(this).attr('va_min_value')){
					var element = '<span class="va_error"></span>';
					var limit = parseInt($(this).attr('va_min_value')), value = parseInt($(this).val());
					if(!isNaN($(this).val())){
						if(value < limit){
							$(this).val(limit);
							element = "<span class='text-danger va_error'>Required greater/equal value then "+limit+"</span>";
							error++;
						}
					}
					else{
						$(this).val(limit);
						element = "<span class='text-danger va_error'>Is not a numeric data</span>";
						error++;
					}
					if(err_msg!=''){element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
					err_parent.append(element);
				}
				
				//TO CHECK for maximum value
				if($(this).attr('va_max_value')){
					var element = '<span class="va_error"></span>';
					var limit = parseInt($(this).attr('va_max_value')), value = parseInt($(this).val());
					if(!isNaN($(this).val())){
						if(value > limit){
							$(this).val(limit);
							element = "<span class='text-danger va_error'>Required lesser/equal value then "+limit+"</span>";
							error++;
						}
					}
					else{
						$(this).val(limit);
						element = "<span class='text-danger va_error'>Is not a numeric data</span>";
						error++;
					}
					if(err_msg!=''){element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
					err_parent.append(element);
				}
				
				//TO CHECK date
				if($(this).attr('va_date')){
					var date = ($(this).val()).split("-");
					var y = parseInt(date[0], 10),
						m = parseInt(date[1], 10),
						d = parseInt(date[2], 10);
					if(y < 1900 || y>9999 || m <1 || m>12 || d <1 || d>31)
						var check = 'Invalid Date';
					else
						var check = new Date(y, m - 1, d);
					if(check == 'Invalid Date'){
						$(this).val('');
						if(err_msg==''){var element = "<span class='text-danger va_error'>Invalid date please provide date in (YYYY-MM-DD) format</span>";}
						else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
						err_parent.append(element);
					}
					else{
						if($(this).attr('va_date_child')){
							var date2 = ($('#'+$(this).attr('va_date_child')).val()).split("-");
							y = parseInt(date2[0], 10);
							m = parseInt(date2[1], 10);
							d = parseInt(date2[2], 10);
							var check2 = new Date(y, m - 1, d);
							if(check < check2){
								$(this).val('');
								if(err_msg==''){var element = "<span class='text-danger va_error'>Please provide date after "+$('#'+$(this).attr('va_date_child')).val()+"</span>";}
								else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
								err_parent.append(element);
							}
						}
					}
				}
			}
		});
		if(error == 0){
			window[success_function]();
			/*$(form_id).attr('onSubmit',success_function+'(); return false;');
			$(form_id).submit();*/
		}
		else{
			$('.disable_div').remove();
			var msg='<div class="alert alert-danger va_form_error"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"><i class="fa fa-times"></i></a>Please correct the following errors</div>';
			$(form_id).prepend(msg);
			var offset = $('.va_form_error').offset();
			if(parseInt(offset.top) < parseInt($(window).height()))
				$("html,body").scrollTop(0);
			else
				$("html,body").scrollTop(offset.top);
		}
	}
	var dynamic_check = function(form_id){
		//for input text box, textarea
		$(document).on('keyup, change', 'form'+form_id+' :input, form'+form_id+' :input[type="textarea"]', function(evt){
			
			var err_parent = $(this).parent();
			var err_msg    = '';
			if($(this).attr('va_err_msg')){err_msg = $(this).attr('va_err_msg')};
			if($(this).attr('va_err')){ err_parent = $('#'+$(this).attr('va_err'));}
			err_parent.find('.va_error').remove();
			
			//TO CHECK REQUIRED
			if($(this).attr('va_req')){
				if($(this).attr('va_child_of')){
					if($('#'+$(this).attr('va_child_of')).val() == $(this).attr('va_match')){
						if($(this).val()=='' || $(this).val()=='undefined'){
							if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
							else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
							err_parent.append(element);
						}
					}
				}
				else if($(this).val()=='' || $(this).val()=='undefined'){
					if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
					else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
					err_parent.append(element);
				}
			}
			
			//TO CHECK minimum character
			if($(this).attr('va_min') && $(this).val()!=''){
				var length = parseInt($(this).attr('va_min'));
				if(($(this).val()).length < length){
					if(err_msg==''){var element = "<span class='text-danger va_error'>Minimum "+length+" character required</span>";}
					else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
					err_parent.append(element);
				}
			}
			//TO CHECK maximum character
			if($(this).attr('va_max') && $(this).val()!=''){
				var length = parseInt($(this).attr('va_max'));
				if(($(this).val()).length > length){
					$(this).val(($(this).val()).substring(0, length));
					if(err_msg==''){var element = "<span class='text-danger va_error'>At max Only "+length+" character allowed</span>";}
					else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
					err_parent.append(element);
				}
			}
			
		});
		
		$(document).on('keypress', 'form'+form_id+' :input, form'+form_id+' :input[type="textarea"]', function(evt){
			//TO CHECK Numeric only
			if($(this).attr('va_num')){
				evt = (evt) ? evt : window.event;
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode > 31 && charCode!=46 && (charCode < 48 || charCode > 57)) {
					return false;
				}
				return true;
			}
		});
		
		$(document).on('blur', 'form'+form_id+' :input, form'+form_id+' :input[type="textarea"]', function(evt){
			var err_parent = $(this).parent();
			var err_msg    = '';
			if($(this).attr('va_err_msg')){err_msg = $(this).attr('va_err_msg')};
			if($(this).attr('va_err')){ err_parent = $('#'+$(this).attr('va_err'));}
			err_parent.find('.va_error').remove();
			
			var value = parseInt($(this).val());
			if($(this).attr('va_num_egt') || $(this).attr('va_num_egt') || $(this).attr('va_num_gt') || $(this).attr('va_num_elt')|| $(this).attr('va_num_lt') || $(this).attr('va_num_eq')){
				if(!isNaN(value)){
					//To check value is equal or grater than
					if($(this).attr('va_num_egt')){
						var limit = parseInt($('#'+$(this).attr('va_num_egt')).val());
						if(value < limit){$(this).val('');element = "<span class='text-danger va_error'>Required greater/equal value then "+limit+"</span>";}
					}
					//To check value is grater than
					if($(this).attr('va_num_gt')){
						if(value <= limit){$(this).val('');element = "<span class='text-danger va_error'>Required greater value then "+limit+"</span>";}
					}
					//To check value is equal or less than
					if($(this).attr('va_num_elt')){
						if(value > limit){$(this).val('');element = "<span class='text-danger va_error'>Required lesser/equal value then "+limit+"</span>";}
					}
					//To check value is less than
					if($(this).attr('va_num_lt')){
						if(value >= limit){$(this).val('');element = "<span class='text-danger va_error'>Required lesser value then "+limit+"</span>";}
					}
					//To check value is equal
					if($(this).attr('va_num_eq')){
						if(value != limit){$(this).val('');element = "<span class='text-danger va_error'>Required equal value to "+limit+"</span>";}
					}
					err_parent.append(element);
				}
				else{
					$(this).val(limit);
					element = "<span class='text-danger va_error'>Is not a numeric data</span>";
					err_parent.append(element);
				}
			}
			//TO CHECK for minimum value
			if($(this).attr('va_min_value')){
				var element = '<span class="va_error"></span>';
				var limit = parseInt($(this).attr('va_min_value')), value = parseInt($(this).val());
				if(!isNaN($(this).val())){
					if(value < limit){
						$(this).val(limit);
						element = "<span class='text-danger va_error'>Required greater/equal value then "+limit+"</span>";
					}
				}
				else{
					$(this).val(limit);
					element = "<span class='text-danger va_error'>Is not a numeric data</span>";
				}
				if(err_msg!=''){element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
				err_parent.append(element);
			}
			
			//TO CHECK for maximum value
			if($(this).attr('va_max_value')){
				var element = '<span class="va_error"></span>';
				var limit = parseInt($(this).attr('va_max_value')), value = parseInt($(this).val());
				if(!isNaN($(this).val())){
					if(value > limit){
						$(this).val(limit);
						element = "<span class='text-danger va_error'>Required lesser/equal value then "+limit+"</span>";
					}
				}
				else{
					$(this).val(limit);
					element = "<span class='text-danger va_error'>Is not a numeric data</span>";
				}
				if(err_msg!=''){element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
				err_parent.append(element);
			}
			//TO CHECK date
			if($(this).attr('va_date')){
				var date = ($(this).val()).split("-");
				var y = parseInt(date[0], 10),
					m = parseInt(date[1], 10),
					d = parseInt(date[2], 10);
				if(y < 1900 || y>9999 || m <1 || m>12 || d <1 || d>31)
					var check = 'Invalid Date';
				else
					var check = new Date(y, m - 1, d);
				if(check == 'Invalid Date'){
					$(this).val('');
					if(err_msg==''){var element = "<span class='text-danger va_error'>Invalid date please provide date in (YYYY-MM-DD) format</span>";}
					else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
					err_parent.append(element);
				}
				else{
					if($(this).attr('va_date_child')){
						var date2 = ($('#'+$(this).attr('va_date_child')).val()).split("-");
						y = parseInt(date2[0], 10);
						m = parseInt(date2[1], 10);
						d = parseInt(date2[2], 10);
						var check2 = new Date(y, m - 1, d);
						if(check < check2){
							$(this).val('');
							if(err_msg==''){var element = "<span class='text-danger va_error'>Please provide date after "+$('#'+$(this).attr('va_date_child')).val()+"</span>";}
							else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
							err_parent.append(element);
						}
					}
				}
			}
		});
		
		$('form'+form_id+' :input[type="file"]').on('change',function(){
			var err_parent = $(this).parent();
			var err_msg    = '';
			if($(this).attr('va_err_msg')){err_msg = $(this).attr('va_err_msg')};
			if($(this).attr('va_err')){ err_parent = $('#'+$(this).attr('va_err'));}
			err_parent.find('.va_error').html('');
			
			if($(this).attr('va_req')){
				err_parent.find('.va_error').remove();
				var accept = ($(this).attr('accept')).split(',');
				if($(this).attr('va_child_of')){
					if($('#'+$(this).attr('va_child_of')).val() == $(this).attr('va_match')){
						if(accept.length){
							var type = ($(this).val()).split('.');
							type = type[type.length-1];
							if(accept.indexOf(type)){
								if(err_msg==''){var element = "<span class='text-danger va_error'>Only "+accept+" format files will be accepted</span>";}
								else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
								err_parent.append(element);
							}
						}
						else{
							if($(this).val()){
								if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
								else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
								err_parent.append(element);
							}
						}
					}
				}
				else{
					if(accept.length){
						var type = ($(this).val()).split('.');
						type = type[type.length-1];
						if(accept.indexOf(type)){
							if(err_msg==''){var element = "<span class='text-danger va_error'>Only "+accept+" format files will be accepted</span>";}
							else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
							err_parent.append(element);
						}
					}
					else{
						if($(this).val()){
							if(err_msg==''){var element = "<span class='text-danger va_error'>This field is required</span>";}
							else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
							err_parent.append(element);
						}
					}
				}
			}
		});
	}
	return {
		//main function to initiate template pages
        validate: function (form_id, success_function) {
			$(form_id).attr('onSubmit','return false;');
			if($(form_id).attr('dynamic_check')){
				dynamic_check(form_id);
			}
			$(document).on('keypress', 'form'+form_id+' :input, form'+form_id+' :input[type="textarea"]', function(evt){
				//TO CHECK Numeric only
				if($(this).attr('va_num')){
					evt = (evt) ? evt : window.event;
					var charCode = (evt.which) ? evt.which : evt.keyCode;
					if (charCode > 31 && charCode!=46 && (charCode < 48 || charCode > 57)) {
						return false;
					}
					return true;
				}
			});
			$(document).on('blur', 'form'+form_id+' :input, form'+form_id+' :input[type="textarea"]', function(evt){
				//TO CHECK email only
				if($(this).attr('va_email')){
					var err_parent = $(this).parent();
					var err_msg    = '';
					if($(this).attr('va_err_msg')){err_msg = $(this).attr('va_err_msg')};
					if($(this).attr('va_err')){err_parent = $('#'+$(this).attr('va_err'));}
					err_parent.find('.va_error').remove();
					var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					if(!regex.test($(this).val())){
						if(err_msg==''){var element = "<span class='text-danger va_error'>Please provide valid Email</span>";}
						else{var element = "<span class='text-danger va_error'>"+err_msg+"</span>";}
						err_parent.append(element);
					}
				}
			});
		},
		form_submit: function (form_id, success_function){
			$('.va_error').remove();
			$('.va_form_error').remove();
			$(form_id).append('<div class="disable_div" style="position:absolute; top:0; left:0; width: 100%; height:100%; z-index:2; opacity:0.4; filter: alpha(opacity = 50); background-color:#949292;"><img style="position: absolute;top:45%;left:45%;width: 100px;" src="'+prefix+'/assets/images/loader.gif" /></div>');
			form_validation(form_id, success_function);
		},
		fileupload: function(prefix, source, type, ajax_url, accept_files){			
			$(source).fileupload({
				url: ajax_url,
				dataType: 'json',
				maxChunkSize: 100000000,
				maxRetries: 3,
				retryTimeout: 500,
				acceptFileTypes: accept_files,
				done: function (e, data) { 
					var path = data['result']['path'], save_path =$(e.target || e.srcElement).attr('save_path');
					$('#'+save_path).val(path);					
					if(type=="image"){
						$(".preview_img").remove();
						$('<img src="'+prefix+path+'" class="preview_img">').insertAfter($('#'+save_path));
					}
					else{
						$(".preview_file").remove();
						$('<a href="'+prefix+path+'" target="_blank" class="preview_file">View uloaded file</a>').insertAfter($('#'+save_path));
					}					
				},
				progressall: function (e, data) {
					$('#'+$(e.target || e.srcElement).attr('pro_path')).css('width',parseInt(data.loaded / data.total * 100, 10) + '%');
					var upload_status = parseInt(data.loaded / data.total * 100, 10);
					$("#upload_status").remove();
					if(upload_status < 100){
						$('<div id="upload_status">Uploading '+upload_status+'% </div>').insertAfter($('#'+$(e.target || e.srcElement).attr('save_path')));
					}
				}
			}).on('fileuploadadd', function (e, data) {
				var msg_target = $(e.target || e.srcElement).attr('message');
				$('#'+msg_target).html('');data.context = $('<div/>').appendTo('#'+msg_target);
				$.each(data.files, function (index, file) {var node = $('<p/>').append($('<span/>').text(file.name));node.appendTo(data.context);});
			}).on('fileuploadprocessalways', function (e, data) {
				var msg_target = $(e.target || e.srcElement).attr('message'), currentFile = data.files[data.index];data.context = $('<div/>').appendTo('#'+msg_target);
				if (data.files.error && currentFile.error) {var node = $('<p/>').append($('<span class="danger"/>').text(currentFile.error));node.appendTo(data.context);}
			});
			if(source == '#requirement_upload' || source == '#design_upload' || source == '#testing_upload' || source == '#package_upload'  ||  source == '#build_upload'){
				getDocs(source);
			}
		}
	};
}();