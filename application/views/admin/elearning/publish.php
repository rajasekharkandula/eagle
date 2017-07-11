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
						<h4>Publish Course</h4>
						<div class="text-center mb-20">
							<button class="btn" type="button" id="publish_btn">Publish</button>
							<a href="<?php echo base_url('admin/courses'); ?>" class="btn">Cancel</a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">
	$(document).ready(function(){
	});	
	$('#publish_btn').on('click',function(){
		$('#publish_btn').attr("disabled",true);
		$('#publish_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_course'); ?>',
			type:'POST',
			data: {'id':<?php echo (int)$id; ?>,'type':'PUBLISH'},
			dataType:'JSON'
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/courses'); ?>';
			}
			else{
				$('#publish_btn').removeAttr("disabled");
				$('#publish_btn').html('Publish');
				$.notify({ message: data.message},{type: 'danger'});
			}
		});
	});
	</script>
</body>
</html>