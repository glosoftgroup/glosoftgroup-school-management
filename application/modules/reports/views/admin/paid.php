<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Fee Payments Report</h4>
        <div class="heading-elements">
         <a href="" id="printBtn" onClick="return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
    </div>
    
    <div class="panel-body">
    
<div class="toolbar">
    <div class="noof">
        <div class="spadn7"><?php echo form_open(current_url()); ?>
            From:<?php echo form_input('from', $this->input->post('from'), 'class ="datepicker col-md-3" '); ?>
            To: <?php echo form_input('to', $this->input->post('to'), 'class ="datepicker col-md-3" '); ?>
            <button class="btn btn-primary"  type="submit">View Payments</button>
            <?php echo form_close(); ?>
        </div>
    </div>
    </div>
    <div class="block invoice" id="printme">
        <h1> </h1>

        <div class="row">
            <div class="col-md-10">
                <h3><?php echo $this->school->school; ?>  Fee Payments Report </h3>
            </div>
        </div>

        <table cellpadding="0" cellspacing="0" width="100%" class="table table-hover nob">
            <thead>
                <tr class="bg-primary">
                    <th width="3%">#</th>
                    <th width="10%">Date</th>
                    <th width="20%">Name</th>
                    <th width="8%">Class</th>
                    <th width="22%">Description</th>
                    <?php /*<th width="25%">Account</th>
                    <th width="10%">Method</th>*/?>
                    <th width="11%">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                ksort($paid);
                $i = 0;
                $s = 0;
                $opd = 0;
                $obal = 0;
                foreach ($paid as $kl => $specs)
                {
                        $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
                        ?>
                        <tr>
                            <td> </td>
                            <td colspan="5"><strong><?php echo $cname; ?>  </strong></td>
                        </tr>
                        <?php
                        foreach ($specs as $str => $pays)
                        {
                                foreach ($pays as $pay)
                                {
                                        $kstr = isset($str_opts[$str]) ? $str_opts[$str] : ' ';
                                        $i++;
                                        $s++;
                                        $opd += $pay->amount;
                                        $stu = $this->worker->get_student($pay->reg_no);
                                        ?>
                                        <tr>
                                            <td><?php echo $i . '. '; ?></td>
                                            <td> <?php echo $pay->payment_date > 10000 ? date('d M Y', $pay->payment_date) : ''; ?></td>
                                            <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?> </td>
                                            <td><?php echo $cname . ' ' . $kstr; ?></td>
                                            <td><?php 
								   if($pay->description==0) echo 'Tuition Fee Payment'; 
								   elseif(is_numeric($pay->description)) echo $extras[$pay->description]; 
								   else echo $p->description;
								   ?><?php //echo $pay->description; ?></td>
                                             <?php /*<td> <?php echo isset($bank[$pay->bank_id]) ? $bank[$pay->bank_id] : ' '; ?></td>
                                            <td><?php echo $pay->payment_method; ?> </td>*/?>
                                            <td class="rttb text-right text-semibold"><?php echo number_format($pay->amount, 2); ?> </td>
                                        </tr>
                                        <?php
                                }
                        }
                        ?> <tr class="rttbt">
                             <td> </td>
                            <td> </td>
                            <td> </td>
                            <td colspan="2"><?php echo $cname; ?> Totals:</td>
                            <td class="rttb text-right text-semibold"><?php echo number_format($opd, 2); ?></td>
                        </tr>
                        <?php
                        $i = 0;
                        $obal += $opd;
                        $opd=0;
                }
                ?>
                <tr>
                    <td colspan="4" > </td>
                    <td >&nbsp; </td>
                    <td></td>
                </tr>
                <tr>
                     <td></td>
                     <td></td>
                    <td colspan="2" class="border-bottom-lg border-bottom-danger text-right text-bold rttbd" > Total Payments:  </td>
                    <td colspan="2"  class="text-bold text-right rttbd"><?php echo number_format($obal, 2);        ?></td>
                </tr>
                <tr>
                    <td colspan="4" > </td>
                    <td >&nbsp; </td>
                    <td></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                     <td class="border-bottom-lg border-bottom-danger text-right" colspan="2" ><small>Total Payments: <?php echo number_format($s); ?></small></td>
                    <td colspan="2" class="text-right" ><small> Date: <?php echo date('d M Y H:i:s'); ?></small></td>
                </tr>

            </tbody>
        </table>

        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3"> </div>
        </div>

    </div>
