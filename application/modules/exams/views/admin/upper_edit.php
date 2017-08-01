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
 <!-- Pager -->
 <div class="panel panel-white border-left-lg border-left-danger animated zoomIn">
     <div class="panel-heading">
         <h4 class="panel-title">Select a Subject</h4>
         <div class="heading-elements">
         
         </div>
     </div>
     
     <div class="panel-body">
           

            <ul class="media-list tickets">
                <?php
                $i = 0;
                foreach ($subjects as $sj => $dets)
                {
                        $ds = (object) $dets;
                        if ($ds->full == '')
                        {
                                continue;
                        }
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
   <!-- Pager -->
   <div class="panel panel-white panel-white border-left-lg border-left-primary animated fadeIn">
       <div class="panel-heading">
           <h4 class="panel-title">Exams Management</h4>
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
        if (count($students) && count($result))
        {
                ?>
                <h3 style="text-align:center; text-decoration:underline"><?php echo $class_name; ?></h3>
                <table class="table-striped table-bordered " >
                    <thead>
                        <tr > 
                            <th width="3%">#</th>
                            <th width="20%">Student</th>
                            <?php
                            $sel = (object) $selected;
                            if (isset($sel->units))
                            {
                                    foreach ($sel->units as $utk => $utt)
                                    {
                                            ?>
                                            <th><abbr title=" <?php echo $utt; ?>">
                                                    <?php echo $utt; ?>
                                                </abbr>
                                            </th>
                                            <?php
                                    }
                            }
                            ?>
                            <th> Total Marks</th>
                           <!-- <th width="15%">Remarks</th>-->
                        </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php
                        $i = 1;
                        $tot_class = '';
                        foreach ($students as $post):
                                $std = $this->worker->get_student($post->id);
                                $mk = isset($result[$post->id]) ? (object) $result[$post->id] : array();
                                $mkbase = isset($mk->marks) ? (object) $mk->marks : new stdClass();
                                ?>  
                                <tr>
                                    <td>
                                        <span id="reference" name="reference" class="heading-reference"><?php echo $i . '. '; ?></span>
                                    </td>
                                    <td> <?php echo $std->first_name . ' ' . $std->last_name; ?>  </td>
                                    <?php
                                    if (isset($sel->units))
                                    {
                                            $tot_class = 'totd_' . $sb;
                                            $units = isset($mkbase->units) ? $mkbase->units : array();
                                            foreach ($sel->units as $utk => $utt)
                                            {
                                                    ?>
                                                    <td>
                                                        <?php
                                                        $uval = isset($units[$utk]) ? $units[$utk] : '';
                                                        if ($this->input->post('units'))
                                                        {
                                                                $usetval = $this->input->post('units');
                                                                $uval = $usetval[$post->id][$utk];
                                                        }
                                                        $unm = 'units[' . $post->id . '][' . $utk . ']';
                                                        echo form_input($unm, $uval, ' placeholder="Marks" class="umarks mkd_' . $sb . '" ');
                                                        echo form_error('units');
                                                        ?>
                                                    </td>
                                                    <?php
                                            }
                                    }
                                    ?>
                                    <td>
                                        <?php
                                        $val = isset($mkbase->mk) ? $mkbase->mk : '';
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
                                  <!--  <td>
                                    <?php
                                    $rval = isset($mk->remarks) ? $mk->remarks : '';
                                    if ($this->input->post('remarks'))
                                    {
                                            $rmval = $this->input->post('remarks');
                                            $rval = htmlspecialchars_decode($rmval[$post->id]);
                                    }
                                    $rnm = 'remarks[' . $post->id . ']';
                                    ?>
                                        <textarea name="<?php echo $rnm; ?>" cols="25" rows="1" class="col-md-12 remarks" id="remarks_<?php echo $i; ?>"><?php echo $rval; ?></textarea>
                                    <?php echo form_error('remarks'); ?>
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

<script>
        $(function () {
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

                /**--------------Update Total Score-------------------*/
                var tt = 0;
                $(this).closest('tr').find(".marks").each(function ()
                {
                    tt += parseInt($(this).val()) || 0;
                });

                $(this).closest('tr').find(".total").val(tt);

            });

            $(".marks,.umarks").on("keypress", function (event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                    notify('Only Numbers allowed');
                }
            });
        });

</script>
