<div class="form-sidebar">
	<ul>
		<li>
			<a href="<?php echo base_url("admin/courses"); ?>"><i class="fa fa-arrow-left"></i> <span class="hidden-xs"> Back</span></a>
		</li>
		<li class="<?php if($page == 'basic')echo 'active';?>">
			<a href="<?php echo base_url("admin/elearning/basic/$id"); ?>"><i class="fa fa-info-circle"></i> <span class="hidden-xs">Basic Details</span></a>
		</li>
		<li class="<?php if($page == 'content' || $page == 'chapters' || $page == 'chapter')echo 'active';?>">
			<a href="<?php echo base_url("admin/elearning/content/$id"); ?>"><i class="fa fa-globe"></i> <span class="hidden-xs">Content</span></a>
		</li>
		<li class="<?php if($page == 'publish')echo 'active';?>">
			<a href="<?php echo base_url("admin/elearning/publish/$id"); ?>"><i class="fa fa-globe"></i> <span class="hidden-xs">Publish</span></a>
		</li>
	</ul>
</div>