<!-- Pager -->
<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">Grades </h6>
		<div class="heading-elements">
			 <?php echo anchor( 'admin/grades/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Grades')), 'class="btn btn-primary"');?>

			 <?php echo anchor( 'admin/grades' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Grades')), 'class="btn btn-primary"');?>

		</div>
		</div>


	<div class="panel-body">
	<?php if ($grades): ?>
                 <div class="block-fluid">
				<table class="table table-hover fpTable" >
	 <thead>
	     <tr class='bg-primary'>
                <th>#</th>
				<th>Title</th>
				<th>Remarks</th>
				<th>Created On</th>
				<th>Created By</th>
				<th ><?php echo lang('web_options');?></th>
		</tr>
		</thead>
		<tbody>
		<?php
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }

            foreach ($grades as $p ):
                 $i++;
				  $user=$this->ion_auth->get_user($p->created_by);
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>
				<td><?php echo $p->title;?></td>
					<td><?php echo $p->remarks;?></td>
					<td><?php echo date('d/m/Y',$p->created_on);?></td>
					<td><?php echo $user->first_name.' '.$user->last_name;?></td>
				 <td width="20%">
						 <div class="btn-group">
							<button class="btn dropdown-toggle" data-toggle="dropdown">Action <i class="glyphicon glyphicon-caret-down"></i></button>
							<ul class="dropdown-menu pull-right">
								 <li><a href="<?php echo site_url('admin/grades/edit/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-eye-open"></i> View</a></li>
								<li><a href="<?php echo site_url('admin/grades/edit/'.$p->id.'/'.$page);?>"><i class="glyphicon glyphicon-edit"></i> Edit</a></li>

								<li><a onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/grades/delete/'.$p->id.'/'.$page);?>'><i class="glyphicon glyphicon-trash"></i> Trash</a></li>
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
	</div>
</div>
