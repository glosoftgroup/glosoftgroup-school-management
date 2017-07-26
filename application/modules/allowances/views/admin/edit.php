<div class="col-md-8">
    <!-- Pager -->
    <div class="panel panel-white animated fadeIn">
    	<div class="panel-heading">
    		<h4 class="panel-title">allowances</h4>
    		<div class="heading-elements">
    		  <?php echo anchor( 'admin/allowances/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'allowances')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/allowances' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'allowances')), 'class="btn btn-primary"');?> 
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
		 <table class="table table-hover" cellpadding="0" cellspacing="0" width="100%">
		  <!-- BEGIN -->
            <thead>
                <tr role="row">
				
				
				<th width="3%">#</th>
				<th width="50" >Name</th>
				<th width="50">Amount</th>
				
				</tr>
            </thead>
            
										<tbody>
										
										<tr id="entry1" class="clonedInput" >
                  
													 <td width="3%">
													  <span id="reference" name="reference" class="heading-reference">1</span>
													</td>
													<td width="50">
													<input type="text" name="name" id="name" class="name" value="<?php 
															if(!empty($result->name)){
																	echo $result->name;}
															?>">
													<?php echo form_error('name'); ?>
													</td> 
													
													<td width="50">
													<input type="text" name="amount" id="amount" class="amount" value="<?php 
															if(!empty($result->amount)){
																	echo $result->amount;}
															?>">
														<?php echo form_error('amount'); ?>
													
													</td>
											
													
												</tr>
										
										</tbody>
								</table>
							</div>
		   
		   
		</div>


<div class='form-group'><div class="col-md-10 p-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/allowances','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
			