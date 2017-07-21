<?php
if ($this->input->get('sb'))
{
        $sel = $this->input->get('sb');
}
elseif ($this->session->userdata('sub'))
{
        $sel = $this->session->userdata('sub');
}
else
{
        $sel = 0;
}
?>


<div class="col-md-3">

   <div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">Select a Subject</h6>
		<div class="heading-elements">
		</div>
	</div>


        <div class="panel-body">
            <ul class="list tickets">
                <?php
                $i = 0;
                foreach ($subjects as $sj => $dets)
                {
                        $ds = (object) $dets;
                        $i++;
                        $cll = $sel == $sj ? 'sel' : '';
                        ?>
                        <li class = "<?php echo $cll; ?> clearfix" >
                            <div class = "title">
                                <a href = "<?php echo current_url() . '?sb=' . $sj; ?>"><?php echo $ds->full; ?></a>
                                <p>&nbsp;</p>
                            </div>
                        </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<div class="col-md-9">
	<div class="panel panel-primary">
	<div class="panel-heading">
		<h6 class="panel-title">Exams Management</h6>
		<div class="heading-elements">
			 <?php echo anchor('admin/exams/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
		</div>
	</div>

    <div class="panel-body">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url() . '?sb=' . $sb, $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='grading'>Grading System <span class='required'>*</span></div>
            <div class="col-md-9">
                <?php
                echo form_dropdown('grading', array('' => '') + $grading, isset($sel_gd) ? $sel_gd : '', ' class="select" data-placeholder="Select Grading System" ');
                echo form_error('grading');
                ?>
            </div>
        </div>
        <?php
        if (count($students))
        {
                ?>
                <h3 style="text-align:center; text-decoration:underline"><?php echo $class_name; ?></h3>
                <table class="table table-striped table-bordered " >
                    <!-- BEGIN -->
                    <thead>
                        <tr>
                            <th width="3%">#</th>
                            <th>Student</th>
                            <?php
                            $sel = (object) $selected;
                            if (isset($sel->units))
                            {
                                    foreach ($sel->units as $utk => $utt)
                                    {
                                            ?>
                                            <th>
                                                <abbr title="<?php echo $utt; ?>">
                                                    <?php echo $utt; ?>
                                                </abbr>
                                            </th>
                                            <?php
                                    }
                            }
                            ?>
                            <th>Total Marks</th>
                           <!-- <th>Remarks</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $tot_class = '';
                        foreach ($students as $post):
                                $std = $this->worker->get_student($post->id)
                                ?>
                                <tr>
                                    <td>
                                        <span id="reference" name="reference" class="heading-reference"><?php echo $i . '. '; ?></span>
                                    </td>
                                    <td> <?php echo $std->first_name . ' ' . $std->last_name; ?>  </td>
                                    <?php
                                    if (isset($sel->units))
                                    {
                                            $outs = $sel->outs;
                                            $tot_class = 'totd_' . $sb;
                                            foreach ($sel->units as $utk => $utt)
                                            {
                                                    ?>
                                                    <td>
                                                        <?php
                                                        $uval = '';
                                                        $cap = isset($outs[$utk]) ? $outs[$utk] : 0;
                                                        if ($this->input->post('units'))
                                                        {
                                                                $usetval = $this->input->post('units');
                                                                $uval = $usetval[$post->id][$utk];
                                                        }
                                                        $unm = 'units[' . $post->id . '][' . $utk . ']';
                                                        echo form_input($unm, $uval, ' title="' . $cap . '" placeholder="Marks" class="umarks mkd_' . $sb . '" ');
                                                        echo form_error('units');
                                                        ?>
                                                    </td>
                                                    <?php
                                            }
                                    }
                                    ?>
                                    <td>
                                        <?php
                                        $val = '';
                                        if ($this->input->post('marks'))
                                        {
                                                $setval = $this->input->post('marks');
                                                $val = $setval[$post->id];
                                        }
                                        $nm = 'marks[' . $post->id . ']';
                                        echo form_input($nm, $val, '  placeholder="Marks" class="marks ' . $tot_class . '" ');
                                        echo form_error('marks');
                                        ?>
                                    </td>
                               <!--        <td>
                                    <?php
                                    $rval = '';
                                    if ($this->input->post('remarks'))
                                    {
                                            $rmval = $this->input->post('remarks');
                                            $rval = htmlspecialchars_decode($rmval[$post->id]);
                                    }
                                    $rnm = 'remarks[' . $post->id . ']';
                                    ?>
                                     <textarea name="<?php //echo $rnm;         ?>" cols="25" rows="1" class="col-md-12 remarks" id="remarks_<?php //echo $i;                              ?>"><?php //echo $rval;                              ?></textarea>
                                    <?php //echo form_error('remarks');   ?>
                                    </td>-->
                                </tr>
                                <?php
                                $i++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
                <div class='form-group'>
                    <div class="col-md-10">
                        <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                        <?php echo anchor('admin/exams', 'Cancel', 'class="btn btn-danger"'); ?>
                    </div>
                </div>

        <?php } ?>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
	</div>
</div>

<script>
        $(function ()
        {
            $('.marks').on('blur', function ()
            {
                var tt = 0;
                $(this).closest('tr').find(".marks").each(function ()
                {
                    tt += parseInt($(this).val()) || 0;
                });

                $(this).closest('tr').find(".total").val(tt);
            });

            var val;
            $('.umarks').on('blur', function ()
            {
                var unit_tot = 0;
                var $tr = $(this).closest('tr');

                var get = $.grep(this.className.split(" "), function (v, i)
                {
                    return v.indexOf('mkd_') === 0;
                }).join();
                val = get.match(/\bmkd_(\d+)\b/)[1];

                $tr.find(".mkd_" + val).each(function ()
                {
                    unit_tot += parseInt($(this).val()) || 0;
                });
                $tr.find(".totd_" + val).val(unit_tot);
                /**--------------Convert Percentage-------------------*/
                var outt = 0;
                var perce = unit_tot;
                $tr.find(".umarks").each(function ()
                {
                    outt += parseInt($(this).attr('title')) || 0;
                });
                $tr.find(".xtt").html(outt);

                if (outt > 0)
                {
                    if (outt != 100)
                    {
                        perce = Math.round((unit_tot / outt) * 100);
                    }
                    $tr.find(".totd_" + val).val(perce);
                }
                /**--------------Update Total Score-------------------*/
                var tt = 0;
                $(this).closest('tr').find(".marks").each(function ()
                {
                    tt += parseInt($(this).val()) || 0;
                });

                $(this).closest('tr').find(".total").val(tt);

            });

            $(".marks,.umarks").on("keypress", function (event)
            {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57))
                {
                    event.preventDefault();
                    notify('Only Numbers allowed');
                }
            });
        });
</script>
