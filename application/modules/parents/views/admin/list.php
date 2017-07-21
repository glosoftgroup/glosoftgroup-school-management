<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Parents  </h2>
    <div class="right">  
        <?php echo anchor('admin/parents', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Parents')), 'class="btn btn-primary"'); ?>
    </div>
</div>
<?php if ($parents): ?>
        <div class="block-fluid">
            <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>	
                <th>Address</th>
                <th>Email</th>
                <th>Status</th>
                <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }

                    foreach ($parents as $p):
                            $i++;
                            if (!empty($p->first_name))
                            {
                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>	

                                        <td><?php echo $p->first_name; ?> <?php echo $p->last_name; ?></td>
                                        <td><?php echo $p->phone; ?></td>
                                        <td><?php echo $p->address; ?></td>
                                        <td><?php echo $p->email; ?></td>
                                        <td><?php
                                            if ($p->status == 1)
                                                    echo '<span class="label label-success">Active</span>';
                                            else
                                                    echo '<span class="label label-danger">Inactive</span>';
                                            ?></td>

                                        <td width='350'>
                                            <div class='btn-group'>
                                                <a  class='btn btn-success' href='<?php echo site_url('admin/parents/view/' . $p->id . '/' . $p->id); ?>'>
                                                    <i class='glyphicon glyphicon-eye-open'></i> View</a>
                                            </div>
                                            <div class='btn-group'>
                                                <a  class='btn btn-primary' href='<?php echo site_url('admin/parents/edit/' . $p->id . '/' . $p->user_id); ?>'>
                                                    <i class='glyphicon glyphicon-edit'></i> Edit</a>
                                            </div>
                                            <?php
                                            if ($p->status == 1)
                                            {
                                                    ?>
                                                    <div class='btn-group'>
                                                        <a onClick="return confirm('Are you sure you want to deactivate this parent')" class='btn btn-danger'  href='<?php echo site_url('admin/parents/deactivate/' . $p->id); ?>' >
                                                            <i class='glyphicon glyphicon-trash'></i> Deactivate</a>
                                                    </div>
                                                    <?php
                                            }
                                            else
                                            {
                                                    ?>
                                                    <div class='btn-group'>
                                                        <a onClick="return confirm('Are you sure you want to activate this parent?')" class='btn btn-warning'  href='<?php echo site_url('admin/parents/activate/' . $p->id); ?>' >
                                                            <i class='glyphicon glyphicon-ok'></i> Activate</a>
                                                    </div>
                        <?php } ?>
                                        </td>
                                    </tr>
                <?php } endforeach ?>
                </tbody>

            </table>


        </div>

<?php else: ?>
        <p class='text-center'><?php echo lang('web_no_elements'); ?></p>
                                                 <?php endif ?>
