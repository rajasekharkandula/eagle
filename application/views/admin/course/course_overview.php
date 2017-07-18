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
							<div class="mb-15">
								<label class="text-left">Overview <span>*</span></label>
								<textarea va_req="true" name="overview" id="overview" placeholder="Enter overview"><?php if(isset($course->overview))echo $course->overview; ?></textarea>
							</div>
							<div class="mb-15">
								<label class="text-left">FAQ <span>*</span></label>
								<textarea va_req="true" name="faq" id="faq" placeholder="Enter Faq`s"><?php if(isset($course->faq))echo $course->faq; ?></textarea>
							</div>
							<div class="mb-15">
								<label class="text-left">Benefits <span>*</span></label>
								<textarea va_req="true" name="benefits" id="benefits" placeholder="Enter benefits"><?php if(isset($course->benefits))echo $course->benefits; ?></textarea>
							</div>
							<h4>Features</h4>
							<?php $i=1;if(isset($course->features)){ $features = json_decode($course->features);?>
							<?php foreach($features as $f){ ?>
							<div class="row mb-15">
								<label class="col-md-3">Feature <?php $i; ?> <span>*</span></label>
								<div class="col-md-8">
									<input type="text" va_req="true" name="features[]" placeholder="Enter feature" value="<?php echo $f;  ?>">
								</div>
							</div>			
							<?php $i++;} ?>
							<?php } ?>							
							<?php for($j=$i;$j<=5;$j++){ ?>
							<div class="row mb-15">
								<label class="col-md-3">Feature <?php echo $j; ?> <span>*</span></label>
								<div class="col-md-8">
									<input type="text" va_req="true" name="features[]" placeholder="Enter feature">
								</div>
							</div>			
							<?php } ?>		
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
	<script>tinymce.init({selector:'textarea',height : 300});</script>
	<script type="text/javascript">
	$(document).ready(function(){
		xu_validation.fileupload('<?php echo base_url();?>', '#image_upload', 'image', '<?php echo base_url('admin/upload_files/image');?>',/(\.|\/)(<?php foreach($this->config->item('ext_img') as $img_type){echo $img_type.'|';} ?>~~)$/i);		
	});
	function save_details(){
		$('#submit_btn').attr("disabled",true);
		$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		
		var formData = new FormData($("#course_form")[0]);
		formData.append('type','UPDATE_OVERVIEW');
		formData.append('id','<?php echo $course->id;?>');
		
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
				window.location='<?php echo base_url('admin/course/content'); ?>/'+data.id;
			}
			else{
				$('#submit_btn').removeAttr("disabled");
				$('#submit_btn').html('Submit');
				$.notify({ message: data.message},{type: 'danger'});
			}
		});
	}
	$('#submit_btn').on('click',function(){
		$("#benefits").val(tinyMCE.get('benefits').getContent());
		$("#faq").val(tinyMCE.get('faq').getContent());
		$("#overview").val(tinyMCE.get('overview').getContent());		
		xu_validation.form_submit('#course_form','save_details');
	});
	</script>
</body>
</html>