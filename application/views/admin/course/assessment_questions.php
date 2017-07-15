<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">Assessment Configuration - <?php echo $assessment->name; ?></h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-9">
					<div class="box">
						<form id="assessment_form" onSubmit="return false;">
							
							<div id="questions">
								<?php foreach($questions as $key=>$q){ ?>
								<div class="box question" data-id="<?php echo ++$key; ?>" >
									<div class="row">
										<div class="col-md-9">
											<label class="qno"><?php echo $key; ?>. Question</label>
											<div>
											<textarea va_req="true" name="question" placeholder="Enter question..."><?php echo $q->question; ?></textarea>
											</div>
											<ul>
												<?php foreach($options as $o){ if($o->question_id == $q->id){ ?>
												<li><input type="<?php if($assessment->question_type == 'Single Choice')echo 'radio';else echo 'checkbox';?>" name="answer<?php echo $key; ?>" <?php if($o->correct == 1)echo 'checked'; ?>> <textarea name="option" placeholder="Enter option..." va_req="true"><?php echo $o->options; ?></textarea><i class="fa fa-times remove_option"></i></li>
												<?php } } ?>
											</ul>
										</div>
										<div class="col-md-3">
											<label>Question Type</label>
											<input type="text" name="qtype" value="<?php echo $assessment->question_type; ?>" readonly>
											<label>Marks</label>
											<input type="number" name="marks" va_req="true" placeholder="Enter marks..."  value="<?php echo $assessment->mark_per_question; ?>">
											<button class="btn btn-sm mt-10 add_option" data-id="<?php echo $key; ?>" data-type="<?php echo $assessment->question_type; ?>"><i class="fa fa-plus"></i> Add Option</button>
										</div>
									</div>
									<div class="q_remove"><i class="fa fa-trash"></i> Remove</div>
								</div>
								<?php } ?>
							</div>
							<div class="row">
								<div class="col-md-9">
									<button class="btn btn-sm" id="add_question"><i class="fa fa-plus"></i> Add Question</button>
								</div>
							</div>
							
							<div class="text-center mb-20">
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
	$(document).on('click','.add_option',function(){
		var id = $(this).data("id");
		if($(this).data("type") == 'Multiple Choice')
			$("div[data-id="+id+"].question ul").append('<li><input type="checkbox" name="answer'+id+'"> <textarea name="option" placeholder="Enter option..."></textarea><i class="fa fa-times remove_option"></i></li>');
		else
			$("div[data-id="+id+"].question ul").append('<li><input type="radio" name="answer'+id+'"> <textarea name="option" placeholder="Enter option..."></textarea><i class="fa fa-times remove_option"></i></li>');
	});
	$(document).on('click','.remove_option,.q_remove',function(){
		$(this).parent().remove();
		var i = 1;
		$(".question").each(function(){
			$(this).find(".qno").html(i+'. Question');
			i++;
		});
	});
	$('#add_question').on('click',function(){
		$('#add_question').attr("disabled",true);
		$('#add_question').html('<i class="fa fa-refresh spin"></i> Please wait...');
		$.ajax({
			url:'<?php echo base_url('admin/get_question_template'); ?>',
			type:'POST',
			data: {'qtype':'<?php echo $assessment->question_type; ?>','marks':'<?php echo $assessment->mark_per_question; ?>','i':parseInt($("#questions .question").length+1)},
			dataType:'HTML'
		}).done(function(data){
			$("#questions").append(data);
			$('#add_question').removeAttr("disabled");
			$('#add_question').html('<i class="fa fa-plus"></i> Add Question');
		});
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
	
	$('#submit_btn').on('click',function(){
		var error = 0;$(".text-danger").remove();
		var questions = [],i=0;
		$(".question textarea").each(function(){
			var obj = $(this);
			if(obj.val().trim() == ""){
				error++;
				obj.parent().append('<div class="text-danger">This field is required</div>');
			}
		});
		$(".question").each(function(){
			var obj = $(this);
			var question = {},id=obj.data('id');			
			question['name'] = obj.find("textarea[name=question]").val().trim();
			question['marks'] = parseInt(obj.find("input[name=marks]").val());
			question['qtype'] = obj.find("input[name=qtype]").val();
			var options = [];
			obj.find("textarea[name=option]").each(function(){
				var obj2 = $(this);var option = {};
				option['name'] = obj2.val();
				if(obj2.parent().find("input[name=answer"+id+"]").is(":checked"))
					option['answer'] = 1;
				else
					option['answer'] = 0;
				options.push(option);
			});
			question['options'] = options;
			questions.push(question);
		});
		if(error == 0){
			$('#submit_btn').attr("disabled",true);
			$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
			
			$("#assessment_form").append('<div class="disable_div" style="position:absolute; top:0; left:0; width: 100%; height:100%; z-index:2; opacity:0.4; filter: alpha(opacity = 50); background-color:#949292;"><img style="position: absolute;top:45%;left:45%;width: 100px;" src="<?php echo base_url('assets/images/loader.gif'); ?>" /></div>');
			
			var formData = new FormData($("#assessment_form")[0]);
			formData.append('type','QUESTIONS');
			formData.append('id','<?php echo $assessment->id;?>');
			formData.append('questions',JSON.stringify(questions));
			
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
	});
	</script>
</body>
</html>