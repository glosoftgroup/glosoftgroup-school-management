<!DOCTYPE html>
<!--[if IE 8]> <html class="ie8"> <![endif]-->
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title><?php echo $template['title']; ?></title>
        <?php echo $template['partials']['meta']; ?>
    </head>
    <body>

        <div id="wrapper">
          
            <!-- End #header -->
            
            <section id="content">
                <div id="breadcrumb-container">
                    <div class="container">
                      
                    </div>
                </div>
                <div class="container">
                    <?php echo $template['body']; ?>
                </div><!-- End .container -->

            </section><!-- End #content -->
            <?php echo $template['partials']['footer']; ?>
            <!-- End #footer -->
        </div><!-- End #wrapper -->
        <a href="#" id="scroll-top" title="Scroll to Top"><i class="fa fa-angle-up"></i></a><!-- End #scroll-top -->
        <!-- END -->
        <?php echo theme_js('bootstrap.min.js'); ?>
        <?php echo theme_js('smoothscroll.js'); ?>
        <?php echo theme_js('retina-1.1.0.min.js'); ?>
        <?php echo theme_js('jquery.placeholder.js'); ?>
        <?php echo theme_js('jquery.hoverIntent.min.js'); ?>
        <?php echo theme_js('jquery.flexslider-min.js'); ?>
        <?php echo theme_js('owl.carousel.min.js'); ?>
        <?php echo theme_js('select2/select2.min.js'); ?>
        <!-- Message attempt -->
        <?php echo theme_js('tok-custom.js'); ?>
        <?php echo theme_js('talk/jquery.nicescroll.min.js'); ?>
        <?php echo theme_js('talk/jquery.uploadify.min.js'); ?>
        <?php echo theme_js('talk/jquery.messages.js'); ?>
        <!-- Message attempt -->

        <?php echo theme_js('main.js'); ?>

    </body>
</html>
