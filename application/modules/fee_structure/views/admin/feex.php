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
<div class="col-md-9">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Manage Fee Extras  & Invoice</h2> 
        <div class="right">                            
             <?php echo anchor('admin/fee_structure/extras', '<i class="glyphicon glyphicon-list">
                </i> Fee Extras', 'class="btn btn-primary"'); ?>
        </div>    					
    </div>
    <div class="block-fluid">
         <?php
             $attributes = array('class' => 'form-horizontal', 'id' => '');
             echo form_open_multipart(current_url(), $attributes);
         ?>
        <div class='form-group'>
            <div class="col-md-3" for='student'>Select Student</div>
            <div class="col-md-9">
                 <?php echo form_input('student', '', 'class=" form-control sella  " data-context="student,list" '); ?>
                 <?php echo form_error('student'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='fee'>Select Fee</div>
            <div class="col-md-9">
                 <?php
                     echo form_dropdown('fee', array('' => 'Select Fee') + $extras, $this->input->post('fee'), ' class="fsel validate[required]"');
                     echo form_error('fee');
                 ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="control-div"></div>
            <div class="col-md-3">
                 <?php echo form_submit('extras', 'View Extras', "id='submit'  class='btn btn-primary'"); ?>
            </div>
            <div class="col-md-3">
                 <?php echo form_submit('invoices', 'View Invoices', "id='invoices' class='btn btn-primary'"); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
        <?php
            if ($show && isset($feex))
            {
                 ?>
                 <h3>  Fee Extras   </h3>
                 <table width="100%" class="fxtbl invoice">
                     <thead>
                         <tr>
                             <th width="6%">#</th>
                             <th width="18%">Name</th>
                             <th width="20%">Fee</th>
                             <th width="7%">Term</th>
                             <th width="7%">Year</th>
                             <th width="38%"> Amount</th>
                             <th width="4%"> </th>
                         </tr>
                     </thead>
                     <tbody>
                          <?php
                          $i = 0;
                          foreach ($feex as $key => $rspecs)
                          {
                               foreach ($rspecs as $r)
                               {
                                    $fxname = isset($extras[$r->fee_id]) ? $extras[$r->fee_id] : '';
                                    $std = $this->worker->get_student($r->student);
                                    $i++;
                                    ?>
                                   <tr class="trf" id="xf<?php echo $r->id; ?>">
                                        <?php
                                        $nm = 'fee_' . $r->id;
                                        ?>
                                       <td> <?php echo $i . '. '; ?></td>
                                       <td> <?php echo $std->first_name . ' ' . $std->last_name; ?></td>
                                       <td> <?php echo $fxname; ?></td>
                                       <td> <?php echo $r->term; ?></td>
                                       <td> <?php echo $r->year; ?></td>
                                       <td class="bglite">
                                           <span class="editable fxamount" id="<?php echo $nm; ?>" data-rec="<?php echo $r->student; ?>">
                                               <?php echo $r->amount; ?></span>
                                       </td>
                                       <td> <button data-id="<?php echo $r->id; ?>" data-content="<?php echo $r->student; ?>" class="fxdel btn-danger">X</button></td>
                                   </tr>
                                   <?php
                              }
                         }
                         ?>         
                     </tbody>
                 </table>
            <?php } ?>
        <?php
            if ($iv)
            {
                 ?>
                 <h3> Invoices</h3>
                 <table width="100%" class="fxtbl invoice">
                     <thead>
                         <tr>
                             <th width="6%">#</th>
                             <th width="18%">Name</th>
                             <th width="20%">Fee</th>
                             <th width="7%">Term</th>
                             <th width="7%">Year</th>
                             <th width="38%"> Amount</th>
                             <th width="4%"> </th>
                         </tr>
                     </thead>
                     <tbody>
                          <?php
                          $i = 0;
                          foreach ($invoices as $v)
                          {
                               $i++;
                               ?>
                              <tr class="trf" id="xf<?php echo $v->id; ?>">
                                  <td> <?php echo $i . '. '; ?></td>
                                  <td> <?php echo $v->student; ?></td>
                                  <td>Tuition Fee</td>
                                  <td> <?php echo $v->term; ?></td>
                                  <td> <?php echo $v->year; ?></td>
                                  <td class="bglite">
                                      <span class="editable fxamount" data-rec="<?php echo $v->id; ?>">
                                          <?php echo $v->amount; ?></span>
                                  </td>
                                  <td> <button data-id="<?php echo $v->id; ?>" data-content="<?php echo $v->student_id; ?>" class="idel btn-danger">X</button></td>
                              </tr>
                              <?php
                         }
                         ?>         
                     </tbody>
                 </table>
            <?php } ?>
    </div>
</div>
<div class="col-md-3">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icosg-newtab"></span></div>
            <h2>Class</h2>
        </div>
        <div class="block-fluid">
            <ul class="list tickets">
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
                                 <a href="javascript:" class="classget" data-rec="<?php echo $cid; ?>"><?php echo $cc->name; ?></a>
                                 <p><?php echo $cc->size; ?> Students</p>
                             </div>
                         </li>
                    <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div id="confirm" title="Delete This Record?">Are you sure you want to remove this Fee?</div>
<div id="void" title="Void Invoice">Are you sure you want to void this Invoice?</div>
<script type="text/javascript">
<?php
    if ($show && isset($feex))
    {
         ?>
              $(function ()
              {
                   $.fn.editable.defaults.mode = 'inline';
                   $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
                   $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
                           '<button type="button" class="btn editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
                   var fpk;
                   $('.fxamount').each(function (i, obj)
                   {
                        var $px = $(this);
                        fpk = $px.attr('data-rec');
                        $px.editable({
                             type: 'text',
                             title: 'Enter Amount',
                             placement: 'right',
                             pk: fpk,
                             url: '<?php echo base_url('admin/fee_structure/put_extras/'); ?>',
                             defaultValue: '   ',
                             success: function (response, newValue)
                             {
                                  notify('Fee Extra', 'Amount Updated: ' + newValue);
                             }
                        });
                   });

              });
    <?php } ?>
     $(function ()
     {
          $(".fsel").select2({'placeholder': 'Please Select', 'width': '70%'});
          $('.sella').select2({
               placeholder: 'Search for Student',
               minimumInputLength: 3,
               width: '70%',
               multiple: true,
               ajax: {
                    url: "<?php echo base_url('admin/admission/pick_students'); ?>",
                    dataType: 'json',
                    quietMillis: 250,
                    data: function (term, page)
                    {
                         return {
                              term: term, //search term
                              page_limit: 50 // page size
                         };
                    },
                    results: function (data, page)
                    {
                         return {results: data};
                    }
               }

          });
          $(".classget").on("click", function ()
          {
               var rec = $(this).attr('data-rec');
               $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('admin/fee_structure/get_class_targets'); ?>",
                    data: {'class': rec},
                    success: function (data)
                    {
                         var json = JSON.parse(data);
                         $('.sella').select2('data', json, true);
                    }
               });
          });
     });
     $(function ()
     {
          var frow, ivr;
          $('.fxdel').on('click', function ()
          {
               frow = $(this).closest('tr');
               frow.data('id', $(this).attr('data-id'));
               frow.data('sid', $(this).attr('data-content'));
               $("#confirm").dialog('open');
          });
          $('.idel').on('click', function ()
          {
               ivr = $(this).closest('tr');
               ivr.data('id', $(this).attr('data-id'));
               ivr.data('sid', $(this).attr('data-content'));
               $("#void").dialog('open');
          });
          $("#confirm").dialog({
               resizable: false,
               height: "auto",
               modal: true,
               autoOpen: false,
               buttons: {
                    'Remove': function ()
                    {
                         $.post("<?php echo base_url('admin/fee_structure/remove_extra/'); ?>", {"id": frow.data('id'), "rec": frow.data('sid')}, function (msg)
                         {
                              notify('Fee Extra', 'Value changed: ');
                              frow.fadeOut(function ()
                              {
                                   $('table.fxtbl > tbody > tr').each(function (i)
                                   {
                                        $(this).children('td:nth-child(1)').text(i + 1 + '.');
                                   });
                              });
                         });
                         $(this).dialog('close');
                    },
                    Cancel: function ()
                    {
                         $(this).dialog('close');
                    }
               }
          });
          $("#void").dialog({
               resizable: false,
               height: "auto",
               modal: true,
               autoOpen: false,
               buttons: {
                    'Remove': function ()
                    {
                         $.post("<?php echo base_url('admin/fee_structure/void_invoice'); ?>" +"/"+ ivr.data('id'), {"id": ivr.data('id')}, function (msg)
                         {
                              notify('Invoice', 'Voided ');
                              frow.fadeOut(function ()
                              {
                                   $('table.fxtbl > tbody > tr').each(function (i)
                                   {
                                        $(this).children('td:nth-child(1)').text(i + 1 + '.');
                                   });
                              });
                         });
                         $(this).dialog('close');
                    },
                    Cancel: function ()
                    {
                         $(this).dialog('close');
                    }
               }
          });
     });
</script> 