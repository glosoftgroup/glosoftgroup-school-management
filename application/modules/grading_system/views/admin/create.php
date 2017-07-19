<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title"> Grading System</h6>
		<div class="heading-elements">
			 <?php echo anchor( 'admin/grading_system/create/'.$page, '<i class="glyphicon glyphicon-plus">                </i>'.lang('web_add_t', array(':name' => 'Grading System')), 'class="btn btn-primary"');?>

			 <?php echo anchor( 'admin/grading_system' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Grading Systems')), 'class="btn btn-primary"');?>
		</div>
		</div>


	<div class="panel-body">
	<?php
	$attributes = array('class' => 'form-horizontal', 'id' => '');
	echo   form_open_multipart(current_url(), $attributes);
	?>
	<div class='form-group'>
		<div class='col-md-2' for='title'>Title <span class='required'>*</span></div>
		<div class="col-md-6">
		<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
		<?php echo form_error('title'); ?>
	</div>
	</div>
	<div class='form-group'>
		<div class='col-md-2' for='title'>Pass Mark <span class='required'>*</span></div>
		<div class="col-md-6">
		<?php echo form_input('pass_mark' ,$result->pass_mark , 'id="pass_mark" placeholder="E.g 250" class="form-control" ' );?>
		<?php echo form_error('pass_mark'); ?>
	</div>
	</div>

	<div class="">
						<div class="form-group editor">
							<div class="col-md-3">
                <label >Description</label>
							</div>
							<div class="col-md-9">
							   <textarea id="wysiwyg"  class='form-control' name="description" >
							   <?php echo set_value('description', $result->description); ?></textarea>
						     <?php echo form_error('description'); ?> </textarea>
					   </div>

						</div>
					</div>

	<div class='form-group'><div class="col-md-2"></div>
	<div class="col-md-10">


		<?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
		<?php echo anchor('admin/grading_system','Cancel','class="btn btn-danger"');?>
	</div>
	</div>


	<?php echo form_close(); ?>
	<div class="clearfix"></div>
	</div>
</div>
