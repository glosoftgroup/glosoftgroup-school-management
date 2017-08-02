<?php echo theme_css('sett.css'); ?>
        <?php echo theme_css('jquery.dataTables.css'); ?>   
        <?php echo theme_css('tableTools.css'); ?>   
        <?php echo theme_css('dataTables.colVis.min.css'); ?>
        <?php echo theme_css('select2/select2.css'); ?>
        <?php echo theme_css('themes/default.css'); ?>
        <?php echo theme_css('themes/default.date.css'); ?>
        <?php echo theme_css('stylesheets.css'); ?>     
        <?php echo theme_css('custom.css'); ?>
        <?php echo theme_css('output.css'); ?>
        <link href="<?php echo js_path('plugins/jeditable/bootstrap-editable.css'); ?>" rel="stylesheet">
<div class="panel panel-flat">
    <div class="panel-heading">
      <h5 class="panel-title">All Classes</h5>
      <div class="heading-elements">
        <div class="heading-btn">

             <?php echo anchor('admin/class_groups/promotion', '<i class="glyphicon glyphicon-thumbs-up">
                </i> Promote Students to next class', 'class="btn heading-btn btn-warning"'); ?>

        </div>
      </div>
    </div>
    <div class="panel-body">
        <div class="row">
          <table class='table datatable-showall' id="fee_bal" width="100%">
            <thead>
             <tr>
                <th>#</th>
                <th>Class </th>
                <th>Class Teacher</th>
                <th>No. of Students</th>
                <th>Status</th>
                <th width="20%"><?php echo lang('web_options'); ?></th>
             </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            </tfoot>
      </table>
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
                "sAjaxSource": "<?php echo base_url('admin/class_groups/get_classes'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, 100, 200, 500], [10, 25, 50, 100, 200, 500]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html(" <div class='btn-group'><button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button><ul class='dropdown-menu pull-right'><li><a class='' href ='<?php echo base_url('admin/class_groups/view/'); ?>" + "/" + aData[0] + "' ><i class='glyphicon glyphicon-eye-open'></i> View</a></li><li><a class='' href ='<?php echo base_url('admin/class_groups/class_teacher/'); ?>" + "/" + aData[0] + "' ><i class='icon-user'></i>Class Teacher</a></li></ul>  " + '</div>');
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
