<div class="col-md-12">
   <!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Expenses</h4>
        <div class="heading-elements">
          <?php echo anchor('admin/expenses/create/' . $page, '<i class="glyphicon glyphicon-plus"> </i>' . lang('web_add_t', array(':name' => 'Expenses')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/expenses/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/expenses/voided', '<i class="glyphicon glyphicon-list">
                </i> Voided Expenses', 'class="btn btn-warning"'); ?>
        </div>
    </div>
    
    <div class="panel-body">
       
        <!------NEW WIDGET------>
        <div class="widget col-md-6">
            <div class="head black">
                <div class="icon"><span class="icosg-list "></span></div>
                <h2>Add Expense Item</h2>
            </div>
            <div class="block-fluid">
                <?php echo form_open('admin/expense_items/quick_add', 'class=""'); ?>
                <div class="form-group">
                    <div class="col-md-3">Name:</div>
                    <div class="col-md-6">                                      
                        <?php echo form_input('name', '', 'id="title_1" class="form-control" placeholder=" E.g Rice, Fuel, Pens, Electricity etc."'); ?>
                        <?php echo form_error('name'); ?>
                    </div>
                    <div class="col-md-3"> <button class="btn btn-primary">Add Item</button></div>
                </div>

                <?php echo form_close(); ?> 
            </div>
        </div>

        <div class="widget col-md-6">
            <div class="head ">
                <div class="icon"><span class="icosg-share2"></span></div>
                <h2>Add Expense Category</h2>
            </div>

            <div class="block-fluid">
                <?php echo form_open('admin/expenses_category/quick_add', 'class=""'); ?>
                <div class="form-group">
                    <div class="col-md-3">Name:</div>
                    <div class="col-md-6">                                      
                        <?php echo form_input('title', '', 'id="title_1" class="form-control"  placeholder=" E.g Stationery, Foodstuff, Transport"'); ?>
                        <?php echo form_error('title'); ?>
                    </div>
                    <div class="col-md-3"> <button class="btn btn-primary">Add Category</button></div>
                </div>
                <?php echo form_close(); ?> 
            </div>
        </div>
        <div class="clearfix"></div>
        <!------END WIDGET------>

        <div class="head">
            <div class="icon"><span class="icosg-target1"></span></div>
            <h2>  Expenses Details</h2>
        </div>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            
            <div >
                <table class='table table-hover' cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                    <tr role="row">
                        <th width="3%">#</th>
                        <th width="10%">Expense Date</th>
                        <th width="10%">Title</th>
                        <th width="10%">Category</th>
                        <th width="10%">Amount</th>
                        <th width="18%">Person<br> Responsible</th>
                        <th width="12%">Receipt</th>
                        <th width="27%">Description</th>

                    </tr>
                </thead>
                    <tbody>
                        <tr id="entry1" class="clonedInput">
                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>
                            <td width="10%">
                                <input id='expense_date' type='text' name='expense_date[]' style="" class='expense_date   datepicker' value="<?php
                                if (!empty($result->expense_date))
                                {
                                        echo date('d/m/Y', $result->expense_date);
                                }
                                else
                                {
                                        echo set_value('expense_date', (isset($result->expense_date)) ? $result->expense_date : '');
                                }
                                ?>" />
                                       <?php echo form_error('expense_date'); ?>
                            </td>
                            <td width="10%">
                                <?php
                                echo form_dropdown('title[]', $items, (isset($result->title)) ? $result->title : '', ' class="form-control title" id="title"   data-placeholder="Select Options..." ');
                                echo form_error('title');
                                ?>
                            </td>
                            <td width="10%">
                                <?php
                                echo form_dropdown('category[]', $cats, (isset($result->category)) ? $result->category : '', ' class="form-control category "   id="category" data-placeholder="Select Options..." ');
                                echo form_error('category');
                                ?>
                                <?php echo form_error('category'); ?>
                            </td>
                            <td width="10%">
                                <input type="text" name="amount[]" placeholder="Amount" id="amount" class="form-control amount" value="<?php
                                if (!empty($result->amount))
                                {
                                        echo $result->amount;
                                }
                                ?>">
                                       <?php echo form_error('amount'); ?>
                            </td>
                            <td width="18%">
                                <?php
                                $staff = $this->ion_auth->list_staff();
                                echo form_dropdown('person_responsible[]', $staff, (isset($result->person_responsible)) ? $result->person_responsible : '', ' class="form-control person_responsible" id="person_responsible" ');
                                echo form_error('person_responsible');
                                ?>
                            </td> 
                            <td width="12%">
                                <input id='receipt' class='file-styled-primary receipt' type='file' style="width:93px !important;" name='receipt[]' />
                                <?php if ($updType == 'edit'): ?>
                                        <a href='<?php echo base_url('uploads/files/' . $result->receipt); ?>' >Download actual file (receipt)</a>
                                <?php endif ?>
                                <br/><?php echo form_error('receipt'); ?>
                                <?php echo ( isset($upload_error['receipt'])) ? $upload_error['receipt'] : ""; ?>
                            </td>
                            <td width="27%">
                                <textarea name="description[]" cols="25" rows="1" placeholder="Description" class="form-control col-md-12 description  validate[required]" style="resize:vertical;" id="description"><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="actions">
                <a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a> 
                <a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
            </div>
        </div>
        <div class='form-group col-md-12'>
            <div class="control-div"></div>
            <div class="col-md-12 text-right">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/expenses', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
</div>
<script type="text/javascript">
        $(function ()
        {
            $('#btnAdd').click(function ()
            {
                var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                        newNum = new Number(num + 1), // the numeric ID of the new input field being added
                        newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
                // manipulate the name/id values of the input inside the new element
                // H2 - section
                newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);

                // subject - select
                newElem.find('.expense_date').attr('id', 'ID' + newNum + '_expense_date').val('').removeClass("hasDatepicker").datepicker({
                    format: "dd MM yyyy",
                }).focus();

                newElem.find('.amount').attr('id', 'ID' + newNum + '_amount').val('');
                newElem.find('.receipt').attr('id', 'ID' + newNum + '_receipt').val('');

                newElem.find('.title').attr('id', 'ID' + newNum + '_title').val('');
                newElem.find('.category').attr('id', 'ID' + newNum + '_category').val('');

                newElem.find('.person_responsible').attr('id', 'ID' + newNum + '_person_responsible').val('');
                newElem.find('.description').attr('id', 'ID' + newNum + '_description').val('');

                // insert the new element after the last "duplicatable" input field
                $('#entry' + num).after(newElem);
                // enable the "remove" button
                $('#btnDel').attr('disabled', false);

                // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
                if (newNum == 100)
                    $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
            });

            $('#btnDel').click(function ()
            {
                // confirmation
                if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
                {
                    var num = $('.clonedInput').length;
                    // how many "duplicatable" input fields we currently have
                    $('#entry' + num).slideUp('slow', function ()
                    {
                        $(this).remove();
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
            $('td').css('padding','5px 5px');
            $('.filename').addClass('hidden');
        });
</script>