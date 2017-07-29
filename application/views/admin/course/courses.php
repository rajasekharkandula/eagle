<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">List of Courses</h2>
				</div>
				<div class="col-md-4">
					
				</div>
				<div class="col-md-2">
					<div class="page-actions text-right">
						<a href="<?php echo base_url('admin/course/basic'); ?>" class="btn"><i class="fa fa-plus"></i> Add course</a>
					</div>
				</div>
			</div>
			
			<div class="row">
				<?php foreach($courses as $c){ ?>
				<div class="col-md-3">
					<div class="c-box">
						<?php if($c->published > 0){ ?>
						<a href="<?php echo base_url('home/course_view/'.$c->id); ?>">
							<img src="<?php echo base_url($c->image); ?>">
							<div class="title"><?php echo $c->name; ?></div>
							<div class="sub-title"><?php echo $c->category_name; ?></div>
						</a>
						<div class="sb">
							<a href="<?php echo base_url('admin/course/basic/'.$c->id); ?>">Edit</a>
						</div>
						<div class="sb">
							<a href="<?php echo base_url('admin/course_sessions/'.$c->id); ?>">Sessions</a>
						</div>
						<div class="sb">
							<a href="<?php echo base_url('admin/course_users/'.$c->id); ?>">Stats</a>
						</div>
						<?php }else{ ?>
							<img src="<?php echo base_url($c->image); ?>">
							<div class="title"><?php echo $c->name; ?></div>
							<div class="sub-title"><?php echo $c->category_name; ?></div>
						<div class="sb">
							<a href="<?php echo base_url('admin/course/basic/'.$c->id); ?>">Edit</a>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
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