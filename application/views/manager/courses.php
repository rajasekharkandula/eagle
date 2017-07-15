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
					<!-- <div class="col-md-2">
						<div class="page-actions text-right">
							<a href="<?php echo base_url('admin/user'); ?>" class="btn"><i class="fa fa-plus"></i> Add new user</a>
						</div>
					</div>--> 
					
				</div>
				<div class="row">
						<div class="col-md-3">
							<div class="box">
								<ul>
									<li><b>Course Categories</b></li>
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
						<a href="<?php echo base_url('admin/course_view/'.$c->id); ?>">
							<img src="<?php echo base_url($c->image); ?>">
							<div class="title"><?php echo $c->name; ?></div>
							<div class="sub-title"><?php echo $c->category_name; ?></div>
						</a>
						
					</div>
				</div>
				<?php } ?>
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
			//alert(categories);
			$.ajax({
				url:'<?php echo base_url(); ?>manager/course_search',
				type:'POST',
				dataType:'JSON',
				data:{'categories':categories,'searchkey':$('#searchkey').val()}
			}).done(function(data){
				var coursehtml='';
				for(var i=0;i<data.length;i++){
				
				coursehtml+='<div class="col-md-4">'+
					'<div class="c-box">'+
						'<a href="<?php echo base_url(); ?>manager/coursview/'+data[i]['id']+'">'+
							'<img src="<?php echo base_url(); ?>'+data[i]['image']+'">'+
							'<div class="title">'+data[i]['name']+'</div>'+
							'<div class="sub-title">'+data[i]['category_name']+'</div>'+
						'</a>'+
						
					'</div>'+
				'</div>';
			}
			$("#courses_list").html(coursehtml);
			});
		}
	</script>
	</body>
</html>