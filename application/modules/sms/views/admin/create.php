<div class="middle">
    <div class="button tip" title="New Message">
        <a href="#" id="openMailModal">
            <span class="icomg-mail"></span>
            <span class="text">New Message</span>
        </a>
    </div>
    <div class="button tip" title="Inbox">
        <a href="#">
            <span class="icomg-box-add"></span>
            <span class="text">All SMS's<br/><?php echo $inbox; ?></span>                       
        </a>
    </div>
    <div class="button tip" title="Outbox">
        <a href="#">
            <span class="icomg-box-remove"></span>
            <span class="text">Sent<br/><?php echo $sent; ?></span>
        </a>                    
    </div> 
    <div class="button tip" title="Draft">
        <a href="#">
            <span class="icomg-box-remove"></span>
            <span class="text">Draft<br/><?php echo $draft; ?></span>
        </a>                    
    </div>                        
    <div class="button tip" title="Custom">
        <a href="<?php echo base_url('admin/sms/custom'); ?>">
            <span class="icomg-comments3"></span>
            <span class="text">Custom</span>
        </a>                    
    </div>                        

    <div class="button tip" title="Check SMS Balance">
        <a href="<?php echo base_url('admin/sms/balance'); ?>">
            <span class="icomg-info"></span>
            <span class="text">Balance<br/> </span>
        </a>                    
    </div>          


</div>

<div class="dialog-fluid" id="sendMailModal" style="display: none;" title="Send SMS">
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo form_open_multipart(current_url(), $attributes);
    ?>
    <div class="row">            

        <?php
        $items = array(
            '' => 'Send To:',
            'All Parents' => 'All Parents',
            'All Teachers' => 'All Teachers',
            'All Staff' => 'All Staff',
            'Class' => 'Per Class',
            'Staff' => 'Staff',
            'Parent' => 'Parent',
        );
        ?>
        <div class="block-fluid">
            <div class="form-group">
                <div class="col-md-12">
                    <?php echo form_dropdown('send_to', $items, $sms_m->send_to, ' data-placeholder="Send To:" onchange="show_field(this.value)" id="send_to" class="select chosen col-md-4"  tabindex="4"'); ?>
                </div>
            </div>


            <div class="form-group" id="rc_staff">
                <div class="col-md-12">
                    <span class="top title"></span>
                    <?php
                    echo form_dropdown('staff', array('' => 'Select Staff') + $users, (isset($sms_m->staff)) ? $sms_m->staff : '', ' class="select populate col-md-4"  ');
                    echo form_error('staff');
                    ?>
                </div>
            </div> 
            <div class="form-group" id="rc_parent">
                <div class="col-md-12">
                    <span class="top title"></span>
                    <?php
                    echo form_dropdown('parent', array('' => 'Select Parent') + (array) $parents, (isset($sms_m->parent)) ? $sms_m->parent : '', ' class=" populate col-md-6" ');
                    echo form_error('parent');
                    ?>
                </div>
            </div> 
            <div class="form-group" id="rc_class">
                <div class="col-md-12">
                    <span class="top title"></span>
                    <?php
                    echo form_dropdown('class', array('' => 'Select Class') + (array) $classes, (isset($sms_m->class)) ? $sms_m->class : '', ' class=" select chosen col-md-6" ');
                    echo form_error('class');
                    ?>
                </div>
            </div> 

        </div>

        <?php
        echo form_textarea(
                     array(
                         'name' => 'description',
                         'rows' => '20',
                         'placeholder' => "Your Message (NB: message is charged per 160 character)",
                         //'maxlength' => "160",
                         'id' => 'message',
                         'style' => 'min-height:180px;',
                     )
        );
        ?> 

        <div class="form-group">
            <div class="col-md-12">

                <div class="input-group file left">
                    <?php
                    $items = array('draft' => 'draft');
                    echo form_dropdown('status', array('' => 'Save as') + (array) $items, (isset($sms_m->status)) ? $sms_m->status : '', ' class="col-md-12" ');
                    echo form_error('status');
                    ?>
                </div>
            </div>
        </div>   
    </div> 
    <div class="toolbar inside">
        <div class="left">
            <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Send SMS', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
            <?php echo anchor('admin/sms', 'Cancel', 'class="btn btn-danger"'); ?>
        </div>

    </div>	
    <?php echo form_close(); ?>	
</div> 

<div class="row">

    <div class="col-md-12">

        <div class="widget">                    
            <div class="head dark">
                <div class="icon"><span class="icos-box-add"></span></div>
                <h2>Inbox</h2>
            </div>                                                 

            <div class="block-fluid">
                <?php if ($sms): ?>

                        <table class="table-hover mailbox" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="checkall"/></th>
                                    <th width="20%">Sent By</th>

                                    <th width="50%">Message</th>
                                    <th width="10%">Date/Time</th>
                                    <th width="20%">Recipient</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($sms as $sms_m):
                                        $user = $this->ion_auth->get_user($sms_m->created_by)
                                        ?>
                                        <tr class="new">
                                            <td><input type="checkbox" name="checkbox"/></td>
                                            <td>
                                                <img src="<?php echo base_url('assets/themes/admin/img/member.png'); ?>" width="25" height="25" class="img-polaroid" align="left"/> 
                                                <a href="#" class="name"><?php echo $user->first_name . ' ' . $user->last_name; ?></a> <a href="#"><?php echo $user->email; ?></a>
                                            </td>

                                            <td><a href="#" class="subject"><?php echo $sms_m->description; ?></a></td>
                                            <td><?php echo time_ago($sms_m->created_on); ?></td>
                                            <td><?php
                                                if ($sms_m->type == 0)
                                                {
                                                        echo $sms_m->recipient;
                                                }
                                                elseif ($sms_m->type == 1)
                                                {
                                                        $user_rec = $this->ion_auth->get_user($sms_m->recipient);
                                                        echo $user_rec->first_name . ' ' . $user_rec->last_name;
                                                }
                                                elseif ($sms_m->type == 2)
                                                {
                                                        $parent_rec = $this->ion_auth->get_single_parent($sms_m->recipient);
                                                        echo $parent_rec->first_name . ' ' . $parent_rec->last_name;
                                                }
                                                elseif ($sms_m->type == 6)
                                                {
                                                        $cc = isset($classes[$sms_m->recipient]) ? $classes[$sms_m->recipient] : ' -';

                                                        echo $cc . ' ' . $ss;
                                                }
                                                ?></td>

                                        </tr>
                                        <?php
                                        $i++;
                                endforeach
                                ?>                                                                       
                            </tbody>
                        </table>
                        <div class="toolbar bottom">

                            <div class="right">
                                <div class="pagination pagination-right pagination-mini">
                                    <?php echo $links; ?>

                                </div><br>

                            </div>

                        </div>
                <?php else: ?>
                        <p class='text-center'><?php echo lang('web_no_elements'); ?></p>
                <?php endif ?> 
            </div>

        </div>

    </div>


</div>

<script>
        function show_field(item) {
            //hide all
            //document.getElementById('cc').style.display='none';
            document.getElementById('rc_staff').style.display = 'none';
            document.getElementById('rc_parent').style.display = 'none';
            document.getElementById('rc_class').style.display = 'none';

            if (item == 'Staff')
                document.getElementById('rc_staff').style.display = 'block';
            if (item == 'Parent')
                document.getElementById('rc_parent').style.display = 'block';
            if (item == 'Class')
                document.getElementById('rc_class').style.display = 'block';
            return;
        }
<?php
if ($this->uri->segment(3) == 'create')
{
        ?>
                show_field('None');
<?php } ?>
</script>