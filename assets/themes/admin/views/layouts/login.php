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
        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('favicon.ico'); ?>" />

    </head>
    <body class="login-container <?php echo $settings->theme_color . ' ' . $settings->background; ?>">
        <div class="header">
            <a href="#" class=" centralize"></a>
        </div>
        <?php echo $template['body']; ?>
    </body>
    <!-- Core JS files -->
    <?php echo core_js('core/js/plugins/loaders/pace.min.js'); ?>
    <?php echo core_js('core/js/core/libraries/jquery.min.js'); ?>
    <?php echo core_js('core/js/core/libraries/bootstrap.min.js'); ?>
    <?php echo core_js('core/js/plugins/loaders/blockui.min.js'); ?>
  	<!-- /core JS files -->
    <!-- Theme JS files -->
    <?php echo core_js('core/js/core/app.js'); ?>
    <?php echo core_js('core/js/plugins/ui/ripple.min.js'); ?>
  	<!-- /theme JS files -->

</html>
