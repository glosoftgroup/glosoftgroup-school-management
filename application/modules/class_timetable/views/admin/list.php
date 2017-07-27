<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Class Timetable</h4>
        <div class="heading-elements">
         <?php if (!$this->ion_auth->is_in_group($this->user->id, 3))
        { ?>          
                <?php echo anchor('admin/class_timetable/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Class Timetable')), 'class="btn btn-primary"'); ?>
        <?php } ?>
        <?php echo anchor('admin/class_timetable/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        </div>
    </div>
 
 
<?php if ($class_timetable): ?>               
       <div class="panel-body">
            <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>School Calendar</th>
                <th>Class</th>
                <th>Created on</th>
                <th>Created By</th>

                <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }

                    foreach ($class_timetable as $p):
                            $i++;
                            $user = $this->ion_auth->get_user($p->created_by);
                            $class = $this->ion_auth->classes_and_stream();
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>	
                                <td> </td>				
                                <td><?php echo $class[$p->class_id]; ?></td>


                                <td><?php echo date('d M Y', $p->created_on); ?></td>
                                <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>

                                <td width="20%">
                                    <div class="btn-group">
                                        <a  href="<?php echo site_url('admin/class_timetable/view/' . $p->class_id); ?>" class="btn btn-success" > <i class="glyphicon glyphicon-eye-open"></i> Full Timetable <i class="glyphicon glyphicon-caret-down"></i></a>
                                        <a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/class_timetable/delete/' . $p->id . '/' . $page); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>

                                    </div> 
                                </td>
                            </tr>
        <?php endforeach ?>
                </tbody>

            </table>


        </div>


<?php else: ?>
        <p class='text-center'><?php echo lang('web_no_elements'); ?></p>
         <?php endif ?>