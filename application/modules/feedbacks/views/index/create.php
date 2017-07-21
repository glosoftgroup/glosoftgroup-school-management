<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Feedbacks  </h2>
             <div class="right"> 
            
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="" style=" width:400px;" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	Feedback <span class='required'>*</span></div>
	 <div class="block-fluid editor">
	<textarea id="feedback"   style="height: 150px; width:400px;" class=" wysihtml5 wysihtml5-min"  name="feedback"  /><?php echo set_value('feedback', (isset($result->feedback)) ? htmlspecialchars_decode($result->feedback) : ''); ?></textarea>
	<?php echo form_error('feedback'); ?>
</div>
</div>

<div class='form-group'>
<div class="col-md-3"></div>
<div class="col-md-6">
    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/feedbacks','Cancel','class="btn  btn-default"');?>
</div>
</div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>