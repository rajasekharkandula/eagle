<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body style="background-image: url('<?php echo base_url('assets/images/backgrounds/login.jpg'); ?>');background-size: cover;">
	<?php //echo $header; ?>
	
	<div class="login-section">
		<img src="<?php echo base_url('assets/images/logo.png'); ?>">
		<input type="text" name="email" id="email" placeholder="Enter username or email">
		<input type="password" name="password" id="password" placeholder="Enter password">
		<button type="button" id="login_btn">Login</button>
	</div>
	
	<?php echo $footer; ?>
	<script type="text/javascript">

    $(document).ready(function(){
		
		$('#login_btn').on('click',function(){
			var error = 0;$(".text-danger").remove();
			if($("#email").val().trim() == ''){
				error++;
				$('<div class="text-danger">This field is required</div>').insertAfter("#email");
			}
			if($("#password").val().trim() == ''){
				error++;
				$('<div class="text-danger">This field is required</div>').insertAfter("#password");
			}
			if(error == 0){
				$('#login_btn').attr("disabled",true);
				$('#login_btn').html('<i class="fa fa-refresh spin"></i> Please wait...');
				$.ajax({
					url:'<?php echo base_url('home/login'); ?>',
					data:{'email':$("#email").val(),'password':$("#password").val()},
					type:'POST',
					dataType:'JSON'
				}).done(function(data){
					if(data.status == 1){
						$.notify({ message: data.message},{type: 'success'});
						window.location.reload();
					}
					else{
						$('#login_btn').removeAttr("disabled");
						$('#login_btn').html('Login');
						$.notify({ message: data.message},{type: 'danger'});
					}
				});
			}			
		});
	});	
	</script>
</body>
</html>