<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title"><?php echo $course->name; ?> - Session Configuration</h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-9">
					<div class="box">
						<div class="text-right mb-5">Fields marked with (*) are mandatory</div>
						<form id="session_form">
							<div class="row mb-15">
								<label class="col-md-3">Session Name <span>*</span></label>
								<div class="col-md-6">
									<input type="text" va_req="true" name="name" placeholder="Enter session name" value="<?php if(isset($session->name))echo $session->name; ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">Start Date <span>*</span></label>
								<div class="col-md-6">
									<input type="date" va_req="true" name="start_date" value="<?php if(isset($session->start_date))echo date('Y-m-d',strtotime($session->start_date)); ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-3">End Date <span>*</span></label>
								<div class="col-md-6">
									<input type="date" va_req="true" name="end_date" value="<?php if(isset($session->end_date))echo date('Y-m-d',strtotime($session->end_date)); ?>">
								</div>
							</div>							
							<div class="text-center mb-20">
								<button class="btn" type="button" id="submit_btn">Submit</button>
								<a href="<?php echo base_url('admin/course_sessions/'.$course->id); ?>" class="btn">Cancel</a>
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
		
		var formData = new FormData($("#session_form")[0]);
		formData.append('id','<?php echo $course->id;?>');
		<?php if(isset($session->id)){ ?>
		formData.append('type','SESSION_UPDATE');
		formData.append('session_id','<?php echo $session->id;?>');
		<?php }else{ ?>
		formData.append('type','SESSION_INSERT');
		<?php } ?>
		
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_course'); ?>',
			type:'POST',
			data: formData,
			dataType:'JSON',
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/course_sessions/'.$course->id); ?>';
			}
			else{
				$('#submit_btn').removeAttr("disabled");
				$('#submit_btn').html('Submit');
				$('.disable_div').remove();
				$.notify({ message: data.message},{type: 'danger'});
			}
		});
	}
	$('#submit_btn').on('click',function(){
		xu_validation.form_submit('#session_form','save_details');
	});
	</script>
</body>
</html>