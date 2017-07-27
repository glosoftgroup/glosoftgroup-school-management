<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h1 class="panel-title">Disciplinary</h1>
		<div class="heading-elements">
			 <?php echo anchor( 'admin/disciplinary/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => ' New Disciplinary')), 'class="btn btn-primary"');?>
             <?php echo anchor( 'admin/disciplinary/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
		</div>
	</div>
	
	<div class="panel-body">
	<?php if ($disciplinary): ?>              
               <div class="block-fluid">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">


 
	 <thead>
                <th>#</th>
				<th>Reported on</th>
				<th>Culprit</th>
				<th>Reason</th>
				<th>Status</th>
				
				<th><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($disciplinary as $p ): 
                 $i++;
				 $user=$this->ion_auth->students_full_details();
                     ?>
	 <tr>
					<td><?php echo $i . '.'; ?></td>					
					<td><?php echo date('d/m/Y',$p->date_reported);?></td>
					<td><?php echo $user[$p->culprit];?></td>
					<td><?php echo substr($p->description,0,30).'...';?></td>
					<td width="20%">
					<?php  
					if(!empty($p->action_taken)){
					echo '<span class="label label-success">Action has been taken</span>';
					}
					else{ echo '<span class="label label-warning">Pending </span>';}
					?>
					</td>
	             <td width="20%">
			
				 <div class="btn-group">
				   
                   <button class="btn dropdown-toggle" data-toggle="dropdown">Action <i class="glyphicon glyphicon-caret-down"></i></button>
					<ul class="dropdown-menu pull-right">
					     <li><a href="<?php echo site_url('admin/disciplinary/view/'.$p->id);?>"><i class="glyphicon glyphicon-eye-open"></i> View Details</a></li>
                        <li><a href="<?php echo site_url('admin/disciplinary/edit/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-edit"></i> Edit Details</a></li>
					 <?php 	if(empty($p->action_taken)){?>
                          <li><a href="<?php echo site_url('admin/disciplinary/action/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-plus"></i> Take Action</a></li>
                      <?php }?>
                        <li><a onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/disciplinary/delete/'.$p->id.'/'.$page);?>'><i class="glyphicon glyphicon-trash"></i> Trash</a></li>
                       
                    </ul>
              
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
	</div>
</div>



         	        