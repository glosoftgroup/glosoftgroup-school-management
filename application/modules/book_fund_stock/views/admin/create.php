 

<div class="col-md-8">
    <!-- Pager -->
    <div class="panel panel-white animated fadeIn">
      <div class="panel-heading">
        <h4 class="panel-title"> Book Fund Stock</h4>
        <div class="heading-elements">
          <?php echo anchor( 'admin/book_fund_stock' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Book Fund Stock')), 'class="btn btn-primary"');?>
        </div>
      </div>
      
      <div class="panel-body">           

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='purchase_date'>Purchased Date <span class='required'>*</span></div><div class="col-md-4">
	<div id="datetimepicker1" class="input-group date form_datetime">
	 <?php echo form_input('purchase_date', $result->purchase_date > 0 ? date('d M Y', $result->purchase_date) : $result->purchase_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
	
	<span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
	</div>
 	<?php echo form_error('purchase_date'); ?>
</div>
</div>

<div class='form-group'>
	<div class=' col-md-3' for='quantity'>Quantity <span class='required'>*</span></div>
        <div class="col-md-4">
	<?php echo form_input('quantity' ,$result->quantity , 'id="quantity"  class="form-control" id="focusedinput" onblur="totals()"' );?>
 	<?php echo form_error('quantity'); ?>
</div>
</div>



 <div class='form-group'>
            <div class="col-md-3" for='receipt'>Upload Receipt </div>
            <div class="col-md-9">
                <input id='receipt' class="file-styled-primary" type='file' name='receipt' />

                <?php if ($updType == 'edit'): ?>
                    <a href='<?php echo base_url('uploads/files/' . $result->receipt); ?>' >Download actual file (receipt)</a>
                <?php endif ?>

                <br/><?php echo form_error('receipt'); ?>
                <?php echo ( isset($upload_error['receipt'])) ? $upload_error['receipt'] : ""; ?>
            </div>
        </div>

<div class='form-group col-md-12'><div class="col-md-2"></div><div class="col-md-12 text-right">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/book_fund_stock','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>