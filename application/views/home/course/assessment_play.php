<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container view">
			
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title"><?php echo $assessment->name; ?></h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-9">
					<div class="box">
					<div class="qt">					
						<ul>
						<?php $i=1;foreach($questions as $q){ ?>
							<li id="q_<?php echo $i; ?>" class="qlist <?php if($i!=1)echo 'hide';?>" data-qid="<?php echo $q->id; ?>">
								<div class="qname"><?php echo $i; ?>. <?php echo $q->question; ?></div>
								
								<?php if(file_exists($q->video)){ ?>
									<video width="100%" height="400" controls>
									  <source src="<?php echo base_url($q->video);?>" type="video/mp4">
									Your browser does not support the video tag.
									</video>
								<?php } ?>
								<?php if(file_exists($q->image)){ ?>
								<img src="<?php echo base_url($q->image);?>" height="300px;">
								<?php } ?>
								
								<?php if($q->question_type == 'Single Choice' || $q->question_type == 'Multiple Choice'){ ?>
								<ul>
									<?php foreach($options as $o){ if($o->question_id == $q->id){ ?>
									<li>
										<input type="<?php if($q->question_type == 'Single Choice')echo 'radio';else echo 'checkbox'; ?>" class="option" name="option_<?php echo $i; ?>" data-type="<?php echo $q->question_type; ?>" value="<?php echo $o->id; ?>">
										<?php echo $o->options; ?>
									</li>
									<?php } } ?>
								</ul>
								<?php }else if($q->question_type == 'Text'){ ?>
									<textarea class="option" data-type="<?php echo $q->question_type; ?>"></textarea>
								<?php }else if($q->question_type == 'Image'){ ?>
									<a href="#" class="btn btn-sm fileinput-button"><i class="fa fa-image"></i> Upload Image <input class="fileupload" id="file_upload_<?php echo $i; ?>" type="file" name="files" save_path="option_<?php echo $i; ?>"></a>
									<input type="hidden" class="option" name="answer_file" id="option_<?php echo $i; ?>" data-type="<?php echo $q->question_type; ?>"/>
								<?php }else if($q->question_type == 'Video'){ ?>
									<a href="#" class="btn btn-sm fileinput-button"><i class="fa fa-video-camera"></i> Upload Video <input class="fileupload" id="file_upload_<?php echo $i; ?>" type="file" name="files" save_path="option_<?php echo $i; ?>"></a>
									<input type="hidden" class="option" name="answer_file" id="option_<?php echo $i; ?>" data-type="<?php echo $q->question_type; ?>"/>
								<?php }else if($q->question_type == 'Document'){ ?>
									<a href="#" class="btn btn-sm fileinput-button"><i class="fa fa-video-camera"></i> Upload Document <input class="fileupload" id="file_upload_<?php echo $i; ?>" type="file" name="files" save_path="option_<?php echo $i; ?>"></a>
									<input type="hidden" class="option" name="answer_file" id="option_<?php echo $i; ?>" data-type="<?php echo $q->question_type; ?>"/>
								<?php } ?>
							</li>
						<?php $i++; } ?>
						</ul>
					</div>
					<div class="text-center">
						<button class="btn" id="next_btn" data-next="2">Next</button>
						<button class="btn hide" type="button" id="csubmit">Submit Assessment</button>
					</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
<!-- Modal -->
<div id="confirm_modal" class="modal fade qtm" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:400px; top: 20%;">

    <!-- Modal content-->
    <div class="modal-content box">
      <div class="modal-body">
        <p>Are you sure want to submit the assessment?</p>     
        <p>Total Questions : <?php echo count($questions); ?></p>     
        <p>Answered Questions : <span id="answd">0</span></p>     
        <p>Not answered Questions : <span id="nanswd"><?php echo count($questions); ?></span></p>     
		<div class="text-center">
			<button type="button" class="btn" id="submit">Submit</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		</div>
	   </div>
    </div>

  </div>
</div>
	<?php echo $footer; ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jwplayer/jwplayer.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jwplayer/jwplayer.html5.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		
	});
	
	$(document).ready(function(){
		<?php $i=1;foreach($questions as $q){ ?>
			<?php if($q->question_type == 'Image'){ ?>
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload_<?php echo $i; ?>', 'image', '<?php echo base_url('admin/upload_files/image');?>',/(\.|\/)(<?php foreach($this->config->item('ext_img') as $img_type){echo $img_type.'|';} ?>~~)$/i);
			<?php } ?>
			<?php if($q->question_type == 'Video'){ ?>
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload_<?php echo $i; ?>', 'video', '<?php echo base_url('admin/upload_files/video');?>',/(\.|\/)(<?php foreach($this->config->item('ext_video') as $img_type){echo $img_type.'|';} ?>~~)$/i);
			<?php } ?>
			<?php if($q->question_type == 'Document'){ ?>
			xu_validation.fileupload('<?php echo base_url();?>', '#file_upload_<?php echo $i; ?>', 'document', '<?php echo base_url('admin/upload_files/document');?>',/(\.|\/)(<?php foreach($this->config->item('ext_document') as $img_type){echo $img_type.'|';} ?>~~)$/i);
			<?php } ?>
		<?php $i++; } ?>
	});
	$("#next_btn").on("click",function(){
		var id= parseInt($(this).data('next'));
		$(".qlist").addClass('hide');
		$("#q_"+id).removeClass("hide");
		$(this).data('next',id+1);
		var qcount=parseInt(<?php echo count($questions); ?>);
		if(id > qcount){
			$(this).addClass("hide");
			$("#csubmit").removeClass("hide");
		}
	});
	
	
	$('#csubmit').on('click', function(){
		var count = 0;
		var total = parseInt(<?php echo count($questions); ?>);
		$(".qt ul>li.qlist").each(function(){
			var obj = $(this);var temp=0;
			obj.find(".option").each(function(){
				if($(this).is(":checked") && ($(this).data('type') == 'Single Choice' || $(this).data('type') == 'Multiple Choice'))
					temp++
				if($(this).val() !='' && ($(this).data('type') == 'Text' || $(this).data('type') == 'Image' || $(this).data('type') == 'Video' || $(this).data('type') == 'Document'))
					temp++
			});
			if(temp > 0)count++;
		});
		$("#answd").html(count);
		$("#nanswd").html(total-count);
		$("#confirm_modal").modal("show");
	});
	$('#submit').on('click', function(){
		var answers = [];
		var total = parseInt(<?php echo count($questions); ?>);
		$(".qt ul>li.qlist").each(function(){
			var answer = [];
			var obj = $(this);
			answer[0] = obj.data("qid");var ansa = [];var answ = '';
			obj.find(".option").each(function(){
				var obj2 = $(this);
				if(obj2.is(":checked") && obj2.data('type') == 'Single Choice')
					answ = obj2.val();
				else if(obj2.is(":checked") && obj2.data('type') == 'Multiple Choice')
					ansa.push(obj2.val());
				else if((obj2.data('type') == 'Text' || obj2.data('type') == 'Image' || obj2.data('type') == 'Video' || obj2.data('type') == 'Document'))
					answ = obj2.val();
			});
			answer[1] = answ;
			if(answer[1] == '')
				 answer[1] = ansa;
			answers.push(answer);
		});
		
		$('#submit').attr("disabled",true);
		$('#submit').html("Please wait...");
		$.ajax({
			url:'<?php echo base_url(); ?>admin/submit_assessment',
			type:'POST',
			data: {'answers':answers,'assessment_id':'<?php echo $assessment->id; ?>','course_id':'<?php echo $course_id; ?>','session_id':'<?php echo $session_id; ?>'},
			dataType:'JSON'
		}).done(function(data){
			$.notify({ message: 'Assessment submitted successfully'},{type: 'success'});
			<?php if($course_id){ ?>
			window.location='<?php echo base_url('home/course/'.$course_id); ?>';
			<?php }else{ ?>
			window.location='<?php echo base_url(); ?>';
			<?php } ?>
		});
		
	});
	</script>
</body>
</html>