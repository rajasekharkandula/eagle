<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">Assessment Evaluation - <?php echo $assessment->name; ?></h2>
				</div>
			</div>			
			<div class="row">
				<div class="col-md-9">
					<div class="box">
						<form id="assessment_form" onSubmit="return false;">
							
							<div id="questions">
								<?php foreach($questions as $key=>$q){ ?>
								
								<div class="box question mb-10" data-id="<?php echo ++$key; ?>">
									<div class="row">
										<div class="col-md-9">
											<div><?php echo $key; ?>. <?php echo $q->question; ?></div>
											
											<div>
											<?php if(file_exists($q->video)){ ?>
											<a href="<?php echo base_url($q->video); ?>" class="btn btn-sm" target="_blank">View video</a>
											<?php } ?>
											
											<?php if(file_exists($q->image)){ ?>
											<a href="<?php echo base_url($q->image); ?>" class="btn btn-sm" target="_blank">View image</a>
											<?php } ?>
											
											<?php if(($q->question_type == 'Image' || $q->question_type == 'Video' || $q->question_type == 'Document') && file_exists($q->user_answer)){ ?>
												<label>Answer</label><br>
												<a href="<?php echo base_url($q->user_answer); ?>" class="btn btn-sm" target="_blank">View uploaded file</a>
											<?php } ?>
											<?php if($q->question_type == 'Text'){ ?>
												<textarea disabled><?php echo $q->user_answer; ?></textarea>
											<?php } ?>
											</div>
											<div class="pull-left">
												<ul>
													<?php $answers = json_decode($q->user_answer,true);	?>
													
													<?php foreach($options as $o){ if($o->question_id == $q->id){ ?>
													<li><input type="<?php if($q->question_type == 'Single Choice')echo 'radio';else echo 'checkbox';?>" name="answer<?php echo $key; ?>" <?php if(in_array($o->id,(array)$answers))echo 'checked';?> readonly> <?php echo $o->options; ?> <?php if($o->correct == 1)echo '<i class="fa fa-check text-success"></i>'; elseif(in_array($o->id,(array)$answers))echo '<i class="fa fa-times text-danger"></i>';?></li>
													<?php } } ?>
												</ul>
											</div>
										</div>
										<div class="col-md-3">
											<label>Total Marks</label>
											<div><?php echo $q->marks; ?></div>
											<label>Obtained Marks</label>
											<input type="number" class="omarks" data-qid="<?php echo $q->id; ?>" value="<?php echo $q->points; ?>">
										</div>										
									</div>
								</div>
							
							<?php } ?>
							</div>
							<div class="text-center mb-20">
								<button class="btn" type="button" id="submit_btn">Submit</button>
								<a href="<?php echo base_url('trainer/requests'); ?>" class="btn">Cancel</a>
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
	
	$('#submit_btn').on('click',function(){
		var error = 0;$(".text-danger").remove();
		var marks = [],i=0;
		$(".omarks").each(function(){
			var obj = $(this);
			if(obj.val() == ""){
				error++;
				obj.parent().append('<div class="text-danger">This field is required</div>');
			}else{
				var mark = [];
				mark[0]=obj.data("qid");
				mark[1]=parseInt(obj.val());
				marks.push(mark);
			}			
		});
		
		if(error == 0){
			$('#submit_btn').attr("disabled",true);
			$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
			
			$("#assessment_form").append('<div class="disable_div" style="position:absolute; top:0; left:0; width: 100%; height:100%; z-index:2; opacity:0.4; filter: alpha(opacity = 50); background-color:#949292;"><img style="position: absolute;top:45%;left:45%;width: 100px;" src="<?php echo base_url('assets/images/loader.gif'); ?>" /></div>');
			
			var formData = new FormData();
			formData.append('type','EVALUATION');
			formData.append('id','<?php echo $assessment->id;?>');
			formData.append('asmt_user_id','<?php echo $asmt_user_id;?>');
			formData.append('marks',JSON.stringify(marks));
			
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
					window.location='<?php echo base_url('trainer/requests'); ?>';
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