<div class="col-md-8">
 <!-- Pager -->
 <div class="panel panel-white animated fadeIn">
     <div class="panel-heading">
         <h4 class="panel-title">Invoices</h4>
         <div class="heading-elements">
           <?php echo anchor( 'admin/invoices/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Invoices')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/invoices' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Invoices')), 'class="btn btn-primary"');?> 
         </div>
     </div>
     
     <div class="panel-body">		
           

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-2" for='term'>Term </div>
<div class="col-md-10">
                <?php $items = array('' =>'', 
"0"=>"Spanish",
"1"=>"English",
);		
     echo form_dropdown('term', $items,  (isset($result->term)) ? $result->term : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('term'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-2" for='invoice_no'>Invoice No <span class='required'>*</span></div><div class="col-md-10">
	<?php echo form_input('invoice_no' ,$result->invoice_no , 'id="invoice_no_"  class="form-control" ' );?>
 	<?php echo form_error('invoice_no'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='fee_id'>Fee Id <span class='required'>*</span></div><div class="col-md-10">
	<?php echo form_input('fee_id' ,$result->fee_id , 'id="fee_id_"  class="form-control" ' );?>
 	<?php echo form_error('fee_id'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='student_id'>Student Id <span class='required'>*</span></div><div class="col-md-10">
	<?php echo form_input('student_id' ,$result->student_id , 'id="student_id_"  class="form-control" ' );?>
 	<?php echo form_error('student_id'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-10"><input id='check' type='checkbox' name='check' value='1'  class="form-control" <?php echo preset_checkbox('check', '1', (isset($result->check)) ? $result->check : ''  )?> />&nbsp;<div class='col-md-2inline' for='check'>Status Check </div>
	<?php echo form_error('check'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-2"></div><div class="col-md-12 text-right p-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/invoices','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>