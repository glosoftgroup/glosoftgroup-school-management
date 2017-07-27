<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
  <div class="panel-heading">
    <h4 class="panel-title">Groups Management</h4>
    <div class="heading-elements">
      <?php echo anchor( 'admin/groups/create/', '<i class="glyphicon glyphicon-plus"></i>'.lang('web_add_t', array(':name' => 'New Groups')), 'class="btn btn-primary"');?>
          <?php echo anchor( 'admin/groups/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
        
    </div>
  </div>
  
  <div class="panel-body">
                    


<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<label class='col-md-2' for='name'>Name <span class='required'>*</span></label><div class="col-md-10">
	<?php echo form_input('name' ,$result->name , 'id="name_"  class="form-control" ' );?>
 	<?php echo form_error('name'); ?>
</div>
</div>

 <div class="form-group">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea id="" class="wysihtml5 wysihtml5-min "  name="description" style="height: 300px;">
                          <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
                        
                    </div>
                   
                </div> 

<div class='col-md-12 form-group'><label class="col-md-2"></label><div class="col-md-12 text-right">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary btn-small''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/groups','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
</div>