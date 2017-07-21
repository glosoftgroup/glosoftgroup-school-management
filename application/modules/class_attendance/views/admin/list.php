<!-- Pager -->
<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title"> Class Attendance</h6>
		<div class="heading-elements">
      <?php echo anchor('admin/class_attendance/create/' . $class . '/1', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Attendance')), 'class="btn btn-primary"'); ?>
      <?php echo anchor('admin/class_attendance/', '<i class="glyphicon glyphicon-list">
              </i> List All', 'class="btn btn-primary"'); ?>
		</div>
	</div>
<?php if ($class_attendance): ?>
      <div class="panel-body">
            <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Date</th>
                <th>Class</th>
                <th>Attendance Type</th>
                <th>Taken on</th>
                <th>Taken By</th>
                <th width="22%"><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                     foreach ($class_attendance as $p):
                            $cc = '';
                            if (isset($this->classlist[$p->class_id]))
                            {
                                    $cro = $this->classlist[$p->class_id];
                                    $cc = isset($cro['name']) ? $cro['name'] : '';
                            }
                            $i++;
                            $u = $this->ion_auth->get_user($p->created_by);
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>
                                <td><?php echo date('d M Y', $p->attendance_date); ?></td>
                                <td><?php echo $cc; ?></td>
                                <td><?php echo $p->title; ?></td>
                                <td><?php echo date('d M Y', $p->created_on); ?></td>
                                <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                                <td width="150">
                                    <div class='btn-group'>
                                        <a href="<?php echo site_url('admin/class_attendance/view/' . $p->id); ?>" class="btn btn-success"><i class="glyphicon glyphicon-eye-open"></i> View Register</a>
                                        <a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/class_attendance/delete/' . $p->id); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; ?>
