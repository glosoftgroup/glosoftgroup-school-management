<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h1 class="panel-title"> Leaving Certificate </h1>
		<div class="heading-elements">
		 <?php echo anchor( 'admin/leaving_certificate/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Leaving Certificate')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/leaving_certificate' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Leaving Certificate')), 'class="btn btn-primary"');?>
		</div>
	</div>
	
	<div class="panel-body">
	<?php if ($leaving_certificate): ?>
                 <div class="block-fluid">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Leaving Date</th>
				<th>Student</th>
				<th>Headteacher Remarks</th>
				<th>Co-Curricular</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($leaving_certificate as $p ): 
			 $student=$this->ion_auth->students_full_details();
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>
				<td><?php echo date('d M Y',$p->leaving_date);?></td>				
				<td><?php echo $student[ $p->student_id];?></td>				
				<td><?php echo $p->ht_remarks;?></td>
					
				<td><?php echo $p->co_curricular;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							
							<a class="btn btn-success" href='<?php echo site_url('admin/leaving_certificate/view/'.$p->id);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a>
							<a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/leaving_certificate/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
							
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



         	                    
              
                 