<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <!--[if gt IE 8]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <![endif]-->
        <title><?php echo $template['title']; ?></title>

        <!-- Global stylesheets -->
	      <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <?php echo core_css('core/css/icons/icomoon/styles.css'); ?>
        <?php echo core_css('core/css/bootstrap.css'); ?>
        <?php echo core_css('core/css/core.css'); ?>
        <?php echo core_css('core/css/components.css'); ?>
        <?php echo core_css('core/css/colors.css'); ?>
	      <!-- /global stylesheets -->
        <!--[if lt IE 10]>
            <link href="css/ie.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        <script> var BASE_URL = '<?php echo base_url(); ?>';</script>
        <!-- Core JS files -->
        <!-- Core JS files -->
        <?php echo core_js('core/js/plugins/loaders/pace.min.js'); ?>
        <?php echo core_js('core/js/core/libraries/jquery.min.js'); ?>
        <?php echo core_js('core/js/core/libraries/bootstrap.min.js'); ?>
        <?php echo core_js('core/js/plugins/loaders/blockui.min.js'); ?>
      	<!-- /core JS files -->
        <!-- Theme JS files -->
        <?php echo core_js('core/js/plugins/ui/nicescroll.min.js'); ?>
        <?php echo core_js('core/js/core/app.js'); ?>
        <?php echo core_js('core/js/pages/layout_fixed_custom.js'); ?>
        <?php echo core_js('core/js/plugins/ui/ripple.min.js'); ?>
      	<!-- /theme JS files -->
        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('favicon.ico'); ?>" />
    </head>
    <?php
    $ccls = 'ssRed';
    if ($this->ion_auth->is_in_group($this->user->id, 3))
    {
            $ccls = 'ssGreen';
    }
    ?>
    <body class="navbar-top " >
        <?php echo $template['partials']['top']; ?>
        <!-- Page container -->
      	<div class="page-container">

      		<!-- Page content -->
      		<div class="page-content">
         <?php echo $template['partials'][$this->side]; ?>
         <!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li>
                <i class="icon-home2 position-left"></i>
                <?php echo anchor('/', 'Home'); ?>
              </li>
              <?php  if ($this->uri->segment(2)) { ?>
              <li>
                <?php echo anchor('admin/' . $this->uri->segment(2), humanize($this->uri->segment(2))); ?>
               </li>
              <?php } ?>
							<li class="active"><?php echo $template['title']; ?></li>
						</ul>

						<ul class="breadcrumb-elements">
              <li>
                <?php
                              $user = $this->ion_auth->get_user();
                              $gp = $this->ion_auth->get_users_groups($user->id)->row();
                              ?><small>&nbsp;</small>
                              <span class="label label-success"  ><?php echo ucwords($gp->name); ?></span>
                              </span>
                      </li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
          <div class="row">
          <!-- quicklinks -->
          <?php echo $template['partials']['quick_links']; ?>
          <!-- ./quicklinks -->
          </div>
          <div class="row">
            <!-- reports -->
            <div class="col-md-8">
              <?php echo $template['partials']['alerts']; ?>
              <!-- ds -->
              <?php if ($this->acl->is_allowed(array('admission', 'create'), 1))  {?>
                            <div class="panel panel-primary">
                              <div class="panel-heading">
                                  <h5 class="panel-title">
                                    <i class="icon-stats-bars3 position-left"></i>
                                    Recently Registered Students
                                  </h5>
                                  <div class="heading-elements">
                                    <ul class="icons-list">
                                      <li><a href="<?php echo base_url('admin/admission/create/'); ?>"><span class="icon-user-plus"></span></a></li>
                                      <li><a href="<?php echo base_url('admin/admission/'); ?>"><span class="icon-cogs"></span></a></li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="panelbody">
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
                    if ($this->acl->is_allowed(array('fee_payment', 'create'), 1)){?>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                 <h5 class="panel-title">
                                   <i class="icon-calendar position-left"></i>
                                   Recent Fee Payments
                                 </h5>
                                 <div class="heading-elements">
                                   <ul class="icons-list">
                                     <li><a data-action="collapse"></a></li>
                                     <li><a data-action="reload"></a></li>
                                     <li><a data-action="close"></a></li>
                                   </ul>
                                 </div>
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
                                            <?php if(empty($recent_payments)){ ?>
                                            <tr>
                                              <td colspan="6" class='text-center text-bold text-mute'>No results found</td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="toolbar-fluid">
                                    <div class="btn-group">
                                        <div class="col-md-3">
                                            <div class="btn legitRipple">
                                                <div class="title"><?php
                                                    if (empty($total_fees->total))
                                                            echo '0.00';
                                                    else
                                                            echo number_format($total_fees->total, 2);
                                                    ?></div>
                                                <div class="description">Total Paid Fees (<?php echo $this->currency; ?>)</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="btn legitRipple">
                                                <div class="title"><?php
                                                    $t = $total_petty_cash->total + $wages + $total_expenses->total;
                                                    echo number_format($t, 2);
                                                    ?></div>
                                                <div class="description">Total Expenses (<?php echo $this->currency; ?>)</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="btn legitRipple">
                                                <div class="title"><?php
                                                    if (empty($total_waiver->total))
                                                            echo '0.00';
                                                    else
                                                            echo number_format($total_waiver->total, 2);
                                                    ?> </div>
                                                <div class="description">Total Fee Waivers (<?php echo $this->currency; ?>)</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="btn legitRipple">
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

              <!-- ./ds -->
            </div>
            <!-- ./reports -->
            <!-- sidebar -->
            <div class="col-md-4">
              <!-- sd -->
              <?php
                    if ($this->acl->is_allowed(array('fee_payment', 'create'), 1))
                    {
                            ?>
                            <div class="panel panel-primary">
								<div class="panel-heading">
								  <h5 class="panel-title">
									<i class="icon-tag position-left"></i>
									Cashflow Summary
								  </h5>
								  <div class="heading-elements">
									<ul class="icons-list">
									  <li><a data-action="collapse"></a></li>
									  <li><a data-action="reload"></a></li>
									  <li><a data-action="close"></a></li>
									</ul>
								  </div>
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
                            <div class="panel panel-primary">
								<div class="panel-heading">
								  <h5 class="panel-title">
									<i class="icon-users2 position-left"></i>
									Online Users
								  </h5>
								  <div class="heading-elements">
									<ul class="icons-list">
									  <li><a data-action="collapse"></a></li>
									  <li><a data-action="reload"></a></li>
									  <li><a data-action="close"></a></li>
									</ul>
								  </div>
								</div>
                                <div class="block-fluid ">
                                  <div class="scroll" style="height: 200px;">
                                  <ul class="media-list media-list-linked">
                                  <?php
                                  foreach ($users as $u)
                                  {
                                      $user = $this->ion_auth->get_user($u->user_id);
                                      ?>
                                      <li class="media media-link">
                                        <div class="media-left">
                                          <?php echo theme_image('examples/users/avatar.png', array('class' => "img-circle")); ?>
                                        </div>
                                        <div class="media-body">
                                          <div class="media-heading text-semibold"><?php echo $user->first_name . ' ' . $user->last_name; ?></div>
                                          <span class="text-muted"> <?php echo $user->email; ?></span>
                                        </div>
                                        <div class="media-right media-middle">
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
                                      </li>
                                  <?php } ?>
                                  </ul>
                                  </div>
                                    <div class="panel-footer panel-footer-condensed bg-primary">
                                        <div class="left">
                                            <div class="text-center">
                                                <span class="text-white" >Total Online Users (<b class='label label-success'><?php echo count($users); ?></b>)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php } ?>
              <!-- ./sd -->

            </div>
            <!-- ./sidebar -->
            <!-- calendar -->
            <div class="col-md-12">
              <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h5 class="panel-title">
                          <i class="icon-calendar position-left"></i>
                          Calendar of Events
                          </h5>
                        <div class="heading-elements">
                          <ul class="icons-list">
                            <li><a href="<?php echo base_url('admin/school_events/create/'); ?>"><span class="icon-plus-circle2"></span></a></li>
                            <li><a href="<?php echo base_url('admin/school_events/'); ?>"><span class="icon-cogs"></span></a></li>
                          </ul>
                        </div>
                      </div>
                        <div class="panel-body">
                            <div class="schedule"></div>
                        </div>
                    </div>
            </div>
            <!-- ./calendar -->
          </div>

				</div>
				<!-- /content area -->
        <!-- Footer -->
        <div class="footer text-muted">
          &copy; <?=date('Y');?>. <a href="#">Glosoft Group</a>
        </div>
        <!-- /footer -->

			</div>
			<!-- /main content -->
       </div>
     <!-- /page content -->
    </div>
    <!-- /page container -->
    <!-- scripts -->

    <?php echo core_js('core/js/plugins/ui/moment/moment.min.js'); ?>
    <?php echo core_js('core/js/plugins/ui/fullcalendar/fullcalendar.min.js'); ?>
    <?php echo core_js('core/js/plugins/visualization/echarts/echarts.js'); ?>

    <!--  //echo core_js('core/js/pages/timelines.js'); -->

    <?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>
    <?php echo theme_js('amct/amcharts.js'); ?>
        <?php echo theme_js('amct/pie.js'); ?>
        <?php echo theme_js('amct/serial.js'); ?>
        <?php echo theme_js('amct/exporting/amexport.js'); ?>
        <?php echo theme_js('amct/exporting/rgbcolor.js'); ?>
        <?php echo theme_js('amct/exporting/canvg.js'); ?>
        <?php echo theme_js('amct/exporting/jspdf.js'); ?>
        <?php echo theme_js('amct/exporting/filesaver.js'); ?>
        <?php echo theme_js('amct/exporting/jspdf.plugin.addimage.js'); ?>



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
                        $(".schedule").fullCalendar({
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
