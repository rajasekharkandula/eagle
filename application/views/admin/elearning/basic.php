<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">Course Configuration - <?php echo $course->name; ?></h2>
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
								<label class="col-md-3">Course Name </label>
								<div class="col-md-6">
									<input type="text" value="<?php echo $course->name; ?>" readonly>
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Course Image </label>
								<div class="col-md-6">
									<img src="<?php echo base_url($course->image); ?>" class="preview_img">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Category</label>
								<div class="col-md-6">
									<input type="text" value="<?php echo $course->category_name; ?>" readonly>
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
										<option value="<?php echo $c; ?>" <?php if(isset($elearning->promo_content_type))if($elearning->promo_content_type == $c)echo 'selected'; ?>><?php echo $c; ?></option>	
										<?php } ?>
									</select>		
								</div>
							</div>
							
							<div class="row mb-15 <?php if(isset($elearning->promo_content_type)){if($elearning->promo_content_type == 'URL')echo 'hide';}else{echo 'hide';} ?>" id="content_file">
								<label class="col-md-3">Promotional Content <span>*</span></label>
								<div class="col-md-6">
									<a href="#" class="btn btn-sm mb-5 fileinput-button">Upload <input class="fileupload" id="file_upload" type="file" name="files" save_path="file_path"></a>
									<input type="hidden" name="content_file" id="file_path" value="<?php if(isset($elearning->promo_content_file))echo $elearning->promo_content_file; ?>"/>
									<?php if(isset($elearning->promo_content_file)){ if($elearning->promo_content_type == 'Image'){ ?>
									<img src="<?php echo base_url($elearning->promo_content_file); ?>" class="preview_img">
									<?php }else{ ?>
									<a class="preview_file" href="<?php echo base_url($elearning->promo_content_file); ?>" target="_blank">View uploaded file</a>
									<?php } } ?>
								</div>
							</div>
							
							<div class="row mb-15 <?php if(isset($elearning->promo_content_type)){if($elearning->promo_content_type != 'URL')echo 'hide';}else{echo 'hide';} ?>" id="content_url">
								<label class="col-md-3">Promotional Content <span>*</span></label>
								<div class="col-md-6">
									<input type="text" placeholder="Enter URL" value="<?php if(isset($elearning->promo_content_url))echo $elearning->promo_content_url; ?>">
								</div>
							</div>
							
							<div class="text-center mb-20">
								<button class="btn" type="button" id="submit_btn">Submit</button>
								<a href="<?php echo base_url('admin/course_categories'); ?>" class="btn">Cancel</a>
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
		<?php if(isset($elearning->promo_content_type)) {?>
		file_init('<?php echo $elearning->promo_content_type; ?>');
		<?php } ?>
	});	
	$("#content_type").on("change",function(){
		$("#content_url,#content_file").addClass("hide");
		$(".preview_img").remove();
		$(".preview_file").remove();
		var type = $(this).val();
		file_init(type);
		if(type == 'URL'){
			$("#content_url").removeClass("hide");
		}else if(type != 'None'){
			$("#content_file").removeClass("hide");
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
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload', 'document', '<?php echo base_url('admin/upload_files/document');?>',/(\.|\/)(<?php foreach($this->config->item('ext_video') as $img_type){echo $img_type.'|';} ?>~~)$/i);
		}else if(type == 'SCORM'){
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload', 'scorm', '<?php echo base_url('admin/upload_files/scorm');?>',/(\.|\/)(<?php foreach($this->config->item('ext_scorm') as $img_type){echo $img_type.'|';} ?>~~)$/i);
		}
	}
	function save_details(){
		$('#submit_btn').attr("disabled",true);
		$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		
		var formData = new FormData($("#course_form")[0]);
		formData.append('type','INSERT_UPDATE');
		formData.append('id','<?php echo $course->id;?>');
		
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_elearning'); ?>',
			type:'POST',
			data: formData,
			dataType:'JSON',
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/elearning/content'); ?>/'+data.id;
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