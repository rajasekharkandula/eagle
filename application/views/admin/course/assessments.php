<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">List of Assessments</h2>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-4">
					<div class="page-actions text-right">
						<a href="<?php echo base_url('trainer/requests'); ?>" class="btn">Evaluation Requests</a>
						<a href="<?php echo base_url('admin/assessment/basic'); ?>" class="btn"><i class="fa fa-plus"></i> Add assessment</a>
					</div>
				</div>
			</div>			

			<div class="box">
			<table class="table table-bordered dataTable">
				<thead>
				  <tr>
					<th>Name</th>
					<th>Question type</th>
					<th>Random</th>
					<th>Mark type</th>
					<th>No. of questions</th>
					<th>Created Date</th>
					<th>Actions</th>
				  </tr>
				</thead>
				<tbody>
				  <?php foreach($assessments as $a){ ?>
				  <tr>
					<td><?php echo $a->name; ?></td>
					<td><?php echo $a->question_type; ?></td>
					<td><?php echo $a->random; ?></td>
					<td><?php echo $a->mark_type; ?></td>
					<td><?php echo $a->questions; ?> <a class="btn btn-sm" href="<?php echo base_url('admin/assessment/questions/'.$a->id); ?>">View</a></td>
					<td><?php echo $a->created_date; ?></td>
					<td><a href="<?php echo base_url('admin/assessment/basic/'.$a->id); ?>" class="btn btn-sm">Edit</a></td>
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