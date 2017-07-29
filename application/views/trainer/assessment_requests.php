<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">List of assessment evaluation requests</h2>
				</div>				
			</div>			

			<div class="box">
			<table class="table table-bordered dataTable">
				<thead>
				  <tr>
					<th>User Name</th>
					<th>Assessment Name</th>
					<th>Evaluate</th>
				  </tr>
				</thead>
				<tbody>
				  <?php foreach($requests as $r){ ?>
				  <tr>
					<td><?php echo $r->first_name.' '.$r->last_name; ?></td>
					<td><?php echo $r->name; ?></td>
					<td><a href="<?php echo base_url('trainer/evaluate/'.$r->asmt_user_id); ?>" class="btn btn-sm">Evaluate</a></td>
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