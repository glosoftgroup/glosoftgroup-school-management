<?php
$ct = count($this->parent->kids);
$bal = 0;
foreach ($this->parent->kids as $pp)
{
        $bal += $pp->balance;
}
?>  
<div class="category-item-container">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="item">
                <div class="item-meta-container">
                    <h3 class="item-name"><a href="#">Fee Balance <?php echo $this->currency; ?></a></h3>
                    <div class="infofmer">
                        <a href="<?php echo base_url('fee_payment/fee'); ?>">
                            <span class="title <?php echo $bal > 0 ? 'item-price-special' : ''; ?>">
                                <?php echo number_format($bal, 2); ?></span>
                            <span class="text"></span>
                        </a>
                    </div>  

                </div><!-- End .item-meta-container -->	
            </div><!-- End .item -->

        </div><!-- End .col-md-4 -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="item">
                <div class="item-meta-container">
                    <h3 class="item-name"><a href="#">Students  [ <span class=""><?php echo $ct; ?></span> ]</a></h3>
                    <div class="infofmer">
                        <a href="<?php echo base_url('reports/student_report'); ?>" class="btn btn-info">
                            <span class="">View Full Report</span>
                            <span class="text"></span>
                        </a>
                    </div>  

                </div><!-- End .item-meta-container -->	
            </div><!-- End .item -->

        </div><!-- End .col-md-4 -->

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="item">
                <div class="item-meta">
                    <ul class="list">
                        <li><strong>Email: </strong> <?php echo $this->parent->profile->email; ?></li>
                        <li><strong>Phone: </strong><?php echo $this->parent->profile->phone; ?></li>
                        <li> <strong>Address: </strong> <?php echo $this->parent->profile->address; ?></li>
                    </ul>

                </div> 
            </div><!-- End .item -->

        </div><!-- End .col-md-4 -->

    </div><!-- End .row -->
</div>

<div class="row">
    <div class="col-md-12">

        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6 service-box-container">
                <a class="" href="<?php echo base_url('fee_payment/fee'); ?>">
                    <div class="services-box">
                        <div class="service-icon service-glyphicon glyphicon-responsive"></div>  
                        <h3>
                            <a class="btn btn-custom" href="<?php echo base_url('fee_payment/fee'); ?>">School Fees</a>
                            <span class="small-bottom-border"></span>
                        </h3>
                        <p>View Your Fee Payment History </p>
                    </div><!-- End .services-box -->
                </a>
            </div><!-- End .col-md-3 -->
            <div class="col-md-3 col-sm-3 col-xs-6 service-box-container">
                <a class="" href="<?php echo base_url('fee_structure/view'); ?>">
                    <div class="services-box">
                        <div class="service-icon service-glyphicon glyphicon-responsive"></div>  
                        <h3>
                            <a class="btn btn-custom" href="<?php echo base_url('fee_structure/view'); ?>">Fees Structure</a>
                            <span class="small-bottom-border"></span>
                        </h3>
                        <p>View Your Fee Payment History </p>
                    </div><!-- End .services-box -->
                </a>
            </div><!-- End .col-md-3 -->
            <div class="col-md-3 col-sm-3 col-xs-6 service-box-container">
                <a class="" href="<?php echo base_url('exams/results/ '); ?>">
                    <div class="services-box">
                        <div class="service-icon service-glyphicon glyphicon-panel"></div>
                        <h3>
                            <a class="btn btn-custom" href="<?php echo base_url('exams/results/ '); ?>">Exams</a>
                            <span class="small-bottom-border"></span>
                        </h3>
                        <p>View Student Exam Results</p>
                    </div><!-- End .services-box -->
                </a>
            </div><!-- End .col-md-3 -->
            <div class="col-md-3 col-sm-3 col-xs-6 service-box-container">
                <a class="" href="<?php echo base_url('reports/student_report'); ?>">
                    <div class="services-box">
                        <div class="service-icon service-glyphicon glyphicon-sliders"></div>
                        <h3>
                            <a class="btn btn-custom" href="<?php echo base_url('reports/student_report'); ?>">Admission Report</a>
                            <span class="small-bottom-border"></span>
                        </h3>
                        <p>Student's Full Report</p>
                    </div><!-- End .services-box -->
                </a>
            </div><!-- End .col-md-3 -->
            <div class="col-md-3 col-sm-3 col-xs-6 service-box-container">
                <a class="" href="<?php echo base_url('profile'); ?>">
                    <div class="services-box">
                        <div class="service-icon service-glyphicon glyphicon-support"></div>
                        <h3>
                            <a class="btn btn-custom" href="<?php echo base_url('profile'); ?>">My Account</a>
                            <span class="small-bottom-border"></span>
                        </h3>
                        <p>Manage Your Online Account</p>
                    </div><!-- End .services-box -->
                </a>
            </div><!-- End .col-md-3 -->
            <div class="col-md-3 col-sm-3 col-xs-6 service-box-container">
                <a class="" href="<?php echo base_url('enquiry_meetings/create'); ?>">
                    <div class="services-box">
                        <div class="service-icon service-glyphicon glyphicon-support"></div>
                        <h3>
                            <a class="btn btn-custom" href="<?php echo base_url('enquiry_meetings/create'); ?>">Book Meeting</a>
                            <span class="small-bottom-border"></span>
                        </h3>
                        <p>Book Meeting with Staff/Teacher</p>
                    </div><!-- End .services-box -->
                </a>
            </div><!-- End .col-md-3 -->
            <div class="col-md-3 col-sm-3 col-xs-6 service-box-container">
                <a class="" href="<?php echo base_url('enquiry_meetings/meetings'); ?>">
                    <div class="services-box">
                        <div class="service-icon fa fa-calendar"></div>
                        <h3>
                            <a class="btn btn-custom" href="<?php echo base_url('enquiry_meetings/meetings'); ?>">My Meetings</a>
                            <span class="small-bottom-border"></span>
                        </h3>
                        <p>Your Previous Meetings</p>
                    </div><!-- End .services-box -->
                </a>
            </div><!-- End .col-md-3 -->
            <div class="col-md-3 col-sm-3 col-xs-6 service-box-container">
                <a class="" href="<?php echo base_url('my_sms'); ?>">
                    <div class="services-box">
                        <div class="service-icon fa fa-calendar"></div>
                        <h3>
                            <a class="btn btn-custom" href="<?php echo base_url('my_sms'); ?>">My Messages</a>
                            <span class="small-bottom-border"></span>
                        </h3>
                        <p>Messages in Your Inbox</p>
                    </div><!-- End .services-box -->
                </a>
            </div><!-- End .col-md-3 -->
        </div><!-- End .row -->

        <div class="lg-margin2x"></div><!-- space -->



        <div class="xlg-margin2x"></div><!-- space -->
    </div><!-- End .col-md-12 -->
</div>
