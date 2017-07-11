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
						<li class="uname"><?php echo $this->session->userdata('user_name'); ?></li>
						<li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
						<li><a href="<?php echo base_url('home/logout'); ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
					<ul>
				</li>
			</ul>
		</div>
	</nav>
	
	<?php if($this->session->userdata("role_name") == $this->config->item("admin_role")){ ?>
	<nav class="nav">
		<div class="container">
			<ul class="header-menu">				
				<li class="<?php if($page == 'DASHBOARD')echo 'active'; ?>"><a href="<?php echo base_url();?>">Dashboard</a></li>
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
             </ul>
		</div>
    </nav>
	<?php } ?>
	
	<?php if($this->session->userdata("role_name") == $this->config->item("manager_role")){ ?>
	<nav class="nav">
		<div class="container">
			<ul class="header-menu">				
				<li class="<?php if($page == 'DASHBOARD')echo 'active'; ?>"><a href="<?php echo base_url();?>">Dashboard</a></li>
                <li class="dropdown <?php if($page == 'MANAGE')echo 'active'; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Team</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url();?>manager/users">Team List</a></li>
					</ul>
				</li>
             </ul>
		</div>
    </nav>
	<?php } ?>
	

</header>