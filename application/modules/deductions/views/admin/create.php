<div class="col-md-8">
       <!-- Pager -->
       <div class="panel panel-white animated fadeIn">
       	<div class="panel-heading">
       		<h4 class="panel-title">Deductions</h4>
       		<div class="heading-elements">
       		   <?php echo anchor( 'admin/deductions/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Deductions')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/deductions' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Deductions')), 'class="btn btn-primary"');?> 
       		</div>
       	</div>
       	
       	<div class="panel-body">		
           
				   <?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
				   	   <!-- END ADVANCED SEARCH EXAMPLE -->
        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
		 
		   <div >
							
							 <table class="table table-hover" cellpadding="0" cellspacing="0" width="100%">   <thead>
                <tr role="row">
				
				
				<th width="3%">#</th>
				<th width="50" >Name</th>
				<th width="50">Amount</th>
				
				</tr>
            </thead>
				<tbody>
				
				<tr id="entry1" class="clonedInput">

							 <td width="3%">
							  <span id="reference" name="reference" class="heading-reference">1</span>
							</td>
							<td width="50">
							<input type="text" name="name[]" id="name" class="form-control name" value="<?php 
									if(!empty($result->name)){
											echo $result->name;}
									?>">
							<?php echo form_error('name'); ?>
							</td> 
							
							<td width="50">
							<input type="text" name="amount[]" id="amount" class="form-control amount" value="<?php 
									if(!empty($result->amount)){
											echo $result->amount;}
									?>">
								<?php echo form_error('amount'); ?>
							
							</td>
					
							
						</tr>
				
				</tbody>
		</table>
	</div>
		   
		   
				
					<div class="actions text-left p-10">
						<a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a> 
						<a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
					</div>
		</div>


<div class='form-group'><div class="col-md-2"></div><div class="col-md-12 text-right p-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/deductions','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
			
			<script type="text/javascript">

$(function () {
    $('#btnAdd').click(function () {
	
	  //$('input.timepicker').eq(0).clone().removeClass("hasTimepicker").prependTo('#entry2');
        var num     = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // the numeric ID of the new input field being added
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    // manipulate the name/id values of the input inside the new element
        // H2 - section
        newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);

        // subject - select
       
         newElem.find('.name').attr('id', 'ID' + newNum + '_name').val('');

		
        newElem.find('.amount').attr('id', 'ID' + newNum + '_amount').val('');
		
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
                $('#entry' + num).slideUp('slow', function () {$(this).remove(); 
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel').attr('disabled', true);
                // enable the "add" button
                $('#btnAdd').attr('disabled', false).prop('value', "add section");});
            }
        return false;
             // remove the last element

    // enable the "add" button
        $('#btnAdd').attr('disabled', false);
    });

    $('#btnDel').attr('disabled', true);

});


</script>  