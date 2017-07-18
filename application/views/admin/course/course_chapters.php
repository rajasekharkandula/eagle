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
						<div class="row mb-10">
							<div class="col-md-6">
								<h4><a href="<?php echo base_url('admin/course/content/'.$id); ?>" class="btn btn-bk"> <i class="fa fa-arrow-left"></i></a> Chapters</h4>
							</div>
							<div class="col-md-6">
								<a href="<?php echo base_url('admin/course/chapter/'.$id.'/'.$section_id); ?>" class="btn pull-right">Add chapter</a>
							</div>
						</div>
						<table class="table table-bordered">
							<thead>
							  <tr>
								<th>SNO</th>
								<th>Chapter Name</th>
								<th>Content Type</th>
								<th>Edit</th>
							  </tr>
							</thead>
							<tbody>
							  <?php $i=1;foreach($chapters as $c){ ?>
							  <tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $c->name; ?></td>
								<td><?php echo $c->content_type; ?></td>
								<td><a href="<?php echo base_url('admin/course/chapter/'.$c->course_id.'/'.$c->section_id.'/'.$c->id); ?>" class="btn btn-sm" data-id="<?php echo $c->id; ?>"><i class="fa fa-pencil"></i> Edit</a></td>
							  </tr>
							  <?php $i++;} ?>
							</tbody>
						</table>
						
					</div>
				</div>
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