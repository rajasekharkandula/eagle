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
			<div class="box">
				<div class="row">
					<div class="col-md-3">
						<img src="<?php echo base_url($course->image); ?>" class="thumbnail" alt="<?php echo $course->name; ?>">
					</div>
					<div class="col-md-6">
						<ul class="features">
							<?php 
							$features = json_decode($course->features);
							foreach($features as $f){ ?>
							<li><?php echo $f; ?></li>
							<?php } ?>
						</ul>
					</div>
					<div class="col-md-3 text-center">
						<br>
						<?php if(in_array(-1,$reg_sessions)){ ?>					
						<a href="<?php echo base_url('home/course/'.$course->id); ?>" class="btn mt-10">Launch</a>
						<?php }else{ ?>
						<button class="btn mt-10 register" id="register_btn" data-courseid="<?php echo $course->id; ?>" data-type="Elearning">Register Elearning</button>
						<?php } ?>
						<br>
						<button class="btn mt-10 hide">Classroom Sessions</button>
					</div>
				</div>
			</div>
			
			<div class="box mt-10" role="tabpanel">
			  <ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
				  <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-expanded="true">Overview</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="faq-tab" data-toggle="tab" href="#faq" role="tab" aria-controls="faq" aria-expanded="false">Faq`s</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="benefits-tab" data-toggle="tab" href="#benefits" role="tab" aria-controls="benefits" aria-expanded="false">Benefits</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="prerequisite-tab" data-toggle="tab" href="#prerequisite" role="tab" aria-controls="prerequisite" aria-expanded="false">Prerequisite</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="elearning-tab" data-toggle="tab" href="#elearning" role="tab" aria-controls="elearning" aria-expanded="false">Contents</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="sessions-tab" data-toggle="tab" href="#sessions" role="tab" aria-controls="sessions" aria-expanded="false">Sessions</a>
				</li>
			  </ul>
			  <div class="tab-content" id="myTabContent">
				<div role="tabpanel" class="tab-pane fade active show" id="overview" aria-labelledby="overview-tab" aria-expanded="true">
				<?php echo $course->overview; ?>
				<?php if(isset($course->promo_content_type)){ ?>
					<?php if($course->promo_content_type == 'Video'){ ?>
						<div id="course_player"> Loading ...</div>
					<?php }else{ ?>
						
					<?php } ?>
				<?php } ?>
				</div>
				<div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab" aria-expanded="false">
				<?php echo $course->faq; ?>
				</div>
				<div class="tab-pane fade" id="benefits" role="tabpanel" aria-labelledby="benefits-tab" aria-expanded="false">
				<?php echo $course->benefits; ?>
				</div>
				<div class="tab-pane fade" id="prerequisite" role="tabpanel" aria-labelledby="prerequisite-tab" aria-expanded="false">
				<?php echo $course->prerequisite; ?>
				</div>
				<?php if(count($sections) > 0){ ?>
				<div class="tab-pane fade contents" id="elearning" role="tabpanel" aria-labelledby="elearning-tab" aria-expanded="false">
				<?php foreach($sections as $key => $s){ ?>
				<h4 class="head mt-15">Lession <?php echo ++$key; ?> : <?php echo $s->name; ?> </h4>
				<ol>
					<?php foreach($chapters as $li){ 
					if($li->section_id == $s->id){ 
					$class = '';
					if($li->content_type == 'Video'){ $class = 'fa-play-circle '; }
					elseif($li->content_type == 'Audio'){ $class = 'fa-headphones '; }
					elseif($li->content_type == 'SCORM'){ $class = 'fa-file-movie-o '; }
					elseif($li->content_type == 'Document'){ $class = 'fa-file-text-o '; }
					elseif($li->content_type == 'Image'){ $class = 'fa-picture-o '; }
					?>
					<li><i class="fa <?php echo $class; ?>"></i> <?php echo $li->name; ?></li>
					<?php } } ?>
				</ol>
				<?php } ?>
				</div>
				<?php } ?>
				
				<?php if(count($sessions) > 0){ ?>
				<div class="tab-pane fade contents" id="sessions" role="tabpanel" aria-labelledby="sessions-tab" aria-expanded="false">
				<table class="table table-bordered">
					<thead>
					  <tr>
						<th>Start date</th>
						<th>End date</th>
						<th>Register</th>
					  </tr>
					</thead>
					<tbody>
					  <?php foreach($sessions as $s){ ?>
					  <tr>
						<td><?php echo date('d M y',strtotime($s->start_date)); ?></td>
						<td><?php echo date('d M y',strtotime($s->end_date)); ?></td>
						<td>
							<?php if(!in_array($s->id,$reg_sessions)){ ?>
							<button class="btn btn-sm register" data-courseid="<?php echo $s->course_id; ?>" data-sessionid="<?php echo $s->id; ?>" data-type="Classroom">Register</button>
							<?php }else{ ?>
							<button class="btn btn-sm" disabled>Registered</button>
							<?php } ?>
						</td>
					  </tr>
					  <?php } ?>
					</tbody>
				</table>
				</div>
				<?php } ?>
			  </div>
			</div>
			
		</div>
	</div>
	
	<?php echo $footer; ?>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jwplayer/jwplayer.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jwplayer/jwplayer.html5.js"></script>
	
	<script type="text/javascript">

    $(document).ready(function(){
		<?php if(isset($course->promo_content_type)){ ?>
		<?php if($course->promo_content_type == 'Video' || $course->promo_content_type == 'Audio'){ ?>
		jwplayer("course_player").setup({
			file: "<?php echo base_url($course->promo_content); ?>",
			image: '<?php echo base_url('assets/images/backgrounds/bg.jpg');?>',
			autostart: false,
			width: "100%",
			height: 500,
			repeat:false,
			androidhls:true,
			stretching : 'exactfit'
		});
		<?php } ?>
		<?php } ?>
	});
	$(".register").on("click",function(){
		var obj = $(this);
		obj.attr("disabled",true);
		obj.html('Please wait...');
		var course_id = obj.data('courseid');
		var session_id = obj.data('sessionid');
		var course_type = obj.data('type');
		$.ajax({
			url:'<?php echo base_url('admin/course_registration'); ?>',
			type:'POST',
			data: {'type':'REGISTER','course_id':course_id,'session_id':session_id,'course_type':course_type},
			dataType:'JSON'
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location.reload();
			}
			else{
				obj.removeAttr("disabled");
				obj.html('Register');
				$.notify({ message: data.message},{type: 'danger'});
			}
		});
	});	
	</script>
</body>
</html>