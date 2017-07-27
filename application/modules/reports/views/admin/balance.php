<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Fee Status Report</h4>
        <div class="heading-elements">
          <a href="" id="printBtn" onClick="return false;" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
    </div>
    
    <div class="panel-body">
    
<div class="toolbar">
    <div class="noof">
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-9"><?php echo form_open(current_url()); ?>
            Include Suspended<input type="checkbox" name="sus" value="1"/>
            <button class="btn btn-primary"  type="submit">Submit</button>
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-2"> 
        </div>
    </div>
</div>
<div class="block invoice" id="printme">
    <h1> </h1>

    <div class="row">
        <div class="col-md-10">
            <h3><?php echo $this->school->school; ?>  Fee Status Report  -  <?php echo date('d M Y'); ?></h3>
        </div>
    </div>

    <table cellpadding="0" cellspacing="0" width="100%" class="table table-hover nob">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="20%">Name</th>
                <th width="10%">Class</th>
                <th width="11%">ADM</th>
                <th width="15%">Invoiced Amt.</th>
                <th width="15%">Paid</th>
                <th width="15%">Overall Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            ksort($fee);
            $i = 0;
            $s = 0;
            $opd = 0;
            $obal = 0;
            foreach ($fee as $kl => $strpecs)
            {
                    $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
                    ?>
                    <tr>
                        <td> </td>
                        <td colspan="6"><strong><?php echo $cname; ?>  </strong></td>
                    </tr>
                    <?php
                    $ivs = 0;
                    $pds = 0;
                    $bal = 0;

                    foreach ($strpecs as $str => $kids)
                    {
                            foreach ($kids as $kid)
                            {
                                    $kstr = isset($str_opts[$str]) ? $str_opts[$str] : ' ';
                                    $i++;
                                    $s++;
                                    $ivs += $kid->invoice_amt;
                                    $pds += $kid->paid;
                                    $bal += $kid->balance > 0 ? $kid->balance : 0;
                                    $stu = $this->worker->get_student($kid->id);
                                    ?> 
                                    <tr>
                                        <td><?php echo $i . '. '; ?></td>
                                        <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?> </td>
                                        <td ><?php echo $cname . ' ' . $kstr; ?></td>
                                        <td><?php echo $kid->old_adm_no ? $kid->old_adm_no : $kid->admission_number; ?></td>
                                        <td class="rttb"> <?php echo number_format($kid->invoice_amt, 2); ?></td>
                                        <td class="rttb"> <?php echo number_format($kid->paid, 2); ?></td>
                                        <td class="rttb"><?php echo number_format($kid->balance, 2); ?> </td>
                                    </tr>
                                    <?php
                            }
                            $opd += $pds;
                            $obal += $bal > 0 ? $bal : 0;
                    }
                    ?> <tr class="rttbt">
                        <td colspan="2" > </td>
                        <td colspan="2"><?php echo $cname; ?> Totals:</td>
                        <td class="rttb"><?php echo number_format($ivs, 2); ?></td>
                        <td class="rttb"><?php echo number_format($pds, 2); ?></td>
                        <td class="rttb"><?php echo number_format($bal, 2); ?></td>
                    </tr>
                    <?php
                    $i = 0;
            }
            ?>
            <tr>
                <td colspan="5" > </td>
                <td >&nbsp; </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" > </td>
                <td colspan="2"  class="rttbd">  Total Payments This Term: </td>
                <td class="rttbd"><?php echo number_format($opd, 2); ?></td>
                <td class="rttbd">  Overall Balance: </td>
                <td class="rttbd"><?php echo number_format($obal, 2); ?></td>
            </tr>
            <tr>
                <td colspan="5" > </td>
                <td >&nbsp; </td>
                <td></td>
            </tr>
            <tr>
                <td> </td>
                <td> </td>
                <td  colspan="3" ><small>Total Students: <?php echo number_format($s); ?></small></td>
                <td colspan="2" ><small> Date: <?php echo date('d M Y H:i:s'); ?></small></td>
            </tr>

        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>
