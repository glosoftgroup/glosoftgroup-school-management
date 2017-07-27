<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h6 class="panel-title">School Events</h6>
		<div class="heading-elements">
		 <?php echo anchor( 'admin/school_events/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => ' New Event')), 'class="btn btn-primary"');?>
         <?php echo anchor( 'admin/school_events/calendar' , '<i class="glyphicon glyphicon-list"> </i> Full Calendar', 'class="btn btn-primary"');?>
         <?php echo anchor( 'admin/school_events/list_view' , '<i class="glyphicon glyphicon-list"> </i> List All', 'class="btn btn-primary"');?>
		</div>
	</div>
	
	<div class="panel-body">
	<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-2" for='title'>Title </div><div class="col-md-10">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>


   <div class='form-group'>
            <div class="col-md-2" for='start_date'>Start Date<span class='required'>*</span></div><div class="col-md-10">
			<div id="datetimepicker1" class="input-group date form_datetime">
			   <?php echo form_input('start_date', $result->start_date > 0 ? date('d M Y', $result->start_date) : $result->start_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
               
				<span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span> </div>
                <?php echo form_error('start_date'); ?>
            </div>
        </div>



<div class='form-group'>
            <div class="col-md-2" for='end_date'>End Date<span class='required'>*</span></div><div class="col-md-10">
			<div id="datetimepicker1" class="input-group date form_datetime">
			   <?php echo form_input('end_date', $result->end_date > 0 ? date('d M Y', $result->end_date) : $result->end_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
               
				<span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span> </div>
                <?php echo form_error('end_date'); ?>
            </div>
        </div>





<div class='form-group'>
	<div class="col-md-2" for='venue'>Venue </div><div class="col-md-10">
	<?php echo form_input('venue' ,$result->venue , 'id="venue_"  class="form-control" ' );?>
 	<?php echo form_error('venue'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='visibility'>Visibility </div>
<div class="col-md-10">
                <?php 
     echo form_dropdown('visibility', array('All'=>'All Members')+(array)$groups,  (isset($result->visibility)) ? $result->visibility : ''     ,   ' class="select chzn-select" data-placeholder="Select Options..." ');
     echo form_error('visibility'); ?>
</div></div>

<div class="form-group">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea id="dwysiwyg" class="form-control" placeholder="Write event description here......" name="description" style="">
                          <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
                        
                    </div>
                   
                </div> 


<div class="form-group" style="display:none">
                    <!-- Text input-->
	<div class="col-md-2" for="componentcolorpicker">Select Color</div>
	<div class="col-md-10">
		<div class="input-group color" data-color="rgb(255, 146, 180)" data-color-format="rgb" id="colorpicker2">
			
			<?php echo form_input('color' ,$result->color , 'id="color_"  id="componentcolorpicker" class="form-control input-block-level" ' );?>
 	        <?php echo form_error('color'); ?>
			<span class="input-group-addon"><i style="background-color: rgb(59, 46, 50);"></i></span>
		</div>
	</div>
</div>

  <div class="form-group" >
						
						<div class="col-md-3">
						
						
                                    <div  id="reminder" >
									 <span ><input type="checkbox" style=""> Set Reminder </span>
									</div>
                       
						
						</div>
						<div class="col-md-9">	
							<?php $items=array(
												''=>'Select Reminder Type',
												'minutes'=>'minutes',
												'hours'=>'hours',
												'days'=>'days',
													
													); ?>
								<div class="reminder col-md-6" style="display:none;">
								 <?php echo form_input('reminder',$result->reminder,'placeholder=" E.g 15" id="reminder1" class="form-control col-md-2"'); ?>
								  <?php echo form_dropdown('reminder_type',$items,$result->reminder_type,' id="rem_type" style="height:34px; " class="select col-md-5"'); ?> <div style="padding:15px"> Before Meeting Starts</div>
								</div>
								
								
						</div>	
						<div class="clearfix"></div>
				  </div>



<div class='form-group'><div class="control-div"></div><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/school_events','Cancel','class="btn btn-danger"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
	</div>
</div>

</div>

  <script>     
$('.reminder').hide();


$('#reminder').click(function(){
		
			$('.reminder').toggle();
		
	});
	
	 $(".datepicker").datepicker({
      format: "dd MM yyyy",
     
    });
	</script>