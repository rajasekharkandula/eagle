<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container view">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title"><?php echo $course->name; ?></h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-sidebar">
						<ul>
						<?php foreach($sections as $key => $s){ ?>
							<li class="section">
								<a href="#"><b><?php echo ++$key; ?>. <?php echo $s->name; ?></b></a>
							</li>
							<?php foreach($chapters as $li){ 
							if($li->section_id == $s->id){ 
							$class = '';
							if($li->content_type == 'Video'){ $class = 'fa-play-circle '; }
							elseif($li->content_type == 'Audio'){ $class = 'fa-headphones '; }
							elseif($li->content_type == 'SCORM'){ $class = 'fa-file-movie-o '; }
							elseif($li->content_type == 'Document'){ $class = 'fa-file-text-o '; }
							elseif($li->content_type == 'Image'){ $class = 'fa-picture-o '; }
							?>
							<li <?php if(!isset($assessment->id)){if($chapter->id == $li->id)echo 'class="active"';} ?>>
								<a href="<?php echo base_url("home/course/".$course->id.'/'.$li->id); ?>"><i class="fa <?php echo $class; ?>"></i> <?php echo $li->name; ?></a>
							</li>
							
							<?php foreach($assessments as $a){ if($a->chapter_id == $li->id){ ?>
							<li <?php if(isset($assessment->id)){if($assessment->id == $a->id)echo 'class="active"';} ?>>
								<a href="<?php echo base_url("home/course/".$course->id.'/'.$li->id.'/'.$a->id); ?>"><i class="fa fa-question"></i> <?php echo $a->name; ?></a>
							</li>
							<?php } } ?>
							
							<?php } } ?>						
						<?php } ?>
						</ul>
					</div>
				</div>
				<div class="col-md-9">
					<div class="box">
					<?php if($assessment){ ?>
					<?php if(isset($assessment_status->marks)){ ?>
						<h3>Your Assessment Score is <?php echo $assessment_status->marks.'/'.$assessment_status->total_marks; ?></h3>
					<?php }else{  ?>
					<div class="qt">					
						<ol>
						<?php $i=1;foreach($questions as $q){ ?>
							<li data-qid="<?php echo $q->id; ?>">
								<div class="qname"><?php echo $q->question; ?></div>
								<ul>
									<?php foreach($options as $o){ if($o->question_id == $q->id){ ?>
									<li>
										<input type="<?php if($q->question_type == 'Single Choice')echo 'radio';else echo 'checkbox'; ?>" class="option" name="option_<?php echo $i; ?>" data-type="<?php echo $q->question_type; ?>" value="<?php echo $o->id; ?>">
										<?php echo $o->options; ?>
									</li>
									<?php } } ?>
								</ul>
							</li>
						<?php $i++; } ?>
						</ol>
					</div>
					<div class="text-center">
						<button class="btn" type="button" id="csubmit">Submit Assessment</button>
					</div>
					<?php } ?>					
					<?php }else if($chapter->content_type == 'Video' || $chapter->content_type == 'Audio'){ ?>
						<div id="course_player"> Loading ...</div>
					<?php }elseif($chapter->content_type == 'SCORM' || $chapter->content_type == 'Document'){ ?>
						<iframe style="overflow:hide;" src="<?php echo base_url($chapter->content);?>" width="800px" height="480px" ></iframe>
					<?php }elseif($chapter->content_type == 'Image'){	?>
						<img src="<?php echo base_url($chapter->content); ?>">
					<?php } ?>
					
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<?php if($assessment){ ?>
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
<?php } ?>	
	<?php echo $footer; ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jwplayer/jwplayer.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jwplayer/jwplayer.html5.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		<?php if(($chapter->content_type == 'Video' || $chapter->content_type == 'Audio') && !$assessment){ ?>
		jwplayer("course_player").setup({
			file: "<?php echo base_url($chapter->content);?>",
			image: '<?php echo base_url('assets/images/backgrounds/bg.jpg');?>',
			autostart: false,
			width: "100%",
			height: 400,
			repeat:false,
			androidhls:true,
			stretching : 'exactfit'
		}).onPause(function(){
			saveDetail(0)
		}).onComplete(function(){
			$('#markComplete').trigger('click');
		})
	<?php } ?>	
	});
	<?php if($assessment){ ?>
	$('#csubmit').on('click', function(){
		var count = 0;
		var total = parseInt(<?php echo count($questions); ?>);
		$(".qt ol>li").each(function(){
			var obj = $(this);var temp=0;
			obj.find(".option").each(function(){
				if($(this).is(":checked") && ($(this).data('type') == 'Single Choice' || $(this).data('type') == 'Multiple Choice'))
					temp++
				if($(this).val() !='' && ($(this).data('type') == 'text' || $(this).data('type') == 'upload'))
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
		$(".qt ol>li").each(function(){
			var answer = [];
			var obj = $(this);
			answer[0] = obj.data("qid");var ansa = [];var answ = '';
			obj.find(".option").each(function(){
				var obj2 = $(this);
				if(obj2.is(":checked") && obj2.data('type') == 'Single Choice')
					answ = obj2.val();
				else if(obj2.is(":checked") && obj2.data('type') == 'Multiple Choice')
					ansa.push(obj2.val());
				else if((obj2.data('type') == 'text' || obj2.data('type') == 'upload'))
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
			data: {'answers':answers,'assessment_id':'<?php echo $assessment->id; ?>','course_id':'<?php echo $course->id; ?>'},
			dataType:'JSON'
		}).done(function(data){
			window.location.reload();
		});
		
	});
	<?php } ?>	
	</script>
</body>
</html>