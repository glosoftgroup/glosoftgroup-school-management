<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h4 class="panel-title">Groups Management</h4>
		<div class="heading-elements">
		  <?php echo anchor( 'admin/groups/create/'.$page, '<i class="glyphicon glyphicon-plus"></i>'.lang('web_add_t', array(':name' => 'New Group')), 'class="btn btn-primary"');?>
			    <?php echo anchor( 'admin/groups/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
		</div>
	</div>
          
   <?php if ($groups): ?>
               
  <div class="panel-body">
    <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">


           
	 <thead>
                <th>#</th>
				<th>Name</th>
				<th>Description</th>
				<th><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($groups as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->name;?></td>
			    <td><?php echo $p->description;?></td>
                    <td width="20%">
					<div class="btn-group">
							<button class="btn dropdown-toggle" data-toggle="dropdown">Action <i class="glyphicon glyphicon-caret-down"></i></button>
							<ul class="dropdown-menu pull-right">
								 <li><a href="<?php echo site_url('admin/groups/edit/'.$p->id);?>"><i class="glyphicon glyphicon-eye-open"></i> View</a></li>
								<li><a href="<?php echo site_url('admin/groups/edit/'.$p->id);?>"><i class="glyphicon glyphicon-edit"></i> Edit</a></li>
							  
								<li><a onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/groups/delete/'.$p->id);?>'><i class="glyphicon glyphicon-trash"></i> Trash</a></li>
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