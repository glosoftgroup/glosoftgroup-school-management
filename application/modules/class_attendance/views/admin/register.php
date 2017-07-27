<?php
$settings = $this->ion_auth->settings();
$refNo = refNo();
?>
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Class Attendance </h4>
        <div class="heading-elements">
          <?php echo anchor('admin/class_attendance/list_attendance/' . $dat->class_id, '<i class="glyphicon glyphicon-list"></i> List All Class Attendance', 'class="btn btn-primary"'); ?>
        </div>
    </div>
    
    <div class="panel-body">
   
<?php if ($post): ?>  
        <div class="widget">
            <div class="block invoice">
                <div class="date right">F-<?php echo $refNo; ?>-<?php echo date('y', time()) . '-' . date('2', time()) . '-' . date('H', time()); ?></div>
                <div class="clearfix"></div>
                <div class="col-md-11 view-title text-center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="150" height="150" />
                        <h5><?php echo ucwords($settings->motto); ?>
                            <br>
                            <span style="font-size:0.6em !important"><?php echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' Cell:' . $settings->cell ?></span>
                        </h5>
                    </h1>	
                </div>
                <span border="0" class="left">
                    <abbr title="Phone"><b>Attendance Date</b>:</abbr>
                    <?php echo date('d M Y', $dat->attendance_date); ?><br>
                    <abbr title="Phone"><b>Attendance Title</b>:</abbr>
                    <?php echo $dat->title; ?>
                </span>
                <div class="clearfix"></div>
                <?php
                $cc = '';
                if (isset($this->classlist[$dat->class_id]))
                {
                        $cro = $this->classlist[$dat->class_id];
                        $cc = isset($cro['name']) ? $cro['name'] : '';
                }
                ?>
                <h3>Class Register For <span style="color:green"> <?php
                         echo $cc;
                        ?></span>
                </h3>
                <span class="right"><b>Total Present:</b> <?php echo $present; ?> Student(s) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   <b>Total Absent:</b> <?php echo $absent; ?> Student(s) </span>
                <div class="clearfix"></div>
                <table class="table table-hover mailbox fpTable" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="background:#55a2e6" width="45%">Student Details</th>
                            <th style="background:#55a2e6" width="10%">Present</th>
                            <th style="background:#55a2e6" width="10%">Absent</th>
                            <th style="background:#55a2e6" width="40%">Remarks</th>
                            <!--<th width="15%">Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($post as $p):
                                $i++;
                                $classes = $this->ion_auth->list_classes();
                                $u = $this->ion_auth->list_student($p->student);
                                ?>
                                <tr class="new">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <img src="<?php echo base_url('assets/themes/admin/img/examples/users/dmitry_m.jpg'); ?>" class="img-polaroid" align="left"/>
                                        <a href="<?php echo base_url('admin/admission/view/' . $p->student); ?>" class="details"><?php echo $u->first_name . ' ' . $u->last_name; ?>  [ ADM No. <?php
                                            if (!empty($u->old_adm_no))
                                                    echo $u->old_adm_no;
                                            else
                                                    echo $u->admission_number;
                                            ?> ]</a>
                                        <a href="#"><?php echo $u->email; ?></a>
                                    </td>
                <?php if ($p->status == 'Present'): ?>
                                            <td style="text-align:center">
                                                <button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
                                            </td>
                                            <td style="text-align:center">---</td>
                <?php else: ?>
                                            <td style="text-align:center">---</td>
                                            <td style="text-align:center">
                                                <button class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                                            </td>
                <?php endif; ?> 
                                    <td><?php echo $p->remarks; ?></td>
                                </tr>
        <?php endforeach ?>        
                    </tbody>
                </table>
            </div>
        </div>
<?php else: ?>
        <p class='text-center'><?php echo lang('web_no_elements'); ?></p>
                                                                        <?php endif ?>