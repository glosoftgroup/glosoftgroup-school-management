<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h4 class="panel-title"> Record Sales</h4>
		<div class="heading-elements">
		   <?php echo anchor( 'admin/record_sales/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> Record Sales', 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/record_sales' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Record Sales')), 'class="btn btn-primary"');?>
				
				<?php echo anchor( 'admin/record_sales/voided' , '<i class="glyphicon glyphicon-list">
                </i> All Voided Sales', 'class="btn btn-warning"');?>
		</div>
	</div>
	

              
              
                 <?php if ($record_sales): ?>
            	<div class="panel-body">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Date</th>
				<th>Item </th>
				<th> Quantity</th>
				<th>Unit Price</th>
				
				<th>Total Cost</th>
				<th>Description</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($record_sales as $p ): 
			
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo date('d M Y',$p->sales_date);?></td>
				<td><?php 
				
				echo $items[$p->item_id];
				
				?></td>
					<td><?php echo  $p->quantity;?></td>
					<td><?php echo  $p->unit_price;?></td>
					
					<td><?php echo number_format($p->total,2);?></td>
					<td><?php echo $p->description;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							<a class="btn btn-success" href='<?php echo base_url('admin/record_sales/receipt/'.$p->receipt_id);?>'><i class='glyphicon glyphicon-eye-open'></i> View Receipt</a>
							
							
							  
						   <a  class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/record_sales/void/'.$p->id);?>'><i class='glyphicon glyphicon-trash'></i> Void</a>
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text-center'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>