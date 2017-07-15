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
				<div class="col-md-10">
					<div class="box">
						<div class="row">
							<div class="text-left mb-3 col-md-3"><b>Employee ID</b></div>
							<div class="text-left mb-3 col-md-3"><b>Designation</b></div>
							<div class="text-left mb-3 col-md-3"><b>Email</b></div>
							<div class="text-left mb-3 col-md-3"><b>Username</b></div>
						</div>
						<div class="row">
							<div class="text-left mb-3 col-md-3"><?php echo $user->uid ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->designation ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->email ?></div>
							<div class="text-left mb-3 col-md-3"><?php echo $user->username ?></div>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="box text-center" >
						<img src="<?php echo base_url($user->image); ?>" height="60" width="60">
					</div>
				</div>
			</div>
			<br>
			<br>
				<div class="box">
				<div class="container">
				  <h2 class="page-title">Courses</h2>
				  <p>To make the tabs toggleable, add the data-toggle="tab" attribute to each link. Then add a .tab-pane class with a unique ID for every tab and wrap them inside a div element with class .tab-content.</p>

				  <ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#home">Home</a></li>
					<li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
					<li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
					<li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
				  </ul>

					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">
							<h3>HOME</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
						<div id="menu1" class="tab-pane fade">
							<h3>Menu 1</h3>
							<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
						</div>
						<div id="menu2" class="tab-pane fade">
							<h3>Menu 2</h3>
							<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
						</div>
						<div id="menu3" class="tab-pane fade">
							<h3>Menu 3</h3>
							<p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
						</div>
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
