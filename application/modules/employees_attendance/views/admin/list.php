<!-- Pager -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h6 class="panel-title">Employees Attendance</h6>
		<div class="heading-elements">
			<ul class="pager pager-sm">
				<li>
				<?php echo anchor( 'admin/employees_attendance/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Employees Attendance')), 'class="btn btn-primary"');?>

				</li>
				<li><?php echo anchor( 'admin/employees_attendance' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Employees Attendance')), 'class="btn btn-primary"');?> </li>
			</ul>
		</div>
	</div>
	<?php if ($employees_attendance): ?>
	<div class="panel-body">
		<table class="table datatable-show-all fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
		<th>#</th>
		<th>Date</th>
		<th>Employee</th>
		<th>Time In</th>
		<th>Time Out</th>
		<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php
       $i = 0;
          if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
          {
              $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
          }
          foreach ($employees_attendance as $p ):
			 $u = $this->ion_auth->get_user($p->employee);
       $i++;
                     ?>
	 <tr>
        <td><?php echo $i . '.'; ?></td>
				<td><a href="<?php echo base_url('admin/employees_attendance/by_date/'.date('d-m-Y',$p->date));?>">
				<i class="glyphicon glyphicon-chevron-right"></i> <?php echo date('d M Y',$p->date);?></a></td>
				<td><a href="<?php echo base_url('admin/employees_attendance/by_employee/'.$p->employee);?>">
				<i class="glyphicon glyphicon-chevron-right"></i> <?php echo $u->first_name.' '.$u->last_name;?></a></td>
				<td><?php echo $p->time_in;?></td>
				<td><?php echo $p->time_out;?></td>
  			<td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								<?php if(empty($p->time_out)){?>
								<li><a  href='<?php echo site_url('admin/employees_attendance/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-plus'></i> Add Time Out</a></li>
								<?php }?>
							  <li><a  href='<?php echo site_url('admin/employees_attendance/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit Details</a></li>

								<li><a  style="color:red" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/employees_attendance/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
							</ul>
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
	  </tbody>

	</table>
	</div>
	<?php else: ?>
 	<p class='alert alert-warning'><?php echo lang('web_no_elements');?></p>
    <?php endif ?>
</div>
<!-- /pager -->
