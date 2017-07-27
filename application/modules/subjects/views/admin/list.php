<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h6 class="panel-title">Subjects</h6>
		<div class="heading-elements">
			<div class="heading-btn">
				 <?php echo anchor('admin/subjects/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?>
                <?php echo anchor('admin/subjects', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Subjects')), 'class="btn heading-btn btn-primary"'); ?>
               <?php echo anchor('admin/subjects/per_class', '  Allocation Report ', 'class="btn heading-btn btn-primary"'); ?>

			</div>
		</div>
	</div>

	<div class="panel-body">
		<?php if ($subjects): ?>
         <div class="panel-body">
             <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 <th>#</th>
                 <th>Name</th>
                 <th>Description</th>
                 <th>Short Name</th>
                 <th><?php echo lang('web_options'); ?></th>
                 </thead>
                 <tbody>
                      <?php
                      $i = 0;
                      if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0))
                      {
                           $i = ($this->uri->segment(4) - 1) * $per;
                      }
                      foreach ($subjects as $p):
                           $i++;
                           ?>
                          <tr>
                              <td><?php echo $i . '.'; ?></td>
                              <td><?php echo $p->name; ?></td>
                              <td width="30%"><?php
                                   foreach ($p->subs as $snid => $ops)
                                   {
                                        $ps = (object) $ops;
                                        echo '<span class="label label-info">' . $ps->title . '</span> ';
                                   }
                                   ?></td>
                              <td><?php echo $p->short_name; ?></td>
                              <td width='20%'>
                                  <div class='btn-group'>
                                      <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                      <ul class='dropdown-menu pull-right'>
                                          <li><a href='<?php echo site_url('admin/subjects/units/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-share-alt'></i> Sub Units</a></li>
                                          <li><a href='<?php echo site_url('admin/subjects/view/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                                          <li><a href='<?php echo site_url('admin/subjects/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
                                          <li><a onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')"
                                                 href='<?php echo site_url('admin/subjects/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
                                      </ul>
                                  </div>
                              </td>
                          </tr>
                     <?php endforeach ?>
                 </tbody>
             </table>
         </div>
    <?php else: ?>
         <p class='alert alert-warning'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>
	</div>

</div>
<!-- /pager -->
