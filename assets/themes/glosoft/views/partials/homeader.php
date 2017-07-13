<header id="header">
     <div id="header-top">
          <div class="container">
               <div class="row">
                    <div class="col-md-12">
                         <div class="header-top-left">
                              <ul id="top-links" class="clearfix">
                                   <li><a href="<?php echo base_url('account') ?>" title="My Account"><span class="top-icon top-glyphicon glyphicon-user"></span><span class="hide-for-xs">My Account</span></a></li>
                              </ul>
                         </div><!-- End .header-top-left -->
                         <div class="header-top-right">

                              <div class="header-top-dropdowns pull-right">
                                   <!-- End .btn-group -->
                              </div><!-- End .header-top-dropdowns -->

                              <div class="header-text-container pull-right">
                                   <?php
                                   if ($this->ion_auth->logged_in())
                                   {
                                        $user = $this->ion_auth->get_user();
                                        ?>
                                        <p class="header-text">Welcome <?php echo $user->first_name . ' ' . $user->last_name; ?>!</p>
                                        <p class="header-link"><a href="<?php echo base_url('logout') ?>">Logout</a>&nbsp; </p>
                                        <?php
                                   }
                                   else
                                   {
                                        ?>
                                        <p class="header-text">&nbsp;</p>
                                        <?php /* <p class="header-link"><a href="<?php echo base_url('login') ?>">Login</a>&nbsp; </p> */ ?>
                                   <?php } ?>

                              </div><!-- End .pull-right -->
                         </div><!-- End .header-top-right -->
                    </div><!-- End .col-md-12 -->
               </div><!-- End .row -->
          </div><!-- End .container -->
     </div><!-- End #header-top -->

     <?php $settings = $this->ion_auth->settings(); ?>

     <div id="inner-header">
          <div class="container">
               <div class="row"> 
               </div><!-- End .row -->
          </div><!-- End .container -->

          <div id="main-nav-container">
               <div class="container">
                    <div class="row">
                         <div class="col-md-12 clearfix">

                              <nav id="main-nav">
                                   <div id="responsive-nav">
                                        <div id="responsive-nav-button">
                                             <span id="responsive-nav-button-icon"></span>
                                        </div><!-- responsive-nav-button -->
                                   </div> 
                              </nav>

                              <div id="quick-access">

                              </div><!-- End #quick-access -->
                         </div><!-- End .col-md-12 -->
                    </div><!-- End .row -->
               </div><!-- End .container -->

          </div><!-- End #nav -->
     </div><!-- End #inner-header -->
</header>
