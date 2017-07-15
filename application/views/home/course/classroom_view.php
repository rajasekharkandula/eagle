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
						<button class="btn mt-10">E Learning</button>
						<br>
						<button class="btn mt-10">Classroom</button>
					</div>
				</div>
			</div>
			<div class="box mt-10" role="tabpanel">
			  <ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
				  <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-expanded="true">overview</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="faq-tab" data-toggle="tab" href="#faq" role="tab" aria-controls="faq" aria-expanded="false">faq</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="benefits-tab" data-toggle="tab" href="#benefits" role="tab" aria-controls="benefits" aria-expanded="false">benefits</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="prerequisite-tab" data-toggle="tab" href="#prerequisite" role="tab" aria-controls="prerequisite" aria-expanded="false">prerequisite</a>
				</li>
			  </ul>
			  <div class="tab-content" id="myTabContent">
				<div role="tabpanel" class="tab-pane fade active show" id="overview" aria-labelledby="overview-tab" aria-expanded="true">
				<?php echo $course->overview; ?>
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
			  </div>
			</div>
			
		</div>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">

    $(document).ready(function(){
		
		
	});	
	</script>
</body>
</html>