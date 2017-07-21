<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h6 class="panel-title">Exams</h6>
		<div class="heading-elements">

			 <?php echo anchor('admin/exams/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Exams')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/exams', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Exams')), 'class="btn btn-primary"'); ?>

		</div>
	</div>

	<div class="panel-body">
	<?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='title'>Title <span class='required'>*</span></div><div class="col-md-9">
                <?php echo form_input('title', $result->title, 'id="title_"  class="form-control" '); ?>
                <?php echo form_error('title'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='term'>Term <span class='required'>*</span></div>
            <div class="col-md-9">
                <?php
                echo form_dropdown('term', $this->terms, (isset($result->term)) ? $result->term : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('term');
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='year'>Year <span class='required'>*</span></div>
            <div class="col-md-9">
                <?php
                krsort($yrs);
                echo form_dropdown('year', $yrs, $result->year, 'id="year_"  class="select" ');
                echo form_error('year');
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='start_date'>Start Date <span class='required'>*</span></div>
            <div class="col-md-9">
                <?php
                $dt = '';
                if ($result->start_date)
                {
                        if ((!preg_match('/[^\d]/', $result->start_date)))//if it contains digits only
                        {
                                $dt = date('d M Y', $result->start_date);
                        }
                        else
                        {
                                $dt = $result->start_date;
                        }
                }
                echo form_input('start_date', $dt, 'class="validate[required] form-control datepicker col-md-6"');
                echo form_error('start_date');
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='end_date'>End Date <span class='required'>*</span></div><div class="col-md-9">
                <?php
                $edt = '';
                if ($result->end_date)
                {
                        if ((!preg_match('/[^\d]/', $result->end_date)))//if it contains digits only
                        {
                                $edt = date('d M Y', $result->end_date);
                        }
                        else
                        {
                                $edt = $result->end_date;
                        }
                }
                echo form_input('end_date', $edt, 'class="validate[required] form-control datepicker col-md-6"');
                echo form_error('end_date');
                ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Description </h2></div>
            <div class="form-group editor">
              <div class="col-md-3">
                <label>Description</label>
              </div>
              <div class="col-md-9">
                <textarea id="description"  class="form-control wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>
              </div>
            </div>
        </div>

        <div class='form-group'>
          <div class="col-md-3"></div>
          <div class="col-md-9 text-right">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/exams', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
	</div>
</div>



</div>
