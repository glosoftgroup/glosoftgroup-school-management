<!-- Pager -->
<div class="panel panel-white animated fadeIn">
  <div class="panel-heading">
    <h4 class="panel-title"> Unlinked Students</h4>
    <div class="heading-elements">
    
    </div>
  </div>
  
  <div class="panel-body">    

<div class="block-fluid">
    <table cellpadding="0" cellspacing="0" border="0" class='hover' id="adm_table" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>ADM.</th>
                <th>Parent Name</th>
                <th>Active</th>
                 <th width="20%"><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
</div>
<script type="text/javascript">
     $(document).ready(function () {
          var oTable;
          oTable = $('#adm_table').dataTable({
               "dom": 'TC lfrtip', //'TC<"clear">lfrtip',
               "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
               },
               "bProcessing": true,
               "bServerSide": true,
               "sServerMethod": "GET",
               "sAjaxSource": "<?php echo base_url('admin/quickbooks/get_unlinked_students'); ?>",
               "iDisplayLength": <?php echo $this->list_size; ?>,
               "aLengthMenu": [[10, 25, 50, 250], [10, 25, 50, 250]],
               "aaSorting": [[0, 'asc']],
               "fnRowCallback": function (nRow, aData, iDisplayIndex)
               {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                     return nRow;
               },
               "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url('assets/ico/loader.gif'); ?>'>"
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
