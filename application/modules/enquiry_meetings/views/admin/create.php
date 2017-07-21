<div class="col-md-8">
       <!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Enquiry Meetings</h4>
        <div class="heading-elements">
                <?php echo anchor( 'admin/enquiry_meetings/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Enquiry Meetings')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/enquiry_meetings' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Enquiry Meetings')), 'class="btn btn-primary"');?> 
        </div>
    </div>
    
    <div class="panel-body">		
       
            
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='person_to_meet'>Person To Meet <span class='required'>*</span></div>
<div class="col-md-6">
                <?php $items = array('' =>'', 
"0"=>"Spanish",
"1"=>"English",
);		
     echo form_dropdown('person_to_meet', $items,  (isset($result->person_to_meet)) ? $result->person_to_meet : ''     ,   ' class="select chzn-select" data-placeholder="Select Options..." ');
     echo form_error('person_to_meet'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='proposed_date'>Proposed Date <span class='required'>*</span></div><div class="col-md-6">
	<input id='proposed_date' type='text' name='proposed_date' maxlength='' class='form-control datepicker' value="<?php echo set_value('proposed_date', (isset($result->proposed_date)) ? $result->proposed_date : ''); ?>"  />
 	<?php echo form_error('proposed_date'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='time'>Time <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('time' ,$result->time , 'id="time_"  class="form-control" ' );?>
 	<?php echo form_error('time'); ?>
</div>
</div>

<div class='form-group'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Reason <span class='required'>*</span></h2></div>
	 <div class="block-fluid editor">
	<textarea id="reason"   style="height: 300px;" class=" wysihtml5 wysihtml5-min"  name="reason"  /><?php echo set_value('reason', (isset($result->reason)) ? htmlspecialchars_decode($result->reason) : ''); ?></textarea>
	<?php echo form_error('reason'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-12 text-right">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/enquiry_meetings','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>