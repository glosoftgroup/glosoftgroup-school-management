<div class="panel">
<div class="panel-heading">
    <div class="icon"><span class="icosg-target1"></span></div>
    <div class="heading-btn">  <h2> Subjects Report   </h2> </div>
</div>

<div class="panel-body">
    <div class="noof">
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-7"><?php echo form_open(current_url()); ?>
            <?php echo form_dropdown('class', array('' => 'Select Class') + $this->classes, $this->input->post('class'), 'class ="select" '); ?>
          </div>
        <div class="col-md-2">
          <button class="btn btn-primary"  type="submit">View Results</button>
        </div><?php echo form_close(); ?>
        </div>
        <div class="col-md-2"><div class="date  right" id="menus">
            </div>
            <a href="" onClick="window.print();
                        return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
      </div>
</div>
</div>
<div class="block invoice">
    <?php
    if ($pst)
    {
            ?>
            <span class="left center titles">
                <?php echo $this->school->school; ?>
                Class Subjects Report
                <hr></span>
            <table cellpadding="0" cellspacing="0" width="100%" class="stt">
                <thead>
                    <tr>
                        <th width="4%"> #</th>
                        <th width="20%"> Subject</th>
                        <th width="20%"> Terms</th>
                        <th width="36"> Units</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $i = 0;
                        foreach ($pst as $sub => $p)
                        {
                                $p = (object) $p;
                                $i++;
                                $sbj = isset($subjects[$sub]) ? $subjects[$sub] : '';
                                ?>
                                <td <?php echo $p->has ? 'rowspan="' . count($p->units) . '"' : ''; ?>><?php echo $i . '.'; ?></td>
                                <td <?php echo $p->has ? 'rowspan="' . count($p->units) . '"' : ''; ?>> <?php echo $sbj; ?> </td>
                                <td  <?php echo $p->has ? 'rowspan="' . count($p->units) . '"' : ''; ?>>Term
                                    <?php
                                    foreach ($p->terms as $tm)
                                    {
                                            echo '<span class="label label-info">' . $tm . '</span> ';
                                    }
                                    if ($p->has)
                                    {
                                            foreach ($p->units as $key => $value)
                                            {
                                                    ?>
                                                <td> <?php echo isset($value['title']) ? $value['title'] : ''; ?></td> </tr>
                                            <?php
                                    }
                            }
                            else
                            {
                                    ?>
                                <td><?php echo $sbj; ?></td> </tr>
                                <?php
                        }
                }
                ?>
                </tbody>
            </table>

            <div class="row">
                <div class="panel panel-white animated fadeIn">
                </div>
                <div class="col-md-3"> <small><?php echo 'Report Generated at:' . date('d M Y H:i:s'); ?></small></div>
            </div>
            <?php
    }
    else
    {
            ?><span class='alert alert-warning col-md-12 text-center'>Select Class to see Exam Subjects</span> <?php } ?>
</div>
<style>
    .fless{width:100%; border:0;}

    @media print{
        td.nob{  border:none !important; background-color:#fff !important;}
        .stt td, th {
            border: 1px solid #ccc;
        }
    }
</style>
