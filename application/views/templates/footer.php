<br><br><br>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap.notify.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/select2.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/tinymce/tinymce.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/datatables.min.js'); ?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/js/jquery.ui.widget.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/fileupload/js/jquery.iframe-transport.js'); ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/js/fileupload/js/jquery.fileupload.js'); ?>"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url('assets/js/fileupload/js/jquery.fileupload-process.js'); ?>"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url('assets/js/fileupload/js/jquery.fileupload-validate.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/xu-validation.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/scripts.js'); ?>" type="text/javascript"></script>

<script>
$(".download").click(function(){
	var obj = $(this);
	var type = obj.data('type');
	var course_id = obj.data('courseid');
	obj.html('Please wait...');
	$.ajax({
		url:'<?php echo base_url('admin/download_excel'); ?>',
		type:'POST',
		data: {'type':type,'course_id':course_id},
		dataType:'TEXT'
	}).done(function(data){
		if(data != 0){
			window.location=data;
		}else{			
			$.notify({ message: 'Error in downloading, Please try again later'},{type: 'danger'});
		}
		obj.html('Download');
	});
});
</script>