<div class="col-md-8">
    <!-- Pager -->
    <div class="panel panel-white animated fadeIn">
        <div class="panel-heading">
            <h4 class="panel-title">Give Items</h4>
            <div class="heading-elements">
              <?php echo anchor('admin/give_items/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Give Items')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/give_items', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Give Items')), 'class="btn btn-primary"'); ?> 
            </div>
        </div>
        
        <div class="panel-body">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='date'>Date <span class='required'>*</span></div>
            <div class="col-md-6">
                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('date', $result->date > 0 ? date('d M Y', $result->date) : $result->date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                    <?php echo form_error('date'); ?>
                </div>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='item'>Item <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('item', array('' => 'Select Item') + $items, (isset($result->item)) ? $result->item : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('item');
                ?>
            </div></div>

        <div class='form-group'>
            <div class="col-md-3" for='quantity'>Quantity <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('quantity', $result->quantity, 'id="quantity_"  class="form-control" '); ?>
                <?php echo form_error('quantity'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='given_to'>Given To <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $staff = $this->ion_auth->list_staff();
                echo form_dropdown('given_to', array('' => 'Select Staff') + $staff, (isset($result->given_to)) ? $result->given_to : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('given_to');
                ?>
            </div></div>

        <div class='form-group'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Comment </h2></div>
            <div class="block-fluid editor">
                <textarea id="comment"   style="height: 300px;" class=" wysihtml5 wysihtml5-min"  name="comment"  /><?php echo set_value('comment', (isset($result->comment)) ? htmlspecialchars_decode($result->comment) : ''); ?></textarea>
                <?php echo form_error('comment'); ?>
            </div>
        </div>

        <div class='form-group col-md-12'><div class="col-md-3"></div><div class="col-md-12 text-right">


                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/give_items', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>