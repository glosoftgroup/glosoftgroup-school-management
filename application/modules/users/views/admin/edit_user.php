
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Users Management</h4>
        <div class="heading-elements">
         
        <?php echo anchor('admin/users/create/', '<i class="glyphicon glyphicon-plus"></i>' . lang('web_add_t', array(':name' => 'New User')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/users/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        </div>
    </div>
    
    <div class="panel-body">
    
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo form_open_multipart(current_url(), $attributes);
    ?>
    <div class='form-group'>
        <div class='col-md-3' for='first_name'>First Name <span class='required'>*</span></div>
        <div class="col-md-4">
            <?php echo form_input($first_name,'','class="form-control"'); ?>
            <?php echo form_error('first_name', '<p class="required">', '</p>'); ?>
        </div>
    </div>

    <div class='form-group'>
        <div class='col-md-3' for='last_name'>Last Name <span class='required'>*</span></div>
        <div class="col-md-4">
            <?php echo form_input($last_name,'','class="form-control"'); ?>
            <?php echo form_error('last_name', '<p class="required">', '</p>'); ?>
        </div>
    </div>
    <input style="display:none" class="mask_mobile" >  
    <div class='form-group'>
        <div class=' col-md-3' for='phone'>Phone Number <span class=' mask_mobile'></span></div>
        <div class="col-md-4">
            <?php echo form_input($phone, '', 'class="form-control mask_mobile"'); ?>  
            <?php echo form_error('phone', '<p class="required">', '</p>'); ?>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-md-3' for='email'>Email <span class='required'>*</span></div>
        <div class="col-md-4">
            <?php echo form_input($email,'','class="form-control"'); ?>
            <?php echo form_error('email', '<p class="required">', '</p>'); ?>
        </div>
    </div>

    <div class='form-group'>
        <div class='col-md-3' for='password'>Password <br> (if changing password) </div><div class="col-md-4">
            <?php echo form_input($password,'','class="form-control"'); ?> <?php echo form_error('password', '<p class="required">', '</p>'); ?>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-md-3' for='password_confirm'>Confirm Password<br> (if changing password)  </div><div class="col-md-4">
            <?php echo form_input($password_confirm,'','class="form-control"'); ?>
            <?php echo form_error('password_confirm', '<p class="required">', '</p>'); ?>
        </div>
    </div>

    <div class='form-group'>
        <div class='col-md-3' for='groups'>Groups  </div>
        <div class="col-md-4">
            <?php echo form_dropdown('groups[]', $groups_list, $selected, '  class="select"'); ?>
        </div>
    </div> 

    <div class='form-group'><div class="control-div"></div><div class="col-md-12 text-right">
            <?php echo form_submit('submit', 'Update', "id='submit' class='btn btn-primary'"); ?> 
            <?php echo anchor('admin/users', 'Cancel', 'class="btn  btn-default"'); ?>
        </div></div>


    <?php echo form_close(); ?>
    <div class="clearfix"></div>
</div>
</div>
</div>
</div>

</div>
