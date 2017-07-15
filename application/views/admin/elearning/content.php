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
								<h4>Sections</h4>
							</div>
							<div class="col-md-6">
								<button class="btn pull-right" type="button" data-toggle="modal" data-target="#section_modal">Add section</button>
							</div>
						</div>
						<table class="table table-bordered">
							<thead>
							  <tr>
								<th>SNO</th>
								<th>Section Name</th>
								<th>No Of Chapters</th>
								<th>View</th>
							  </tr>
							</thead>
							<tbody>
							  <?php $i=1;foreach($sections as $s){ ?>
							  <tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $s->name; ?></td>
								<td><?php echo $s->chapters; ?></td>
								<td><a href="<?php echo base_url('admin/elearning/chapters/'.$id.'/'.$s->id); ?>" class="btn btn-sm"><i class="fa fa-eye"></i> View</a>
								<a href="#" class="btn btn-sm edit_section" data-name="<?php echo $s->name; ?>" data-id="<?php echo $s->id; ?>"><i class="fa fa-pencil"></i> Edit</a></td>
							  </tr>
							  <?php $i++;} ?>
							</tbody>
						</table>
						
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<div id="section_modal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="max-width:650px;">

		<!-- Modal content-->
		<div class="modal-content">
		 <div class="modal-body">
			<div class="row">
			<div class="col-md-9">
				<input type="text" id="section_name" placeholder="Enter section name">
			</div>
			<div class="col-md-3">
				<button class="btn" type="button" id="submit_btn">Submit</button>
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
	$('.edit_section').on('click',function(){
		var id = $(this).data("id");
		$('#submit_btn').data("id",id);
		$("#section_name").val($(this).data("name"));
		$("#section_modal").modal("show");
	});
	$('#submit_btn').on('click',function(){
		$('#submit_btn').attr("disabled",true);
		$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		var section_id = $(this).data("id");
		var section_name = $("#section_name").val();
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_elearning'); ?>',
			type:'POST',
			data: {'type':'SECTION','id':<?php echo $id; ?>,'section_id':section_id,'section_name':section_name},
			dataType:'JSON'
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/elearning/content'); ?>/'+data.id;
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