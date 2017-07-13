<!DOCTYPE html>
<html lang="en">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <!--[if gt IE 8]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <![endif]-->        
        <title><?php echo $template['title']; ?></title>
        

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
         <?php echo core_css('global/plugins/font-awesome/css/font-awesome.min.css'); ?>        
         <?php echo core_css('global/plugins/bootstrap/css/bootstrap.min.css'); ?>         
        
        <?php echo core_css('global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>
        
        <?php echo core_css('global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>
        <!-- END GLOBAL MANDATORY STYLES -->        
        
         <!-- BEGIN PAGE LEVEL PLUGINS -->        
        <?php echo core_css('global/plugins/select2/css/select2.min.css'); ?>        
        <?php echo core_css('global/plugins/select2/css/select2-bootstrap.min.css'); ?>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        
        <?php echo core_css('global/css/components-md.min.css'); ?>       
        <?php echo core_css('global/css/plugins-md.min.css'); ?>
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        
        <?php echo theme_css('glosoft/login-4.min.css'); ?>
        <!-- END PAGE LEVEL STYLES -->
        <!--[if lt IE 10]>
            <link href="css/ie.css" rel="stylesheet" type="text/css" />
        <![endif]-->        
        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('favicon.ico'); ?>" /> 
          
    </head>
    <body class="login <?php echo $settings->theme_color . ' ' . $settings->background; ?>">
        <div class="header">
            <a href="#" class=" centralize"></a>
        </div>    
        <?php echo $template['body']; ?>
    </body>
    <!-- BEGIN CORE PLUGINS -->
    <?php echo core_js('global/plugins/jquery.min.js'); ?>       
    <?php echo core_js('global/plugins/bootstrap/js/bootstrap.min.js'); ?>       
    <?php echo core_js('global/plugins/js.cookie.min.js'); ?>        
    <?php echo core_js('global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>        
    <?php echo core_js('global/plugins/jquery.blockui.min.js'); ?>
        
    <?php echo core_js('global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <?php echo core_js('global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>        
    <?php echo core_js('global/plugins/jquery-validation/js/additional-methods.min.js'); ?>        
    <?php echo core_js('global/plugins/select2/js/select2.full.min.js'); ?>        
    <?php echo core_js('global/plugins/backstretch/jquery.backstretch.min.js'); ?>     
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->        
    <?php echo core_js('global/scripts/app.min.js'); ?>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <?php echo theme_js('glosoft/login-4.min.js'); ?>         
        <!-- END PAGE LEVEL SCRIPTS -->
</html>
