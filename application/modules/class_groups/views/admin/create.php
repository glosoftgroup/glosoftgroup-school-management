<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h6 class="panel-title">  Class Group</h6>
		<div class="heading-elements">
			 <?php echo anchor('admin/class_groups/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Class Groups')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/class_groups', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Class Groups')), 'class="btn btn-primary"'); ?>
		</div>
	</div>

	<div class="panel-body">
	     <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='name'>Name </div>
            <div class="col-md-10">
                <?php echo form_input('name', $result->name, 'id="name_"  class="form-control" '); ?>
                <?php echo form_error('name'); ?>
            </div>
        </div>

        <div class='form-group'>

            <div class="form-group  editor">
              <div class="col-md-2" for='name'>
                <label>Description</label>
              </div>
              <div class="col-md-10">
                <textarea id="description"    class=" wysihtml5 wysihtml5-min  "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>
              </div>
            </div>
        </div>

        <div class='form-group'>
          <div class="col-md-2"></div>
          <div class="col-md-10 text-right">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/class_groups', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
          </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
	</div>
</div>
</div>
