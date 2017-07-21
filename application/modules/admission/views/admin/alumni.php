<!-- Pager -->
<div class="panel panel-white">
    <div class="panel-heading">
        <h6 class="panel-title">Alumni Students </h6>
        <div class="heading-elements">
            <?php echo anchor('admin/admission/create/' , '<i class="glyphicon glyphicon-plus"></i> New Admission', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list"></i> ' . lang('web_list_all', array(':name' => 'Students')), 'class="btn btn-primary"'); ?>
      <?php echo anchor('admin/admission/alumni/', '<i class="glyphicon glyphicon-thumbs-up"></i> Alumni Students', 'class="btn btn-success"'); ?>      
        <?php echo anchor('admin/admission/inactive/', '<i class="glyphicon glyphicon-question-sign"></i> Inactive Students', 'class="btn btn-warning"'); ?>
        </div>
    </div>
    
    <div class="panel-body">
     <table cellpadding="0" cellspacing="0" border="0" class='table table-hover' id="adm_table" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>ADM Number</th>
                <th>Gender</th>
                <th>Birthday</th>
                <th>Admission Date</th>
                <th>Completion Year</th>    
                <th ><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
     
    </div>
</div>



<script type="text/javascript">
        $(document).ready(function () {
            var oTable;
            oTable = $('#adm_table').dataTable({
                "dom": 'TC lfrtip', 
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/admission/completed'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    var htm = '<div class="btn-group"> <button class="btn btn-default">Actions</button>   ' +
                            ' <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>' +
                            '<ul class="dropdown-menu pull-right">' +
                            ' <li><a href="<?php echo base_url('admin/admission/view/'); ?>' + "/" + aData[0] + '">Profile</a></li>' +
                            ' <li><a href="<?php echo base_url('admin/admission/edit/'); ?>' + "/" + aData[0] + '">Edit</a></li>' +
                            ' <li><a onClick="return confirm(\'Are you sure you want to activate this student?\')" href="<?php echo base_url('admin/admission/activate/'); ?>' + "/" + aData[0] + '">Activate</a></li>' +
                            ' <li><a href="<?php echo base_url('admin/admission/sus_payment/' ); ?>' + "/" + aData[0] + '" target="blank">Payment</a></li>' +
                            '</ul>' +
                            '</div>';
                    $("td:last", nRow).html(htm);
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
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true}
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": "null"
                    }
                ]
            }).fnSetFilteringDelay(700);
        });
</script>
