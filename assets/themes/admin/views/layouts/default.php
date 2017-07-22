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
        <?=core_css("core/css/extras/animate.min.css");?>
        <style>.error { color:red; }</style>
	      <!-- /global stylesheets -->
        <!--[if lt IE 10]>
            <link href="css/ie.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        <script> var BASE_URL = '<?php echo base_url(); ?>';</script>
        <!-- Core JS files -->
        <!-- Core JS files -->
        <?php echo core_js('core/js/plugins/loaders/pace.min.js'); ?>
        <?php echo core_js('core/js/core/libraries/jquery.min.js'); ?>
	      <?php echo theme_js('plugins/jquery/jquery-migrate-1.1.1.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-ui-1.10.1.custom.min.js'); ?>
        <?php echo core_js('core/js/core/libraries/bootstrap.min.js'); ?>
        <?php echo core_js('core/js/plugins/loaders/blockui.min.js'); ?>

      	<!-- /core JS files -->
        <!-- Theme JS files -->
        <?php echo core_js('core/js/plugins/ui/nicescroll.min.js'); ?>
        <?php echo core_js('core/js/core/app.js'); ?>
        <?php echo core_js('core/js/plugins/forms/selects/select2.min.js'); ?>
        <?php echo core_js('core/js/pages/layout_fixed_custom.js'); ?>
        <?php echo core_js('core/js/plugins/ui/ripple.min.js'); ?>
      	<!-- /theme JS files -->
        <!-- datatables -->
        <?php echo core_js('core/js/plugins/tables/datatables/datatables.min.js'); ?>
        <?php echo core_js('core/js/pages/datatables_advanced.js'); ?>
        <!-- ./datatables -->

        <!-- theme scripts -->
        <?php echo core_js('core/js/plugins/pickers/pickadate/picker.js'); ?>

        <?php echo core_js('core/js/plugins/pickers/pickadate/picker.date.js'); ?>

        <?php echo core_js('core/js/plugins/pickers/pickadate/picker.time.js'); ?>
        <!-- Updated stylesheet url -->
        <?=core_js("core/js/core/libraries/jquery_ui/widgets.min.js");?>
        <?=core_js("core/js/pages/animations_css3.js");?>

        <!-- ./theme scripts -->

        <!-- old files -->

       <!-- echo theme_css('sett.css'); ?> -->
        <?php echo theme_css('jquery.dataTables.css'); ?>
        <?php echo theme_css('tableTools.css'); ?>
        <?php echo theme_css('dataTables.colVis.min.css'); ?>


          <!-- echo theme_css('select2/select2.css'); -->
        <link href="<?php echo js_path('plugins/jeditable/bootstrap-editable.css'); ?>" rel="stylesheet">

        <script> var BASE_URL = '<?php echo base_url(); ?>';</script>
        <?php echo theme_js('plugins/jquery/globalize.js'); ?>
        <?php echo theme_js('plugins/other/excanvas.js'); ?>
        <script type="text/javascript" src="<?php echo plugin_path('boxer/jquery.fs.boxer.js'); ?>"></script>
        <?php echo theme_js('plugins/switch/js/switch.js'); ?>
        <?php echo theme_js('plugins/other/jquery.mousewheel.min.js'); ?>

        <?php echo theme_js('plugins/cookies/jquery.cookies.2.2.0.min.js'); ?>
        <?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>
        <?php echo theme_js('plugins/fullcalendar/fullcalendar.min.js'); ?>
        <!-- limit calender -->
       <?php echo core_js('core/js/plugins/ui/moment/moment.min.js'); ?>
       <?php echo core_js('core/js/plugins/ui/fullcalendar/fullcalendar.min.js'); ?>
       <?php echo core_js('core/js/plugins/visualization/echarts/echarts.js'); ?>
        <!-- ./limit  calendar -->
        <?php echo theme_js('plugins/datatables/media/js/jquery.dataTables.min.js'); ?>
        <?php echo theme_js('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>
        <?php echo theme_js('plugins/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>
        <?php echo theme_js('jquery.dataTables.delay.min.js'); ?>
        <?php echo theme_js('amct/amcharts.js'); ?>
        <?php echo theme_js('amct/pie.js'); ?>
        <?php echo theme_js('amct/serial.js'); ?>
        <?php echo theme_js('amct/exporting/amexport.js'); ?>
        <?php echo theme_js('amct/exporting/rgbcolor.js'); ?>
        <?php echo theme_js('amct/exporting/canvg.js'); ?>
        <?php echo theme_js('amct/exporting/jspdf.js'); ?>
        <?php echo theme_js('amct/exporting/filesaver.js'); ?>
        <?php echo theme_js('amct/exporting/jspdf.plugin.addimage.js'); ?>

        <?php echo theme_js('plugins/underscore/underscore-min.js'); ?>
        <?php echo theme_js('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>
        <?php echo theme_js('plugins/uniform/jquery.uniform.min.js'); ?>
        
        <?php echo theme_js('plugins/maskedinput/jquery.maskedinput-1.3.min.js'); ?>
        <?php echo theme_js('plugins/multiselect/jquery.multi-select.min.js'); ?>

        <?php echo theme_js('plugins/validationEngine/languages/jquery.validationEngine-en.js'); ?>
        <?php echo theme_js('plugins/validationEngine/jquery.validationEngine.js'); ?>
        <?php echo theme_js('plugins/stepywizard/jquery.stepy.js'); ?>

        <?php echo theme_js('plugins/scrollup/jquery.scrollUp.min.js'); ?>
        
        <?=core_js('core/js/pages/form_inputs.js');?>
        <?php echo theme_js('ajaxfileupload.js'); ?>
        <script src="<?php echo plugin_path('bootstrap.daterangepicker/moment.js'); ?>" ></script>
        <script src="<?php echo plugin_path('bootstrap.daterangepicker/daterangepicker.js'); ?>" ></script>
        <script src="<?php echo plugin_path('bootstrap.datetimepicker/bootstrap-datetimepicker.min.js'); ?>"></script>	<link rel="shortcut icon" type="image/ico" href="<?php echo image_path('favicon.ico'); ?>" />
        
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
                <?php 
                if (!preg_match('/^(admin\/leaving_certificate)/i', $this->uri->uri_string())){
                ?>
                <!-- breadcrumb -->
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

                      </li>
						</ul>
					</div>
                    <!-- end breadcrumbs -->
                    <?php } ?>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
          <div>
            <!-- alerts -->
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

          <!-- ./alerts -->
          </div>
          <div class="row">
          <?php echo $template['body']; ?>
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
    <?php echo core_js('core/js/plugins/forms/selects/bootstrap_multiselect.js'); ?>
    <script>
     // Default initialization
     $('.select').select2({
         minimumResultsForSearch: Infinity
     });
     $('.multiselect').multiselect({
        onChange: function() {
            $.uniform.update();
        }
    });
    $(".datepicker").datepicker({
      format: "dd MM yyyy",
     
    });
    </script>
    <?=core_js("core/js/plugins/editors/wysihtml5/wysihtml5.min.js");?>
    <?=core_js("core/js/plugins/editors/wysihtml5/toolbar.js");?>
    <?=core_js("core/js/plugins/editors/wysihtml5/parsers.js");?>

    <?=core_js("core/js/plugins/editors/wysihtml5/locales/bootstrap-wysihtml5.ua-UA.js");?>
   <?=core_js("core/js/pages/editor_wysihtml5.js");?> 
   <!-- wysihtml5 wysihtml5-min  -->

     <script type="text/javascript">var sub=1;  var flist = '<?php echo $this->list_size; ?>';</script>
        <?php echo theme_js('plugins/animatedprogressbar/animated_progressbar.js'); ?>
        <?php echo theme_js('plugins/hoverintent/jquery.hoverIntent.minified.js'); ?>
    <?php echo theme_js('plugins/cleditor/jquery.cleditor.js'); ?>
    <?php echo theme_js('actions.js'); ?>
    <?php echo core_js('core/js/plugins.js'); ?>
    <?php echo theme_js('ng/lib-ng.js'); ?> 
        <?php echo theme_js('ng/ngsc.js'); ?>
    <style>
    .uppercase {
    font-family: sans-serif;
    line-height: 250%;
    word-spacing: 3px;
    font-size: 1.3em;
}

</style>


    </body>
</html>
