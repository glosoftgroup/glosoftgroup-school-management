<?php
    if ($this->input->get('sw'))
    {
         $sel = $this->input->get('sw');
    }
    elseif ($this->session->userdata('pop'))
    {
         $sel = $this->session->userdata('pop');
    }
    else
    {
         $sel = 0;
    }
?>
<div class="col-md-8">

    <!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h6 class="panel-title">Edit Student Classes</h6>
		<div class="heading-elements">
			<ul class="pager pager-sm">
				<li>
				   <?php echo anchor('admin/class_groups/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
				</li>
			</ul>
		</div>
	</div>

	<div class="panel-body">
		<?php echo form_open(current_url(), 'class="form-inline" id="fextra"'); ?>
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
        <div class='col-md-12 '>
            <div class="col-md-6">
                 <?php
                     echo form_dropdown('class', array('' => 'Select Class') + $classes, '', ' class="fsel validate[required]"');
                     echo form_error('class');
                 ?>
            </div>
            <div class="col-md-4">
                 <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary' "); ?>
                 <?php echo anchor('admin/class_groups', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
	</div>
</div>
<!-- /pager -->


</div>

<div class="col-md-4">
 <div class="panel panel-primary">
   <div class="panel-heading">
		<h6 class="panel-title">Class</h6>
		<div class="heading-elements">

		</div>
	</div>
	<ul class="media-list media-list-linked">

		<?php
			 $i = 0;
			 foreach ($this->classlist as $cid => $cl)
			 {
				  $i++;
				  $cc = (object) $cl;
				  $cll = $sel == $cid ? 'sel' : '';
		 ?>

		<li class="media">
			<a href="<?php echo current_url() . '?sw=' . $cid; ?>" class="media-link">
				<div class="media-left"><img src="assets/images/demo/users/face1.jpg" class="img-circle" alt=""></div>
				<div class="media-body">
					<div class="media-heading text-semibold"><?php echo $cc->name; ?></div>
					<span class="text-muted"></span>
				</div>
				<div class="media-right media-middle">
					<span class="label label-primary"><?php echo $cc->size; ?> Students</span>
				</div>
			</a>
		</li>
		 <?php } ?>
	</ul>
	</div>
 </div>

</div>
<?php echo core_js('core/js/plugins/forms/selects/select2.min.js'); ?>

<?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>

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
               "sAjaxSource": "<?php echo base_url('admin/class_groups/get_students'); ?>",
               "iDisplayLength": 50,
               "aLengthMenu": [[10, 25, 50, 250], [10, 25, 50, 250]],
               "aaSorting": [[0, 'asc']],
               "fnRowCallback": function (nRow, aData, iDisplayIndex)
               {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:nth-child(5)", nRow).html('<input type="checkbox" name="sids[]" value="' + aData[0] + '"/>');
                    $("td:last", nRow).html("<a class='btn btn-success' href ='<?php echo base_url('admin/admission/view/'); ?>" + "/" + aData[0] + " ' >Profile</a>");
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

          $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
          $(".fsel").on("change", function (e)
          {
               notify('Select', 'Value changed: ' + e.val);
          });
     });
</script>
