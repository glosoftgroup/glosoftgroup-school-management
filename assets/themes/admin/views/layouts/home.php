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
          <!-- body content here -->
          <!-- student -->
          <div class="col-lg-2 text-center">
              <?php if ($this->acl->is_allowed(array('admission', 'create'), 1)) { ?>
                <a href="<?php echo base_url('admin/admission/create'); ?>">

                <div class="panel bg-pink-400">
                  <div class="panel-body">

                    <h1 class="no-margin">
                      <i class='icon-user'></i>
                    </h1>
                    New Student
                  </div>
                </div>
              <?php } ?>
						  </div>
              <!-- /student -->
              <!-- fee payment -->
              <div class="col-lg-2 text-center">
                  <?php if ($this->acl->is_allowed(array('fee_payment', 'create'), 1)) { ?>
                    <a href="<?php echo base_url('admin/fee_payment/create'); ?>">

                    <div class="panel bg-indigo-400">
                      <div class="panel-body">

                        <h1 class="no-margin">
                          <i class='icon-database'></i>
                        </h1>
                      New Payment
                      </div>
                    </div>
                  <?php } ?>
    						  </div>
                  <!-- /fee payment -->
                  <!-- classes -->
                  <div class="col-lg-2 text-center">

                        <a href="<?php echo base_url('admin/class_groups/classes'); ?>">
                        <div class="panel  bg-blue-400">
                          <div class="panel-body">

                            <h1 class="no-margin">
                              <i class='icon-list-numbered'></i>
                            </h1>
                          Classes
                          </div>
                        </div>
        						  </div>
                      <!-- /classes -->
              <!-- send sms -->
              <div class="col-lg-2 text-center">
                    <a href="<?php echo base_url('admin/sms/create'); ?>">
                    <div class="panel panel-default">
                      <div class="panel-body">

                        <h1 class="no-margin">
                          <i class='icon-comment-discussion'></i>
                        </h1>
                      Send SMS
                      </div>
                    </div>
    						  </div>
                  <!-- /send sms -->
                <!-- payroll -->
                <div class="col-lg-2 text-center">
                    <?php if ($this->acl->is_allowed(array('record_salaries'), 1)) { ?>
                      <a href="<?php echo base_url('admin/record_salaries/'); ?>">

                      <div class="panel bg-pink-400">
                        <div class="panel-body">

                          <h1 class="no-margin">
                            <i class='icon-cash'></i>
                          </h1>
                          Payroll
                        </div>
                      </div>
                    <?php } ?>
      						  </div>
                    <!-- /payroll -->
                    <!-- Expenses -->
                    <div class="col-lg-2 text-center">
                        <?php if ($this->acl->is_allowed(array('expenses'), 1)) { ?>
                          <a href="<?php echo base_url('admin/expenses/'); ?>">

                          <div class="panel bg-dark-400">
                            <div class="panel-body">

                              <h1 class="no-margin">
                                <i class=' icon-file-tex'></i>
                              </h1>
                              Expenses
                            </div>
                          </div>
                        <?php } ?>
          						  </div>
                        <!-- /expenses -->
                        <!-- rollcall -->
                        <div class="col-lg-2 text-center">
                              <a href="<?php echo base_url('admin/class_attendance'); ?>">
                              <div class="panel panel-default">
                                <div class="panel-body">

                                  <h1 class="no-margin">
                                    <i class='icon-file-spreadsheet2'></i>
                                  </h1>
                                 RollCall
                                </div>
                              </div>
              						  </div>
                            <!-- /roll call -->
                            <!-- rollcall -->
                            <div class="col-lg-2 text-center">
                                <a href="<?php echo base_url('admin/exams'); ?>">
                                <div class="panel panel-default">
                                  <div class="panel-body">

                                    <h1 class="no-margin">
                                      <i class='icon-copy4'></i>
                                    </h1>
                                   Exam
                                  </div>
                                </div>
                						  </div>
                              <!-- /send sms -->

          <!-- ./body content -->
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
    </body>
</html>
