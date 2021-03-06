<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="page-title">List of Groups</h2>
				</div>
				<div class="col-md-4">
					
				</div>
				<div class="col-md-2">
					<div class="page-actions text-right">
						<a href="<?php echo base_url('admin/group'); ?>" class="btn"><i class="fa fa-plus"></i> Add new group</a>
					</div>
				</div>
			</div>
			<div class="box" id="dlist">
				<table class="table table-bordered dataTable">
					<thead>
					  <tr>
						<th>Name</th>
						<th>No. of users</th>
						<th>Created on</th>
						<th>Actions</th>
					  </tr>
					</thead>
					<tbody>
					  <?php foreach($groups as $g){ ?>
					  <tr>
						<td><?php echo $g->name; ?></td>
						<td><?php echo $g->users; ?></td>
						<td><?php echo date('d M Y H:i A',strtotime($g->created_date)); ?></td>
						<td><a href="<?php echo base_url('admin/group/'.$g->id); ?>" class="btn btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a><button class="btn btn-sm removeuser" data-id="<?php echo $g->id; ?>"><i class="fa fa-trash"></i> Remove</button></td>
					  </tr>
					  <?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<div id="myModal" class="modal fade alert" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <p>Confirm remove Group?</p>
      </div>
      <div class="text-center">
        <button type="button" class="btn btn-default" id="confirm-btn" data-dismiss="modal">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>
	<?php echo $footer; ?>
	<script type="text/javascript">

    $(document).ready(function(){
		
		
	});	
$(".removeuser").click(function(){
		var id=$(this).data("id");
		$("#confirm-btn").data("id",id);
		$("#myModal").modal("show");
		
	});
	$("#confirm-btn").click(function(){
		var id=$(this).data("id");
		$("#confirm-btn").attr("disabled",true);
		$("#myModal").modal("hide");
		$("#dlist").append('<div class="disable_div" style="position:absolute; top:0; left:0; width: 100%; height:100%; z-index:2; opacity:0.4; filter: alpha(opacity = 50); background-color:#949292;"><img style="position: absolute;top:45%;left:45%;width: 100px;" src="<?php echo base_url(); ?>assets/images/loader.gif" /></div>');
		$.ajax({
			url:'<?php echo base_url('admin/ins_upd_group'); ?>',
			type:'POST',
			data: {'type':'DELETE','id':id},
			dataType:'JSON'
		}).done(function(data){
			if(data.status == 1){
				$.notify({ message: data.message},{type: 'success'});
				window.location='<?php echo base_url('admin/groups'); ?>';
			}
			else{
				$('#submit_btn').removeAttr("disabled");
				$('#submit_btn').html('Submit');
				$.notify({ message: data.message},{type: 'danger'});
			}
		});
	});
	</script>
</body>
</html>