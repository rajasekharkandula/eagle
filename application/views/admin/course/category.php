<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">Course Category Configuration</h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-9">
					<div class="box">
						<div class="text-right mb-5">Fields marked with (*) are mandatory</div>
						<form id="category_form">
							<div class="row mb-15">
								<label class="col-md-3">Name <span>*</span></label>
								<div class="col-md-6">
									<input type="text" va_req="true" name="name" placeholder="Enter category name" value="<?php if(isset($category->name))echo $category->name; ?>">
								</div>
							</div>							
							<div class="text-center mb-20">
								<button class="btn" type="button" id="submit_btn">Submit</button>
								<a href="<?php echo base_url('admin/course_categories'); ?>" class="btn">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">

    $(document).ready(function(){
		
		
	});	
	function save_details(){
		$('#submit_btn').attr("disabled",true);
		$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		
		var formData = new FormData($("#category_form")[0]);
		<?php if(isset($category->id)){ ?>
		formData.append('type','UPDATE');
		formData.append('id','<?php echo $category->id;?>');
		<?php }else{ ?>
		formData.append('type','INSERT');
		<?php } ?>
		
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_course_category'); ?>',
			type:'POST',
			data: formData,
			dataType:'JSON',
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/course_categories'); ?>';
			}
			else{
				$('#submit_btn').removeAttr("disabled");
				$('#submit_btn').html('Submit');
				$.notify({ message: data.message},{type: 'danger'});
			}
		});
	}
	$('#submit_btn').on('click',function(){
		xu_validation.form_submit('#category_form','save_details');
	});
	</script>
</body>
</html>