<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Address Book Category</h4>
        <div class="heading-elements">
           <?php echo anchor( 'admin/address_book_category/create/'.$page, '<i class="glyphicon glyphicon-plus"></i>'.lang('web_add_t', array(':name' => ' New Category')), 'class="btn btn-primary"');?>
                <?php echo anchor( 'admin/address_book_category/' , '<i class="glyphicon glyphicon-list">
                </i> List All Categories', 'class="btn btn-primary"');?>
        </div>
    </div>
    
   
                  


 <?php if ($address_book_category): ?>
   <div class="panel-body">
    <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
	
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($address_book_category as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
<td >
<a class='btn btn-info' href='<?php echo site_url('admin/address_book_category/edit/'.$p->id.'/'.$page);?>'><?php echo lang('web_edit');?></a>
<a class='btn btn-warning' onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/address_book_category/delete/'.$p->id.'/'.$page);?>'><?php echo lang('web_delete')?></a>
</td>
					
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	<?php echo $links; ?>
  </div>
            

<?php else: ?>
 	<p class='text-center text-muted p-10'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>