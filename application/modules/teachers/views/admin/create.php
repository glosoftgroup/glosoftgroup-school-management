<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">Teachers</h6>
		<div class="heading-elements">
			<div class="heading-btn">
				 <?php echo anchor('admin/teachers/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Teachers')), 'class="btn heading-btn btn-primary"'); ?>
              <?php echo anchor('admin/teachers', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Teachers')), 'class="btn heading-btn btn-primary"'); ?>
			</div>
		</div>
	</div>

	<div class="panel-body">
		 <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='first_name'>First Name <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('first_name', $result->first_name, 'id="first_name_"  class="form-control" '); ?>
                <?php echo form_error('first_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='last_name'>Last Name <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('last_name', $result->last_name, 'id="last_name_"  class="form-control" '); ?>
                <?php echo form_error('last_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='email'>Email <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('email', $result->email, 'id="email_"  class="form-control" '); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='phone'>Phone </div><div class="col-md-6">
                <?php echo form_input('phone', $result->phone, 'id="phone_"  class="form-control" '); ?>
                <?php echo form_error('phone'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='status'>Status <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $items = array('' => 'Select Status',
                    1 => "Active",
                    0 => "Inactive",
                );
                echo form_dropdown('status', $items, (isset($result->status)) ? $result->status : '', ' class="form-control select" data-placeholder="Select Options..." ');
                echo form_error('status');
                ?>
            </div></div>

        <div class='form-group'>
            <div class="col-md-3" for='designation'>Designation </div><div class="col-md-6">
                <?php echo form_input('designation', $result->designation, 'id="designation_"  class="form-control" '); ?>
                <?php echo form_error('designation'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-3"></div><div class="col-md-6">

                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/tts', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<!-- /pager -->
</div>
