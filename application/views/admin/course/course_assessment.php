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
								<h4>Assessment</h4>
							</div>
							<div class="col-md-6">
								<a href="#" class="btn pull-right" data-toggle="modal" data-target="#myModal">Add Assessment</a>
							</div>
						</div>
						<?php if($assessment){ ?>
						<table class="table table-bordered">
							<thead>
							  <tr>
								<th>Assessment Name</th>
								<th>Type</th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td><?php echo $assessment->name; ?></td>
								<td><?php echo $assessment->question_type; ?></td>
								</tr>
							</tbody>
						</table>
						<?php } ?>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content box">
		  <div class="modal-body">
			<table class="table table-bordered">
				<thead>
				  <tr>
					<th>Select</th>
					<th>Name</th>
					<th>No. of questions</th>
				  </tr>
				</thead>
				<tbody>
				  <?php foreach($assessments as $a){ ?>
				  <tr>
					<td><input type="radio" class="assessments" data-name="<?php echo $a->name; ?>" data-questions="<?php echo $a->questions; ?>" name="asmt" value="<?php echo $a->id; ?>"  <?php //if(in_array($a->id,$selected_asmts)) echo 'checked'; ?>></td>
					<td><?php echo $a->name; ?></td>
					<td><?php echo $a->questions; ?></td>
				  </tr>
				  <?php } ?>
				</tbody>
			</table>
		  </div>
		  <hr>
		  <div class="text-center">
			<button type="button" class="btn btn-default" id="select_btn">Select</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>
	
	
	<?php echo $footer; ?>
	<script type="text/javascript">
	$(document).ready(function(){
		
	});
	$("#select_btn").on("click",function(){
		$('.text-danger').remove();
		var assessment_id = $("input[name='asmt']:checked").val();
		if(assessment_id){
			$('#select_btn').attr("disabled",true);
			$('#select_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_course'); ?>',
				type:'POST',
				data:{'type':'ASSESSMENT','assessment_id':assessment_id,'id':<?php echo $course->id; ?>},
				dataType:'JSON'
			}).done(function(data){
				if(data.status == 1){
					$.notify({ message: data.message},{type: 'success'});
					window.location.reload();
				}
				else{
					$('#select_btn').removeAttr("disabled");
					$('#select_btn').html('Select');
					$.notify({ message: data.message},{type: 'danger'});
				}
			});
		}else{
			$(this).parent().append('<div class="text-danger">Select atleast one assessment</div>');
		}
	});
	</script>
</body>
</html>