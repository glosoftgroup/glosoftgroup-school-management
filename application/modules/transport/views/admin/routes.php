<div class="col-md-12">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>  Transport Routes </h2> 
        <div class="right">
            <?php echo anchor('admin/transport/', '<i class="glyphicon glyphicon-circle-arrow-left"></i> Go Back', 'class="btn btn-primary"'); ?>            
        </div>					
    </div>
    <div class="block-fluid">
        <div class="widget col-md-6">
            <?php
            if ($this->uri->segment(3) !== 'students')
            {
                    ?>
                    <div class="head black">
                        <div class="icon"><span class="icosg-list "></span></div>
                        <h2>New Route</h2>
                    </div>
                    <div class="block-fluid">
                        <?php echo form_open(current_url(), 'class=""'); ?>
                        <div class="form-group">
                            <div class="col-md-3">Name:</div>
                            <div class="col-md-6">                                      
                                <?php echo form_input('name', isset($result->name) ? $result->name : '', 'id="title_1"  placeholder="Name"'); ?>
                                <?php echo form_error('name'); ?>
                            </div>
                            <div class="col-md-3"> <button type="submit" class="btn btn-primary">Save</button></div>
                        </div>

                        <?php echo form_close(); ?> 
                    </div>
            <?php } ?>
        </div> 
        <div class="clearfix"></div>
        <?php
        if (isset($routes))
        {
                ?>
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Route List</h2>
                </div>        
                <table cellpadding="0" cellspacing="0" width="100%">
                    <!-- BEGIN -->
                    <thead>
                        <tr role="row">
                            <th width="3%">#</th>
                            <th>Name</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($routes as $r):
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>	
                                    <td width="50%"><?php echo $r->name; ?></td>
                                    <td >
                                        <div class="btn-group">
                                            <a  href="<?php echo site_url('admin/transport/students/' . $r->id); ?>" class="btn btn-primary" > Students </a>
                                            <a  href="<?php echo site_url('admin/transport/edit_route/' . $r->id); ?>" class="btn btn-primary" > Edit </a>
                                            <a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/transport/delete_route/' . $r->id); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>
                                        </div> 
                                    </td>
                                </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
        <?php } ?>
        <div class="clearfix"></div>

        <?php
        if (isset($students))
        {
                ?>
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Route : <?php echo $row->name ?></h2>
                </div>        
                <table cellpadding="0" cellspacing="0" width="100%">
                    <!-- BEGIN -->
                    <thead>
                        <tr role="row">
                            <th width="3%">#</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Term</th>
                            <th>Year</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($students as $s):
                                $st = $this->worker->get_student($s->student);
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>	
                                    <td><?php echo $st->first_name . ' ' . $st->last_name; ?></td>
                                    <td><?php echo isset($st->cl->name) ? $st->cl->name : '-'; ?></td>
                                    <td><?php echo isset($this->terms[$s->term]) ? $this->terms[$s->term] : ' -'; ?></td>
                                    <td><?php echo $s->year; ?></td>	
                                    <td>  </td>
                                </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
        <?php } ?>
        <div class="clearfix"></div>
    </div>
</div>
