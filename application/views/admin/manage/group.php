<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">Group Configuration</h2>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="box">
						<div class="text-right mb-5">Fields marked with (*) are mandatory</div>
						<form id="group_form">
							<div class="row mb-15">
								<label class="col-md-2">Group Name <span>*</span></label>
								<div class="col-md-6">
									<input type="text" va_req="true" name="name" placeholder="Enter group name" value="<?php if(isset($group->name))echo $group->name; ?>">
								</div>
							</div>
							<div class="row mb-15">
								<label class="col-md-2">Users <span>*</span></label>
								<div class="col-md-10">
									<a href="#" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" class="btn mb-10" >Add users</a>
									<br>
									<table class="table table-bordered">
										<thead>
										  <tr>
											<th>Employee ID</th>
											<th>Name</th>
											<th>Email</th>
											<th>Designation</th>
											<th>Remove</th>
										  </tr>
										</thead>
										<tbody id="group_users">
										  <?php foreach($group_users as $u){ ?>
										  <tr>
											<td><input type="hidden" name="users[]" value="<?php echo $u->id; ?>"><?php echo $u->uid; ?></td>
											<td><?php echo $u->first_name.' '.$u->last_name; ?></td>
											<td><?php echo $u->email; ?></td>
											<td><?php echo $u->designation; ?></td>
											<td><a href="#" class="btn remove_btn" data-id=="<?php echo $u->id; ?>"><i class="fa fa-trash"></i> Remove</a></td>
										  </tr>
										  <?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="text-center mb-20">
								<button class="btn" type="button" id="submit_btn">Submit</button>
								<a href="<?php echo base_url('admin/groups'); ?>" class="btn">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
			<h4 class="modal-title pull-left">Users</h4>
		  </div>
		  <div class="modal-body">
			<table class="table table-bordered">
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
					<td><input type="checkbox" class="group_users" data-name="<?php echo $u->first_name.' '.$u->last_name; ?>" data-uid="<?php echo $u->uid; ?>" data-email="<?php echo $u->email; ?>" data-designation="<?php echo $u->designation; ?>" value="<?php echo $u->id; ?>"></td>
					<td><?php echo $u->uid; ?></td>
					<td><?php echo $u->first_name.' '.$u->last_name; ?></td>
					<td><?php echo $u->email; ?></td>
					<td><?php echo $u->designation; ?></td>
				  </tr>
				  <?php } ?>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn" id="select_btn" data-dismiss="modal">Select</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">

    $(document).ready(function(){
		xu_validation.fileupload('<?php echo base_url();?>', '#image_upload', 'image', '<?php echo base_url('admin/upload_files/image');?>',/(\.|\/)(<?php foreach($this->config->item('ext_img') as $img_type){echo $img_type.'|';} ?>~~)$/i);		
	});	
	$('input[name=group_role]').on('change',function(){
	 var th = $(this), name = th.attr('name'); 
	 if(th.is(':checked')){
		 $(':checkbox[name="'  + name + '"]').not(th).prop('checked',false);   
	  }
	});	
	$(document).on('click','.remove_btn',function(e){
		e.preventDefault();
		var obj = $(this);
		var id = obj.data("id");
		$('.group_users').each(function(){
			var obj2 = $(this);
			if(obj2.val() == id)
				obj2.prop('checked',false);
		});
		obj.parents('tr').remove();
	});
	$('#select_btn').on('click',function(){
		var users = [];var html = '';
		$('.group_users').each(function(){
		 var th = $(this), name = th.attr('name'); 
		 if(th.is(':checked')){
			html+='<tr>'+
				'<td><input type="hidden" name="users[]" value="'+th.val()+'">'+th.data('uid')+'</td>'+
				'<td>'+th.data('name')+'</td>'+
				'<td>'+th.data('email')+'</td>'+
				'<td>'+th.data('designation')+'</td>'+
				'<td><a href="#" class="btn remove_btn" data-id="'+th.val()+'"><i class="fa fa-trash"></i> Remove</a></td>'+
			'</tr>';
		  }
		});	
		$("#group_users").html(html);
	});	
	function save_details(){
		$('#submit_btn').attr("disabled",true);
		$('#submit_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
		
		var formData = new FormData($("#group_form")[0]);
		<?php if(isset($group->id)){ ?>
		formData.append('type','UPDATE');
		formData.append('id','<?php echo $group->id;?>');
		<?php }else{ ?>
		formData.append('type','INSERT');
		<?php } ?>
		
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_group'); ?>',
			type:'POST',
			data: formData,
			dataType:'JSON',
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/groups'); ?>';
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
		xu_validation.form_submit('#group_form','save_details');
	});
	</script>
</body>
</html>