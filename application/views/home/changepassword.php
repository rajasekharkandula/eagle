<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<h2 class="page-title">Change Password: <?php echo $user->first_name.' '.$user->last_name; ?></h2>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="box">
						<div class="row">
							<label class="col-md-4">Current Password <span>*</span></label>
							<div class="col-md-8"><input type="password" id="cpwd" placeholder="Enter current password"></div>
						</div>
						
						<div class="row mt-10">
							<label class="col-md-4">New Password <span>*</span></label>
							<div class="col-md-8"><input type="password" id="npwd" placeholder="Enter New password"></div>
						</div>
						
						<div class="row mt-10">
							<label class="col-md-4">Confirm Password <span>*</span></label>
							<div class="col-md-8"><input type="password" id="rpwd" placeholder="Retype password"></div>
						</div>
						
						<div class="row mt-10">
							<div class="col-md-12 text-center"><button class="btn" id="submit_pwd">Change Password</button></div>
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
	$("#submit_pwd").on("click",function(){
		var cpwd = $("#cpwd").val();
		var npwd = $("#npwd").val();
		var rpwd = $("#rpwd").val();
		var regularExpression  = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; 
		var err=0;
		$(".text-danger").remove();
		$("input[type=password]").each(function(){
			var obj=$(this);
			if(obj.val()==""){
				err++;
				obj.parent().append('<div class="text-danger">This field is required</div>');
			}else if (!regularExpression.test(obj.val())) {
				err++;
				obj.parent().append('<div class="text-danger">Rule: Minimum eight characters, at least one letter and one number.</div>');
			}
		});
		if(npwd!=rpwd && err==0){
			err++;
			$("#rpwd").parent().append('<div class="text-danger">Password mismatch.</div>');
		}
		
		if (err==0){
			$('#submit_pwd').attr("disabled",true);
			$('#submit_pwd').html('<i class="fa fa-refresh spin"></i> Please wait...');
			$.ajax({
				url:'<?php echo base_url('admin/ins_upd_user'); ?>',
				data:{'type':'CHANGEPASSWORD','password':cpwd,'newpassword':npwd},
				type:'POST',
				dataType:'JSON'
			}).done(function(data){
				if(data.status == 1){
					$.notify({ message: data.message},{type: 'success'});
					window.location.reload();
				}
				else{
					$('#submit_pwd').removeAttr("disabled");
					$('#submit_pwd').html('Change password');
					$.notify({ message: data.message},{type: 'danger'});
				}
			});
		}
	})
	</script>
</body>
</html>
