<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h4 class="panel-title">Enquiry Meetings</h4>
		<div class="heading-elements">
			<?php echo anchor( 'admin/enquiry_meetings/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Enquiry Meetings')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/enquiry_meetings' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Enquiry Meetings')), 'class="btn btn-primary"');?> 
             
		</div>
	</div>
	
	<div class="panel-body">
			 
             
         	                    
              
                 <?php if ($enquiry_meetings): ?>
                 <div class="block-fluid">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Parent</th>
				<th>Title</th>
				<th>Date/Time</th>
				<th>Person to Meet</th>
				<th>Reason</th>	
				<th><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($enquiry_meetings as $p ): 
                 $i++;
				 $u = $this->ion_auth->get_user($p->person_to_meet);
				 $paro = $this->ion_auth->get_user($p->created_by);
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>
                <td><?php echo $paro->first_name.' '.$paro->last_name;?></td>				
				<td><?php echo $p->title;?></td>
					<td><?php echo date('d M Y',$p->proposed_date).'<br>'. $p->time;?></td>
					<td><?php echo $u->first_name.' '.$u->last_name;?></td>
					<td><?php echo $p->reason;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/enquiry_meetings/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/enquiry_meetings/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/enquiry_meetings/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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