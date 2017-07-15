<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">Assigning Course - <?php echo $course->name; ?></h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-9">
					<div class="box">
						<div class="text-right mb-5">Fields marked with (*) are mandatory</div>
						<form id="category_form">
							<div class="row assign-lbl">
								<div class="col-md-3 text-right">Course Type </div>
								<div class="col-md-2">
									<input type="radio" name="course_type" value="Mandatory" checked> Mandatory
								</div>
								<div class="col-md-3">
									<input type="radio" name="course_type" value="Recommended"> Recommended
								</div>
							</div>	
							<div class="row assign-lbl assign_type">
								<div class="col-md-3 text-right">Assign to a </div>
								<div class="col-md-2">
									<input type="checkbox" name="assign_type" value="DESIGNATION" target="#section_1"> Designation
								</div>
								<div class="col-md-2">
									<input type="checkbox" name="assign_type" value="GROUP" target="#section_2"> Group
								</div>
								<div class="col-md-2">
									<input type="checkbox" name="assign_type" value="USER" target="#section_3"> Specific User
								</div>
							</div>	
							<div class="hide" id="section_1">
								<div class="row mb-15">
									<label class="col-md-3">Designations <span>*</span></label>
									<div class="col-md-6">
										<select class="select2" id="designations" data-placeholder="Select designation...">
											<option></option>
											<?php foreach($designations as $d){ ?>
											<option value="<?php echo $d->id; ?>"><?php echo $d->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="hide" id="designation_list">
									<table class="table table-bordered">
										<thead>
										  <tr>
											<th>Employee ID</th>
											<th>Name</th>
											<th>Email</th>
											<th>Designation</th>
										  </tr>
										</thead>
										<tbody id="designation_body">
										  
										</tbody>
									</table>
								</div>
							</div>
							<div class="hide" id="section_2">
								<div class="row mb-15">
									<label class="col-md-3">Groups <span>*</span></label>
									<div class="col-md-6">
										<select class="select2" id="groups" data-placeholder="Select group...">
											<option></option>
											<?php foreach($groups as $g){ ?>
											<option value="<?php echo $g->id; ?>"><?php echo $g->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="hide" id="users_list">
									<table class="table table-bordered">
										<thead>
										  <tr>
											<th>Employee ID</th>
											<th>Name</th>
											<th>Email</th>
											<th>Designation</th>
										  </tr>
										</thead>
										<tbody id="users_body">
										  
										</tbody>
									</table>
								</div>
							</div>
							<div class="box hide" id="section_3">
								<table class="table table-bordered dataTable">
									<thead>
									  <tr>
										<th>Select</th>
										<th>Employee ID</th>
										<th>Name</th>
										<th>Email</th>
										<th>Designation</th>
									  </tr>
									</thead>
									<tbody>
									  <?php foreach($users as $u){ ?>
									  <tr>
										<td class="text-center"><input type="checkbox" class="susers" value="<?php echo $u->id; ?>"></td>
										<td><?php echo $u->uid; ?></td>
										<td><?php echo $u->first_name.' '.$u->last_name; ?></td>
										<td><?php echo $u->email; ?></td>
										<td><?php echo $u->designation; ?></td>
									  </tr>
									  <?php } ?>
									</tbody>
								</table>
							</div>
							<div class="text-center mb-20">
								<button class="btn" type="button" id="submit_btn">Assign</button>
								<a href="<?php echo base_url('admin/courses'); ?>" class="btn">Cancel</a>
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
		$(".select").select2({
			'width':'100%'
		});
	});	
	$(".assign_type input").on('change',function(){
		$("#section_1,#section_2,#section_3").addClass("hide");		
		var th = $(this), name = th.attr('name'); 
		if(th.is(':checked')){
		 $(':checkbox[name="'  + name + '"]').not(th).prop('checked',false);   
		}
		var section = $(".assign_type input:checked").attr('target');
		$(section).removeClass("hide");
	});
	$("#groups").on('change',function(){
		$("#users_list").addClass("hide");
		$.ajax({
			url:'<?php echo base_url('admin/get_group'); ?>',
			type:'POST',
			data: {'type':'GROUP_USERS','id':$(this).val()},
			dataType:'JSON'
		}).done(function(data){
			var html = '';
			for(var i=0;i<data.length;i++){
				html+='<tr>'+
				'<td>'+data[i]['uid']+'</td>'+
				'<td>'+data[i]['first_name']+'</td>'+
				'<td>'+data[i]['email']+'</td>'+
				'<td>'+data[i]['designation']+'</td>'+
				'</tr>';
			}
			$("#users_body").html(html);
			$("#users_list").removeClass("hide");
		});
	})
	$("#designations").on('change',function(){
		$("#designation_list").addClass("hide");
		$.ajax({
			url:'<?php echo base_url('admin/get_designation'); ?>',
			type:'POST',
			data: {'type':'USERS','id':$(this).val()},
			dataType:'JSON'
		}).done(function(data){
			var html = '';
			for(var i=0;i<data.length;i++){
				html+='<tr>'+
				'<td>'+data[i]['uid']+'</td>'+
				'<td>'+data[i]['first_name']+'</td>'+
				'<td>'+data[i]['email']+'</td>'+
				'<td>'+data[i]['designation']+'</td>'+
				'</tr>';
			}
			$("#designation_body").html(html);
			$("#designation_list").removeClass("hide");
		});
	})
	
	$('#submit_btn').on('click',function(){
		var assign_type = $(".assign_type input:checked").val();
		var course_type = $("input[name=course_type]:checked").val();
		var error=0;$(".text-danger").remove();
		var course_id = parseInt(<?php echo $course->id; ?>);
		var users = [];
		$(".susers:checked").each(function(){
			users.push($(this).val());
		});
		if(assign_type == 'DESIGNATION' && $("#designations").val() == ''){
			error++;
			$("#designations").parent().append('<div class="text-danger">This field is required</div>');
		}
		if(assign_type == 'GROUP' && $("#groups").val() == ''){
			error++;
			$("#groups").parent().append('<div class="text-danger">This field is required</div>');
		}
		if(assign_type == 'USER' && users.length == 0){
			error++;
			$.notify({ message: 'Please select atleast one user'},{type: 'danger'});
		}
		if(error ==0){
			$('#submit_btn').attr("disabled",true);
			$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
			$.ajax({
				url:'<?php echo base_url('admin/assign_course'); ?>',
				type:'POST',
				data: {'assign_type':assign_type,'course_type':course_type,'course_id':course_id,'group_id':$("#groups").val(),'designation_id':$("#designations").val(),'users':users},
				dataType:'JSON'
			}).done(function(data){
				if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/course_users/'.$course->id); ?>';
			}
			else{
				$('#submit_btn').removeAttr("disabled");
				$('#submit_btn').html('Assign');
				$('.disable_div').remove();
				$.notify({ message: data.message},{type: 'danger'});
			}
			});
		}
	});
	</script>
</body>
</html>