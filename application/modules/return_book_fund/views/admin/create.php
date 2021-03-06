<div class="col-md-8">

   <!-- Pager -->
   <div class="panel panel-white animated fadeIn">
   	<div class="panel-heading">
   		<h4 class="panel-title"> Return Book Fund </h4>
   		<div class="heading-elements">
   		  <?php echo anchor( 'admin/return_book_fund' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Borrowed Books')), 'class="btn btn-primary"');?> 
   		</div>
   	</div>
   	
   	<div class="panel-body">		
          
            
<h4> <?php $u=$this->ion_auth->list_student($student); echo $u->first_name.' '.$u->last_name;?> Borrowed Book(s)</h4>  
<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
   

		
		<table class="table table-striped table-bordered  " >
            <!-- BEGIN -->
            <thead>
                <tr >
				<th width="5"><input type="checkbox" class="checkall" /></th>
				<th >Book</th>
				<th >Return Date</th>
				<th  >Remarks</th>
				<th  ></th>
				
				</tr>
            </thead>
			
		 <tbody role="alert" aria-live="polite" aria-relevant="all">
	

		
		<?php $i=1; 
		
		foreach($b_books as $post):?>  
		<tr >
              <?php echo form_open('admin/return_book_fund/create/'.$id.'/1', ' id="form"  class="form-horizontal"'); ?>     
			 <td >
			  <span id="reference" name="reference" class="heading-reference"><?php echo form_checkbox('action_to[]', $post->id); ?></span>
			</td> 
			<td >
			<span style="display:none">
			
			<?php 	
				 echo form_input('book[]', $post->id,  (isset($result->book)) ? $result->book : '' ,' class=" form-control"');
				 echo form_error('book'); ?>
				 
			</span>	 
				 <?php echo $books[$post->book];?>
				
				
			</td>
			<td >
			<span style="">
			<div id="datetimepicker1" class="input-group date form_datetime">
			 <?php echo form_input('return_date[]', $result->return_date > 0 ? date('d M Y', $result->return_date) : $result->return_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
			 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>

                </div>
			</span>	 
				
			</td>
			
			
			<td >
			  <textarea name="remarks[]" cols="25" rows="1" class="col-md-12 remarks  validate[required]" style="resize:vertical;" id="remarks"><?php echo set_value('remarks', (isset($result->remarks)) ? htmlspecialchars_decode($result->remarks) : ''); ?></textarea>
                 
			</td>
				<td width="20%">
					<div class="btn-group">
					<button type="submit" name="btnID" value="<?php echo 1; ?>" class="btn btn-success">Return</button>
					
				</div>
				 
				</td>
			<?php echo form_close(); ?>  
		 </tr>
		<?php $i++; endforeach; ?>		
	</tbody>
	</table>

<div class='form-group'><div class="col-md-10">
    <br>

    <button type="submit" name="btnAction" value="delete" class="btn btn-primary">Update Changes</button>
	<?php echo anchor('admin/return_book_fund','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>