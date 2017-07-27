<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h4 class="panel-title"> Items</h4>
		<div class="heading-elements">
		   <?php echo anchor( 'admin/items/create/'.$page, '<i class="glyphicon glyphicon-plus">                </i>'.lang('web_add_t', array(':name' => 'Items')), 'class="btn btn-primary"');?>
			    <?php echo anchor( 'admin/items/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
			  <div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Options</button>
					
					<ul class="dropdown-menu pull-right">
					  <li><a class=""  href="<?php echo base_url('admin/items'); ?>"><i class="glyphicon glyphicon-list-alt"></i> Manage Items</a></li>
					   <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/items_category'); ?>"><i class="glyphicon glyphicon-fullscreen"></i> Manage Items Category</a></li>
					  <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/add_stock/create'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Stock</a></li>
					    <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/stock_taking'); ?>"><i class="glyphicon glyphicon-edit"></i> Stock Taking</a></li>
					   <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/inventory'); ?>"><i class="glyphicon glyphicon-folder-open"></i> Inventory Listing</a></li>
					</ul>
				</div>
		</div>
	</div>
	

                    
         	        <?php if ($items): ?>              
    	<div class="panel-body">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">

	 <thead>
                <th>#</th>
				<th>Item Name</th>
				<th>Category</th>
				<th>Reorder Level</th>
				<th>Description</th>
                <th>Created on</th>					
				<th>Created by</th>	
				
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($items as $p ): 
                 $i++;
				   $user=$this->ion_auth->get_user($p->created_by);
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->item_name;?></td>
				<td><?php echo $category[$p->category];?></td>
				<td><?php echo $p->reorder_level;?></td>
				<td><?php echo $p->description;?></td>
				<td><?php echo date('d M, Y',$p->created_on);?></td>
				<td><?php echo $user->first_name.' '.$user->last_name;?></td>
				 <td width="20%">
					<div class="btn-group">
						<a class='btn btn-primary' href="<?php echo site_url('admin/items/edit/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-edit"></i> </a>
						<a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/items/delete/'.$p->id.'/'.$page);?>'><i class="glyphicon glyphicon-trash"></i> </a>	
					</div>
				</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>
</div>
	
<?php else: ?>
 	<p class='text-center p-10 text-muted'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>