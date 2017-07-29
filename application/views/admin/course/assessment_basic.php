<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">Assessment Configuration</h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-9">
					<div class="box">
						<div class="text-right mb-5">Fields marked with (*) are mandatory</div>
						<form id="assessment_form">
							<div class="row mb-15">
								<label class="col-md-3">Name <span>*</span></label>
								<div class="col-md-8">
									<input type="text" va_req="true" name="name" placeholder="Enter name" value="<?php if(isset($assessment->name))echo $assessment->name; ?>">
								</div>
							</div>
							
							<div class="row mb-15">
								<label class="col-md-3">Question Type <span>*</span></label>
								<div class="col-md-8">
									<select class="select2" va_req="true" data-placeholder="Select question type" name="question_type">
										<option value=""></option>
										<?php foreach((array)$this->config->item('question_type') as $qt){ ?>
										<option <?php if(isset($assessment->question_type))if($assessment->question_type == $qt)echo 'selected'; ?>><?php echo $qt; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="row mb-15">
								<div class="col-md-3 text-right">Random Question </div>
								<div class="col-md-2">
									<input type="radio" name="random" value="Yes"  <?php if(isset($assessment->random)){if($assessment->random == 'Yes')echo 'checked';}else{echo 'checked';} ?>> Yes
								</div>
								<div class="col-md-2">
									<input type="radio" name="random" value="No" <?php if(isset($assessment->random))if($assessment->random == 'No')echo 'checked'; ?>> No
								</div>
							</div>	
							<div class="row mb-15">
								<div class="col-md-3 text-right">Mark Type </div>
								<div class="col-md-2">
									<input type="radio" name="mark_type" value="Fixed"  <?php if(isset($assessment->mark_type)){if($assessment->mark_type == 'Fixed')echo 'checked';}else{echo 'checked';} ?>> Fixed
								</div>
								<div class="col-md-2">
									<input type="radio" name="mark_type" value="Differ" <?php if(isset($assessment->mark_type))if($assessment->mark_type == 'Differ')echo 'checked'; ?>> Differ
								</div>
							</div>
							<div class="row mb-15" id="mark_per_question">
								<label class="col-md-3">Mark per question <span>*</span></label>
								<div class="col-md-8">
									<input type="number" va_req="true" name="mark_per_question" placeholder="Enter mark per question" value="<?php if(isset($assessment->mark_per_question))echo $assessment->mark_per_question; ?>">
								</div>
							</div>
							<div class="row mb-15" id="pass_marks">
								<label class="col-md-3">Pass Marks <span>*</span></label>
								<div class="col-md-8">
									<input type="number" va_req="true" name="pass_marks" placeholder="Enter pass marks" value="<?php if(isset($assessment->pass_marks))echo $assessment->pass_marks; ?>">
								</div>
							</div>
							<div class="row mb-15" id="display_questions">
								<label class="col-md-3">No. of questions to display <span>*</span></label>
								<div class="col-md-8">
									<input type="number" va_req="true" name="display_questions" placeholder="Enter No. of questions to display" value="<?php if(isset($assessment->display_questions))echo $assessment->display_questions; ?>">
								</div>
							</div>
							<div class="text-center mb-20">
								<?php if(isset($assessment->id)){ ?>
								<a href="<?php echo base_url('admin/assessment/questions/'.$assessment->id); ?>" class="btn">Questions</a>
								<?php } ?>
								<button class="btn" type="button" id="submit_btn">Submit</button>
								<a href="<?php echo base_url('admin/assessments'); ?>" class="btn">Cancel</a>
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
	$('input[name=mark_type]').on('change',function(){
		if($(this).val() == 'Fixed'){
			$("#mark_per_question").removeClass("hide");
			$("#mark_per_question input").attr("va_req","true");
		}
		else{
			$("#mark_per_question").addClass("hide");
			$("#mark_per_question input").removeAttr("va_req");
		}
			
	});	
	function save_details(){
		$('#submit_btn').attr("disabled",true);
		$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		
		var formData = new FormData($("#assessment_form")[0]);
		<?php if(isset($assessment->id)){ ?>
		formData.append('type','UPDATE_BASIC');
		formData.append('id','<?php echo $assessment->id;?>');
		<?php }else{ ?>
		formData.append('type','INSERT_BASIC');
		<?php } ?>
		
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_assessment'); ?>',
			type:'POST',
			data: formData,
			dataType:'JSON',
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/assessment/questions'); ?>/'+data.id;
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
		xu_validation.form_submit('#assessment_form','save_details');
	});
	</script>
</body>
</html>