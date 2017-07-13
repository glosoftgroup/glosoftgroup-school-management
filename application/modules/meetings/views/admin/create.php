<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Meetings  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/meetings/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Meetings')), 'class="btn btn-primary"');?> 
				 <?php echo anchor( 'admin/meetings/calendar' , '<i class="glyphicon glyphicon-calendar"></i> Calendar View', 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/meetings' , '<i class="glyphicon glyphicon-list">
                </i> List View', 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-2" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='start_date'>Start Date <span class='required'>*</span></div>
	<div class="col-md-6">
	<div id="datetimepicker1" class="input-group date form_datetime">
	 <?php echo form_input('start_date', $result->start_date > 0 ? date('d M Y', $result->start_date) : $result->start_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
	
	  <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
	  </div>
 	<?php echo form_error('start_date'); ?>

</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='end_date'>End Date <span class='required'>*</span></div>
	<div class="col-md-6">
	<div id="datetimepicker1" class="input-group date form_datetime">
	 <?php echo form_input('end_date', $result->end_date > 0 ? date('d M Y', $result->end_date) : $result->end_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
	
	 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
	</div>
 	<?php echo form_error('end_date'); ?>

</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='venue'>Venue <span class='required'>*</span></div>
	<div class="col-md-6">
	<?php echo form_input('venue' ,$result->venue , 'id="venue_"  class="form-control" ' );?>
 	<?php echo form_error('venue'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='importance'>Importance </div>
<div class="col-md-6">
                <?php $items = array( 
"Low"=>"Low",
"Medium"=>"Medium",
"High"=>"High",
);		
     echo form_dropdown('importance', $items,  (isset($result->importance)) ? $result->importance : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('importance'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-2" for='status'>Status </div>
<div class="col-md-6">
                <?php $items = array( 
"live"=>"Live",
"draft"=>"Draft",
);		
     echo form_dropdown('status', $items,  (isset($result->status)) ? $result->status : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('status'); ?>
</div></div>
<div class="form-group">
	<div class="col-md-2" for='status'>Guests </div>
                    <div class="col-md-6">
						<?php 
					  $user=$this->ion_auth->get_user_details();
					  $parent=$this->ion_auth->get_parent_details();
					  $items=array(
								''=>'Guests',
								'Parents and Staff'=>'Parents and Staff',
								'All Parents'=>'All Parents',
								'All Teachers'=>'All Teachers',
								'All Staff'=>'All Staff',
								'Staff'=>'Staff',
								'Parent'=>'Parent',
					); ?>
                       
                        <?php echo form_dropdown('send_to',$items,$result->send_to,' data-placeholder="Send To:" onchange="show_field(this.value)" id="send_to" class="select"  tabindex="4"'); ?>
						
                    </div>
                </div>
				
                  
                <div class="form-group" id="rc_staff">
				<div class="col-md-2" for='status'> </div>
                    <div class="col-md-6">
                        <span class="top title"></span>
                        <?php	
							echo form_dropdown('staff', array(''=>'Select Staff')+$user,  (isset($result->staff)) ? $result->staff : '' ,' class="select populate "  ');
							echo form_error('staff'); 
					     ?>
                    </div>
                </div> 
				<div class="form-group" id="rc_parent">
				<div class="col-md-2" for='status'> </div>
                    <div class="col-md-6">
                        <span class="top title"></span>
                       <?php	
						echo form_dropdown('parent', array(''=>'Select Parent')+(array)$parent,  (isset($result->parent)) ? $result->parent : ''     ,   ' class="select populate " ');
							 echo form_error('parent'); 
						?>
                    </div>
                </div> 

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Description </h2></div>
	 <div class="block-fluid editor">
	<textarea id="description"   style="height: 300px;" class=" wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-2"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/meetings','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
</div>


<script>
	function show_field(item){
		//hide all
		
		//document.getElementById('cc').style.display='none';
		document.getElementById('rc_staff').style.display='none';
		document.getElementById('rc_parent').style.display='none';
		
		if(item=='Staff') document.getElementById('rc_staff').style.display='block';
		if(item=='Parent') document.getElementById('rc_parent').style.display='block';
		
		return ;
			
	}
	<?php if($this->uri->segment(3)=='create'){ ?>
	show_field('None');
	<?php } ?>
</script>