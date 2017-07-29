<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title"><?php echo $user->first_name.' '.$user->last_name; ?></h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-9">
					<div class="box">
						<div class="row">
							<div class="text-left mb-3 col-md-2"><b>Employee ID</b></div>
							<div class="text-left mb-3 col-md-2"><b>Designation</b></div>
							<div class="text-left mb-3 col-md-3"><b>Email</b></div>
							<div class="text-left mb-3 col-md-2"><b>Username</b></div>
							<div class="text-left mb-3 col-md-3"><b>Department</b></div>
						</div>
						<div class="row">
							<div class="text-left mb-3 col-md-2"><?php echo $user->uid ?></div>
							<div class="text-left mb-3 col-md-2"><?php echo $user->designation ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->email ?></div>
							<div class="text-left mb-3 col-md-2"><?php echo $user->username ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->department_id ?></div>
						</div>
					</div>
					<br><br>
					<div class="box">
						<div class="row">
							<div class="text-left mb-3 col-md-3"><b>Join Date</b></div>
							<div class="text-left mb-3 col-md-3"><b>Gender</b></div>
							<div class="text-left mb-3 col-md-3"><b>Date of Birth</b></div>
						</div>
						<div class="row">
							<div class="text-left mb-3 col-md-3"><?php echo $user->created_date ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->gender ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->dob ?></div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="box text-center" >
						<img src="<?php echo base_url($user->image); ?>" height="160" width="160">
						<button type="button" class="btn btn-sm" style="margin-top:10px;" id="edit_ibtn">Edit Image</button>
						<form id="user_form" class="hide">
							<input type="file" id="user_image" name="image">
						</form>
					</div>
				</div>
			</div>
			<div class="box mt-10" role="tabpanel">
			  <ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
				  <a class="nav-link active" id="courses-tab" data-toggle="tab" href="#courses" role="tab" aria-controls="courses" aria-expanded="true">All Courses</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="ongoing-tab" data-toggle="tab" href="#ongoing" role="tab" aria-controls="ongoing" aria-expanded="false">Ongoing Courses</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-expanded="false">Completed Courses</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="assessments-tab" data-toggle="tab" href="#assessments" role="tab" aria-controls="assessments" aria-expanded="false">Assessments</a>
				</li>
			  </ul>
			  <div class="tab-content" id="myTabContent">
				<div role="tabpanel" class="tab-pane fade active show" id="courses" aria-labelledby="courses-tab" aria-expanded="true">
					<table class="table table-bordered">
						<thead>
						  <tr>
							<th>Name</th>
							<th>Course Type</th>
							<th>Attempts</th>
							<th>Assessment Score</th>
							<th>Status</th>
						  </tr>
						</thead>
						<tbody>
						  <?php foreach($courses as $c){ ?>
						  <tr>
							<td><?php echo $c->name; ?></td>
							<td><?php echo $c->course_type; ?></td>
							<td><?php echo $c->attempts; ?></td>
							<td><?php echo $c->marks; ?></td>
							<td><?php if($c->marks)echo 'Pass';else echo $c->status; ?></td>
						  </tr>
						  <?php } ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="ongoing" role="tabpanel" aria-labelledby="ongoing-tab" aria-expanded="false">
					<table class="table table-bordered">
						<thead>
						  <tr>
							<th>Name</th>
							<th>Type</th>
							<th>End Date</th>
						  </tr>
						</thead>
						<tbody>
						  <?php foreach($ongoing as $o){ ?>
						  <tr>
							<td><?php echo $o->name; ?></td>
							<td><?php echo $o->course_type; ?></td>
							<td><?php echo date('d M,Y',strtotime($o->end_date)); ?></td>
						  </tr>
						  <?php } ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab" aria-expanded="false">
					<table class="table table-bordered">
						<thead>
						  <tr>
							<th>Name</th>
							<th>Type</th>
							<th>Completed Date</th>
						  </tr>
						</thead>
						<tbody>
						  <?php foreach($completed as $c){ ?>
						  <tr>
							<td><?php echo $c->name; ?></td>
							<td><?php echo $c->course_type; ?></td>
							<td><?php echo date('d M,Y',strtotime($c->end_date)); ?></td>
						  </tr>
						  <?php } ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="assessments" role="tabpanel" aria-labelledby="assessments-tab" aria-expanded="false">
					<table class="table table-bordered">
						<thead>
						  <tr>
							<th>Name</th>
							<th>Question Type</th>
							<th>Score</th>
							<th>Status</th>
						  </tr>
						</thead>
						<tbody>
						  <?php foreach($assessments as $a){ ?>
						  <tr>
							<td><?php echo $a->name; ?></td>
							<td><?php echo $a->question_type; ?></td>
							<td><?php if($a->status == 'Completed')echo $a->score.'/'.$a->total_marks;else echo '-'; ?></td>
							<td><?php echo $a->status; ?></td>
						  </tr>
						  <?php } ?>
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
		var tab = window.location.hash.substr(1);
		$("#"+tab+"-tab").trigger("click");
	});	
	$("#edit_ibtn").on("click",function(){
		$("#user_image").trigger("click");
	});
	$("#user_image").on("change",function(){
		$('#edit_ibtn').attr("disabled",true);
		$('#edit_ibtn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		
		var formData = new FormData($("#user_form")[0]);
		formData.append('type','UPDATE_PIC');
		formData.append('id','<?php echo $user->id;?>');
		
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_user'); ?>',
			type:'POST',
			data: formData,
			dataType:'JSON',
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location.reload();
			}
			else{
				$('#edit_ibtn').removeAttr("disabled");
				$('#edit_ibtn').html('Edit Image');
				$.notify({ message: data.message},{type: 'danger'});
			}
			
		});
	});
	
	</script>
</body>
</html>
