<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">List of Trainers</h2>
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