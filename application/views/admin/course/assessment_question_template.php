<div class="box question" data-id="<?php echo $i; ?>">
	<div class="row">
		<div class="col-md-9">
			<label class="qno"><?php echo $i; ?>. Question</label>
			<div>
			<textarea va_req="true" name="question" placeholder="Enter question..."></textarea>
			</div>
			<div class="pull-left">
			<a href="#" class="video fileinput-button"><i class="fa fa-video-camera"></i> Add Video <input class="fileupload" id="video_upload_<?php echo $i; ?>" type="file" name="files" save_path="video_path_<?php echo $i; ?>"></a>
			<input type="hidden" name="video" id="video_path_<?php echo $i; ?>"/>
			</div>
			<div class="pull-left">
			<a href="#" class="image fileinput-button"><i class="fa fa-image"></i> Add Image <input class="fileupload" id="img_upload_<?php echo $i; ?>" type="file" name="files" save_path="img_path_<?php echo $i; ?>"></a>
			<input type="hidden" name="image" id="img_path_<?php echo $i; ?>"/>
			</div>
			<ul></ul>
		</div>
		<div class="col-md-3">
			<label>Answer Type</label>
			<?php if($qtype != 'Mixed'){ ?>
			<input type="text" class="qtype" name="qtype" value="<?php echo $qtype; ?>" readonly>
			<?php }else{ ?>
				<select va_req="true" class="select2 qtype" data-placeholder="Select answer type" name="qtype" data-id="<?php echo $i; ?>">
					<option value=""></option>
					<?php foreach((array)$this->config->item('question_type') as $qt){ if($qt != 'Mixed'){ ?>
					<option <?php if(isset($qtype))if($qtype == $qt)echo 'selected'; ?>><?php echo $qt; ?></option>
					<?php } } ?>
				</select>
			<?php } ?>
			<label>Marks</label>
			<input type="number" name="marks" va_req="true" placeholder="Enter marks..."  value="<?php echo $marks; ?>">
			<button class="btn btn-sm mt-10 add_option hide" data-id="<?php echo $i; ?>"><i class="fa fa-plus"></i> Add Option</button>			
		</div>
	</div>
	<div class="q_remove"><i class="fa fa-trash"></i> Remove</div>
</div>