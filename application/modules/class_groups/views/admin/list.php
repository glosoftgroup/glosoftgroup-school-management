<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Classes  </h2>
    <div class="right"> 
        <?php echo anchor('admin/class_groups/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Class')), 'class="btn btn-primary"'); ?> 
        <?php echo anchor('admin/class_groups', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Classes')), 'class="btn btn-primary"'); ?> 

    </div>

</div>

<?php if ($class_groups): ?>
        <div class="block-fluid">
            <table class="stable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Name</th>
                <th>Total Students</th>
                <th>Streams</th>
                <th>Status</th>	
                <th>Description</th>	
                <th width='30%'><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }

                    foreach ($class_groups as $p):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->name; ?></td>
                                <td><?php echo $p->size; ?></td>
                                <td><?php
                                    foreach ($p->streams as $st)
                                    {
                                            ?> 
                                            <span class="label label-info">  <?php echo $st; ?></span>
                                    <?php } ?>
                                </td>
                                <td><?php
                                    if ($p->status == 1)
                                            echo '<b style="color:green">Active</b>';
                                    else
                                            echo '<b style="color:red">Disabled</b>';
                                    ?></td>
                                <td><?php echo $p->description; ?></td>

                                <td>
                                    <div class="btn-group">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Action <i class="glyphicon glyphicon-caret-down"></i></button>
                                        <ul class="dropdown-menu pull-right">

                                            <li>
                                                <a href="<?php echo site_url('admin/class_groups/edit/' . $p->id . '/' . $page); ?>"><i class="glyphicon glyphicon-eye-open"></i> Edit Details</a>
                                            </li>

                                            <?php if ($p->status == 1): ?>

                                                    <li> <a class="" href='<?php echo site_url('admin/class_groups/add_stream/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i>Add Streams</a></li>

                                                    <li><a class="" onClick="return confirm('<?php echo "Are you sure you want to Disable this class?"; ?>')" href='<?php echo site_url('admin/class_groups/disable/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i>Disable</a></li>
                                            <?php else: ?>

                                                    <li> <a class="" onClick="return confirm('<?php echo "Are you sure you want to Enable this class?"; ?>')" href='<?php echo site_url('admin/class_groups/enable/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i>Enable</a></li>

                                            <?php endif; ?>
                                        </ul>
                                    </div>


                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>

            </table>

        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                                                                     <?php endif; 