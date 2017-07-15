<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">My Courses</h2>
				</div>
			</div>
			<?php if(count($courses) > 0){ ?>
			<div class="row">
				<?php foreach($courses as $c){ ?>
				<div class="col-md-3">
					<div class="c-box">
						<a href="<?php echo base_url('home/course_view/'.$c->id); ?>">
							<img src="<?php echo base_url($c->image); ?>">
							<div class="title"><?php echo $c->name; ?></div>
							<div class="sub-title"><?php echo $c->category_name; ?></div>
						</a>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php }else{ ?>
			<h6>No courses found</h6>
			<?php } ?>
		</div>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">

    $(document).ready(function(){
		
		
	});	
	</script>
</body>
</html>