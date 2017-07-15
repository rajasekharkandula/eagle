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
					<br>
					<div class="box">
						<div class="row">
							<div class="text-left mb-3 col-md-3"><b>Role</b></div>
							<div class="text-left mb-3 col-md-3"><b>Join Date</b></div>
							<div class="text-left mb-3 col-md-3"><b>Gender</b></div>
							<div class="text-left mb-3 col-md-3"><b>Date of Birth</b></div>
						</div>
						<div class="row">
							<div class="text-left mb-3 col-md-3"><?php echo $user->role_id ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->created_date ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->gender ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->dob ?></div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="box text-center" >

							<img src="<?php echo base_url($user->image); ?>" height="160" width="160">
							<button type="button" class="btn" style="margin-top:10px;">Edit Image</button>

					</div>
				</div>
			</div>
			<br>
			<br>

		</div>
	</div>
<?php echo $footer; ?>
	<script type="text/javascript">

    $(document).ready(function(){
		
		
	});	
	</script>
</body>
</html>
