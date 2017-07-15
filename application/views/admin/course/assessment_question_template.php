<div class="box question" data-id="<?php echo $i; ?>">
	<div class="row">
		<div class="col-md-9">
			<label class="qno"><?php echo $i; ?>. Question</label>
			<div>
			<textarea va_req="true" name="question" placeholder="Enter question..."></textarea>
			</div>
			<ul></ul>
		</div>
		<div class="col-md-3">
			<label>Marks</label>
			<input type="text" name="qtype" value="<?php echo $qtype; ?>" readonly>
			<input type="number" name="marks" placeholder="Enter marks..." value="<?php echo $marks; ?>">
			<button class="btn btn-sm mt-10 add_option" data-id="<?php echo $i; ?>" data-type="<?php echo $qtype; ?>"><i class="fa fa-plus"></i> Add Option</button>
		</div>
	</div>
	<div class="q_remove"><i class="fa fa-trash"></i>Remove</div>
</div>