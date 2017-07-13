<div class="head">
    <div class="icon"></div>
    <h2></h2>
    <div class="right"></div>    					
</div><?php
$sslist = array();
foreach ($this->classlist as $ssid => $s)
{
        $sslist[$ssid] = $s['name'];
}
?>
<div class="toolbar">
    <div class="row row-fluid">
        <div class="col-md-12 span12">
            <?php echo form_open(current_url()); ?>
            Class
            <?php echo form_dropdown('class', array('' => 'Select Class') + $sslist, $this->input->post('class'), 'class ="tsel" '); ?>
            Exam(s) 
            <?php echo form_dropdown('exams[]', $exams, $this->input->post('exams'), 'class ="fsel" multiple placeholder="Select Exams" '); ?>
            <button class="btn btn-primary"  type="submit">View Report</button>
            <div class="pull-right"> 
                <a href="" onClick="window.print(); return false" class="btn btn-primary"><i class="icos-printer"></i> Print </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php
$ij = 0;
$bars = array();
foreach ($mks as $student => $pyl)
{
        $ij ++;
        $st = $this->worker->get_student($student);
        $cst = ' - ';
        if (isset($st->cl))
        {
                $crr = isset($this->classes[$st->cl->class]) ? $this->classes[$st->cl->class] : '';
                $ctr = isset($streams[$st->cl->stream]) ? $streams[$st->cl->stream] : '';
                $cst = $crr . $ctr;
        }
        $p = (object) $pyl;
        ?>
        <div class="invoice">
            <div class="row row-fluid">
                <div class="row-fluid center">
                    <span class="" style="text-align:center">
                        <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="80" height="80" />
                    </span>
                    <h3>
                        <span style="text-align:center !important;font-size:20px;"><?php echo strtoupper($this->school->school); ?></span>
                    </h3>
                    <small style="text-align:center !important;font-size:13px; line-height:2px;">
                        <?php
                        if (!empty($this->school->tel))
                        {
                                echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                        }
                        else
                        {
                                echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                        }
                        ?>
                    </small>
                    <h3>
                        <span style="text-align:center !important;font-size:22px; font-weight:700; border:double; padding:5px;">MOTTO: <?php echo strtoupper($this->school->motto); ?></span>
                    </h3>
                    <br>
                    <small style="text-align:center !important;font-size:20px; line-height:2px; border-bottom:2px solid  #ccc;">Student Performance Terminal Report</small>
                    <br>
                 </div>
                <div class="col-sm-9 invoice-left">
                    <div class="col-xs-2 hpe">
                        <?php
                        if (!empty($st->pass))
                        {
                                ?>
                                <img src="<?php echo base_url('uploads/' . $st->pass->fpath . '/' . $st->pass->filename); ?>" alt="">
                        <?php } ?>
                    </div>
                    <strong>Student: <?php echo $st->first_name . ' ' . $st->last_name; ?></strong> &nbsp;
                    <strong class="pull-right"> Level: <?php echo $cst; ?> &nbsp; </strong>                    
                    <strong> Adm. No. </strong><strong><?php echo isset($st->old_adm_no) && !empty($st->old_adm_no) ? $st->old_adm_no : $st->admission_number; ?> </strong>  &nbsp;
                    <strong class="pull-right"> Produced On:
                        <?php
                        $estr = '';
                        foreach ($list as $e)
                        {
                                $estr = $e->start_date;
                        }
                        ?>
                        <?php echo date('d M Y'); ?> &nbsp; </strong>
                </div>
            </div>
             <table class="tablex table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th><b>Subject</b></th>
                        <?php
                        $tf = 0;
                        foreach ($list as $l)
                        {
                                $tf++;
                                $pref = str_ireplace('Exams', '', $l->title);
                                $pref = str_ireplace('Exam', '', $pref);
                                $tt = trim($pref) . ' ' . $l->term . ' ' . $l->year;
                                ?>
                                <th><b><?php echo $tt; ?></b></th>
                                <?php
                        }
                        ?>
                        <th><b>Average.</b></th>
                        <th><b>Grade</b></th>
                        <th><b>Remarks</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($p->res as $sub => $spms)
                    {
                            $sp = (object) $spms;
                            $i++;
                            if (isset($sp->units) && !empty($sp->units))
                            {
                                    foreach ($sp->units as $uxid => $uxres)
                                    { //These are sub units
                                            ?>
                                            <tr>
                                                <td class="text-center"></td>
                                                <td class=""><?php echo $uxid; ?></b></td>
                                                <?php
                                                foreach ($uxres as $e)
                                                {
                                                        $rs = (object) $xres;
                                                        ?>
                                                        <td><small><?php echo $e; ?></small></td>
                                                <?php } ?>
                                                <td class="">  </td>
                                                <td class="">  </td>
                                            </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i; ?></td>
                                        <td><b><?php echo $sp->subject; ?> TOTAL</b></td>
                                        <?php
                                        //These are exams without sub units
                                        $k = 0;
                                        foreach ($sp->maks as $xid => $xres)
                                        {
                                                $k++;
                                                $rs = (object) $xres;
                                                ?>
                                                <td class="text-right"><b><?php echo $rs->marks; ?></b></td>
                                        <?php } ?>
                                        <td style="text-align:center"><strong> <?php
                                                $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                                                echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : '';
                                                ?>  </strong>
                                        </td>
                                        <td style="text-align:center"><strong> <?php
                                                $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                                                echo isset($rmks->grade) && isset($grades[$rmks->grade]) ? $grades[$rmks->grade] : '';
                                                ?> </strong> 
                                        </td>
                                    </tr>
                                    <?php
                            }
                            else
                            {
                                    //These are exams without sub units
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i; ?></td>
                                        <td><b><?php echo $sp->subject; ?></b></td>
                                        <?php
                                        $k = 0;
                                        foreach ($sp->maks as $xid => $xres)
                                        {
                                                $k++;
                                                $rs = (object) $xres;
                                                ?>
                                                <td class="text-right"><b><?php echo $rs->marks; ?></b></td>
                                        <?php } ?>
                                        <td style="text-align:center"><strong> <?php
                                                $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                                                echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : '';
                                                ?>  </strong></td>
                                        <td style="text-align:center"><strong> <?php
                                                $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                                                echo isset($rmks->grade) && isset($grades[$rmks->grade]) ? $grades[$rmks->grade] : '';
                                                ?> </strong> </td>
                                    </tr>
                                    <?php
                            }
                    }
                    ?>
                    <tr class="rttbx">
                        <td class="text-center"> </td>
                        <td> <strong> Totals per Exam  </strong></td>
                        <?php
                        foreach ($p->tots as $gd)
                        {
                                ?>
                                <td class="text-right"><?php echo $gd; ?></td>  
                        <?php } ?>
                        <td class="">  </td>
                        <td class="">  </td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td class="bltop"> </td>
                        <td class="rttb">  POSITION: <strong><?php echo $ij; ?></strong></td>
                        <td class="bltop"> <strong>OUT OF: <?php echo count($mks); ?></strong></td>
                        <td class="bltop">  </td>
                        <td class="">  </td>
                        <td class="">  </td>
                    </tr>
                </tbody>
            </table>
            <div id="pxbar<?php echo $ij; ?>" class="grapdh" style="width:82%; height:200px;"></div>
            <div>						 
                <div class="foo"> <br> </div>
                <div class="foo">
                    <strong><span style="text-decoration:underline">Student's Co-curricular Activities:</span></strong>
                    <br>
                    <span style="line-height:30px; font-size:20px;">
                        ................................................................................................................................................................										  
                </div>
                <div class="foo">
                    <strong><span style="text-decoration:underline">Class Teacher's Remarks:</span></strong>
                    <br>
                    <span style="line-height:30px; font-size:20px;">
                        ................................................................................................................................................................
                        .................................................................<strong><span style="font-size:12px"> Days Absent</span></strong>....................<strong><span style="font-size:12px">  Sign</span></strong>................................
                    </span>

                </div>
                <br>
                <strong><span style="text-decoration:underline">Headteacher's/Deputy Headteacher's Remarks:</span></strong>
                <span style="line-height:30px; font-size:20px;">
                    ................................................................................................................................................................
                    ...................................................................................................<strong><span style="font-size:12px">  Sign</span></strong>.........................
                </span>
                <br>
                <span style="line-height:30px; font-size:20px;">

                    <strong><span style="font-size:12px"> Next Term Begins On </span></strong>.....................<strong><span style="font-size:12px"> Fee Balance </span></strong>...................<strong><span style="font-size:12px"> Next Term Fee</span></strong> ..................... <strong><span style="font-size:12px"> Total Fee</span></strong>......................

                </span>
                <br>
                <span style="line-height:30px; font-size:20px; ">
                    <strong><span style="font-size:12px"> Parent / Guardian Signature</span></strong>.......................................................................................................................................

                </span>
            </div>
            <div class="center" style="border-top:1px solid #ccc">		
                <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                    This document was produced without any alteration. For any question please contact our office 
                    <?php
                    echo ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                    ?>
                </span>
            </div>
            <div class="margin"></div>
            <div class="row row-fluid">
                <div class="col-sm-6 span6">                   
                </div>
                <div class="col-sm-6 span6">
                    <div class="invoice-right"> </div>
                </div>
            </div>
        </div>
        <?php
        $scores = array();
        foreach ($p->bars as $kk => $scr)
        {
                $rtt = (object) $titles[$kk];
                $xtit = $rtt->term == 'Average' ? $rtt->term : 'Term ' . $rtt->term;
                $scores[] = array('marks' => $scr, 'title' => $xtit);
        }
        ?>
        <script>
                $(document).ready(
                        function ()
                        {
                            Morris.Bar({
                                element: 'pxbar<?php echo $ij; ?>',
                                data: <?php echo json_encode($scores); ?>,
                                xkey: 'title',
                                ykeys: ['marks'],
                                labels: ['Marks'],
                                barSizeRatio: 0.55,
                                barSize: 50,
                                xLabelAngle: 35,
                                hideHover: 'auto',
                                grid: true
                            });

                        });</script>
        <div class="page-break"></div>
<?php } ?>
<script>
        $(document).ready(
                function ()
                {
                    $(".tsel").select2({'placeholder': 'Please Select', 'width': '200px'});
                    $(".tsel").on("change", function (e) {
                        notify('Select', 'Value changed: ' + e.added.text);
                    });
                    $(".fsel").select2({'placeholder': 'Please Select', 'width': '400px'});
                    $(".fsel").on("change", function (e) {
                        notify('Select', 'Value changed: ' + e.added.text);
                    });
                });
</script>
<style>
    .morris-hover{position:absolute;z-index:1000;}.morris-hover.morris-default-style{border-radius:10px;padding:6px;color:#666;background:rgba(255, 255, 255, 0.8);border:solid 2px rgba(230, 230, 230, 0.8);font-family:sans-serif;font-size:12px;text-align:center;}.morris-hover.morris-default-style .morris-hover-row-label{font-weight:bold;margin:0.25em 0;}
    .morris-hover.morris-default-style .morris-hover-point{white-space:nowrap;margin:0.1em 0;}
    .tablex{ width: 95% !important; margin: auto 15px  !important; border:1px solid #000 !important;}
    .tablex tr{
        border:1px solid #000 !important;
    }
    .tablex td{
        border:1px solid #000 !important;
    }
    .tablex th{
        border:1px solid #000 !important;
    }
    .page-break{margin-bottom: 15px;}
    @media print {
        .tablex{ width: 100%;}
        .page-break{ display: block; page-break-after: always; position: relative;}
        table td, table th { padding: 4px; }
    }
</style>