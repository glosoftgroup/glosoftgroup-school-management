<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Extra Curricular  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/extra_curricular/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> Add Student To Activity', 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/extra_curricular' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Extra Curricular')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($extra_curricular): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Student</th>
				<th>Activity</th>
				<th>Date From</th>
				<th>Date To</th>
				<th>Remarks</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
			 $i = 0;
				if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
				{
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}
                
            foreach ($extra_curricular as $p ): 
                 $i++;
				 $student=$this->ion_auth->students_full_details();
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo  ucwords($student[$p->student]);?></td>
				<td><?php echo $activity[$p->activity];?></td>
					<td><?php echo date('d/m/Y',$p->date_from);?></td>
					<td><?php echo date('d/m/Y',$p->date_to);?></td>
					<td><?php echo $p->remarks;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/extra_curricular/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/extra_curricular/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
							</ul>
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>