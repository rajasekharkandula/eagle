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
								<label class="col-md-3">Chapter Name <span>*</span></label>
								<div class="col-md-6">
									<input type="text" value="<?php if(isset($chapter->name))echo $chapter->name; ?>" name="chapter_name" placeholder="Enter chapter name">
								</div>
							</div>
							
							<div class="row mb-15">
								<label class="col-md-3">Content Type <span>*</span></label>
								<div class="col-md-6">
									<select class="select2" data-placeholder="Select content type" name="content_type" id="content_type">
										<option></option>
										<option value="None">None</option>
										<?php foreach($this->config->item('content_type') as $c){ ?>
										<option value="<?php echo $c; ?>" <?php if(isset($chapter->content_type))if($chapter->content_type == $c)echo 'selected'; ?>><?php echo $c; ?></option>	
										<?php } ?>
									</select>		
								</div>
							</div>
							
							<div class="row mb-15 <?php if(isset($chapter->content_type)){if($chapter->content_type == 'URL')echo 'hide';}else{echo 'hide';} ?>" id="content">
								<label class="col-md-3">Content <span>*</span></label>
								<div class="col-md-6">
									<a href="#" class="btn btn-sm mb-5 fileinput-button">Upload <input class="fileupload" id="file_upload" type="file" name="files" save_path="file_path"></a>
									<input type="hidden" name="content" id="file_path" value="<?php if(isset($chapter->content))echo $chapter->content; ?>"/>
									<?php if(isset($chapter->content)){ if($chapter->content_type == 'Image'){ ?>
									<img src="<?php echo base_url($chapter->content); ?>" class="preview_img">
									<?php }else{ ?>
									<a class="preview_file" href="<?php echo base_url($chapter->content); ?>" target="_blank">View uploaded file</a>
									<?php } } ?>
								</div>
							</div>
							
							<div class="row mb-15 <?php if(isset($chapter->content_type)){if($chapter->content_type != 'URL')echo 'hide';}else{echo 'hide';} ?>" id="content">
								<label class="col-md-3">Content <span>*</span></label>
								<div class="col-md-6">
									<input type="text" placeholder="Enter URL" value="<?php if(isset($chapter->content))echo $chapter->content; ?>">
								</div>
							</div>
							
							<div class="row mb-15">
								<label class="col-md-3">Assessments</label>
								<div class="col-md-6">
									<button type="button" class="btn btn-sm" id="add_btn" data-toggle="modal" data-target="#myModal">Add assessment</button>
								</div>
							</div>
							<table class="table table-bordered">
									<thead>
									  <tr>
										<th>Name</th>
										<th>Questions</th>
										<th>Remove</th>
									  </tr>
									</thead>
									<tbody id="assessments">
									 <?php foreach($assessments as $a){ if(in_array($a->id,$selected_asmts)){ ?>
									  <tr>
										<td><input type="hidden" name="assessments[]" value="<?php echo $a->id; ?>"><?php echo $a->name; ?></td>
										<td><?php echo $a->questions; ?></td>
										<td><a href="#" class="btn remove_btn" data-id=="<?php echo $a->id; ?>"><i class="fa fa-trash"></i> Remove</a></td>
									  </tr>
									  <?php } } ?>
									</tbody>
								</table>
							<div class="text-center mb-20">
								<button class="btn" type="button" id="submit_btn">Submit</button>
								<a href="<?php echo base_url('admin/course/content/'.$id); ?>" class="btn">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-body">
			<table class="table table-bordered">
				<thead>
				  <tr>
					<th>Select</th>
					<th>Name</th>
					<th>No. of questions</th>
				  </tr>
				</thead>
				<tbody>
				  <?php foreach($assessments as $a){ ?>
				  <tr>
					<td><input type="checkbox" class="assessments" data-name="<?php echo $a->name; ?>" data-questions="<?php echo $a->questions; ?>" value="<?php echo $a->id; ?>"  <?php if(in_array($a->id,$selected_asmts)) echo 'checked'; ?>></td>
					<td><?php echo $a->name; ?></td>
					<td><?php echo $a->questions; ?></td>
				  </tr>
				  <?php } ?>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" id="select_btn" data-dismiss="modal">Select</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">
	$(document).ready(function(){
		<?php if(isset($chapter->promo_content_type)) {?>
		file_init('<?php echo $chapter->promo_content_type; ?>');
		<?php } ?>
	});	
	$('#select_btn').on('click',function(){
		var users = [];var html = '';
		$('.assessments').each(function(){
		 var th = $(this), name = th.attr('name'); 
		 if(th.is(':checked')){
			html+='<tr>'+
				'<td><input type="hidden" name="assessments[]" value="'+th.val()+'">'+th.data('name')+'</td>'+
				'<td>'+th.data('questions')+'</td>'+
				'<td><a href="#" class="btn remove_btn" data-id="'+th.val()+'"><i class="fa fa-trash"></i> Remove</a></td>'+
			'</tr>';
		  }
		});	
		$("#assessments").html(html);
	});	
	$(document).on('click','.remove_btn',function(e){
		e.preventDefault();
		var obj = $(this);
		var id = obj.data("id");
		$('.assessments').each(function(){
			var obj2 = $(this);
			if(obj2.val() == id)
				obj2.prop('checked',false);
		});
		obj.parents('tr').remove();
	});
	$("#content_type").on("change",function(){
		$("#content_url,#content").addClass("hide");
		$(".preview_img").remove();
		$(".preview_file").remove();
		var type = $(this).val();
		file_init(type);
		if(type == 'URL'){
			$("#content_url").removeClass("hide");
		}else if(type != 'None'){
			$("#content").removeClass("hide");
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
		formData.append('type','CHAPTER');
		formData.append('id','<?php echo $id; ?>');
		formData.append('section_id','<?php echo $section_id; ?>');
		formData.append('chapter_id','<?php echo $chapter_id; ?>');
		
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
				window.location='<?php echo base_url('admin/course/chapters'); ?>/'+data.id+'/'+'<?php echo $section_id; ?>';
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