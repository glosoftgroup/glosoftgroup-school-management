<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  All Classes  </h2>
    <div class="right">  
        <?php echo anchor('admin/class_groups/promotion', '<i class="glyphicon glyphicon-thumbs-up">
                </i> Promote Students to next class', 'class="btn btn-warning"'); ?> 
    </div>
</div>

<div class="block-fluid">
    <table id="fee_bal" cellpadding="0" cellspacing="0" width="100%">
        <thead>
        <th>#</th>
        <th>Class </th>
        <th>Class Teacher</th>
        <th>No. of Students</th>
        <th>Status</th>
        <th width="20%"><?php echo lang('web_options'); ?></th>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        </tfoot>

    </table> 
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
                "sAjaxSource": "<?php echo base_url('admin/class_groups/get_classes'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, 100, 200, 500], [10, 25, 50, 100, 200, 500]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html(" <div class='btn-group'><a class='btn btn-success' href ='<?php echo base_url('admin/class_groups/view/'); ?>" + "/" + aData[0] + "' ><i class='glyphicon glyphicon-eye-open'></i> View</a><a class='btn btn-primary' href ='<?php echo base_url('admin/class_groups/class_teacher/'); ?>" + "/" + aData[0] + "' >Class Teacher</a>  " + '</div>');
                    $("td:nth-child(5)", nRow).addClass('rttb');
                    $("td:nth-child(6)", nRow).addClass('rttb');
                    $("td:nth-child(7)", nRow).addClass('rttb');
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
