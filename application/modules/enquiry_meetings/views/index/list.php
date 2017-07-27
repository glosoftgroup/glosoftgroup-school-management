<div class="col-sm-9">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h4 class="panel-title">Enquiry Meetings</h4>
		<div class="heading-elements">
		<?php echo anchor( 'enquiry_meetings/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Enquiry Meetings')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'enquiry_meetings/meetings' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Enquiry Meetings')), 'class="btn btn-primary"');?>
		
	
	<div class="panel-body"> 
			               
              
     <?php if ($enquiry_meetings): ?>
     <div class="block-fluid">
	 <table cellpadding="0" cellspacing="0" width="100%" class="table table-hover display" style="">
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Time</th>
				<th>Reason</th>	
				<th>Status</th>	
				<th>Comment</th>	
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
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
				<td><?php echo $p->time;?></td>
				<td><?php echo $p->reason;?></td>
				<td><?php //;?></td>
				<td><?php //;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
						 <a href='<?php echo site_url('enquiry_meetings/view/'.$p->id);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a>
							
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text-center'>You have no enquiry meeting scheduled for now !!</p>
 <?php endif ?>
 </div>