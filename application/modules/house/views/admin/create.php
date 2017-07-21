<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
  <div class="panel-heading">
    <h6 class="panel-title">House</h6>
    <div class="heading-elements">
       <?php echo anchor( 'admin/house/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'House')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/house' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'House')), 'class="btn btn-primary"');?> 
    </div>
  </div>
  
  <div class="panel-body">
           <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
  <div class="col-md-3" for='name'>Name <span class='required'>*</span></div><div class="col-md-9">
  <?php echo form_input('name' ,$result->name , 'id="name_"  class="form-control" ' );?>
  <?php echo form_error('name'); ?>
</div>
</div>

<div class='form-group'>
  <div class="col-md-3" for='slogan'>Slogan </div><div class="col-md-9">
  <?php echo form_input('slogan' ,$result->slogan , 'id="slogan_"  class="form-control" placeholder=" E.g We are the champions" ' );?>
  <?php echo form_error('slogan'); ?>
</div>
</div>

<div class='form-group'>
            <div class="col-md-3" for='leader'>Leader (Teacher)<span class='required'>*</span>  </div>
            <div class="col-md-9">
                <?php
                $items = $this->ion_auth->get_teachers();
                echo form_dropdown('leader', array('' => 'Select Leader') + (array) $items, (isset($result->leader)) ? $result->leader : '', ' class="select chzn-select" data-placeholder="Select Options..." ');
                echo form_error('leader');
                ?>
            </div></div>


<div class='form-group'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
  <h2>Description </h2></div>
   <div class="block-fluid editor">
  <textarea id="description"   style="height: 300px;" class=" wysihtml5 wysihtml5-min  "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
  <?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-12 text-right">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
  <?php echo anchor('admin/house','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
  </div>
</div>

</div>


       
                              
               
  