<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">List of Users - <?php echo $course->name; ?></h2>
				</div>
				<div class="col-md-6">
					<div class="page-actions text-right">
						<button class="btn download" data-type="COURSE_USERS" data-courseid="<?php echo $course->id; ?>">Download</button>
						<a href="<?php echo base_url('admin/course_assign/'.$course->id); ?>" class="btn"><i class="fa fa-plus"></i> Assign</a>
					</div>
				</div>
			</div>			
			
			<div class="box" role="tabpanel">
			  <ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
				  <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-expanded="true">Users</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="groups-tab" data-toggle="tab" href="#groups" role="tab" aria-controls="groups" aria-expanded="false">Groups</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id="designations-tab" data-toggle="tab" href="#designations" role="tab" aria-controls="designations" aria-expanded="false">Designations</a>
				</li>
			  </ul>
			  <div class="tab-content" id="myTabContent">
				<div role="tabpanel" class="tab-pane fade active show" id="users" aria-labelledby="users-tab" aria-expanded="true">
					<div class="box">
					<table class="table table-bordered dataTable">
						<thead>
						  <tr>
							<th>Employee ID</th>
							<th>Name</th>
							<th>Course Type</th>
							<th>Assign Type</th>
							<th>Attempts</th>
							<th>Assessment Score</th>
							<th>Status</th>
						  </tr>
						</thead>
						<tbody>
						  <?php foreach($users as $u){ ?>
						  <tr>
							<td><?php echo $u->uid; ?></td>
							<td><?php echo $u->first_name.' '.$u->last_name; ?></td>
							<td><?php echo $u->course_type; ?></td>
							<td><?php echo $u->register_type; ?></td>
							<td><?php echo $u->attempts; ?></td>
							<td><?php echo $u->marks; ?></td>
							<td><?php if($u->marks)echo 'Pass';else echo $u->status; ?></td>
						  </tr>
						  <?php } ?>
						</tbody>
					</table>
					</div>
				</div>
				<div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="groups-tab" aria-expanded="false">
					<table class="table table-bordered">
						<thead>
						  <tr>
							<th>Group</th>
							<th>No. of Users</th>
							<th>Actios</th>
						  </tr>
						</thead>
						<tbody>
						  <?php foreach($groups as $g){ ?>
						  <tr>
							<td><?php echo $g->name; ?></td>
							<td><?php echo $g->users; ?></td>
							<td><button class="btn btn-sm remove" data-groupid="<?php echo $g->id; ?>" data-courseid="<?php echo $course->id; ?>" data-type="GROUP">Remove</button></td>
						  </tr>
						  <?php } ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="designations" role="tabpanel" aria-labelledby="designations-tab" aria-expanded="false">
					<table class="table table-bordered">
						<thead>
						  <tr>
							<th>Designation</th>
							<th>No. of Users</th>
							<th>Actios</th>
						  </tr>
						</thead>
						<tbody>
						  <?php foreach($designations as $d){ ?>
						  <tr>
							<td><?php echo $d->name; ?></td>
							<td><?php echo $d->users; ?></td>
							<td><button class="btn btn-sm remove" data-groupid="<?php echo $g->id; ?>" data-courseid="<?php echo $course->id; ?>" data-type="DESIGNATION">Remove</button></td>
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
		
		
	});	
	</script>
</body>
</html>