<?php $settings = $this->ion_auth->settings(); ?>          
<div class="col-md-12">

    <div class="widget">

        <div class=" invoice">

            <div class="widget">

                <div class="col-md-12 view-title center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />  </h1>	
                    <h5><?php echo ucwords($settings->school); ?>
                        <br>
                        <span style="font-size:0.7em !important"><?php echo $settings->motto; ?></span>
                    </h5>
                    <h3> PROFIT AND LOSS STATEMENT AS AT: <?php echo date('d M, Y', time()); ?> </h3>
                    <div class="clearfix"></div>
                    <div>&nbsp;</div>
                </div>

                <div id="tabxx">

                    <table cellpadding="0" cellspacing="0" width="60%" style="margin: 15px auto;">

                        <tbody>
                            <?php
                            $rv = 0;
                            $xp = array();
                            foreach ($accounts as $typ => $fins)
                            {
                                if (is_array($fins) && !empty($fins))
                                {
                                    ?>
                                    <tr>
                                        <td colspan="3"><strong><?php echo$typ; ?></strong></td>
                                    </tr>
                                    <?php
                                    foreach ($fins as $fk)
                                    {
                                        $k = (object) $fk;
                                        $rv +=$k->balance;
                                        ?>
                                        <tr>
                                            <td><?php echo $k->account; ?></td>
                                            <td class="rttx"><?php echo number_format($k->balance, 2); ?></td>
                                            <td class="rttx"></td>
                                        </tr>
                                        <?php
                                    }
                                    $xp[] = $rv;
                                }
                                ?>
                                <tr>
                                    <td class="rttb"> <strong>Total <?php echo$typ; ?></td>
                                    <td class="rttx"></td>
                                    <td class="rttx"><strong><?php echo number_format($rv, 2); ?></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp; </td>
                                </tr>
                                <?php
                                $rv = 0;
                            }
                            ?>
                            <tr>
                                <td class="rttb"> PROFIT/(LOSS)</td>
                                <td><?php //echo number_format($dr, 2); ?></td>
                                <td class="ctots"><?php echo number_format(($xp[0] - $xp[1]) - $rv, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <p>&nbsp; </p>
                </div>

            </div>


        </div>

    </div>

</div>

<style>
    @media print{

        .navigation{
            display:none;
        }
        .head{
            display:none;
        }

        .tip{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; }
        .view-title h3{border:none !important; }

        .split{

            float:left;
        }
        .header{display:none}
        .invoice { 
            width:100%;
            margin: auto !important;
            padding: 0px !important;
        }
        .invoice table{padding-left: 0; margin-left: 0; }

        .smf .content {
            margin-left: 0px;
        }
        .content {
            margin-left: 0px;
            padding: 0px;
        }
    }
</style> 

