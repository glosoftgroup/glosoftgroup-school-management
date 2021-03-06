<?php
if ($this->input->get('pw'))
{
        $sel = $this->input->get('pw');
}
elseif ($this->session->userdata('pw'))
{
        $sel = $this->session->userdata('pw');
}
else
{
        $sel = 0;
}
?>
<div class="col-md-10">
   <!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Fee Payment </h4>
        <div class="heading-elements">
            <?php echo anchor('admin/fee_payment/create/', '<i class="glyphicon glyphicon-plus"></i> Receive Payment', 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/fee_payment', '<i class="glyphicon glyphicon-list"></i> ' . lang('web_list_all', array(':name' => 'Fee Payment')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/fee_payment/bulk', '<i class="glyphicon glyphicon-envelope"></i> Bulk SMS Reminder', 'class="btn btn-warning" '); ?>
        </div>
    </div>
    
    <div class="panel-body">
       
        <table class='table table-hover' id="fee_bal" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <th>#</th>
            <th>Student</th>
            <th>Class </th>
            <th>Adm. #</th>
            <th>Payable </th>
            <th>Paid </th>
            <th>Balance </th>
            <th width="13%"><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            </tfoot>

        </table> 
    </div>
</div>
</div>

<div class="col-md-2">

    <!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Filter by Class</h4>
        <div class="heading-elements">
        
        </div>
    </div>
    
    <div class="panel-body">           

            <ul class="media-list media-list-linked pb-5">
                <?php
                $i = 0;
                foreach ($this->classlist as $cid => $cl)
                {
                        $i++;
                        $cc = (object) $cl;
                        $cll = $sel == $cid ? 'sel' : '';
                        ?> 
                        <li class = "<?php echo $cll; ?> clearfix" >
                            <div class = "title">
                                <a href = "<?php echo current_url() . '?pw=' . $cid; ?>"><?php echo $cc->name; ?></a>
                                <p><?php echo $cc->size; ?> Students</p>
                            </div>
                        </li>
                <?php } ?>
            </ul>
        </div>
    </div>

</div>

<script type="text/javascript">
        $(document).ready(function () {
            var oTable;
            oTable = $('#fee_bal').dataTable({
                "dom": 'TC lfrtip',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/fee_payment/get_by_student'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html("<div class='btn-group'><a class='btn btn-success tip' data-original-title='View Statement' href ='<?php echo base_url('admin/fee_payment/statement/'); ?>" + "/" + aData[0] + "' ><i class='glyphicon glyphglyphicon glyphicon-list'></i></a> <a class='btn btn-warning tip'  onClick='return confirm(\"Are you sure you want to send SMS reminder to parent/guardian?\")' href ='<?php echo base_url('admin/fee_payment/reminder/'); ?>" + "/" + aData[0] + "' data-original-title='Send Reminder'  ><i class='glyphicon glyphicon-envelope'></i> </a>  " + '</div>');
                    $("td:nth-child(5)", nRow).addClass('rttb');
                    $("td:nth-child(6)", nRow).addClass('rttb');
                    $("td:nth-child(7)", nRow).addClass('rttb');
                    $(".tip", nRow).tooltip({placement: 'top', trigger: 'hover'});
                    return nRow;
                },
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
                },
                "aoColumns": [
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": " "
                    }
                ]
            }).fnSetFilteringDelay(700);
        });
</script>
