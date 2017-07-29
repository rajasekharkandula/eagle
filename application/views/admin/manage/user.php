<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">User Configuration</h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-7">
					<div class="box">
						<div class="text-right mb-5">Fields marked with (*) are mandatory</div>
						<form id="user_form">
							<div class="row mb-15">
								<label class="col-md-3">First Name <span>*</span></label>
								<div class="col-md-8">
									<input type="text" va_req="true" name="first_name" placeholder="Enter first name" value="<?php if(isset($user->first_name))echo $user->first_name; ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Last Name <span>*</span></label>
								<div class="col-md-8">
									<input type="text" va_req="true" name="last_name" placeholder="Enter last name" value="<?php if(isset($user->last_name))echo $user->last_name; ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Image</label>
								<div class="col-md-8">
									<a href="#" class="btn btn-sm mb-5 fileinput-button">Upload <input class="fileupload" id="image_upload" type="file" name="files" save_path="image_file_path"></a>
									<input type="hidden" name="user_image" id="image_file_path" value="<?php if(isset($user->image)){echo $user->image; }?>"/>
									<?php if(isset($user->image)){ ?>
										<img src="<?php echo base_url($user->image); ?>" class="preview_img">
									<?php } ?>
								</div>
							</div>							
							<div class="row mb-15">
								<label class="col-md-3">Username <span>*</span></label>
								<div class="col-md-8">
									<input type="text" va_req="true" name="username" placeholder="Enter username" value="<?php if(isset($user->username))echo $user->username; ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Password <?php if(!isset($user->username)){ ?><span>*</span><?php } ?></label>
								<div class="col-md-8">
									<input type="text" <?php if(!isset($user->username)){ ?>va_req="true"<?php } ?> name="password" placeholder="Enter password">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Employee ID <span>*</span></label>
								<div class="col-md-8">
									<input type="text" va_req="true" name="uid" placeholder="Enter employee ID" value="<?php if(isset($user->uid))echo $user->uid; ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Department <span>*</span></label>
								<div class="col-md-8">
									<select class="select2" data-placeholder="Select department" name="department" va_req="true">
										<option></option>
										<?php foreach($departments as $d){ ?>
										<option value="<?php echo $d->id; ?>" <?php if(isset($user->department_id))if($user->department_id == $d->id)echo 'selected'; ?>><?php echo $d->name; ?></option>	
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Email <span>*</span></label>
								<div class="col-md-8">
									<input type="text" va_req="true" name="email" placeholder="Enter email" value="<?php if(isset($user->email))echo $user->email; ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Phone</label>
								<div class="col-md-8">
									<input type="text" name="phone" placeholder="Enter phone" value="<?php if(isset($user->phone))echo $user->phone; ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Role <span>*</span></label>
								<div class="col-md-8">
									<?php foreach($roles as $role){ ?>
									<div class="checkbox">
										<input name="user_role" value="<?php echo $role->id; ?>" type="checkbox" va_req="true" va_err="checkbox_check_error" <?php if(isset($user->role_id))if($user->role_id == $role->id)echo 'checked'; ?>><?php echo $role->name; ?>
									</div>
									<?php } ?>
									<div class="text-danger" id="checkbox_check_error"></div>
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Designation <span>*</span></label>
								<div class="col-md-8">
									<select class="select2" data-placeholder="Select designation" name="designation" va_req="true">
										<option></option>
										<?php foreach($designations as $d){ ?>
										<option value="<?php echo $d->id; ?>" <?php if(isset($user->designation_id))if($user->designation_id == $d->id)echo 'selected'; ?>><?php echo $d->name; ?></option>	
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Supervisor</label>
								<div class="col-md-8">
									<select class="select2" data-placeholder="Select supervisor" name="manager_id">
										<option></option>
										<?php foreach($managers as $m){ if($m->id != $id){ ?>
										<option value="<?php echo $m->id; ?>" <?php if(isset($user->manager_id))if($user->manager_id == $m->id)echo 'selected'; ?>><?php echo $m->first_name.' '.$m->last_name.'('.$m->email.')'; ?></option>	
										<?php } } ?>
									</select>		
								</div>
							</div>
							<div class="text-center mb-20">
								<button class="btn" type="button" id="submit_btn">Submit</button>
								<a href="<?php echo base_url('admin/users'); ?>" class="btn">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">

    $(document).ready(function(){
		xu_validation.fileupload('<?php echo base_url();?>', '#image_upload', 'image', '<?php echo base_url('admin/upload_files/image');?>',/(\.|\/)(<?php foreach($this->config->item('ext_img') as $img_type){echo $img_type.'|';} ?>~~)$/i);		
	});	
	$('input[name=user_role]').on('change',function(){
	 var th = $(this), name = th.attr('name'); 
	 if(th.is(':checked')){
		 $(':checkbox[name="'  + name + '"]').not(th).prop('checked',false);   
	  }
	});	
	function save_details(){
		$('#submit_btn').attr("disabled",true);
		$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		
		var formData = new FormData($("#user_form")[0]);
		<?php if(isset($user->id)){ ?>
		formData.append('type','UPDATE');
		formData.append('id','<?php echo $user->id;?>');
		<?php }else{ ?>
		formData.append('type','INSERT');
		<?php } ?>
		
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_user'); ?>',
			type:'POST',
			data: formData,
			dataType:'JSON',
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/users'); ?>';
			}
			else{
				$('#submit_btn').removeAttr("disabled");
				$('#submit_btn').html('Submit');
				$('.disable_div').remove();
				$.notify({ message: data.message},{type: 'danger'});
			}
			
		});
	}
	$('#submit_btn').on('click',function(){
		xu_validation.form_submit('#user_form','save_details');
	});
	</script>
</body>
</html>