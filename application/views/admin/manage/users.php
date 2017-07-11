<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">List of Users</h2>
				</div>
				<div class="col-md-4">
					<div class="page-actions">
						<input type="text" placeholder="Search...">
					</div>
				</div>
				<div class="col-md-2">
					<div class="page-actions text-right">
						<a href="<?php echo base_url('admin/user'); ?>" class="btn"><i class="fa fa-plus"></i> Add new user</a>
					</div>
				</div>
			</div>
			
			<table class="table table-bordered">
				<thead>
				  <tr>
					<th>Employee ID</th>
					<th>Name</th>
					<th>Username</th>
					<th>Email</th>
					<th>Role</th>
					<th>Designation</th>
					<th>Joined On</th>
					<th>Actions</th>
				  </tr>
				</thead>
				<tbody>
				  <?php foreach($users as $u){ ?>
				  <tr>
					<td><?php echo $u->uid; ?></td>
					<td><?php echo $u->first_name.' '.$u->last_name; ?></td>
					<td><?php echo $u->username; ?></td>
					<td><?php echo $u->email; ?></td>
					<td><?php echo $u->role_name; ?></td>
					<td><?php echo $u->designation; ?></td>
					<td><?php echo date('d M Y H:i A',strtotime($u->created_date)); ?></td>
					<td><a href="<?php echo base_url('admin/user/'.$u->id); ?>" class="btn btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a></td>
				  </tr>
				  <?php } ?>
				</tbody>
			  </table>
			
		</div>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">

    $(document).ready(function(){
		
		
	});	
	</script>
</body>
</html>