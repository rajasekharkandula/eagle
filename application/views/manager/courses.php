<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
	<body>
		<?php echo $header; ?>
		<div class="body-content">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h2 class="page-title">List of Courses</h2>
					</div>
					<div class="col-md-6">
						<div class="page-actions">
							<input type="text" placeholder="Search..." id='searchkey'>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="box sidebar">
							<ul style="list-style-type:none;padding-left:0px;">
								<li><b>Categories</b></li>
								<?php foreach ($course_cat as $cc)
									echo "<li> <input type='checkbox' class='categories' style='height:15px;width:15px' value='" .$cc->id . "'>" . $cc->name ."</li>";
								?>
							</ul>
						</div>
					</div>
					<div class="col-md-9">
						<div class="box">
							<div class="row" id="courses_list">
								<?php foreach($courses as $c){ ?>
								<div class="col-md-4">
									<div class="c-box">
										<a href="<?php echo base_url('home/course_view/'.$c->id); ?>">
											<img src="<?php echo base_url($c->image); ?>">
											<div class="title"><?php echo $c->name; ?></div>
											<div class="sub-title"><?php echo $c->category_name; ?></div>
										</a>
										<div class="sb">
											<a href="<?php echo base_url('admin/course_assign/'.$c->id); ?>">Assign</a>
										</div>
										<div class="sb">
											<a href="<?php echo base_url('admin/course_users/'.$c->id); ?>">Users</a>
										</div>
									</div>
								</div>
								<?php } ?>
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
	$("#searchkey").on('keyup',function(){
		search();
		
	});
	$(".categories").on('change',function(){
			 search();
		});
		function search()
		{
			var categories=[];
			$('.categories:checked').each(function() {
				categories.push($(this).val());
			});
			$.ajax({
				url:'<?php echo base_url(); ?>manager/course_search',
				type:'POST',
				dataType:'JSON',
				data:{'categories':categories,'searchkey':$('#searchkey').val()}
			}).done(function(data){
				var coursehtml='';
				if(data.length > 0){
					for(var i=0;i<data.length;i++){				
						coursehtml+='<div class="col-md-4">'+
							'<div class="c-box">'+
								'<a href="<?php echo base_url(); ?>home/course_view/'+data[i]['id']+'">'+
									'<img src="<?php echo base_url(); ?>'+data[i]['image']+'">'+
									'<div class="title">'+data[i]['name']+'</div>'+
									'<div class="sub-title">'+data[i]['category_name']+'</div>'+
								'</a>'+
								'<div class="sb">'+
									'<a href="<?php echo base_url('admin/course_assign'); ?>/'+data[i]['id']+'">Assign</a>'+
								'</div>'+
								'<div class="sb">'+
									'<a href="<?php echo base_url('admin/course_users'); ?>/'+data[i]['id']+'">Users</a>'+
								'</div>'+
							'</div>'+
						'</div>';
					}
				}else{
					coursehtml = '<h5 style="padding-left:25px;">No products found</h5>';
				}
				$("#courses_list").html(coursehtml);
			});
		}
	</script>
	</body>
</html>