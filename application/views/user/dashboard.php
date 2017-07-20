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
				<a href="<?php echo base_url('home/profile#courses'); ?>">
				<div id="report1" style="height: 200px; width: 100%;"></div>
				<span class="rcount"><?php echo $reports->total; ?></span>
				</a>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<a href="<?php echo base_url('home/profile#ongoing'); ?>">
				<div id="report2" style="height: 200px; width: 100%;"></div>
				<span class="rcount"><?php echo $reports->ongoing; ?></span>
				</a>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<a href="<?php echo base_url('home/profile#completed'); ?>">
				<div id="report3" style="height: 200px; width: 100%;"></div>
				<span class="rcount"><?php echo $reports->completed; ?></span>
				</a>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<a href="<?php echo base_url('home/profile#assessments'); ?>">
				<div id="report4" style="height: 200px; width: 100%;"></div>
				<span class="rcount"><?php echo $reports->assessments->total; ?></span>
				</a>
			</div>
		</div>
		<div class="box mt-10">
			<div class="row">
				<div class="col-md-6">
					<h5>Courses</h5>
					<table class="table table-condensed">
						<thead>
							<tr>
								<th>Course Name</th>
								<th>Registered on</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($courses as $c){ ?>
							<tr>
								<td><a href="<?php echo base_url('home/view/'.$c->id); ?>"><?php echo $c->name; ?></a></td>
								<td><?php echo date('d M y h:i A',strtotime($c->date_time)); ?></td>
								<td><?php echo $c->status; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-md-6">
					<h5>Assessments</h5>
					<table class="table table-condensed">
						<thead>
							<tr>
								<th>Assessment Name</th>
								<th>Question Type</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($assessments as $a){ ?>
							<tr>
								<td><?php echo $a->name; ?></td>
								<td><?php echo $a->question_type; ?></td>
								<td><?php echo $a->status; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
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
					text: "Total Courses",
					fontColor: "#fff"
				},
				backgroundColor: "rgba(62, 62, 62, 0.88)",
				data: [
				{
					type: "doughnut",
					startAngle: 60,
					toolTipContent: "{y}",
					dataPoints: [
					{ y: <?php echo $reports->total; ?>}
					]
				}
				]
			});
			
			var report2 = new CanvasJS.Chart("report2", {
				title: {
					text: "Ongoing Courses",
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
					{ y: <?php echo $reports->ongoing; ?> },
					{ y: <?php echo $reports->total - $reports->ongoing; ?> }
					]
				}
				]
			});
		
			var report3 = new CanvasJS.Chart("report3", {
				title: {
					text: "Completed",
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
					{ y: <?php echo $reports->completed; ?> },
					{ y: <?php echo $reports->total - $reports->completed; ?> }
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
					{ y: <?php echo $reports->assessments->total - $reports->assessments->completed; ?> },
					{ y: <?php echo $reports->assessments->completed; ?> }
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