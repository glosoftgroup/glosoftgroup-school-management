<div class="col-md-12">
   <!-- Pager -->
   <div class="panel panel-white animated fadeIn">
   <?php $std = $this->worker->get_student($student); ?> 
       <div class="panel-heading">
           <h4 class="panel-title">Progress Record For: <?php echo $std->first_name . ' ' . $std->last_name; ?></h4>
           <div class="heading-elements">
              <?php echo anchor('admin/exams/rec_lower/' . $class . '/' . $stream . '/1/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?> 
            <button onClick="return false;" id="printBtn" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
           </div>
       </div>
       
       <div class="panel-body" id="printme">
        

        
        <div class="col-md-9">
            <h3 align="text-center"> <?php echo $this->school->school; ?></h3> 
            <h4 align="text-center"> Progress Record For <?php echo isset($this->classes[$class]) ? $this->classes[$class] : ' - '; ?></h4> 
            <b>Student : </b>
            <abbr title="Name" ><?php echo ucwords($std->first_name . ' ' . $std->last_name); ?> </abbr>
            <span class="text-right">
                <b>Class :</b>
                <abbr title="Class"><?php echo isset($this->classes[$class]) ? $this->classes[$class] : ' - '; ?></abbr>
                <b>Year :</b>
                <abbr title="Class"><?php echo date('Y'); ?></abbr>
            </span>	

        </div>
        <?php
        $frm = array();
        $frmw = array();
        foreach ($remarks as $rm)
        {
            if ($rm->sub_id == 9999)
            {
                $frmw[$rm->parent] = $rm->remarks;
            }
            else
            {
                $frm[$rm->parent][$rm->sub_id] = $rm->remarks;
            }
        }
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>

        <?php
        if (count($subjects) < 1)
        {
            ?>
            <div class="col-md-6">
                <div class="alert alert-block">                
                    <strong>Error!</strong> You Must Add All Subjects First Before Recording Exam Marks 
                    <br><br>Add Subjects <?php echo anchor('admin/subjects', 'Here'); ?>
                </div>
            </div>
            <?php
        }
        else
        {
            ?>
            <table width="100%">
                <tr> 
                    <th colspan="2" width="40%">TESTS</th>
                    <th colspan="2" width="60%"><?php echo isset($exams[$exam]) ? strtoupper($exams[$exam]) : ' '; ?><br>
                        CLASS TEACHER'S REMARKS</th>
                </tr>
                <?php                        
                foreach ($subjects as $key =>$post):
                    ?><tr> 
                        <?php
                        if (isset($subtests[$key]))
                        {
                            $tts = $subtests[$key];
                            ?>
                            <td rowspan="<?php echo count($tts); ?>"> <?php echo $full_subjects[$key]; ?>  </td>
                            <?php
                            foreach ($tts as $tid => $ttl)
                            {
                                $nm = 'rmk_' . $key . '_' . $tid;
                                $srmk = isset($frm[$key]) && isset($frm[$key][$tid]) ? $frm[$key][$tid] : '';
                                ?>
                                <td><?php echo $ttl; ?></td><td colspan="2" class="bglite"><span class="editable remarks" id="<?php echo $nm; ?>" ><?php echo $srmk; ?></span></td> </tr>
                            <?php
                        }
                    }
                    else
                    {
                        $nm = 'rmk_' . $key;
                        $mrmk = isset($frmw[$key]) ? $frmw[$key] : ' ';
                        ?>
                        <td colspan="2"> <?php echo $full_subjects[$key]; ?> </td>
                        <td colspan="2"  class="bglite"><span  class="editable remarks" id="<?php echo $nm; ?>"><?php echo $mrmk; ?></span></td>
                        </tr>
                    <?php } ?>
                <?php endforeach; ?>         

            </table>

            <div class='form-group'>
                <div class="col-md-10"> 
                </div>
            </div>
        <?php } ?> 
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        //editables on first profile page
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
                '<button type="button" class="btn editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
        $('.remarks').editable({
            type: 'text',
            title: 'Enter Remarks',
            placement: 'right',
            pk: <?php echo $student; ?>,
            url: '<?php echo base_url('admin/exams/push_lower/' . $exam); ?>',
            defaultValue: '   ',
            success: function (response, newValue) {
                notify('Progress Record', 'Remarks Added: ' + newValue);
            }
        }
        );

    });
</script>
<style>
    .bglite{background-color: #fff;}
</style>