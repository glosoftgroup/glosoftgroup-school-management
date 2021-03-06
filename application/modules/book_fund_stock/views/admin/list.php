<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h4 class="panel-title"> Books Fund Stocks</h4>
		<div class="heading-elements">
			 <?php echo anchor( 'admin/book_fund' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Book Fund Stock')), 'class="btn btn-primary"');?> 
		</div>
	</div>
	

                   
              
                 <?php if ($book_fund_stock): ?>
        	<div class="panel-body">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Book</th>
				<th>Purchase Date</th>
				<th>Quantity</th>
				
				<th>Receipt</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($book_fund_stock as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				
				<td><?php 
				if(!empty($p->book_id)){
					echo $book[$p->book_id];
				}
				?></td>
				<td><?php echo date('d/m/Y',$p->purchase_date);?></td>
				<td><?php echo $p->quantity;?></td>
					
					<td>
				<?php if(!empty($p->receipt)):?>
				<a href='<?php echo base_url();?>uploads/files/<?php echo $p->receipt?>' />Download receipt</a>
				<?php else:?>
				................
				<?php endif?>
				</td>

			 <td width='20%'>
						 <div class='btn-group'>
							
								<a class="btn btn-primary" href='<?php echo site_url('admin/book_fund_stock/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> </a>
							  
								<a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/book_fund_stock/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> </a>
							
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