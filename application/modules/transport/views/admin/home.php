<?php
if ($this->input->get('sw'))
{
        $sel = $this->input->get('sw');
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

<div class="col-md-9">
  <!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Student Transport</h4>
        <div class="heading-elements">
         <div class="btn-group" >
                <a href="<?php echo base_url('admin/transport/routes'); ?>" class="btn btn-primary">Routes</a>     
            </div>
        </div>
    </div>
    
    <div class="panel-body">
        
    <div class="block-fluid">
        <?php echo form_open(current_url(), 'class="form-inline" id="fext"'); ?>
        <table cellpadding="0" cellspacing="0" border="0" class='table table-hover' id="adm_table" width="100%">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th >Student Name</th>
                    <th>Class</th>
                    <th>ADM. No.</th>
                    <th width="5%"><input type="checkbox" class="checkall"/></th>
                    <th ><?php echo lang('web_options'); ?></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        <?php echo form_error('sids', '<p class="error" style="width:200px; margin: 15px auto;" >', '</p>'); ?>
        <table class="clon" width="100%">
            <tr id="entry1"> 
                <td width="55%"><?php
                    echo form_dropdown('route', array('' => 'Select Route') + $list, '', ' class="fsel validate[required] fetcher"');
                    echo form_error('route');
                    ?>
                </td>
                <td>
                    <?php echo form_dropdown('term', array('' => ' Term') + $this->terms, '', 'class="xsel validate[required]" '); ?>
                    <?php echo form_error('term'); ?>
                </td> 

                <td> <?php
                    krsort($yrs);
                    echo form_dropdown('year', array('' => 'Year') + $yrs, '', 'class=" xsel validate[required]" ');
                    echo form_error('year');
                    ?></td> 
            </tr>
        </table>

        <div class='form-group'>
        <div class="col-md-12 text-right" style="padding: 12px;">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary' "); ?>
                <?php echo anchor('admin/fee_structure', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>
</div>
<div class="col-md-3">
    <!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Classes</h4>
        <div class="heading-elements">
        
        </div>
    </div>
    
    <div class="panel-body">
           
            <div class="clearfix"></div>
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
                                <a href = "<?php echo current_url() . '?sw=' . $cid; ?>"><?php echo $cc->name; ?></a>
                                <p><?php echo $cc->size; ?> Students</p>
                            </div>
                        </li>
                <?php } ?>
            </ul>
        </div>
    </div>

</div>
<?php echo form_close(); ?>
<script type = "text/javascript">
        $(document).ready(function ()
        {
            var oTable;
            oTable = $('#adm_table').dataTable({
                "dom": 'TC lfrtip <"clear">',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/fee_structure/get_table'); ?>",
                "iDisplayLength": 50,
                "aLengthMenu": [[10, 25, 50, 250], [10, 25, 50, 250]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:nth-child(5)", nRow).html('<input type="checkbox" name="sids[]" value="' + aData[0] + '"/>');
                    $("td:last", nRow).html("<a class='btn btn-success' href ='<?php echo base_url('admin/admission/view/'); ?>" + "/" + aData[0] + " ' >View</a>");
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
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": " "
                    }]
            }).fnSetFilteringDelay(700);
        });
</script>
<script type = "text/javascript">
        $(document).ready(function () {
            $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
            $(".xsel").select2({'placeholder': 'Please Select', 'width': '120px'});
        });
</script>