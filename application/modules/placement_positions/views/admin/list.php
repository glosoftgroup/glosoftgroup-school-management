<div class="col-md-8">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Exams Timetable</h4>
        <div class="heading-elements">
           <?php echo anchor( 'admin/placement_positions/create/'.$page, '<i class="glyphicon glyphicon-plus">                </i>'.lang('web_add_t', array(':name' => 'Placement Positions')), 'class="btn btn-primary"');?>
            
        </div>
    </div>

                    
      
                 <?php if ($placement_positions): ?>
        
    <div class="panel-body">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Title</th>
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
                
            foreach ($placement_positions as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
				<td><?php echo $p->description;?></td>
<td width='60'><a class='btn btn-info' href='<?php echo site_url('admin/placement_positions/edit/'.$p->id.'/'.$page);?>'><?php echo lang('web_edit');?></a></td>
					<td width='60'><a class='btn btn-warning' onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/placement_positions/delete/'.$p->id.'/'.$page);?>'><?php echo lang('web_delete')?></a></td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>
	</div>

	<?php echo $links; ?>
  
  <?php else: ?>
 	<p class='text-center'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
            </div>
        
