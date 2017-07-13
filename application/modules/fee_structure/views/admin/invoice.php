<div class="row actions">
    <div class="  right" id="menus">
        <h3>Generate Per Class Or Per Student</h3>	
        <?php echo form_open('admin/fee_structure/invoice/'); ?>
        Select a Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $this->classes, $this->input->post('class'), 'class="select"') ?> 
        or
        <select name="student" class="select" tabindex="-1">
            <option value="">Select Student</option>
            <?php
            $data = $this->ion_auth->students_full_details();
            foreach ($data as $key => $value):
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $value ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="checkbox" name="waiver" value="1"/> Include Fee Waiver
        <input type="checkbox" name="bal" value="1"/> Include Balance
        <button class="btn btn-warning"  style="height:30px;" type="submit">View Invoice</button>
        <a href="" onClick="window.print();
                    return false" class="btn btn-primary"><i class="icos-printer"></i> Print
        </a>
        </form>
        <br>
        <br>
    </div>
</div>

<div class="widget">
    <?php
    if ($flag)
    {//************************multiple**/
            foreach ($payload as $student => $row)
            {
                    $bal = $row['bal'];
                    $parent = $row['parent'];
                    $post = $this->worker->get_student($student);
                    $invoice = $row['invoice'];
                    ?>
                    <div class="slip">
                        <div class="statement">
                            <div class="block invoice slip-content">
                                <div class="row row-fluid">
                                    <div class="col-sm-3 invoice-left">
                                        <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" alt="" style="width: 80%;">
                                    </div>
                                    <div class="col-sm-9 span9 invoice-left">
                                        <h1><?php echo $this->school->school; ?></h1>
                                        <br>
                                        <?php
                                        if (!empty($this->school->tel))
                                        {
                                                echo $this->school->postal_addr . '<br> Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                        }
                                        else
                                        {
                                                echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="center">
                                        <span class="center titles">STUDENT INVOICE  </span>
                                        <hr>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-12">
                                        <div class="col-md-10 ">
                                            <b style="font-size:15px">Student:</b>
                                            <abbr title="Name" style="font-size:15px" ><?php echo $post->first_name . ' ' . $post->last_name; ?> </abbr>
                                            <span class="right" style="font-size:15px">
                                                <b style="font-size:15px">Invoice No: </b>
                                                <?php echo date('m') . '/' . date('y') . '-' . $post->id; ?>
                                            </span>
                                            <br>
                                            <b style="font-size:15px">Class</b>:
                                            <abbr title="Stream" style="font-size:15px"><?php
                                                echo $classes_groups[$classes[$post->class]];
                                                ?></abbr>
                                            <span class="right" style="font-size:15px">
                                                <b>Invoice Date: </b>
                                                <?php echo date('d M Y', time()) ?>
                                            </span>	

                                            <br>
                                            <span style="font-size:15px" >
                                                <b>Admission No:</b>
                                                <?php
                                                if (!empty($post->old_adm_no))
                                                {
                                                        echo $post->old_adm_no;
                                                }
                                                else
                                                {
                                                        if ($post->admission_number)
                                                        {
                                                                echo $post->admission_number;
                                                        }
                                                }
                                                ?>
                                            </span>			
                                            <hr>
                                        </div>		  
                                    </div>
                                </div>

                                <h5 class = "center titles">Tuition and Extra Fees for Next term.</h5>
                                <table cellpadding = "0" cellspacing = "0" width = "100%" class = "stt" style = "margin-bottom: 6px;">
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Amount (<?php echo $this->currency; ?>)</th>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    $tot = 0;
                                    $extra = 0;
                                    $wvd = 0;
                                    $arr = isset($bal->balance) ? $bal->balance : 0;
                                    foreach ($invoice as $yr => $fees)
                                    {
                                            foreach ($fees as $term => $row)
                                            {
                                                    foreach ($row as $title => $specs)
                                                    {
                                                            if ($title === 'Extra')
                                                            {
                                                                    foreach ($specs as $dkey => $dspec)
                                                                    {
                                                                            $ds = (object) $dspec;
                                                                            $extra += $ds->amount;
                                                                    }
                                                            }
                                                            if ($title === 'Waivers')
                                                            {
                                                                    foreach ($specs as $dkey => $dspec)
                                                                    {
                                                                            $ds = (object) $dspec;
                                                                            $wvd += $ds->amount;
                                                                    }
                                                            }

                                                            foreach ($specs as $key => $spec)
                                                            {
                                                                    $s = (object) $spec;
                                                                    $tot += $title === 'Waivers' ? 0 : $s->amount;
                                                                    $i++;
                                                                    ?>
                                                                    <tr class="item-row">
                                                                        <td width="5%"><?php echo $i; ?>. </td>
                                                                        </td>
                                                                        <td class="description"> <?php echo $s->desc; ?>  </td>
                                                                        <td  width="25%" class="amt">
                                                                            <?php
                                                                            echo ($title === 'Waivers') ? '- ' : '';
                                                                            echo number_format($s->amount, 2);
                                                                            ?> </td>
                                                                    </tr>
                                                                    <?php
                                                            }
                                                    }
                                            }
                                    }
                                    $actual = $has_wv ? ($arr + $wvd) - $extra : $arr - $extra;
                                    if ($has_wv)
                                    {
                                            $tot = $tot - $wvd;
                                    }
                                    ?>
                                    <tr class="rttb">
                                        <td class="blank"> </td>
                                        <td class="total-line"><b>Subtotal:</b></td>
                                        <td class="amt"> <strong><?php echo number_format($tot, 2); ?></strong></td>
                                    </tr>
                                    <?php
                                    if ($has_bal)
                                    {
                                            ?>
                                            <tr class="rttb">
                                                <td class="blank"> </td>
                                                <td class="total-line"><b>Current Fee Arrears: </b></td>
                                                <td class="amt"><strong><?php echo number_format($actual, 2); ?></strong></td>
                                            </tr>
                                    <?php } ?>
                                    <tr class="rttb">
                                        <td class="blank"> </td>
                                        <td class="total-line balance"><b>Total Due: </b></td>
                                        <td class="total-value balance amt" style="border-bottom:double"><strong>
                                                <?php echo $has_bal ? number_format(($tot + $actual), 2) : number_format(($tot), 2); ?></strong></td>
                                    </tr>

                                </table>
                                <?php
                                if ($banks)
                                {
                                        ?>
                                        <h5 style="width:100%; border-bottom:1px solid #000;">Bank(s) Details</h5>
                                        <table width="100%" border="0" style="border:none !important">
                                            <tr style="border:none !important">
                                                <th style="border:none !important" width="3%">#</th>
                                                <th style="border:none !important; text-align:left">Bank Name</th>
                                                <th style="border:none !important; text-align:left">Account Name</th>
                                                <th style="border:none !important;text-align:left ">Branch</th>
                                                <th style="border:none !important; text-align:left">Account No.</th>
                                            </tr>
                                            <?php
                                            $i = 0;
                                            foreach ($banks as $b)
                                            {
                                                    $i++;
                                                    ?>
                                                    <tr style="border:none !important">
                                                        <td style="border:none !important"><?php echo $i; ?></td>
                                                        <td style="border:none !important"><?php echo $b->bank_name ?></td>
                                                        <td style="border:none !important"><?php echo $b->account_name ?></td>
                                                        <td style="border:none !important"><?php echo $b->branch ?></td>
                                                        <td style="border:none !important"><?php echo $b->account_number ?></td>
                                                    </tr>
                                            <?php } ?>
                                    <?php } ?>
                                    <tr style="border:none !important">
                                        <td style="border:none !important"> </td>
                                        <td style="border:none !important">Mobile Payment</td>
                                        <td style="border:none !important"> </td>
                                        <td style="border:none !important" colspan="2"><?php echo $this->school->mobile_pay ?></td>
                                    </tr>
                                </table>

                                <span style="width:400px">
                                    <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Thank you for choosing <?php
                                        $ss = $this->school;
                                        echo $ss->school;
                                        ?></h3>
                                </span>

                            </div>
                            <div class="footer">
                                <div class="center" style="border-top:1px solid #ccc">		
                                    <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                                        <?php
                                        if (!empty($this->school->tel))
                                        {
                                                echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                        }
                                        else
                                        {
                                                echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                        }
                                        ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
            }
    }
    else
    {//single
            //*********** ****END PER STUDENT ********* ******************************///
            if (isset($post) && !empty($post))
            {
                    ?>
                    <div class="col-md-12 slip">

                        <div class="statement">
                            <div class="block invoice slip-content">
                                <div>
                                    <div class="center">
                                        <h1><?php echo $this->school->school; ?></h1>
                                        <br>
                                        <?php
                                        if (!empty($this->school->tel))
                                        {
                                                echo $this->school->postal_addr . '<br> Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                        }
                                        else
                                        {
                                                echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                        }
                                        ?>
                                        </span>
                                        <br>
                                        <br>
                                        <span class="center titles">STUDENT INVOICE  </span>
                                        <hr>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-md-12">
                                        <div class="col-md-10 " style="font-size:15px">
                                            <b>Student:</b>
                                            <abbr title="Name" style="font-size:18px" ><?php echo $post->first_name . ' ' . $post->last_name; ?> </abbr>
                                            <span class="right">
                                                <b>Invoice No.: </b>
                                                <?php
                                                echo date('m') . '/' . date('y') . '-' . $post->id;
                                                ?>
                                            </span>	

                                            <br>
                                            <b>Class</b>:
                                            <abbr title="Stream"><?php
                                                echo $classes_groups[$classes[$post->class]];
                                                ?></abbr>

                                            <span class="right">
                                                <b>Invoice Date: </b>
                                                <?php echo date('d M Y', time()) ?>
                                            </span>	

                                            <br>
                                            <span >
                                                <b>Registration Number:</b>
                                                <?php
                                                if (!empty($post->old_adm_no))
                                                {
                                                        echo $post->old_adm_no;
                                                }
                                                else
                                                {
                                                        if ($post->admission_number)
                                                        {
                                                                echo $post->admission_number;
                                                        }
                                                }
                                                ?>
                                            </span>			
                                            <hr>
                                        </div>		  
                                    </div>
                                </div>
                                <h5 class="center titles">Tuition and Extra Fees for Next term.</h5>
                                <table cellpadding="0" cellspacing="0" width="100%" class="stt" style="margin-bottom: 6px;">
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Amount (<?php echo $this->currency; ?>)</th>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    $tot = 0;
                                    $extra = 0;
                                    $wvd = 0;
                                    $arr = isset($bal->balance) ? $bal->balance : 0;
                                    foreach ($payload as $yr => $fees)
                                    {
                                            foreach ($fees as $term => $row)
                                            {
                                                    foreach ($row as $title => $specs)
                                                    {
                                                            if ($title === 'Extra')
                                                            {
                                                                    foreach ($specs as $dkey => $dspec)
                                                                    {
                                                                            $ds = (object) $dspec;
                                                                            $extra += $ds->amount;
                                                                    }
                                                            }
                                                            if ($title === 'Waivers')
                                                            {
                                                                    foreach ($specs as $dkey => $dspec)
                                                                    {
                                                                            $ds = (object) $dspec;
                                                                            $wvd += $ds->amount;
                                                                    }
                                                            }

                                                            foreach ($specs as $key => $spec)
                                                            {
                                                                    $s = (object) $spec;
                                                                    $tot += ($title === 'Waivers') ? 0 : $s->amount;
                                                                    if (($title === 'Waivers') && !$has_wv)
                                                                    {
                                                                            continue;
                                                                    }
                                                                    $i++;
                                                                    ?>
                                                                    <tr class="item-row">
                                                                        <td width="5%"><?php echo $i; ?>. </td>
                                                                        <td class="description"> <?php echo $s->desc; ?>   </td>
                                                                        <td  width="25%" class="amt">
                                                                            <?php
                                                                            echo ($title === 'Waivers') ? '- ' : '';
                                                                            echo number_format($s->amount, 2);
                                                                            ?> 
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                            }
                                                    }
                                            }
                                    }
                                    $actual = $has_wv ? ($arr + $wvd) - $extra : $arr - $extra;
                                    if ($has_wv)
                                    {
                                            $tot = $tot - $wvd;
                                    }
                                    ?>
                                    <tr class="rttb">
                                        <td class="blank"> </td>
                                        <td class="total-line"><b>Subtotal: <?php echo $this->currency; ?></b></td>
                                        <td class="amt"> <strong><?php echo number_format($tot, 2); ?></strong></td>
                                    </tr>
                                    <?php
                                    if ($has_bal)
                                    {
                                            ?>
                                            <tr class="rttb">
                                                <td class="blank"> </td>
                                                <td class="total-line"><b>Current Fee Arrears: </b></td>
                                                <td class="amt"><strong><?php echo number_format($actual, 2); ?></strong></td>
                                            </tr>
                                    <?php } ?>
                                    <tr class="rttb">
                                        <td class="blank"> </td>
                                        <td class="total-line balance"><b>Total Due:</b></td>
                                        <td class="total-value balance amt" style="border-bottom:double"><strong>
                                                <?php echo $has_bal ? number_format(($tot + $actual), 2) : number_format(($tot), 2); ?></strong></td>
                                    </tr>

                                </table>
                                <?php
                                if ($banks)
                                {
                                        ?>
                                        <h5 style="width:100%; border-bottom:1px solid #000;">Bank(s) Details</h5>
                                        <table width="100%" border="0" style="border:none !important">
                                            <tr style="border:none !important">
                                                <th style="border:none !important" width="3%">#</th>
                                                <th style="border:none !important; text-align:left">Bank Name</th>
                                                <th style="border:none !important; text-align:left">Account Name</th>
                                                <th style="border:none !important;text-align:left ">Branch</th>
                                                <th style="border:none !important; text-align:left">Account No.</th>
                                            </tr>
                                            <?php
                                            $i = 0;
                                            foreach ($banks as $b)
                                            {
                                                    $i++;
                                                    ?>
                                                    <tr style="border:none !important">
                                                        <td style="border:none !important"><?php echo $i; ?></td>
                                                        <td style="border:none !important"><?php echo $b->bank_name ?></td>
                                                        <td style="border:none !important"><?php echo $b->account_name ?></td>
                                                        <td style="border:none !important"><?php echo $b->branch ?></td>
                                                        <td style="border:none !important"><?php echo $b->account_number ?></td>
                                                    </tr>

                                            <?php } ?>
                                    <?php } ?>
                                </table>
                                <span style="width:400px">
                                    <h3 style="border:1px solid #ccc; text-align:center; background-color:#F5F5F5; "> Thank you for choosing <?php
                                        $ss = $this->school;
                                        echo $ss->school;
                                        ?></h3>
                                </span>

                            </div>
                            <div class="footer">
                                <div class="center" style="border-top:1px solid #ccc">		
                                    <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                                        <?php
                                        if (!empty($this->school->tel))
                                        {
                                                echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                        }
                                        else
                                        {
                                                echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                        }
                                        ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
            }
            else
            {
                    ?>

                    <!--
                <div class="col-md-12 slip">

                <div class="statement">
                <div class="block invoice slip-content">
                <h3>Please Select Student First</h3>

                    <?php echo form_open('admin/fee_structure/invoice/'); ?> 
                <select name="student" class="select" tabindex="-1">
                <option value="">Select Student</option>
                    <?php
                    $data = $this->ion_auth->students_full_details();
                    foreach ($data as $key => $value):
                            ?>
                                                                                                                                                                                                        <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-warning"  style="height:30px;" type="submit">View Invoice</button>

                    <?php form_close(); ?>
                </div>
                </div>
                </div>
                    -->
                    <?php
            }
    }
    ?>

</div>
<style>
    .amt{text-align: right;}
    .fless{width:100%; border:0;}
    .slip {
        width: 21cm;
        min-height: 29.7cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    @page {
        size: A4;
        margin: 0;
    }
    @media print{
        .slip{
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;   
        }
        td.nob{  border:none !important; background-color:#fff !important;}
        .stt td, th {
            border: 1px solid #ccc;
        } 
        table tr{
            border:1px solid #666 !important;
        }
        table th{
            border:1px solid #666 !important;
        }
        table td{
            border:1px solid #666 !important;
        }	
        .highlight{
            background-color:#000 !important;
            color:#fff !important;
        }	

    }
    .actions{background-color: #fff; padding: 8px}
</style>
