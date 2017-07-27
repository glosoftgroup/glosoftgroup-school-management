<div class="col-md-8 animated zoomIn">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
  <div class="panel-heading">
    <h4 class="panel-title">Students Placement</h4>
    <div class="heading-elements">
        <?php echo anchor( 'admin/students_placement/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => ' New Placement')), 'class="btn btn-primary"');?>
              <?php echo anchor( 'admin/students_placement/' , '<i class="glyphicon glyphicon-list"> </i> List All', 'class="btn btn-primary"');?>
    </div>
  </div>
  
  <div class="panel-body">
     <div class="block-fluid">  
  

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
  <div class="col-md-3" for='student'>Student <span class='required'>*</span></div>
<div class="col-md-9">
                <?php 
        $items = $this->ion_auth->students_full_details();
     echo form_dropdown('student', array(''=>'Select Student')+(array)$items,  (isset($result->student)) ? $result->student : ''     ,   ' class="select" data-placeholder="Select Options..." ');
     echo form_error('student'); ?>
</div></div>

<div class='form-group'>
  <div class="col-md-3" for='start_date'>Start Date <span class='required'>*</span></div><div class="col-md-6">
  
  <div id="datetimepicker1" class="input-group date form_datetime">
    <?php echo form_input('start_date', $result->start_date > 0 ? date('d M Y', $result->start_date) : $result->start_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
  
  
                            <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
              
                        </div>
            
            <?php echo form_error('start_date'); ?>

</div>
</div>

<div class='form-group'>
  <div class="col-md-3" for='position'>Position <span class='required'>*</span></div>
  
<div class="col-md-9">
 
                <?php     
     echo form_dropdown('position',array(''=>'Select Position')+ $positions,  (isset($result->position)) ? $result->position : ''     ,   ' class="select" data-placeholder="Select Options..." ');
     echo form_error('position'); ?>

</div>
</div>



<div class='form-group'>
  <div class="col-md-3" for='class'>Representative of <span class='required'>*</span></div>
<div class="col-md-9">
    <?php 
   $class= $this->ion_auth->fetch_classes();
     echo form_dropdown('student_class', array(''=>'Select Option')+(array)$class+array('Others'=>'Others'),  (isset($result->student_class)) ? $result->student_class : ''     ,   ' class="select" data-placeholder="Select Options..." ');
      ?><?php echo form_error('student_class'); ?>
</div></div>

<div class='form-group'>
  <div class="col-md-3" for='duration'>Date upto </div><div class="col-md-6">
  
  <div id="datetimepicker1" class="input-group date form_datetime">
    <?php echo form_input('duration', $result->duration > 0 ? date('d M Y', $result->duration) : $result->duration, 'class="validate[required] form-control datepicker col-md-4"'); ?>
    
      <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
      
    </div>
<?php echo form_error('duration'); ?>
</div>
</div>

<div class="form-group">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea class="wysihtml5 wysihtml5-min"  name="description" style="height: 300px;">
                          <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
  <?php echo form_error('description'); ?>
                        
                    </div>
                   
                </div> 

<div class='form-group'><div class="col-md-3"></div><div class="col-md-12 text-right">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
  <?php echo anchor('admin/students_placement','Cancel','class="btn btn-danger"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
  </div>
</div>

</div>


           
<div class="col-md-4 animated fadeIn">
<!-- Pager -->
<div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title">Add  Position</h4>
    <div class="heading-elements">
    
    </div>
  </div>
  
  <div class="panel-body">
  <div class="block-fluid">
                        <?php echo form_open('admin/placement_positions/quick_add','class=""'); ?>
                        <div class="form-group">
                            <lable>Name:</lable>                                    
                                 <?php echo form_input('title','', 'id="title_1" class="form-control" placeholder=" e.g Prefect, Monitor, Headboy etc."' );?>
                             <?php echo form_error('title'); ?>
                            </div>
                        </div>
                           <br>                         
                        <div class="form-group">
             <label>Description:</label>
                           
                                <textarea name="description" class="form-control"></textarea> 
                           
                        </div>                        
                   
                    <div class="toolbar TAR">
                        <button class="btn btn-primary">Add</button>
                    </div>
             <?php echo form_close(); ?> 
             </div>
  </div>
</div>

</div>
    
         