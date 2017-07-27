<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">School Classes</h4>
        <div class="heading-elements">
          <?php echo anchor('admin/class_stream/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Stream')), 'class="btn btn-primary"'); ?>
         <?php echo anchor('admin/class_stream/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        </div>
    </div>
    
    <div class="panel-body">
   
     <?php
         $attributes = array('class' => 'form-horizontal', 'id' => '');
         echo form_open_multipart(current_url(), $attributes);
     ?>
    <div class='form-group'>
        <label class='col-md-2' for='name'>Stream Name </label><div class="col-md-6">
             <?php echo form_input('name', $result->name, 'id="name_"  placeholder="E.g Blue, Red etc" class="form-control" '); ?>
             <?php echo form_error('name'); ?>
        </div>
    </div>

    <div class='form-group'><label class="col-md-2"></label><div class="col-md-6">


            <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-success'")); ?>
            <?php echo anchor('admin/class_stream', 'cancel', 'class="btn  btn-default"'); ?>
        </div></div>

    <?php echo form_close(); ?>
    <div class="clearfix"></div>
</div>
</div>
</div>
</div>