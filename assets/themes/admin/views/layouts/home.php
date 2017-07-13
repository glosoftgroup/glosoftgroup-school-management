<!DOCTYPE html>
<html lang="en">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <!--[if gt IE 8]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <![endif]-->        
        <title><?php echo $template['title']; ?></title>
        <?php echo theme_css('stylesheets.css'); ?>     
        <?php echo theme_css('custom.css'); ?>
        <!--[if lt IE 10]>
            <link href="css/ie.css" rel="stylesheet" type="text/css" />
        <![endif]-->        
        <script> var BASE_URL = '<?php echo base_url(); ?>';</script>
        <?php echo theme_js('plugins/jquery/jquery.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-ui-1.10.1.custom.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-migrate-1.1.1.min.js'); ?>
        <?php echo theme_js('plugins/jquery/globalize.js'); ?>
        <?php echo theme_js('plugins/other/excanvas.js'); ?>
        <?php echo theme_js('plugins/other/jquery.mousewheel.min.js'); ?>
        <?php echo theme_js('plugins/bootstrap/bootstrap.min.js'); ?>            
        <?php echo theme_js('plugins/cookies/jquery.cookies.2.2.0.min.js'); ?>
        <?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>
        <?php echo theme_js('plugins/fullcalendar/fullcalendar.min.js'); ?>        
        <?php echo theme_js('plugins/datatables/jquery.dataTables.min.js'); ?>    
        <?php echo theme_js('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>
        <?php echo theme_js('plugins/uniform/jquery.uniform.min.js'); ?>
        <?php echo theme_js('plugins/select/select2.min.js'); ?>
        <?php echo theme_js('plugins/hoverintent/jquery.hoverIntent.minified.js'); ?>
        <?php echo theme_js('plugins/ibutton/jquery.ibutton.min.js'); ?>
        <?php echo theme_js('plugins/scrollup/jquery.scrollUp.min.js'); ?>
        <script type="text/javascript">  var flist = '<?php echo $this->list_size; ?>';</script>
        <?php echo theme_js('amct/amcharts.js'); ?>
        <?php echo theme_js('amct/pie.js'); ?>
        <?php echo theme_js('amct/serial.js'); ?>
        <?php echo theme_js('amct/exporting/amexport.js'); ?>
        <?php echo theme_js('amct/exporting/rgbcolor.js'); ?>
        <?php echo theme_js('amct/exporting/canvg.js'); ?>
        <?php echo theme_js('amct/exporting/jspdf.js'); ?>
        <?php echo theme_js('amct/exporting/filesaver.js'); ?>
        <?php echo theme_js('amct/exporting/jspdf.plugin.addimage.js'); ?>
        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('favicon.ico'); ?>" />
    </head>
    <?php
    $ccls = 'ssRed';
    if ($this->ion_auth->is_in_group($this->user->id, 3))
    {
            $ccls = 'ssGreen';
    }
    ?>
    <body class="<?php echo $this->school->theme_color . ' ' . $this->school->background; ?>" >
        <?php echo $template['partials']['top']; ?>
        <?php echo $template['partials'][$this->side]; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="breadCrumb clearfix">    
                    <div>
                        <div style="display: inline-block; width:40%"> 
                            <span > <?php echo anchor('/', 'Home'); ?> > </span>
                            <?php
                            if ($this->uri->segment(2))
                            {
                                    ?>
                                    <span ><?php echo anchor('admin/' . $this->uri->segment(2), humanize($this->uri->segment(2))); ?> > </span>
                            <?php } ?>
                            <span ><?php echo $template['title']; ?></span>
                        </div>
                        <div style="display: inline-block; width:40%"><?php
                            $user = $this->ion_auth->get_user();
                            $gp = $this->ion_auth->get_users_groups($user->id)->row();
                            ?><small>&nbsp;</small>
                            <span class="label label-success"  ><?php echo ucwords($gp->name); ?></span>
                            </span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">        
                <div class="middle">
                      <?php
                    if ($this->acl->is_allowed(array('admission', 'create'), 1))
                    {
                            ?>
                    <div class="informer">
                        <a href="<?php echo base_url('admin/admission/create'); ?>">
                            <span class="icomg-user"></span>
                            <span class="text">New Student</span>
                        </a>
                    </div><?php } ?>
                    <?php
                    if ($this->acl->is_allowed(array('fee_payment', 'create'), 1))
                    {
                            ?>
                            <div class="informer">
                                <a href="<?php echo base_url('admin/fee_payment/create'); ?>">
                                    <span class="icomg-database"></span>
                                    <span class="text">New Payment</span>
                                </a>
                            </div><?php } ?>
                    <div class="informer">
                        <a href="<?php echo base_url('admin/class_groups/classes'); ?>">
                            <span class="icomg-list"></span>
                            <span class="text">Classes</span>                        
                        </a>
                    </div>
                    <div class="informer">
                        <a href="<?php echo base_url('admin/sms/create'); ?>">
                            <span class="icomg-comments3"></span>
                            <span class="text">Send SMS</span>                        
                        </a>
                    </div>     
                    <?php
                    if ($this->acl->is_allowed(array('record_salaries'), 1))
                    {
                            ?>
                            <div class="informer">
                                <a href="<?php echo base_url('admin/record_salaries/'); ?>">
                                    <span class="icomg-tag"></span>
                                    <span class="text">Payroll</span>
                                </a>
                            </div><?php } ?>
                    <?php
                    if ($this->acl->is_allowed(array('expenses'), 1))
                    {
                            ?>
                            <div class="informer">
                                <a href="<?php echo base_url('admin/expenses/'); ?>">
                                    <span class="icomg-file"></span>
                                    <span class="text">Expenses</span>
                                </a>
                            </div>
                    <?php } ?>
                    <div class="informer">
                        <a href="<?php echo base_url('admin/class_attendance'); ?>">
                            <span class="icomg-calendar"></span>
                            <span class="text"> Rollcall</span>
                        </a>
                    </div>                                  
                    <div class="informer">
                        <a href="<?php echo base_url('admin/exams'); ?>">
                            <span class="icomg-attachment"></span>
                            <span class="text">Exams</span>
                        </a>
                    </div>
                    <?php
                    if ($this->acl->is_allowed(array('fee_arrears'), 1))
                    {
                            ?>
                            <div class="informer">
                                <a href="<?php echo base_url('admin/fee_arrears'); ?>">
                                    <span class="icomg-clipboard1"></span>
                                    <span class="text">Fee Arrears </span>
                                </a>
                            </div>	<?php } ?>	
                    <div class="informer">
                        <a href="<?php echo base_url('admin/transport'); ?>">
                            <span class="icomg-bus"></span>
                            <span class="text">Transport </span>
                        </a>
                    </div>	
                    <?php
                    if ($this->acl->is_allowed(array('hostels'), 1))
                    {
                            ?>
                            <div class="informer">
                                <a href="<?php echo base_url('admin/hostels'); ?>">
                                    <span class="icomg-home"></span>
                                    <span class="text">Boarding </span>
                                </a>
                            </div><?php } ?>
                    <?php
                    if ($this->acl->is_allowed(array('inventory'), 1))
                    {
                            ?>
                            <div class="informer">
                                <a href="<?php echo base_url('admin/inventory'); ?>">
                                    <span class="icomg-archive2"></span>
                                    <span class="text">Inventory </span>
                                </a>
                            </div>    <?php } ?>            
                    <div class="informer">
                        <a href="<?php echo base_url('admin/settings'); ?>">
                            <span class="icomg-cog"></span>
                            <span class="text">Settings </span>
                        </a>
                    </div>	
                    <div class="informer">
                        <a href="<?php echo base_url('admin/settings/backup'); ?>">
                            <span class="icomg-download"></span>
                            <span class="text">Data Backup </span>
                        </a>
                    </div>					
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <?php
                    if ($this->session->flashdata('warning'))
                    {
                            ?>
                            <div class="alert">
                                <button type="button" class="close" data-dismiss="alert">                                    
                                    <i class="glyphicon glyphglyphicon glyphicon-remove"></i> </button>
                                <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                            </div>
                    <?php } ?>
                    <?php
                    if ($this->session->flashdata('success'))
                    {
                            ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">  <i class="glyphicon glyphglyphicon glyphicon-remove-circle"></i>  </button>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                    <?php } ?>
                    <?php
                    if ($this->session->flashdata('info'))
                    {
                            ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">                                    
                                    <i class="glyphicon glyphglyphicon glyphicon-remove-circle"></i> </button>
                                <?php echo $this->session->flashdata('info'); ?>
                            </div>
                    <?php } ?>
                    <?php
                    if ($this->session->flashdata('message'))
                    {
                            $message = $this->session->flashdata('message');
                            $str = is_array($message) ? $message['text'] : $message;
                            ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">                                   
                                    <i class="glyphicon glyphglyphicon glyphicon-remove-circle"></i>                                </button>
                                <?php echo $str; //$this->session->flashdata('message');  ?>
                            </div>
                    <?php } ?>
                    <?php
                    if ($this->session->flashdata('error'))
                    {
                            ?>
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">                                    
                                    <i class="glyphicon glyphicon-remove"></i>      </button>
                                <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                            </div>
                    <?php } ?>
                    <?php
                    if ($this->acl->is_allowed(array('admission', 'create'), 1))
                    {
                            ?>
                            <div class="widget">
                                <div class="head dark">
                                    <div class="icon"><i class="icos-stats-up"></i></div>
                                    <h2>Recently Registered Students</h2>
                                    <ul class="buttons">                            
                                        <li><a href="<?php echo base_url('admin/admission/create/'); ?>"><span class="icos-plus"></span></a></li>
                                        <li><a href="<?php echo base_url('admin/admission/'); ?>"><span class="icos-cog"></span></a></li>
                                    </ul>                         
                                </div>                
                                <div class="block-fluid">
                                    <table class="table table-hover" cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="checkall"/></th>
                                                <th width="25%">Name</th>
                                                <th width="20%">ADM Date</th>
                                                <th width="20%">ADM No.</th>
                                                <th width="14%">Gender</th>
                                                <th width="26%">Time</th>
                                                <th width="15%" class="TAC">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            $sts = $this->ion_auth->list_students();
                                            foreach ($sts as $st):
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><input type="checkbox" name="order[]" value="528"/></td>
                                                        <td><a style="font-size:.8em" href="<?php echo base_url('admin/admission/view/' . $st->id); ?>"><?php echo $st->first_name . ' ' . $st->last_name; ?></a></td>
                                                        <td><?php echo $st->admission_date > 10000 ? date('d/m/Y', $st->admission_date) : '-'; ?></td>
                                                        <td><?php
                                                            if (!empty($st->old_adm_no))
                                                            {
                                                                    echo $st->old_adm_no;
                                                            }
                                                            else
                                                            {
                                                                    echo $st->admission_number;
                                                            }
                                                            ?></td>
                                                        <td><?php
                                                            if ($st->gender)
                                                            {
                                                                    if ($st->gender == 1)
                                                                            echo 'Male';
                                                                    else
                                                                            echo 'Female';
                                                            }
                                                            ?></td>
                                                        <td><?php echo time_ago($st->created_on); ?></td>
                                                        <td class="TAC">
                                                            <a href="<?php echo base_url('admin/admission/view/' . $st->id); ?>"><span class="glyphicon glyphglyphicon glyphicon-eye-open"></span></a> 
                                                            <a href="<?php echo base_url('admin/admission/edit/' . $st->id); ?>"><span class="glyphicon glyphglyphicon glyphicon-pencil"></span></a> 
                                                        </td>
                                                    </tr>
                                            <?php endforeach ?>                         
                                        </tbody>
                                    </table>                    
                                </div> 
                            </div>     
                            <?php
                    }
                    if ($this->acl->is_allowed(array('fee_payment', 'create'), 1))
                    {
                            ?> 
                            <div class="widget">
                                <div class="head dark">
                                    <div class="icon"><span class="icos-calendar"></span></div>
                                    <h2>Recent Fee Payments</h2>
                                    <ul class="buttons">                            
                                        <li><a href="#"><span class="icos-refresh"></span></a></li>
                                        <li><a href="#"><span class="icos-history"></span></a></li>
                                        <li><a href="#"><span class="icos-flag1"></span></a></li>
                                    </ul>                         
                                </div>
                                <div class="block-fluid">
                                    <table class="table table-hover" cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="checkall"/></th>
                                                <th width="35%">Student</th>
                                                <th width="10%">Amount</th>
                                                <th width="20%">Paid On</th>
                                                <th width="20%">Recorded By</th>
                                                <th width="7%" class="TAC">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $this->load->library('Dates');
                                            foreach ($recent_payments as $py):
                                                    $u = $this->ion_auth->get_user($py->created_by);
                                                    $st = $this->worker->get_student($py->reg_no);
                                                    if (empty($st))
                                                    {
                                                            $st = new stdClass();
                                                            $st->first_name = '';
                                                            $st->last_name = '';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><input type="checkbox" name="ids[]" value="<?php echo $py->id; ?>"/></td>
                                                        <td><a style="font-size:.8em" href="<?php echo base_url('admin/admission/view/' . $py->reg_no); ?>"><?php echo $st->first_name . ' ' . $st->last_name; ?></a></td>
                                                        <td><?php echo number_format($py->amount, 2); ?></td>
                                                        <td><?php echo $this->dates->createFromTimeStamp($py->created_on)->diffForHumans(); ?></td>
                                                        <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                                                        <td class="TAC">
                                                            <a href="<?php echo base_url('admin/fee_payment/receipt/' . $py->receipt_id); ?>" title="View Receipt"><span class="glyphicon glyphglyphicon glyphicon-eye-open"></span></a> 
                                                        </td>
                                                    </tr>
                                            <?php endforeach ?>                         
                                        </tbody>
                                    </table>                    
                                </div> 
                                <div class="toolbar-fluid">
                                    <div class="information">
                                        <div class="item">
                                            <div class="rates">
                                                <div class="title"><?php
                                                    if (empty($total_fees->total))
                                                            echo '0.00';
                                                    else
                                                            echo number_format($total_fees->total, 2);
                                                    ?></div>
                                                <div class="description">Total Paid Fees (<?php echo $this->currency; ?>)</div>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="rates">
                                                <div class="title"><?php
                                                    $t = $total_petty_cash->total + $wages + $total_expenses->total;
                                                    echo number_format($t, 2);
                                                    ?></div>
                                                <div class="description">Total Expenses (<?php echo $this->currency; ?>)</div>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="rates">
                                                <div class="title"><?php
                                                    if (empty($total_waiver->total))
                                                            echo '0.00';
                                                    else
                                                            echo number_format($total_waiver->total, 2);
                                                    ?> </div>
                                                <div class="description">Total Fee Waivers (<?php echo $this->currency; ?>)</div>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="rates">
                                                <div class="title"><?php
                                                    if (empty($total_stock->total))
                                                            echo '0.00';
                                                    else
                                                            echo number_format($total_stock->total, 2);
                                                    ?></div>
                                                <div class="description">Inventory Totals</div>
                                            </div>
                                        </div>                            
                                    </div>
                                </div>
                            </div>
                    <?php } ?>
                    <div class="widget">
                        <div class="head dark">
                            <div class="icon"><i class="icos-calendar"></i></div>
                            <h2>Calendar of Events</h2>
                            <ul class="buttons">                            
                                <li><a href="<?php echo base_url('admin/school_events/create/'); ?>"><span class="icos-plus"></span></a></li>
                                <li><a href="<?php echo base_url('admin/school_events/'); ?>"><span class="icos-cog"></span></a></li>
                            </ul>                         
                        </div>  
                        <div class="block-fluid">
                            <div id="calendar"></div>
                        </div>            
                    </div>
                </div>
                <div class="col-md-4">
                    <?php
                    if ($this->acl->is_allowed(array('fee_payment', 'create'), 1))
                    {
                            ?> 
                            <div class="widget">
                                <div class="head dark">
                                    <div class="icon"><i class="icos-tag"></i></div>
                                    <h2>Cashflow Summary</h2>
                                    <ul class="buttons">                                                        
                                        <li><a href="#"><span class="icos-cog"></span></a></li>
                                    </ul>                          
                                </div>
                                <div class="block TAC">
                                    <div id= "money" style="width: 100%; height: 350px;"></div>
                                </div>
                            </div>                              
                    <?php } ?>		
                    <?php
                    if ($this->acl->is_allowed(array('users', 'create'), 1))
                    {
                            ?>
                            <div class="widget"> 
                                <div class="head dark">
                                    <div class="icon"><i class="icos-user2"></i></div>
                                    <h2>Online Users</h2>
                                    <ul class="buttons">                                                        
                                        <li><a href="#" class="cblock"><span class="icos-menu"></span></a></li>
                                    </ul>                       
                                </div> 
                                <div class="block-fluid users">
                                    <div class="scroll" style="height: 200px;">
                                        <?php
                                        foreach ($users as $u)
                                        {
                                                $user = $this->ion_auth->get_user($u->user_id);
                                                ?>
                                                <div class="userCard">
                                                    <div class="image">
                                                        <?php echo theme_image('examples/users/avatar.png', array('class' => "img-polaroid")); ?>
                                                    </div>
                                                    <div class="info-s">
                                                        <h3><?php echo $user->first_name . ' ' . $user->last_name; ?></h3>
                                                        <p><span class="glyphicon glyphglyphicon glyphicon-envelope"></span> <?php echo $user->email; ?></p>
                                                        <?php
                                                        foreach ($u->groups as $g)
                                                        {
                                                                ?>
                                                                <span class="label label-info"><?php echo rtrim($g->description, 's'); ?></span>
                                                        <?php } ?>
                                                        <div class="informer">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php } ?>
                                    </div>  
                                    <div class="toolbar">
                                        <div class="left">
                                            <div class="btn-group">
                                                <button class="btn " >Total Online Users (<?php echo count($users); ?>)</button>                            
                                            </div>                         
                                        </div>
                                    </div>                    
                                </div>                               
                            </div>                               
                    <?php } ?>

                </div>            
            </div>
        </div>  
        <div id="fcAddEvent" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="fcAddEventLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="fcAddEventLabel">Add new event</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">Title:</div>
                    <div class="col-md-9"><input type="text" id="fcAddEventTitle"/></div>
                </div>
            </div>
            <div class="modal-footer">            
                <button class="btn btn-primary" id="fcAddEventButton">Add</button>            
            </div>
        </div>
        <?php
        $event_data = array();
        foreach ($events as $event)
        {
                $user = $this->ion_auth->get_user($event->created_by);
                $start_date = $event->start_date;
                $end_date = $event->end_date;
                $current = date('Y-m-d', time());
                if ($end_date < time())
                {
                        $event_data[] = array(
                            'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
                            'start' => date('d M Y H:i', $event->start_date),
                            'end' => date('d M Y H:i', $event->end_date),
                            'venue' => $event->venue,
                            'event_title' => $event->title,
                            'cache' => true,
                            'backgroundColor' => 'black',
                            'description' => strip_tags($event->description),
                            'user' => $user->first_name . ' ' . $user->last_name,
                        );
                }
                else
                {
                        $event_data[] = array(
                            'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
                            'start' => date('d M Y H:i', $event->start_date),
                            'end' => date('d M Y H:i', $event->end_date),
                            'venue' => $event->venue,
                            'event_title' => $event->title,
                            'cache' => true,
                            'backgroundColor' => $event->color,
                            'description' => strip_tags($event->description),
                            'user' => $user->first_name . ' ' . $user->last_name,
                        );
                }
        }
        ?>
        <?php
        $pie[] = array(
            'label' => "Fee Paid",
            'data' => $total_fees->total,
        );
        $pie[] = array(
            'label' => "Expenses",
            'data' => $total_expenses->total,
        );
        if (isset($total_petty_cash->total) && $total_petty_cash->total)
        {
                $pie[] = array(
                    'label' => "Petty Cash",
                    'data' => $total_petty_cash->total,
                );
        }
        if (isset($wages) && $wages)
        {
                $pie[] = array(
                    'label' => "Payroll",
                    'data' => $wages,
                );
        }
        $tam = get_term(date('m'));
        ?>
        <?php echo theme_js('plugins.js'); ?>
        <?php echo theme_js('actions.js'); ?>
        <script>
                $(document).ready(function ()
                {
                    // PIE CHART
                    var chartData = <?php echo json_encode($pie); ?>;
                    pie = new AmCharts.AmPieChart();
                    pie.dataProvider = chartData;
                    pie.titles = [{"text": " Cashflow <?php echo ' - Term ' . $tam . ' ' . date('Y') . ' (' . $this->currency . ')'; ?> ", "size": 12, "color": "#4B990F", "alpha": 0, "bold": true}];
                    pie.titleField = "label";
                    pie.valueField = "data";
                    pie.labelsEnabled = false;
                    pie.autoMargins = false;
                    pie.marginTop = 0;
                    pie.marginBottom = 0;
                    pie.marginLeft = 0;
                    pie.marginRight = 0;
                    pie.pullOutRadius = 10;
                    pie.depth3D = 15;
                    pie.angle = 52;
                    pie.exportConfig = {
                        menuTop: '21px',
                        menuLeft: 'auto',
                        menuRight: '21px',
                        menuBottom: '0px',
                        menuItems: [{
                                textAlign: 'center',
                                onclick: function ()
                                {
                                },
                                icon: '<?php echo base_url('assets/export.png'); ?>',
                                iconTitle: 'Save chart as an image',
                                items: [{
                                        title: 'IMAGE',
                                        format: 'png'
                                    }, {
                                        title: 'PDF',
                                        format: 'pdf'
                                    }]
                            }],
                        menuItemStyle: {
                            backgroundColor: 'transparent',
                            rollOverBackgroundColor: '#EFEFEF',
                            color: '#000000',
                            rollOverColor: '#CC0000',
                            paddingTop: '6px',
                            paddingRight: '6px',
                            paddingBottom: '6px',
                            paddingLeft: '6px',
                            marginTop: '0px',
                            marginRight: '0px',
                            marginBottom: '0px',
                            marginLeft: '0px',
                            textAlign: 'left',
                            textDecoration: 'none'
                        }
                    };
                    // LEGEND
                    legend = new AmCharts.AmLegend();
                    legend.align = "center";
                    legend.markerType = "circle";
                    pie.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                    pie.addLegend(legend);
                    // WRITE
                    pie.write("money");
                });
                /*End Dashboard PIE*/
                var cld;
                cld = (function ($)
                {
                    "use strict";
                    var init, initCalendar;
                    init = function ()
                    {
                        initCalendar();
                    };
                    /* initialize the calendar*/
                    initCalendar = function ()
                    {
                        var d, date, m, y;
                        date = new Date();
                        d = date.getDate();
                        m = date.getMonth();
                        y = date.getFullYear();
                        $("#calendar").fullCalendar({
                            header: {
                                left: "prev,next today",
                                center: "title",
                                right: "month,agendaWeek,agendaDay"
                            },
                            events: <?php echo json_encode($event_data); ?>
                        });
                    };
                    /* Add a new elements to the "Draggable Events" list */
                    return {
                        init: init
                    };
                })(jQuery);
                cld.init();
        </script>	
    </body>
</html>
