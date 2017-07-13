<header id="header">
    <?php $settings = $this->ion_auth->settings(); ?>
    <div id="top-container">
        <div class="container">
            <ul class="conts">
                <li> <?php echo $settings->school; ?></li>
                <li> |</li>
                <li> <?php echo $settings->postal_addr; ?></li>
                <li> |</li>
                <li> <?php echo $settings->tel; ?></li>
                <li> |</li>
                <li> <?php echo $settings->cell; ?></li>
                <li> |</li>
                <li> <?php echo $settings->email; ?></li>
                <li> &nbsp;</li>
            </ul>
        </div>
    </div>
    <div id="inner-header">
        <div id="main-nav-container">
            <div class="container">
                <div class="row">

                    <div class="col-md-1 col-sm-1 col-xs-12 logo-container">
                        <h1 class="logo clearfix">
                            <span> </span>
                            <?php if (!empty($settings)):
                                    ?>
                                    <a href="<?php echo base_url('') ?>" ><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80"  height="60"  /></a>
                            <?php else: ?> 
                                    <a href="<?php echo base_url('') ?>" ><?php echo theme_image('logo.png', array('width' => "80", 'height' => "60")) ?></a>
                            <?php endif; ?>
                        </h1>
                    </div><!-- End .col-md-5 -->
                    <div class="col-md-11 col-sm-11 col-xs-12 logo-container">
                        <nav id="main-nav">
                            <div id="responsive-nav">
                                <div id="responsive-nav-button">
                                    Menu <span id="responsive-nav-button-icon"></span>
                                </div><!-- responsive-nav-button -->
                            </div>
                            <ul class="menu clearfix">
                                <li>  <a class="active" href="<?php echo base_url('account'); ?>">HOME</a> </li>
                                <?php
                                if ($this->ion_auth->logged_in())
                                {
                                        ?>
                                        <li><a href="<?php echo base_url('fee_payment/fee'); ?>">School Fees <i class="fa fa-angle-down"></i></a>
                                            <ul style="display: none;">
                                                <li><a href="<?php echo base_url('fee_payment/fee'); ?>">Fee Statement</a></li>
                                                <li><a href="<?php echo base_url('fee_structure/view'); ?>">Fee Structure</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="<?php echo base_url('exams/results'); ?>">Exams</a></li>
                                        <li><a href="#">Communication <i class="fa fa-angle-down"></i></a>
                                            <ul style="display: none;">
                                                <li><a href="<?php echo base_url('enquiry_meetings/meetings'); ?>">My Meetings</a></li>
                                                <li><a href="<?php echo base_url('enquiry_meetings/create'); ?>">Book Meeting</a></li>
                                                <li><a href="<?php echo base_url('my_sms'); ?>">My Messages</a></li>
                                                <li><a href="<?php echo base_url('feedbacks/add'); ?>">Feedback/Suggestion</a></li>
                                            </ul>
                                        </li>
                                <?php } ?>
                            </ul>
                        </nav>
                        <div class="sort-box pull-right clearfix" >
                            <?php
                            if ($this->ion_auth->logged_in())
                            {
                                    ?>
                                    <span class="separator"></span>
                                    <div class="btn-group select-dropdown"> 
                                        <button type="button" class="btn select-btn"><?php echo $this->user->first_name . ' ' . $this->user->last_name; ?></button>
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?php echo base_url('parent_profile'); ?>">Profile</a></li>
                                            <li><a href="<?php echo base_url('change_password'); ?>">Reset Password</a></li>
                                            <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>
                                        </ul>
                                    </div>
                            <?php } ?>
                        </div>
                        <div id="quick-access">
                        </div><!-- End #quick-access -->
                    </div><!-- End .col-md-12 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End #nav -->
    </div><!-- End #inner-header -->
</header>