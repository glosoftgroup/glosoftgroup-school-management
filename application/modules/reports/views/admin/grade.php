<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title"> Exams Report </h4>
        <div class="heading-elements">
         <div class="col-md-2"><div class="date  right" id="menus"> </div>
            <a href="" id="printBtn" onClick="return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
        </div>
    </div>
    
<div class="panel-body">    
<div class="toolbar">
    <div class="noof">
        <div class="col-md-10"><?php echo form_open(current_url()); ?>
            <?php echo form_dropdown('class', $ccc, $this->input->post('class'), 'class ="selecte" '); ?>
            <?php echo form_dropdown('exam', array('' => 'Select Exam') + $exams, $this->input->post('exam'), 'class ="select" '); ?>
            <button class="btn btn-primary"  type="submit">View Results</button>
            <?php echo form_close(); ?>
        </div>
        
    </div>
</div>
<div class="block invoice" id="printme">
    <?php
    if (!empty($res))
    {
            ?> <span class="left center titles">   
            <?php echo $this->school->school; ?>
                Grade Analysis Report  </span><br/><br/>
            <?php
            if ($ex)
            {
                    echo $ex->title . ' - Term ' . $ex->term . ' ' . $ex->year;
            }
            echo isset($ccc[$class]) ? '  - ' . $ccc[$class] : '';
            ?><hr>
            <table cellpadding="0" cellspacing="0" width="100%" class="resot stt">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SUBJECT</th>
                        <?php
                        foreach ($titles as $t)
                        {
                                ?>
                                <th class="rttb"><?php echo $t; ?></th>           
                        <?php } ?>
                        <th>M/S</th>
                        <th>M/G</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($res as $key => $grades)
                    {
                            $i++;
                            ?>
                            <tr class="rtrep">
                                <td width="4%"><?php echo $i; ?>.</td>
                                <td><?php echo $key; ?></td>
                                <?php
                                $gdtotal = 0;
                                $cls = 0;
                                foreach ($grades as $gkey => $collection)
                                {
                                        $base = $points[str_replace(' ', '', $gkey)];
                                        $ct = count($collection);
                                        $gdtotal += $ct * $base;
                                        $cls += $ct;
                                        ?>
                                        <td class="rttb"><?php echo $ct; ?></td>                
                                        <?php
                                }
                                $mnpt = round($gdtotal / $cls);
                                $mn_grade = isset(array_flip($points)[$mnpt]) ? array_flip($points)[$mnpt] : '';
                                ?>
                                <td class="rttb"><?php echo round($gdtotal / $cls, 3); ?></td>                
                                <td class="rttc"><?php echo $mn_grade; ?></td>                
                            </tr>
                    <?php } ?>
                    <tr class="rttbx">
                        <td class="rttb" colspan="3"> </td>                       
                        <td class="rttb">&nbsp; </td>
                        <td class="rttb" colspan="<?php echo count($titles); ?>"></td>                
                    </tr>
                </tbody>
            </table>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <table cellpadding="0" cellspacing="0" width="100%" class="table-hover">
                <thead>
                    <tr>
                        <th> </th>
                        <th  colspan="<?php echo count($summary); ?>"> Class Mean : <?php
                            $mean = array_sum($ipoints) / count($ipoints);
                            echo round($mean, 2);
                            ?>
                            ( <?php echo isset(array_flip($points)[round($mean)]) ? array_flip($points)[round($mean)] : ''; ?> )
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Students </td>   
                        <?php
                        foreach ($summary as $ttl => $count)
                        {
                                ?>
                                <td>  <?php echo $ttl; ?> </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td><?php echo $size; ?> </td>                         
                        <?php
                        foreach ($summary as $tl => $xcount)
                        {
                                ?>
                                <td>  <?php echo $xcount; ?> </td>
                        <?php } ?>                        
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-9"></div> 
                <div class="col-md-3"><small><?php echo 'Report Generated at:' . date('d M Y H:i:s'); ?></small></div>
            </div>
    <?php } ?>
</div>
<script>
        $(document).ready(function ()
        {
            $(".selecte").select2({'placeholder': 'Select Option', 'width': '200px'});
        });
</script>
<style>
    .fless{width:100%; border:0;}

    @media print{
        td.nob{  border:none !important; background-color:#fff !important;}
        .stt td, th {
            border: 1px solid #ccc;
        }  
    }
</style>