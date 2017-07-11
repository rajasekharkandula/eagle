<header>
	<nav class="top">
		<div class="container">
			<a class="logo" href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url('assets/images/logo.png'); ?>">
			</a>
			<ul class="ls">
				<li>
					<a href="#">
						<i class="fa fa-bell"></i>
						<span class="count">0</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown">
						<img src="<?php echo base_url('assets/images/user.jpg'); ?>">
						<i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><?php echo $this->session->userdata('user_name'); ?></li>
						<li><a href="#">Profile</a></li>
						<li><a href="<?php echo base_url('home/logout'); ?>">Logout</a></li>
					<ul>
				</li>
			</ul>
		</div>
	</nav>
	<nav class="nav">
		<div class="container">
			<ul class="header-menu">				
				<li class="<?php if($page == 'DASHBOARD')echo 'active'; ?>"><a href="<?php echo base_url();?>learner/dashboard">Dashboard</a></li>
                <li class="dropdown <?php if($page == 'MANAGE')echo 'active'; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url();?>admin/users">Users</a></li>
						<li><a href="<?php echo base_url();?>admin/designations">Designations</a></li>
						<li><a href="<?php echo base_url();?>admin/skills">Skills</a></li>
					</ul>
				</li>
				<li class="dropdown <?php if($page == 'COURSE')echo 'active'; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Course</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url();?>admin/course_categories">Course Category</a></li>
						<li><a href="<?php echo base_url();?>admin/courses">Course List</a></li>
						<li><a href="<?php echo base_url();?>admin/assessments">Assessments</a></li>
					</ul>
				</li>
                <!--li class="dropdown <?php if($page == 'GAME')echo 'active'; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Games</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url();?>learner/games">My Games</a></li>
						<li><a href="<?php echo base_url();?>learner/games/mandatory">Mandatory Games</a></li>
						<li><a href="<?php echo base_url();?>learner/games/recommended">Recommended Games</a></li>
					</ul>
				</li-->				
			</ul>
		</div>
    </nav>

</header>