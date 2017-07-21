<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title"> Assign Bed</h4>
        <div class="heading-elements">
         <?php echo anchor('admin/assign_bed/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> Assign Bed', 'class="btn btn-primary"'); ?>

            <?php echo anchor('admin/assign_bed', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Assign Bed')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    
    <div class="panel-body">
    

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='date_assigned'>Date Assigned <span class='required'>*</span></div><div class="col-md-6">
                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('date_assigned', $result->date_assigned > 0 ? date('d M Y', $result->date_assigned) : $result->date_assigned, 'class="validate[required] form-control datepicker col-md-4"'); ?>

                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
                </div>
                <?php echo form_error('date_assigned'); ?>

            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='student'>Student <span class='required'>*</span></div><div class="col-md-9">
                <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select Student') + $data, (isset($result->student)) ? $result->student : '', ' class="select" ');
                ?>
                <?php echo form_error('student'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='Term'>Term<span class='required'>*</span></div><div class="col-md-9">
                <?php
                echo form_dropdown('term', array('' => 'Select Term') + $this->terms, (isset($result->term)) ? $result->term : '', ' class="select" ');
                echo form_error('term');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='year'>Year<span class='required'>*</span></div><div class="col-md-9">
                <?php
                krsort($yrs);
                echo form_dropdown('year', array('' => 'Select Year') + $yrs, (isset($result->year)) ? $result->year : '', ' class="select" ');
                echo form_error('year');
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='bed'>Bed <span class='required'>*</span></div><div class="col-md-9">
                <?php echo form_dropdown('bed', array('' => 'Select Bed') + $beds, (isset($result->bed)) ? $result->bed : '', ' class="select" '); ?>
                <?php echo form_error('bed'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Comment </h2></div>
            <div class="block-fluid editor">
                <textarea id="comment"   style="height: 50px;" class=" wysihtml5 wysihtml5-min"  name="comment"  /><?php echo set_value('comment', (isset($result->comment)) ? htmlspecialchars_decode($result->comment) : ''); ?></textarea>
                <?php echo form_error('comment'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-3"></div><div class="col-md-12 text-right"> 
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/assign_bed', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>