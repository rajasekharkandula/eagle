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
							<?php if($course_asmt){ ?>
							<li class="section <?php if(isset($assessment->id)){if($assessment->id == $course_asmt->id)echo 'active';} ?>" >
								<a href="<?php echo base_url("home/course/".$course->id.'/'.$li->id.'/'.$course_asmt->id); ?>"><i class="fa fa-question"></i> Final Assessment</a>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="col-md-9">
					<div class="box">
					<?php if($assessment){ ?>
					<a class="btn btn-sm mb-10" href="<?php echo base_url('home/assessment/'.$assessment->id.'/'.$course->id.'/'.$course->id); ?>">Take Assessment</a>
					<?php if(count($history) > 0){ ?>
						<table class="table table-bordered">
							<tr>
								<th>S.No.</th>
								<th>Date Time</th>
								<th>Marks</th>
								<th>Status</th>
							</tr>
							<?php $i=1;foreach($history as $h){ ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $h->created_date; ?></td>
									<td><?php if($h->evaluated == 1)echo $h->marks.'/'.$h->total_marks;else echo '--' ?></td>
									<td><?php if($h->evaluated == 1){if($h->pass_marks > $h->marks)echo 'Fail'; else echo 'Pass';}else{ echo 'Submitted';} ?></td>
								</tr>
							<?php $i++;} ?>
						</table>
					<?php } ?>					
					<?php }else if($chapter->content_type == 'Video' || $chapter->content_type == 'Audio'){ ?>
						<!--div id="course_player"> Loading ...</div-->
						<video width="100%" height="400" controls>
						  <source src="<?php echo base_url($chapter->content);?>" type="video/mp4">
						Your browser does not support the video tag.
						</video>
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
	<?php echo $footer; ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jwplayer/jwplayer.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jwplayer/jwplayer.html5.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		<?php if(($chapter->content_type == 'Video' || $chapter->content_type == 'Audio') && !$assessment && 0){ ?>
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
	
	</script>
</body>
</html>