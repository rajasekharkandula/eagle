<!DOCTYPE html>
<html lang="en">
<?php echo $head; ?>
<body>
	<?php echo $header; ?>	
	<div class="body-content">
	<div class="container">
		<br>
		<div class="row">
			<div class="col-md-3 col-sm-4 col-xs-12">
				<a href="<?php echo base_url('admin/users'); ?>">
				<div id="report3" style="height: 200px; width: 100%;"></div>
				<span class="rcount"><?php echo $reports->users; ?></span>
				</a>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<a href="<?php echo base_url('admin/courses'); ?>">
				<div id="report1" style="height: 200px; width: 100%;"></div>
				<span class="rcount"><?php echo $reports->courses; ?></span>
				</a>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<a href="<?php echo base_url('admin/groups'); ?>">
				<div id="report2" style="height: 200px; width: 100%;"></div>
				<span class="rcount"><?php echo $reports->groups; ?></span>
				</a>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<a href="<?php echo base_url('admin/assessments'); ?>">
				<div id="report4" style="height: 200px; width: 100%;"></div>
				<span class="rcount"><?php echo $reports->assessments; ?></span>
				</a>
			</div>
		</div>
	</div>
	</div>
	
	
	<?php echo $footer; ?>
	<script src="<?php echo base_url('assets'); ?>/js/canvasjs.min.js" type="text/javascript"></script>
	<script type="text/javascript">

    $(document).ready(function(){
		
		
	});	
	</script>
<script type="text/javascript">
		window.onload = function () {
			var report1 = new CanvasJS.Chart("report1", {
				title: {
					text: "Courses",
					fontColor: "#fff"
				},
				backgroundColor: "rgba(62, 62, 62, 0.88)",
				data: [
				{
					type: "doughnut",
					startAngle: 60,
					toolTipContent: "{y}",
					dataPoints: [
					{ y: <?php echo $reports->courses ? $reports->courses : 1; ?>}
					]
				}
				]
			});
			
			var report2 = new CanvasJS.Chart("report2", {
				title: {
					text: "Groups",
					fontColor: "#fff"
				},
				backgroundColor: "rgba(62, 62, 62, 0.88)",
				data: [
				{
					type: "doughnut",
					radius:  "100%", 
					startAngle: 60,
					toolTipContent: "{y}",
					dataPoints: [
					{ y: <?php echo $reports->groups ? $reports->groups : 1; ?> }
					]
				}
				]
			});
		
			var report3 = new CanvasJS.Chart("report3", {
				title: {
					text: "Users",
					fontColor: "#fff"
				},
				backgroundColor: "rgba(62, 62, 62, 0.88)",
				data: [
				{
					type: "doughnut",
					radius:  "100%", 
					startAngle: 60,
					toolTipContent: "{y}",
					dataPoints: [
					{ y: <?php echo $reports->users; ?> }
					]
				}
				]
			});
		
			var report4 = new CanvasJS.Chart("report4", {
				title: {
					text: "Assessments",
					fontColor: "#fff"
				},
				backgroundColor: "rgba(62, 62, 62, 0.88)",
				data: [
				{
					type: "doughnut",
					radius:  "100%", 
					startAngle: 60,
					toolTipContent: "{y}",
					dataPoints: [
					{ y: <?php echo $reports->assessments ? $reports->assessments : 1; ?> }
					]
				}
				]
			});
			report1.render();
			report2.render();
			report3.render();
			report4.render();
		}
	</script>
</body>
</html>