<div class="form-sidebar">
	<ul>
		<li>
			<a href="<?php echo base_url("admin/courses"); ?>"><i class="fa fa-arrow-left"></i> <span class="hidden-xs"> Back</span></a>
		</li>
		<li class="<?php if($page == 'basic')echo 'active';?>">
			<a href="<?php echo base_url("admin/course/basic/$id"); ?>"><i class="fa fa-info-circle"></i> <span class="hidden-xs">Basic Details</span></a>
		</li>
		<li class="<?php if($page == 'overview')echo 'active';?>">
			<a href="<?php echo base_url("admin/course/overview/$id"); ?>"><i class="fa fa-globe"></i> <span class="hidden-xs">Overview</span></a>
		</li>
		<li class="<?php if($page == 'content')echo 'active';?>">
			<a href="<?php echo base_url("admin/course/content/$id"); ?>"><i class="fa fa-files-o"></i> <span class="hidden-xs">Content</span></a>
		</li>
		<li class="<?php if($page == 'publish')echo 'active';?>">
			<a href="<?php echo base_url("admin/course/publish/$id"); ?>"><i class="fa fa-sign-out"></i> <span class="hidden-xs">Publish</span></a>
		</li>
	</ul>
</div>