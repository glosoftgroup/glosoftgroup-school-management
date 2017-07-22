<?php echo theme_css('sett.css'); ?>
        <?php echo theme_css('jquery.dataTables.css'); ?>   
        <?php echo theme_css('tableTools.css'); ?>   
        <?php echo theme_css('dataTables.colVis.min.css');?>
        
        <?php echo theme_css('themes/default.css'); ?>
        <?php echo theme_css('custom.css'); ?>
           
        <?php echo theme_css('output.css'); ?>
        <link href="<?php echo js_path('plugins/jeditable/bootstrap-editable.css'); ?>" rel="stylesheet">
<div class="col-md-12">
   <!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Fee Payment </h4>
        <div class="heading-elements">
            <?php echo anchor('admin/fee_payment/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Fee Payment')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/fee_payment', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Payment')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    
    <div class="panel-body">           

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='reg_no'>Student Registration Number <span class='required'>*</span></div><div class="col-md-6">
                <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('reg_no', array('' => 'Select Student') + $data, (isset($result->reg_no)) ? $result->reg_no : '', ' class="select"');
                ?>
                <?php echo form_error('reg_no'); ?> <span class="pull-right">Receipt #: <?php echo number_format($next); ?></span>
            </div>
        </div>

        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table class="" cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN -->
                <thead>
                    <tr role="row">
                        <th width="3%">#</th>
                        <th width="10%">Payment Date</th>
                        <th width="15%" class="text-center">Amount</th>
                        <th width="15%" class="text-center">Payment Method</th>
                        <th width="15%" class="text-center"> Transaction No.</th>
                        <th width="20%" class="text-center">Bank</th>
                        <th width="17%" class="text-center">Description</th>
                    </tr>
                </thead>
            </table>
          
            <div id="entry1" class="clonedInput">
                <?php echo validation_errors(); ?>
                <table class=""  cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>
                        <tr >
                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>

                            <td width="10%">
                                <input id='payment_date' type='text' placeholder=" Date" name='payment_date[]' style="" class='payment_date   datepicker' value="<?php
                                if (!empty($result->payment_date))
                                {
                                        echo date('d/m/Y', $result->payment_date);
                                }
                                else
                                {
                                        echo set_value('payment_date', (isset($result->payment_date)) ? $result->payment_date : '');
                                }
                                ?>"  />
                            </td>
                            <td width="10%">
                                <input type="text" name="amount[]" placeholder="Amount" id="amount" class=" amount" value="<?php
                                if (!empty($result->amount))
                                {
                                        echo $result->amount;
                                }
                                ?>"> 
                            </td>
                            <td width="15%">
                                <?php
                                $items = array('Bank Slip' => 'Bank Slip', 'Cash' => 'Cash', 'Mpesa' => 'Mpesa', 'Cheque' => 'Cheque');
                                echo form_dropdown('payment_method[]', array('' => 'Select Pay Method') + $items, (isset($result->payment_method)) ? $result->payment_method : '', ' class=" payment_method" placeholder="Payment Method" id="payment_method" data-placeholder="Select Options..." ');
                                ?>
                            </td>
                            <td width="15%">
                                <input type="text" name="transaction_no[]" id="transaction_no" placeholder="Transaction Number" class="transaction_no" value="<?php
                                if (!empty($result->transaction_no))
                                {
                                        echo $result->transaction_no;
                                }
                                ?>">
                            </td>
                            <td width="20%">
                                <?php
                                echo form_dropdown('bank_id[]', array('' => 'Select Bank Account') + $bank, (isset($result->bank_id)) ? $result->bank_id : '', ' class=" bank_id" id="bank_id" ');
                                ?>
                            </td>
                            <td width="47%">

                                <?php
                                echo form_dropdown('description[]', array('' => 'Select option', '0' => 'Tuition Fee Payment') + $extras, (isset($result->description)) ? $result->description : '', ' class=" description validate[required]" placeholder="Description" id="description" ');
                                ?>

                            </td> 
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="actions col-md-12 text-left" style="padding: 12px;">
                <a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a> 
                <a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
            </div>
        </div>

        <div class='form-group'><div class="col-md-2"></div><div class="col-md-12 text-right">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/fee_payment', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
 <?php echo theme_js('plugins/jeditable/bootstrap-editable.js'); ?>
<script type="text/javascript">
        $(function ()
        {
            var amtts = 0;
            $('#btnAdd').click(function ()
            {
                var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                        newNum = new Number(num + 1), // the numeric ID of the new input field being added
                        newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
                // manipulate the name/id values of the input inside the new element
                // H2 - section
                newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);
                // sum amounts
                var val = parseFloat($('#entry' + num).find('.amount').val());
                amtts += isNaN(val) ? 0 : val;
                console.log(amtts);
                // subject - select
                newElem.find('.payment_date').attr('id', 'ID' + newNum + '_payment_date').val('').removeClass("hasDatepicker").datepicker({
                    format: "dd MM yyyy",
                }).focus();

                newElem.find('.amount').attr('id', 'ID' + newNum + '_amount').val('');

                newElem.find('.payment_method').attr('id', 'ID' + newNum + '_payment_method').val('');
                newElem.find('.transaction_no').attr('id', 'ID' + newNum + '_transaction_no').val('');

                newElem.find('.bank_id').attr('id', 'ID' + newNum + '_bank_id').val('');
                newElem.find('.description').attr('id', 'ID' + newNum + '_description').val('');

                // insert the new element after the last "duplicatable" input field
                $('#entry' + num).after(newElem);

                // enable the "remove" button
                $('#btnDel').attr('disabled', false);

                // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
                if (newNum == 100)
                    $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
            });

            $('#btnDel').click(function () {
                // confirmation
                if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
                {
                    var num = $('.clonedInput').length;
                    // how many "duplicatable" input fields we currently have
                    $('#entry' + num).slideUp('slow', function () {
                        $(this).remove();
                        // sum amounts
                        var val = parseFloat($('#entry' + num).find('.amount').val());
                        amtts -= isNaN(val) ? 0 : val;
                        console.log(amtts);
                        // if only one element remains, disable the "remove" button
                        if (num - 1 === 1)
                            $('#btnDel').attr('disabled', true);
                        // enable the "add" button
                        $('#btnAdd').attr('disabled', false).prop('value', "add section");
                    });
                }
                return false;
                // remove the last element

                // enable the "add" button
                $('#btnAdd').attr('disabled', false);
            });

            $('#btnDel').attr('disabled', true);
        });
    $(document).ready(function(){
        $('td').css('padding','8px 5px');
    });
  
</script>