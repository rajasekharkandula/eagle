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
			</div>
			<div class="box">
			<table class="table table-bordered dataTable">
				<thead>
				  <tr>
					<th>Employee ID</th>
					<th>Name</th>
					<th>Username</th>
					<th>Email</th>
					<th>Designation</th>
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
					<td><?php echo $u->designation; ?></td>
					<td><a href="<?php echo base_url("home/profile/$u->id"); ?>" class="btn btn-sm"><i class="fa fa-pencil-square-o"></i> View</a></td>
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
	</script>
</body>
</html>