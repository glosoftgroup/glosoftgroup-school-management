<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Teachers</h4>
        <div class="heading-elements">
         <?php echo anchor('admin/teachers/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Teachers')), 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/teachers', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Teachers')), 'class="btn btn-primary"'); ?> 

        </div>
    </div>
    
    <div class="panel-body">
   
    <table class="table table-hover" id="ModeTable" cellpadding="0" cellspacing="0" width="100%">
        <thead>
        <th>#</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>	
        <th>Status</th>	
        <th>Designation</th>	
        <th width="20%"><?php echo lang('web_options'); ?></th>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

</div>


<script type="text/javascript">
    $(document).ready(function() {
        var oTable;
        oTable = $('#ModeTable').dataTable({
            "dom": 'TC lfrtip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/teachers/get_table'); ?>",
            "iDisplayLength": <?php echo $this->list_size;?>,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html(" <div class='btn-group'> <a class='btn btn-primary' href ='<?php echo base_url('admin/teachers/edit/'); ?>"  + "/" + aData[0] + "'  ><i class='glyphicon glyphicon-edit'></i> Edit Details</a>  </div>");
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
                {"bVisible": true, "bSearchable": false, "bSortable": false},
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