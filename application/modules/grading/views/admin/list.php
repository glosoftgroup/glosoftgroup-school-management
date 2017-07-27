<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h6 class="panel-title">Grading</h6>
		<div class="heading-elements">
			<div class="heading-btn">
				<?php echo anchor('admin/grading/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Grading')), 'class="btn heading-btn btn-primary"'); ?>
               <?php echo anchor('admin/grading/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn heading-btn btn-primary"'); ?>
			</div>
		</div>
	</div>

	<div class="panel-body">
	<?php if ($grading): ?>
        <div class="block-fluid">
            <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                   <tr class="bg-primary">
                <th width="3">#</th>
                <th>Grading System</th>
                <th>Added By</th>
                <th>Added On</th>
                <th><?php echo lang('web_options'); ?></th>
              </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }

                    foreach ($grading as $p):
                            $user = $this->ion_auth->get_user($p->created_by);
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>
                                <td><?php echo $grading_system[$p->grading_system]; ?></td>

                                <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                <td><?php echo date('d/m/Y', $p->created_on); ?></td>
                                <td>
                                  <ul class="icons-list">
                                    <li><?php echo anchor('admin/grading/view/' . $p->id, '<i class="glyphicon glyphicon-list"></i> View Grades', 'class="btn btn-primary"'); ?>
                                    </li>
                                    <li>
                                    <a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/grading/delete/' . $p->id); ?>'>
                                      <i class="glyphicon glyphicon-trash"></i> Move to Trash</a>
                                    </li>
                                  </ul>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>



<?php else: ?>
        <p class='text-center'><?php echo lang('web_no_elements'); ?></p>
         <?php endif ?>

	</div>

</div>
<!-- /pager -->
