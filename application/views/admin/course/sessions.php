<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title"><?php echo $course->name; ?> - Sessions</h2>
				</div>
				<div class="col-md-6">
					<div class="page-actions text-right">
						<a href="<?php echo base_url('admin/course_session/'.$course->id); ?>" class="btn"><i class="fa fa-plus"></i> Add session</a>
					</div>
				</div>
			</div>
			
			<div class="box">
				<table class="table table-bordered">
					<thead>
					  <tr>
						<th>Session Name</th>
						<th>Start date</th>
						<th>End date</th>
						<th>Edit</th>
					  </tr>
					</thead>
					<tbody>
					  <?php foreach($sessions as $s){ ?>
					  <tr>
						<td><?php echo $s->name; ?></td>
						<td><?php echo date('d M y',strtotime($s->start_date)); ?></td>
						<td><?php echo date('d M y',strtotime($s->end_date)); ?></td>
						<td><a href="<?php echo base_url('admin/course_session/'.$s->course_id.'/'.$s->id); ?>" class="btn btn-sm" data-id="<?php echo $s->id; ?>"><i class="fa fa-pencil"></i> Edit</a></td>
					  </tr>
					  <?php } ?>
					</tbody>
				</table>
						
			</div>
			
		</div>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">
	$(document).ready(function(){
		
	});
	$('.edit_section').on('click',function(){
		var id = $(this).data("id");
		$('#submit_btn').data("id",id);
		$("#section_modal").modal("show");
	});
	$('#submit_btn').on('click',function(){
		$('#submit_btn').attr("disabled",true);
		$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		var section_id = $(this).data("id");
		var section_name = $("#section_name").val();
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_course'); ?>',
			type:'POST',
			data: {'type':'SECTION','id':<?php echo $id; ?>,'section_id':section_id,'section_name':section_name},
			dataType:'JSON'
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
	
	});
	</script>
</body>
</html>