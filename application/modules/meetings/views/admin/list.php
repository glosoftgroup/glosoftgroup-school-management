<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Meetings</h4>
        <div class="heading-elements">
            <?php echo anchor('admin/meetings/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Event')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/meetings/calendar', '<i class="glyphicon glyphicon-calendar"></i> Calendar View', 'class="btn btn-primary"'); ?> 
        <?php echo anchor('admin/meetings/', '<i class="glyphicon glyphicon-list">
                </i> List View', 'class="btn btn-primary"'); ?>
        </div>
    </div>
    

    

<?php if ($meetings): ?>
       <div class="panel-body">
            <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Title</th>
                <th>Venue</th>
                <th>From</th>
                <th>To</th>
                <th>Guests</th>
                <th>Description</th>
                <th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }

                    foreach ($meetings as $p):
                            if ($p->type == 1)
                            {
                                    $u = $this->ion_auth->get_user($p->guests);
                            }
                            if ($p->type == 2)
                            {
                                    $pr = $this->ion_auth->get_single_parent($p->guests);
                            }

                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->title; ?></td>
                                <td><?php echo $p->venue; ?></td>
                                <td><?php echo date('d M Y', $p->start_date); ?></td>
                                <td><?php echo date('d M Y', $p->end_date); ?></td>
                                <td><?php
                                    if ($p->type == 1)
                                    {
                                            echo $u->first_name . ' ' . $u->last_name;
                                    }
                                    elseif ($p->type == 2)
                                    {
                                            echo $pr->first_name . ' ' . $pr->last_name;
                                    }
                                    else
                                    {
                                            echo $p->guests;
                                    }
                                    ?></td>
                                <td><?php echo $p->description; ?></td>

                                <td width='125'>
                                    <a class="btn btn-success" href='<?php echo site_url('admin/meetings/view/' . $p->id); ?>'><i class='glyphicon glyphicon-eye-open'></i> Full Details</a>
                                    <!-- <div class='btn-group'>
                                            <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                            <ul class='dropdown-menu pull-right'>
                                                     <li><a href='<?php echo site_url('admin/meetings/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                                                    <li><a  href='<?php echo site_url('admin/meetings/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
                                              
                                                    <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/meetings/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
                                            </ul>
                                    </div>-->
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>

            </table>


        </div>

<?php else: ?>
        <p class='text-center text-muted p-10'><?php echo lang('web_no_elements'); ?></p>
                         <?php endif ?>