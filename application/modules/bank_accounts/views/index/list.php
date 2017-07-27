<div class="col-sm-9"> 
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h4 class="panel-title"> Bank Accounts</h4>
		<div class="heading-elements">
		
		</div>
	</div>
	
	
           
         	                    
              
                 <?php if ($bank_accounts): ?>
                <div class="panel-body">
				 <table cellpadding="0" cellspacing="0" width="100%" class="table table-hover display" style="">
	 <thead>
                <th>#</th>
				<th>Bank</th>
				<th>Account Name</th>
				<th>Account Number</th>
				<th>Branch</th>
				<th>Description</th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($bank_accounts as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->bank_name;?></td>
				<td><?php echo $p->account_name;?></td>
					<td><?php echo $p->account_number;?></td>
					<td><?php echo $p->branch;?></td>
					<td><?php echo $p->description;?></td>


				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text-center text-muted p-10'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 </div>