<header>
	<nav class="top">
		<div class="container">
			<a class="logo" href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url('assets/images/logo.png'); ?>">
			</a>
			<ul class="ls">
				<li>
					<a href="#" data-toggle="dropdown">
						<i class="fa fa-bell"></i>
						<span class="count hide">0</span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right nt">
						
						<?php foreach($data['notifications'] as $n){ ?>
						<li>
							<img src="<?php echo base_url($n->image); ?>">
							<div class="content">
								<div><?php echo $n->subject; ?></div>
								<div class="time"><i class="fa fa-clock-o"></i> <?php echo date('d M,y h:i A', strtotime($n->created_date)); ?></div>
							</div>
						</li>
						<?php } ?>
						<?php if(count($data['notifications']) == 0){ ?>
						<li>No messages</li>
						<?php } ?>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown">
						<img src="<?php if(file_exists($this->session->userdata('profile_pic'))) echo base_url($this->session->userdata('profile_pic')); else echo base_url('assets/images/user.jpg'); ?>">
						<i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li class="uname"><?php echo $this->session->userdata('user_name'); ?></li>
						<li><a href="<?php echo base_url('home/profile')?>"><i class="fa fa-user"></i> Profile</a></li>
						<li><a href="<?php echo base_url('home/changepassword')?>"><i class="fa fa-user"></i> Change Password</a></li>
						<li><a href="<?php echo base_url('home/logout'); ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
					</ul>
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
						<li><a href="<?php echo base_url();?>admin/departments">Departments</a></li>
						<li><a href="<?php echo base_url();?>admin/designations">Designations</a></li>
						<li><a href="<?php echo base_url();?>admin/users">Users</a></li>
						<li><a href="<?php echo base_url();?>admin/groups">Groups</a></li>
						<li><a href="<?php echo base_url();?>admin/send_notification">Send Notifications</a></li>
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
				<li class="dropdown <?php if($page == 'MYCOURSE')echo 'active'; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Courses</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url('user/mycourses');?>">My Courses</a></li>
						<li><a href="<?php echo base_url('user/recommended');?>">Recommended Courses</a></li>
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
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url();?>manager/users">My Team</a></li>
						<li><a href="<?php echo base_url();?>manager/trainers">Trainers</a></li>
						<li><a href="<?php echo base_url();?>admin/courses">Courses</a></li>
						<li><a href="<?php echo base_url();?>admin/groups">Groups</a></li>
					</ul>
				</li>
				<li class="dropdown <?php if($page == 'MYCOURSE')echo 'active'; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Courses</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url('user/mycourses');?>">My Courses</a></li>
						<li><a href="<?php echo base_url('user/recommended');?>">Recommended Courses</a></li>
					</ul>
				</li>
             </ul>
		</div>
    </nav>
	<?php } ?>
	
	<?php if($this->session->userdata("role_name") == $this->config->item("user_role")){ ?>
	<nav class="nav">
		<div class="container">
			<ul class="header-menu">				
				<li class="<?php if($page == 'DASHBOARD')echo 'active'; ?>"><a href="<?php echo base_url('user');?>">Dashboard</a></li>
				<li class="dropdown <?php if($page == 'COURSE')echo 'active'; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Courses</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url('user/mycourses');?>">My Courses</a></li>
						<li><a href="<?php echo base_url('user/recommended');?>">Recommended Courses</a></li>
						<li><a href="<?php echo base_url('user/reports');?>">Reports</a></li>
					</ul>
				</li>
             </ul>
		</div>
    </nav>
	<?php } ?>
	<?php if($this->session->userdata("role_name") == $this->config->item("trainer_role")){ ?>
	<nav class="nav">
		<div class="container">
			<ul class="header-menu">				
				<li class="<?php if($page == 'DASHBOARD')echo 'active'; ?>"><a href="<?php echo base_url('trainer');?>">Dashboard</a></li>
				<li class="dropdown <?php if($page == 'COURSE')echo 'active'; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Course</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url();?>admin/course_categories">Course Category</a></li>
						<li><a href="<?php echo base_url();?>admin/courses">Course List</a></li>
						<li><a href="<?php echo base_url();?>admin/assessments">Assessments</a></li>
					</ul>
				</li>
				<li class="dropdown <?php if($page == 'COURSE')echo 'active'; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Courses</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url('user/mycourses');?>">My Courses</a></li>
						<li><a href="<?php echo base_url('user/recommended');?>">Recommended Courses</a></li>				
					</ul>
				</li>
             </ul>
		</div>
    </nav>
	<?php } ?>
	

</header>