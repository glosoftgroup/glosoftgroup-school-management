<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Admission </h2>
    <div class="right">
        <?php
        if ($this->ion_auth->is_admin())
        {
                ?>
                <div class='btn-group'>	
                    <?php echo anchor('admin/admission/create/' . $page, '<i class="glyphicon glyphicon-plus"></i>New Admission', 'class="btn btn-primary"'); ?>
                    <?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list"></i> ' . lang('web_list_all', array(':name' => 'Students')), 'class="btn btn-primary"'); ?> 
                    <?php echo anchor('admin/admission/alumni/', '<i class="glyphicon glyphicon-thumbs-up"></i> Alumni Students', 'class="btn btn-success"'); ?>
                    <?php echo anchor('admin/admission/inactive/', '<i class="glyphicon glyphicon-question-sign"></i> Inactive Students', 'class="btn btn-warning"'); ?>
                </div>
        <?php } ?>
    </div>
</div>

<div class="block-fluid">
    <table cellpadding="0" cellspacing="0" border="0" class='hover' id="adm_table" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th width="">Student Name</th>
                <th>Class</th>
                <th>ADM.</th>
                <th>Parent Name</th>
                <th>Parent Phone</th>
                <th width="20%"><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
</div>
<script type="text/javascript">
        $(document).ready(function ()
        {
            var oTable;
            oTable = $('#adm_table').dataTable({
                "dom": 'TC lfrtip', //'TC<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/admission/get_table'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, 250, -1], [10, 25, 50, 250, "All"]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex)
                {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html("  <div class='btn-group'><a class='btn btn-success' href ='<?php echo base_url('admin/admission/view/'); ?>" + "/" + aData[0] + "' >Profile</a><?php
        if ($this->ion_auth->is_admin())
        {
                ?> <a class='btn btn-primary' href ='<?php echo base_url('admin/admission/edit/'); ?>" + "/" + aData[0] + "' >Edit</a> <a class='kftt btn btn-danger' href ='<?php echo base_url('admin/suspended/create/'); ?>" + "/" + aData[0] + "' ' >Suspend</a><?php } ?>" + '</div>');
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