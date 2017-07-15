<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">List of Departments</h2>
				</div>
				<div class="col-md-4">
					<div class="page-actions">
						<input type="text" placeholder="Search...">
					</div>
				</div>
				<div class="col-md-2">
					<div class="page-actions text-right">
						<a href="<?php echo base_url('admin/department'); ?>" class="btn"><i class="fa fa-plus"></i> Add department</a>
					</div>
				</div>
			</div>
			
			<table class="table table-bordered">
				<thead>
				  <tr>
					<th>Name</th>
					<th>Created On</th>
					<th>Actions</th>
				  </tr>
				</thead>
				<tbody>
				  <?php foreach($departments as $d){ ?>
				  <tr>
					<td><?php echo $d->name; ?></td>
					<td><?php echo $d->created_date; ?></td>
					<td><a href="<?php echo base_url('admin/department/'.$d->id); ?>" class="btn btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a></td>
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