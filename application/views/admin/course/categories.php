<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">List of Course Categories</h2>
				</div>
				<div class="col-md-4">
					<div class="page-actions">
						<input type="text" placeholder="Search...">
					</div>
				</div>
				<div class="col-md-2">
					<div class="page-actions text-right">
						<a href="<?php echo base_url('admin/course_category'); ?>" class="btn"><i class="fa fa-plus"></i> Add category</a>
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
				  <?php foreach($categories as $c){ ?>
				  <tr>
					<td><?php echo $c->name; ?></td>
					<td><?php echo $c->created_date; ?></td>
					<td><a href="<?php echo base_url('admin/course_category/'.$c->id); ?>" class="btn btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a></td>
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