<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">  Extra Curricular</h4>
        <div class="heading-elements">
            <?php echo anchor( 'admin/extra_curricular/create' , '<i class="glyphicon glyphicon-plus">
                </i> Add Student To Activity', 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/extra_curricular' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Extra Curricular')), 'class="btn btn-primary"');?> 
        </div>
    </div>
    
    <div class="panel-body">
    <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
    <div class="col-md-3" for='student'>Student <span class='required'>*</span></div><div class="col-md-6">
      <?php
            $student=$this->ion_auth->students_full_details();
            echo form_dropdown('student[]', $student, (isset($result->student)) ? $result->student : '', ' class="select" multiple ');
            ?>  
    <?php echo form_error('student'); ?>
</div>
</div>
<div class='form-group'>
    <div class="col-md-3" for='start_date'>Activity <span class='required'>*</span></div><div class="col-md-4">
     <?php
                echo form_dropdown('activity', $activity, (isset($result->activity)) ? $result->activity : '', ' class="select"  ');
                echo form_error('activity');
                ?>
</div>
</div>
<div class='form-group'>
    <div class="col-md-3" for='date_from'>Date From <span class='required'>*</span></div><div class="col-md-4">
     <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('date_from', $result->date_from > 0 ? date('d M Y', $result->date_from) : $result->date_from, 'class="validate[required] form-control datepicker col-md-4"'); ?>


                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>

                </div>
    <?php echo form_error('date_from'); ?>
</div>
</div>



<div class='form-group'>
    <div class="col-md-3" for='date_to'>Date To <span class='required'>*</span></div><div class="col-md-4">
     <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('date_to', $result->date_to > 0 ? date('d M Y', $result->date_to) : $result->date_to, 'class="validate[required] form-control datepicker col-md-4"'); ?>


                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>

                </div>
    <?php echo form_error('date_to'); ?>
</div>
</div>

<div class='form-group'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
    <h2>Remarks </h2></div>
     <div class="block-fluid editor">
    <textarea id="remarks"   style="height: 300px;" class=" wysihtml5 wysihtml5-min "  name="remarks"  /><?php echo set_value('remarks', (isset($result->remarks)) ? htmlspecialchars_decode($result->remarks) : ''); ?></textarea>
    <?php echo form_error('remarks'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-12 text-right">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
    <?php echo anchor('admin/extra_curricular','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
    </div>
</div>
</div>
<!-- sidebar -->
<div class="col-md-4">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Add Activity</h4>
        <div class="heading-elements">      
        </div>
    </div>
    
    <div class="panel-body">
     <div class="block-fluid">
            <?php echo form_open('admin/activities/quick_add', 'class=""'); ?>
            <div class="form-group">
                <label>Name:</label>                                       
                    <?php echo form_input('name', '', 'id="title_1" class="form-control"  placeholder=" e.g Football, Music, Hockey, Athletics etc."'); ?>
                    <?php echo form_error('name'); ?>
                
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea class='form-control' name="description"></textarea> 
               
            </div>                        

            <div class="col-md-12 text-right TAR">
                <button class="btn btn-primary">Add Activity</button>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>
</div>
</div>



 
