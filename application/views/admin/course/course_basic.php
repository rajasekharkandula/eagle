<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">Course Configuration</h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
				<?php echo $sidebar; ?>
				</div>
				<div class="col-md-9">
					<div class="box">
						<div class="text-right mb-5">Fields marked with (*) are mandatory</div>
						<form id="course_form">
							<div class="row mb-15">
								<label class="col-md-3">Course Name <span>*</span></label>
								<div class="col-md-6">
									<input type="text" va_req="true" name="name" placeholder="Enter course name" value="<?php if(isset($course->name))echo $course->name; ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Course Image <span>*</span></label>
								<div class="col-md-6">
									<a href="#" class="btn btn-sm mb-5 fileinput-button">Upload <input class="fileupload" id="image_upload" type="file" name="files" save_path="image_file_path"></a>
									<input type="hidden" name="image" id="image_file_path" value="<?php if(isset($course->image)){echo $course->image; }?>" va_req="true"/>
									<?php if(isset($course->image)){ ?>
										<img src="<?php echo base_url($course->image); ?>" class="preview_img">
									<?php } ?>
								</div>
							</div>
							<div class="row">
								<label class="col-md-3">Category</label>
								<div class="col-md-6">
									<select class="select2" data-placeholder="Select category" name="category_id">
										<option></option>
										<?php foreach($categories as $c){ ?>
										<option value="<?php echo $c->id; ?>" <?php if(isset($course->category_id))if($course->category_id == $c->id)echo 'selected'; ?>><?php echo $c->name; ?></option>	
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="row mb-15" style="margin-top:5px;">
								<label class="col-md-3">E-Learning</label>
								<div class="col-md-6">
									<input type="checkbox" name="elearning" value="1" style="margin-top:12px;" <?php if(isset($course->elearning))if($course->elearning == 1)echo 'checked'; ?>>
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Trainer <span>*</span></label>
								<div class="col-md-6">
									<select va_req="true" class="select2" data-placeholder="Select trainer" name="trainers[]" multiple>
										<option></option>
										<?php foreach($trainers as $t){ ?>
										<option value="<?php echo $t->id; ?>" <?php if(in_array($t->id,$selected_trainers))echo 'selected';?>><?php echo $t->first_name.' '.$t->last_name.'('.$t->email.')'; ?></option>	
										<?php } ?>
									</select>		
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Promotional Content Type</label>
								<div class="col-md-6">
									<select class="select2" data-placeholder="Select promotional content type" name="content_type" id="content_type">
										<option></option>
										<option value="None">None</option>
										<?php foreach($this->config->item('content_type') as $c){ ?>
										<option value="<?php echo $c; ?>" <?php if(isset($course->promo_content_type))if($course->promo_content_type == $c)echo 'selected'; ?>><?php echo $c; ?></option>	
										<?php } ?>
									</select>		
								</div>
							</div>
							
							<div class="row mb-15 <?php if(isset($course->promo_content_type)){if($course->promo_content_type == 'URL')echo 'hide';}else{echo 'hide';} ?>" id="content_file">
								<label class="col-md-3">Promotional Content <span>*</span></label>
								<div class="col-md-6">
									<a href="#" class="btn btn-sm mb-5 fileinput-button">Upload <input class="fileupload" id="file_upload" type="file" name="files" save_path="file_path"></a>
									<input type="hidden" name="promo_content" id="file_path" value="<?php if(isset($course->promo_content))echo $course->promo_content; ?>"/>
									<?php if(isset($course->promo_content)){ if($course->promo_content_type == 'Image'){ ?>
									<img src="<?php echo base_url($course->promo_content); ?>" class="preview_img">
									<?php }else{ ?>
									<a class="preview_file" href="<?php echo base_url($course->promo_content); ?>" target="_blank">View uploaded file</a>
									<?php } } ?>
								</div>
							</div>
							
							<div class="row mb-15 <?php if(isset($course->promo_content_type)){if($course->promo_content_type != 'URL')echo 'hide';}else{echo 'hide';} ?>" id="content_url">
								<label class="col-md-3">Promotional Content <span>*</span></label>
								<div class="col-md-6">
									<input type="text" id="contenturl" name="promo_content_url" placeholder="Enter URL" value="<?php if(isset($course->promo_content))echo $course->promo_content; ?>">
								</div>
							</div>
							
							<div class="text-center mb-20">
								<button class="btn" type="button" id="submit_btn">Submit</button>
								<a href="<?php echo base_url('admin/courses'); ?>" class="btn">Cancel</a>
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
		
		<?php if(isset($course->promo_content_type)) {?>
		file_init('<?php echo $course->promo_content_type; ?>');
		<?php } ?>
		
	});
	$("#content_type").on("change",function(){
		$("#content_url,#content_file").addClass("hide");
		$(".preview_img").remove();
		$(".preview_file").remove();
		$("#contenturl,#file_path").removeAttr("va_req");
		var type = $(this).val();
		file_init(type);
		if(type == 'URL'){
			$("#content_url").removeClass("hide");
			$("#contenturl").attr("va_req","true");
		}else if(type != 'None'){
			$("#content_file").removeClass("hide");
			$("#file_path").attr("va_req","true");
		}		
	});
	function file_init(type){
		if(type == 'Image'){
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload', 'image', '<?php echo base_url('admin/upload_files/image');?>',/(\.|\/)(<?php foreach($this->config->item('ext_img') as $img_type){echo $img_type.'|';} ?>~~)$/i);
		}else if(type == 'Audio'){
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload', 'audio', '<?php echo base_url('admin/upload_files/audio');?>',/(\.|\/)(<?php foreach($this->config->item('ext_audio') as $img_type){echo $img_type.'|';} ?>~~)$/i);
		}else if(type == 'Video'){
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload', 'video', '<?php echo base_url('admin/upload_files/video');?>',/(\.|\/)(<?php foreach($this->config->item('ext_video') as $img_type){echo $img_type.'|';} ?>~~)$/i);
		}else if(type == 'Document'){
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload', 'document', '<?php echo base_url('admin/upload_files/document');?>',/(\.|\/)(<?php foreach($this->config->item('ext_document') as $img_type){echo $img_type.'|';} ?>~~)$/i);
		}else if(type == 'SCORM'){
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload', 'scorm', '<?php echo base_url('admin/upload_files/scorm');?>',/(\.|\/)(<?php foreach($this->config->item('ext_scorm') as $img_type){echo $img_type.'|';} ?>~~)$/i);
		}
	}
	function save_details(){
		$('#submit_btn').attr("disabled",true);
		$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		
		var formData = new FormData($("#course_form")[0]);
		<?php if(isset($course->id)){ ?>
		formData.append('type','UPDATE_BASIC');
		formData.append('id','<?php echo $course->id;?>');
		<?php }else{ ?>
		formData.append('type','INSERT_BASIC');
		<?php } ?>
		
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_course'); ?>',
			type:'POST',
			data: formData,
			dataType:'JSON',
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/course/overview'); ?>/'+data.id;
			}
			else{
				$('#submit_btn').removeAttr("disabled");
				$('#submit_btn').html('Submit');
				$.notify({ message: data.message},{type: 'danger'});
			}
		});
	}
	$('#submit_btn').on('click',function(){
		xu_validation.form_submit('#course_form','save_details');
	});
	</script>
</body>
</html>