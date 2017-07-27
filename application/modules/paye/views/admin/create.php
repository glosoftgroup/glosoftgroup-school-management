<div class="col-md-8">
  <!-- Pager -->
  <div class="panel panel-white animated fadeIn">
      <div class="panel-heading">
          <h4 class="panel-title">Paye</h4>
          <div class="heading-elements">
            <?php echo anchor('admin/paye/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'PAYE')), 'class="btn btn-primary"'); ?> 
             <?php echo anchor('admin/paye', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'PAYE')), 'class="btn btn-primary"'); ?> 
          </div>
      </div>
      
      <div class="panel-body">	
       
         <?php
             $attributes = array('class' => 'form-horizontal', 'id' => '');
             echo form_open_multipart(current_url(), $attributes);
         ?>
        <div class='form-group'>
            <div class="col-md-3" for='range_from'>Range From <span class='required'>*</span></div>
            <div class="col-md-6">
                 <?php echo form_input('range_from', $result->range_from, 'id="range_from_"  class="form-control" '); ?>
                 <?php echo form_error('range_from'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='range_to'>Range To <span class='required'>*</span></div>
            <div class="col-md-6">
                 <?php echo form_input('range_to', $result->range_to, 'id="range_to_"  class="form-control" '); ?>
                 <?php echo form_error('range_to'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='tax'>Tax Percentage (%)<span class='required'>*</span></div>
            <div class="col-md-6">
                 <?php echo form_input('tax', $result->tax, 'id="tax_"  class="form-control" '); ?>
                 <?php echo form_error('tax'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='amount'>Taxable Amount<span class='required'>*</span></div>
            <div class="col-md-6">
                 <?php echo form_input('amount', $result->amount, 'id="amount_"  class="form-control" '); ?>
                 <?php echo form_error('amount'); ?>
            </div>
        </div>
        <div class='form-group'><div class="col-md-3"></div><div class="col-md-12 text-right p-10">
                  <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                  <?php echo anchor('admin/paye', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>