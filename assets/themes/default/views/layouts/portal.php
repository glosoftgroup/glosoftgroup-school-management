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
            <?php echo $template['partials']['header']; ?>
            <!-- End #header -->

            <section id="content">
                <div id="breadcrumb-container">
                    <div class="container">
                        <div class="col-md-8 col-sm-8">
                            <ul class="breadcrumb">
                                <li><?php echo anchor('/', 'Home'); ?></li>
                                <?php
                                if ($this->uri->segment(1))
                                {
                                    ?>
                                    <li><?php echo anchor($this->uri->segment(1), humanize($this->uri->segment(1))); ?></li>
                                <?php } ?> 
                                <li class="active"><?php echo $template['title']; ?></li>
                            </ul>

                        </div>
                        <div class="col-md-4 col-sm-4">  
                            <span class="pull-right" style="color: #FFF;">
                                <?php
                                if ($this->ion_auth->logged_in())
                                {
                                    $user = $this->ion_auth->get_user();
                                    ?>
                                    Welcome <?php echo $user->first_name . ' ' . $user->last_name; ?> |                                 
                                    <?php echo anchor('logout', 'Logout', 'style="color: #FFF;"'); ?> 
                                <?php } ?> 
                            </span>
                        </div>

                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="container dbody">
                    <div class="row">
                        <?php echo $template['partials']['sidebar']; ?>
                        <?php echo $template['body']; ?>
                    </div>
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
        <?php echo theme_js('main.js'); ?>
        <script>
            var BASE_URL = '<?php echo base_url(); ?>';
        </script>
    </body>
</html>