<div class="col-md-12">
    <!-- Pager -->
<div class="panel panel-indigo">
	<div class="panel-heading">
		<h6 class="panel-title">Employees Attendance</h6>
		<div class="heading-elements">
			<ul class="pager pager-sm">
				<li>
				 <?php echo anchor('admin/employees_attendance/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Employees Attendance')), 'class="btn btn-primary"'); ?>
				</li>
				<li><?php echo anchor('admin/employees_attendance', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Employees Attendance')), 'class="btn btn-primary"'); ?></li>
			</ul>
		</div>
	</div>

	<div class="panel-body">
		<?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>

        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN -->
                <thead>
                    <tr role="row">
                        <th width="3%">#</th>
                        <th width="17%"><i class="glyphicon glyphicon-calendar "></i> Date </th>
                        <th width="40%" >Employee</th>
                        <th width="20%">Time In</th>
                        <th width="20%">Time Out</th>
                    </tr>
                </thead>
            </table>

            <div id="entry1" class="clonedInput">

                <table class='table' cellpadding="0" cellspacing="0" width="100%">
                    <tbody>

                        <tr >

                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>
                            <td width="17%">
                                <?php echo form_input('date[]', $result->date > 0 ? date('d M Y', $result->date) : $result->date, 'class="validate[required] form-control datepicker col-md-6 date"'); ?>
                            </td>

                            <td width="40%">
                                <?php
                                $staff = $this->ion_auth->list_staff();
                                echo form_dropdown('employee[]', array('' => 'Select Employee') + $staff, (isset($result->employee)) ? $result->employee : '', ' class="form-control col-md-12 employee select_ttl" id="employee" style=""');
                                echo form_error('employee');
                                ?>
                            </td>

                            <td width="20%">
                                <input type="text" name="time_in[]" id="time_in" class="form-control time_in col-md-12 input_ed timepicker" value="<?php
                                if (!empty($result->time_in))
                                {
                                        echo $result->time_in;
                                }
                                ?>">
                                       <?php echo form_error('time_in'); ?>
                            </td>
                            <td width="20%">
                                <input type="text" name="time_out[]" id="time_out" class="form-control time_out   col-md-12 input_ed timepicker" value="<?php
                                if (!empty($result->time_out))
                                {
                                        echo $result->time_out;
                                }
                                ?>">
                                       <?php echo form_error('time_out'); ?>
                            </td>


                        </tr>

                    </tbody>
                </table>
            </div>



            <div class="actions">
                <a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a>
                <a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
            </div>
        </div>
        <br />
        <br />
        <div class='form-group'>
            <div class="col-md-4">


                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Bulk Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/class_timetable', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>


        <?php echo form_close(); ?>
        <div class="clearfix"></div>
	</div>
</div>
<!-- /pager -->





</div>

<?php echo core_js('core/js/bootstrap-datepicker.min.js'); ?>
<?php echo core_js('core/js/jquery.timepicker.js'); ?>

<script src="<?php echo plugin_path('bootstrap.daterangepicker/moment.js'); ?>" ></script>
<script src="<?php echo plugin_path('bootstrap.daterangepicker/daterangepicker.js'); ?>" ></script>
<script src="<?php echo plugin_path('bootstrap.datetimepicker/bootstrap-datetimepicker.min.js'); ?>"></script>
<link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">

        <!-- Updated JavaScript url -->
        <script src="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>

<script type="text/javascript">


        $(function () {
            $('#btnAdd').click(function () {

                //$('input.timepicker').eq(0).clone().removeClass("hasTimepicker").prependTo('#entry2');
                var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                        newNum = new Number(num + 1), // the numeric ID of the new input field being added
                        newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
                // manipulate the name/id values of the input inside the new element
                // H2 - section
                newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);

                // employee - select

                newElem.find('.employee').attr('id', 'ID' + newNum + '_employee').val('');

                // start date name - text

                newElem.find('.time_in').attr('id', 'ID' + newNum + '_time_in').val('').removeClass("hasTimepicker").timepicker({
                    showPeriod: true,
                    showLeadingZero: true
                }).focus();

                // end name - text

                newElem.find('.time_out').attr('id', 'ID' + newNum + '_time_out').val('').removeClass("hasTimepicker").timepicker({
                    showPeriod: true,
                    showLeadingZero: true
                }).focus();


                // subject - select
                newElem.find('.date').attr('id', 'ID' + newNum + '_date').val('').removeClass("hasDatepicker").datepicker({
                    format: "dd MM yyyy",
                }).focus();


                // insert the new element after the last "duplicatable" input field
                $('#entry' + num).after(newElem);



                // enable the "remove" button
                $('#btnDel').attr('disabled', false);

                // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
                if (newNum == 100)
                    $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
            });

            $('#btnDel').click(function () {
                // confirmation
                if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
                {
                    var num = $('.clonedInput').length;
                    // how many "duplicatable" input fields we currently have
                    $('#entry' + num).slideUp('slow', function () {
                        $(this).remove();
                        // if only one element remains, disable the "remove" button
                        if (num - 1 === 1)
                            $('#btnDel').attr('disabled', true);
                        // enable the "add" button
                        $('#btnAdd').attr('disabled', false).prop('value', "add section");
                    });
                }
                return false;
                // remove the last element

                // enable the "add" button
                $('#btnAdd').attr('disabled', false);
            });

            $('#btnDel').attr('disabled', true);

        });


</script>
