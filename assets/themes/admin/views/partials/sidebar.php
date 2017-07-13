<div class="navigation hidden-print">
    <ul class="main" >
        <li><a 
            <?php
            if (
                         preg_match('/^(admin)$/i', $this->uri->uri_string())
            )
                    echo 'class="active"';
            ?> href="<?php echo base_url('admin'); ?>" class="<?php if (preg_match('/^(admin)$/i', $this->uri->uri_string())) echo 'active'; ?>">
                <span class="icom-screen"></span><span class="text">Dashboard</span></a></li>
        <li>
            <a href="#ui" 
            <?php
            if (
                         preg_match('/^(admin\/class_groups\/classes)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_stream)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/subjects)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/grading)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_rooms)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/grades)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/grading_system)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/exams_management)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/exams)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_attendance)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_groups\/classes)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/sub_cats)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/school_events)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/assignments)/i', $this->uri->uri_string()))
                    echo 'class="active"';
            ?>>
                <span class="icom-bookmark"></span><span class="text">Academics</span></a></li>
        <li >
            <a href="#forms"
            <?php
            if (
                         preg_match('/^(admin\/admission)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/leaving_certificate)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/house)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/suspended)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/enquiries)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/feedbacks)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/hostels)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/extra_curricular)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/students_placement)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/disciplinary)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/assign_bed)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/medical_records)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/enquiry_meetings)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/hostel_rooms)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/transport)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/hostel_beds)/i', $this->uri->uri_string())
            )
                    echo 'class="active"';
            ?>>
                <span class="icom-pencil3"></span><span class="text">Administration</span></a>
        </li>
        <li><a href="#accounts"
            <?php
            if (
                         preg_match('/^(admin\/fee_structure)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/fee_arrears)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/fee_payment)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/fee_statement)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/expenses_category)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/expense_items)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/expenses)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/purchase_order)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/fee_pledge)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/sales_items)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/sales_items_category)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/record_sales)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/sales_items_stock)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/deductions)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/tax_config)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/bank_accounts)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/allowances)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/paye)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/salaries)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/invoices)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/accounts)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/accounting)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/petty_cash)/i', $this->uri->uri_string())
            )
            {
                    echo 'class="active"';
            }
            ?>><span class = "icom-database"></span><span class = "text">Accounts</span></a>
        </li>
        <li><a href="#media"
               class="  <?php
               if (preg_match('/^(admin\/emails)/i', $this->uri->uri_string()) ||
                            (preg_match('/^(admin\/meetings)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/address_book_category)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/address_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/email_templates)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/sms_templates)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/sms)/i', $this->uri->uri_string()))
               )
                       echo 'active';
               ?>">
                <span class="icom-videos"></span><span class="text">Communication</span></a>
        </li> 
        <li><a href="#inventory"
            <?php
            if (
                         preg_match('/^(admin\/inventory)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/add_stock)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/items)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/items_category)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/give_items)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/stock_taking)/i', $this->uri->uri_string())
            )
            {
                    echo 'class="active"';
            }
            ?>><span class = "icom-list"></span><span class = "text">Inventory</span></a>
        </li>
        <li><a href="#lib"
               class="  <?php
               if (preg_match('/^(admin\/book_category)/i', $this->uri->uri_string()) ||
                            (preg_match('/^(admin\/books)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/add_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/borrow_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/return_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/renew_book)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/book_fund)/i', $this->uri->uri_string())) ||
                            (preg_match('/^(admin\/library_settings)/i', $this->uri->uri_string()))
               )
                       echo 'active';
               ?>">
                <span class="lib"><img src="<?php echo base_url('assets/themes/admin/img/read.png'); ?>" /></span><span class="text">Library</span></a>
        </li>
        <li><a href="#reports"
            <?php
            if (preg_match('/^(admin\/reports)/i', $this->uri->uri_string()))
            {
                    echo 'class="active"';
            }
            ?>><span class = "icom-stats-up"></span><span class = "text">Reports</span></a>
        </li>
        <li><a 
                class=" <?php
                if (
                             preg_match('/^(admin\/users)/i', $this->uri->uri_string()) ||
                             preg_match('/^(admin\/change_password)/i', $this->uri->uri_string()) ||
                             preg_match('/^(admin\/parents)/i', $this->uri->uri_string()) ||
                             preg_match('/^(admin\/teachers)/i', $this->uri->uri_string()) ||
                             preg_match('/^(admin\/employees_attendance)/i', $this->uri->uri_string()) ||
                             preg_match('/^(admin\/sandbox)/i', $this->uri->uri_string()) ||
                             preg_match('/^(admin\/groups)/i', $this->uri->uri_string())
                )
                        echo 'active';
                ?>"
                href="#users"><span class="icom-user"></span><span class="text">Users</span></a>
        </li>
        <li><a  class = " <?php
            if (preg_match('/^(admin\/settings)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/class_groups)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/permissions)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/license)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/uploads)/i', $this->uri->uri_string()) ||
                         preg_match('/^(admin\/setup)/i', $this->uri->uri_string()))
                    echo 'active';
            ?>" href="#other"><span class="icom-cog"></span><span class="text">Settings</span></a>
        </li>
    </ul>
    <div class="control"></div>        
    <div class="submain">
        <div id="default">
            <div class="widget-fluid userInfo clearfix">
                <div class="image" >
                    <img style="padding:1px;"src="<?php echo base_url('assets/themes/admin/img/member.png'); ?>" width="60" height="60" />
                </div>              
                <div class="name"><?php
                    $user = $this->ion_auth->get_user();
                    echo trim($user->first_name . ' ' . $user->last_name);
                    ?> </div>
                <ul class="menuList">
                    <li><a href="<?php echo base_url('admin/settings'); ?>"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                    <li><a href="<?php echo base_url('admin/sms'); ?>"><span class="glyphicon glyphicon-comment"></span> Messaging</a></li>
                    <li><a href="<?php echo base_url('admin/help'); ?>" target="_blank"><span class="glyphicon glyphicon-question-sign"></span> Help</a></li>
                    <li><a href="<?php echo base_url('admin/logout'); ?>"><span class="glyphicon glyphicon-share-alt"></span> Logout</a></li>                        
                </ul>
                <div class="text">
                    Welcome back! <?php echo $this->ion_auth->get_user()->last_login ? 'Your last visit: ' . date('d M Y H:i', $this->ion_auth->get_user()->last_login) : ''; ?>
                </div>
            </div>
            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <li>
                    <a href="<?php echo base_url('admin/admission'); ?>">Total Students </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_students();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/teachers'); ?>">All Teachers</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_teachers();
                        echo $count;
                        ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/parents'); ?>">Registered Parents</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_parents();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/users'); ?>">Administration Staff</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_administration();
                        echo $count;
                        ?></span>
                </li>                
                <li>
                    <a href="<?php echo base_url('admin/class_groups/classes'); ?>" >All Classes</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_classes();
                        echo $count;
                        ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/subjects'); ?>">All Subjects</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_subjects();
                        echo $count;
                        ?></span>
                </li>	
                <li>
                    <a href="<?php echo base_url('admin/class_rooms'); ?>">All Class Rooms </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_class_rooms();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/admission'); ?>">All Events </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_events();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/meetings'); ?>">All Meetings </a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_meetings(); ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/emails'); ?>">All Emails</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_emails(); ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/sms'); ?>">All SMS'</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_sms(); ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/admission'); ?>">All Registered Users </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_users();
                        echo $count;
                        ?></span>
                </li>
            </ul>
            <div class="dr"><span></span></div>
        </div>
        <div id="ui">                
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/class_stream)/i', $this->uri->uri_string()) || preg_match('/^(admin\/class_groups\/classes)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_groups/classes'); ?>"><span class="glyphicon glyphicon-home"></span>All Classes</a>
                <a  <?php if (preg_match('/^(admin\/class_rooms)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_rooms'); ?>"><span class="glyphicon glyphicon-list"></span> Class Rooms</a>
                <a  <?php if (preg_match('/^(admin\/subjects)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/subjects'); ?>"><span class="glyphicon glyphicon-list-alt "></span> Subjects</a>
                <a  <?php if (preg_match('/^(admin\/grading)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/grading\/view)/i', $this->uri->uri_string()) || preg_match('/^(admin\/grades)/i', $this->uri->uri_string()) || preg_match('/^(admin\/grading\/edit)/i', $this->uri->uri_string()) || preg_match('/^(admin\/grading\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/grading'); ?>"><span class="glyphicon glyphicon-list "></span> Grading</a>
                <a  <?php if (preg_match('/^(admin\/grading_system)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/grading_system'); ?>"><span class="glyphicon glyphicon-list-alt "></span> Grading System</a>
                <a  <?php if (preg_match('/^(admin\/exams)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/exams'); ?>"><span class="glyphicon glyphicon-list "></span> Exams</a>
                <a  <?php if (preg_match('/^(admin\/class_attendance)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_attendance'); ?>"><span class="glyphicon glyphicon-check "></span> Class Attendance</a>
                <a  <?php if (preg_match('/^(admin\/assignments)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/assignments'); ?>"><span class="glyphicon glyphicon-file "></span> Assignments</a>
                <a  <?php if (preg_match('/^(admin\/school_events)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/school_events'); ?>"><span class="glyphicon glyphicon-calendar "></span> School Events</a>
                <a  <?php if (preg_match('/^(admin\/school_events\/calendar)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/school_events/calendar'); ?>"><span class="glyphicon glyphicon-calendar "></span> Full Calendar</a>
            </div>    
            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <li>
                    <a href="<?php echo base_url('admin/admission'); ?>">All Registered Students </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_students();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/class_groups/classes'); ?>" >All Classes</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_classes();
                        echo $count;
                        ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/subjects'); ?>">All Subjects</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_subjects();
                        echo $count;
                        ?></span>
                </li>
            </ul>
        </div>            
        <!--******************************ADMINISTRATION MENU******************************************-->	
        <div id="forms">                                                
            <div class="menu">
                <a  
                <?php if (preg_match('/^(admin\/admission)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                <?php if (preg_match('/^(admin\/admission\/edit)/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                <?php if (preg_match('/^(admin\/admission\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                <?php if (preg_match('/^(admin\/admission\/student)/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                <?php if (preg_match('/^(admin\/admission\/inactive)/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                <?php if (preg_match('/^(admin\/admission\/view)/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                    href="<?php echo base_url('admin/admission'); ?>"><span class="glyphicon glyphicon-file"></span> Students Admission</a>
                <a  <?php if (preg_match('/^(admin\/admission\/alumni)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/admission/alumni'); ?>"><span class="glyphicon glyphicon-list"></span> Alumni Students</a>
                <a  <?php if (preg_match('/^(admin\/enquiries)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/enquiries'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Enquiries</a> 
                <a  <?php if (preg_match('/^(admin\/house)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/house'); ?>"><span class="glyphicon glyphicon-home"></span> Students Houses</a> 
                <a  <?php if (preg_match('/^(admin\/leaving_certificate)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/leaving_certificate'); ?>"><span class="glyphicon glyphicon-bookmark"></span> Leaving Certificate</a>
                <a  <?php if (preg_match('/^(admin\/students_placement)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/students_placement'); ?>"><span class="glyphicon glyphicon-thumbs-up "></span> Leadership Position</a>
                <a  <?php if (preg_match('/^(admin\/disciplinary)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/disciplinary'); ?>"><span class="glyphicon glyphicon-question-sign "></span> Discipline</a>
                <a  <?php if (preg_match('/^(admin\/extra_curricular)/i', $this->uri->uri_string()) || preg_match('/^(admin\/activities)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/extra_curricular'); ?>"><span class="glyphicon glyphicon-tasks"> </span> Extra Curricular Activities</a>
                <a  <?php if (preg_match('/^(admin\/medical_records)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/medical_records'); ?>"><span class="glyphicon glyphicon-briefcase"></span> Medical Records</a>
                <a  <?php if (preg_match('/^(admin\/enquiry_meetings)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/enquiry_meetings'); ?>"><span class="glyphicon glyphicon-calendar"></span> Parents Enquiry Meetings</a>
                <a  <?php if (preg_match('/^(admin\/feedbacks)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/feedbacks'); ?>"><span class="glyphicon glyphicon-envelope"></span> Feedback</a> 
                <div class="dr"><span></span></div> 
                <ul class="fmenu changed" >
                    <li  <?php
                    if (preg_match('/^(admin\/hostels)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/hostel_rooms)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/assign_bed)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/hostel)/i', $this->uri->uri_string()))
                    )
                            echo 'class="active"';
                    ?>>
                        <a  <?php
                        if (preg_match('/^(admin\/hostels)/i', $this->uri->uri_string()) ||
                                     (preg_match('/^(admin\/hostel_rooms)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/assign_bed)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/hostel)/i', $this->uri->uri_string()))
                        )
                                echo 'class="active"';
                        ?> href="#"><span class="glyphicon glyphicon-home"></span> Hostels/Dormitories <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul >
                            <li><a  <?php if (preg_match('/^(admin\/hostels)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/hostels\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/hostels'); ?>"><span class="glyphicon glyphicon-list"></span> Manage Hostels</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/hostel_rooms)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/hostel_rooms\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/hostel_rooms'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Manage Hostel Rooms</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/hostel_beds)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/hostel_beds\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/hostel_beds'); ?>"><span class="glyphicon glyphicon-random"></span> Manage Hostel Beds</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/assign_bed)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/assign_bed\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/assign_bed'); ?>"><span class="glyphicon glyphicon-fast-forward"></span> Assign Bed</a></li>
                        </ul>
                    </li> 
                </ul>
                <!--New menu-->
                <ul class="fmenu changed" >
                    <li  class="
                    <?php if (preg_match('/^(admin\/transport)/i', $this->uri->uri_string())) echo 'active'; ?>
                         ">
                        <a  <?php
                        if (preg_match('/^(admin\/transport)$/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/transport\/routes)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/transport\/students)/i', $this->uri->uri_string()))
                                echo 'class="active"';
                        ?> href="#"><span class="icosg-bus"></span> Transport <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul >
                            <li><a  <?php if (preg_match('/^(admin\/transport)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/transport\/routes)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/transport'); ?>"><span class="glyphicon glyphicon-list"></span> Transport</a></li>
                        </ul>
                    </li>
                </ul> 
            </div>                                                                
            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <li>
                    <a href="<?php echo base_url('admin/admission'); ?>">All Registered Students </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_students();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/class_rooms'); ?>">All Class Rooms </a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_class_rooms();
                        echo $count;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/hostels'); ?>">All Dormitories /Hostels</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_hostels();
                        echo $count;
                        ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/hostel_rooms'); ?>">All Dormitories /Hostels Rooms</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_hostel_rooms();
                        echo $count;
                        ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/hostel_beds'); ?>">All Hostel Beds</a>
                    <span class="caption blue"><?php
                        $count = $this->ion_auth->count_hostel_beds();
                        echo $count;
                        ?></span>
                </li> 
            </ul>
            <div class="dr"><span></span></div>                
        </div> 
        <!--******************************ACCOUNTS MENU******************************************-->		
        <div id="accounts">                                                
            <div class="menu">
                <ul class="fmenu changed" style="background:#ccc; display:block;" >
                    <li
                    <?php
                    if (preg_match('/^(admin\/fee_payment)/i', $this->uri->uri_string()) ||
                                 preg_match('/^(admin\/fee_structure)/i', $this->uri->uri_string()) ||
                                 preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string()) ||
                                 preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string()))
                            echo 'class="active"';
                    ?> >
                        <a  <?php
                        if (preg_match('/^(admin\/fee_payment)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/fee_structure)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string()))
                                echo 'class="active"';
                        ?> href="#"><span class="glyphicon glyphicon-lock"></span> Financial Management</a>
                        <ul style="display:block;" >
                            <li><a  <?php if (preg_match('/^(admin\/fee_payment\/statement)/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_payment)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_payment\/view)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_payment'); ?>"><span class="glyphicon glyphicon-file"></span> Fee Payment Status</a></li>
                            <li> <a  <?php if (preg_match('/^(admin\/fee_payment\/paid)/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_payment\/receipt)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_payment/paid'); ?>"><span class="glyphicon glyphicon-list"></span> Payments List</a></li>
                            <li> <a  <?php if (preg_match('/^(admin\/fee_payment\/create)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_payment/create'); ?>"><span class="glyphicon glyphicon-briefcase"></span> Receive Payment</a></li>
                            <li> <a  <?php if (preg_match('/^(admin\/fee_structure)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_structure\/edit)/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_structure)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_structure\/view)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_structure'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Fee Structure</a></li>
                            <li> <a  <?php if (preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_extras'); ?>"><span class="glyphicon glyphicon-list"></span> Fee Extras Category </a></li> 
                            <li> <a  <?php if (preg_match('/^(admin\/fee_structure\/extras)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_structure/extras'); ?>"><span class="glyphicon glyphicon-list"></span> Fee Extras </a></li>
                            <li> <a  <?php if (preg_match('/^(admin\/invoices)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/invoices'); ?>"><span class="glyphicon glyphicon-file"></span> All Invoices </a></li> 
                            <li> <a  <?php if (preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_waivers'); ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Fee Waiver</a></li>
                            <li> <a  <?php if (preg_match('/^(admin\/fee_arrears)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_arrears'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Fee Arrears</a></li>
                            <li> <a  <?php if (preg_match('/^(admin\/fee_pledge)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/fee_pledge'); ?>"><span class="glyphicon glyphicon-tasks"></span> Fee Pledges</a></li>
                        </ul>
                    </li>
                </ul>
                <a  <?php if (preg_match('/^(admin\/expenses)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/expenses'); ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Expenses</a> 
                <a  <?php if (preg_match('/^(admin\/expenses\/requisitions)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/expenses/requisitions'); ?>"><span class="glyphicon glyphicon-check"></span>Requisitions</a> 
                <a  <?php if (preg_match('/^(admin\/petty_cash)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/petty_cash'); ?>"><span class="glyphicon glyphicon-briefcase"></span> Petty Cash</a> 
                <a  <?php if (preg_match('/^(admin\/purchase_order)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/purchase_order'); ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Purchase Orders</a>
                <a  <?php if (preg_match('/^(admin\/bank_accounts)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/bank_accounts'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Bank Accounts</a>
                <a  <?php if (preg_match('/^(admin\/tax_config)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/tax_config'); ?>"><span class="glyphicon glyphicon-download-alt"></span> Tax Config</a>
                <div class="dr"><span></span></div>  
                <ul class="fmenu changed"  >
                    <li  <?php
                    if (preg_match('/^(admin\/deductions)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/salaries)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/paye)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/allowances)/i', $this->uri->uri_string()))
                    )
                            echo 'class="active"';
                    ?>>
                        <a  <?php
                        if (preg_match('/^(admin\/deductions)/i', $this->uri->uri_string()) ||
                                     (preg_match('/^(admin\/allowances)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/paye)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/salaries)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string()))
                        )
                                echo 'class="active"';
                        ?> href="#"><span class="glyphicon glyphicon-th"></span> Payrolls Management <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul  >
                            <li><a  <?php if (preg_match('/^(admin\/salaries)/i', $this->uri->uri_string()) || preg_match('/^(admin\/salaries)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/salaries'); ?>"><span class="glyphicon glyphicon-list"></span> Salaried Employees</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string()) || preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/record_salaries'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Process Salaries</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string()) || preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/advance_salary'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Advance Salaries</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/deductions)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/deductions'); ?>"><span class="glyphicon glyphicon-filter"></span> Deductions</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/allowances)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/allowances'); ?>"><span class="glyphicon glyphicon-gift"></span> Allowances</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/paye)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/paye'); ?>"><span class="glyphicon glyphicon-gift"></span> PAYE Configuration</a></li>
                        </ul>
                    </li> 
                </ul>
                <ul class="fmenu changed"  >
                    <li  <?php
                    if (preg_match('/^(admin\/sales_items)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/sales_items_stock)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/record_sales)/i', $this->uri->uri_string())))
                            echo 'class="active"';
                    ?>>
                        <a <?php
                        if (preg_match('/^(admin\/sales_items)/i', $this->uri->uri_string()) ||
                                     (preg_match('/^(admin\/sales_items_stock)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/record_sales)/i', $this->uri->uri_string())))
                                echo 'class="active"';
                        ?> href="#"><span class="glyphicon glyphicon-folder-open"></span> Sales <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul>
                            <li><a  <?php if (preg_match('/^(admin\/sales_items)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/sales_items\/create)/i', $this->uri->uri_string()) || preg_match('/^(admin\/sales_items\/edit)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/sales_items'); ?>"><span class="glyphicon glyphicon-list"></span> Sales Items</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/sales_items_stock)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/sales_items_stock'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Sales Items Stock Trend</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/record_sales)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/record_sales'); ?>"><span class="glyphicon glyphicon-briefcase"></span> Record Sales</a></li>
                        </ul>
                    </li> 
                </ul>
                <div class="dr"><span></span></div>  
                <ul class="fmenu changed" >
                    <?php /* ?>  <li  class="
                      <?php if (preg_match('/^(admin\/accounts)/i', $this->uri->uri_string())) echo 'active'; ?>
                      ">
                      <a  <?php
                      if (preg_match('/^(admin\/accounts)/i', $this->uri->uri_string()))
                      echo 'class="active"';
                      ?> href="#"><span class="glyphicon glyphicon-fire"></span> Book of Accounts <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                      <ul >
                      <li><a  <?php if (preg_match('/^(admin\/accounting)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/accounting'); ?>"><span class="glyphicon glyphicon-book"></span> Chart of Accounts</a></li>
                      <li><a  <?php if (preg_match('/^(admin\/accounts\/trial)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/accounts/trial'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Trial Balance</a></li>
                      <li><a  <?php if (preg_match('/^(admin\/accounts\/balance)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/accounts/balance'); ?>"><span class="glyphicon glyphicon-random"></span> Balance Sheet</a></li>
                      <li><a  <?php if (preg_match('/^(admin\/accounts\/pnl)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/accounts/pnl'); ?>"><span class="glyphicon glyphicon-edit"></span> Profit & Loss</a></li>
                      </ul>
                      </li>
                      <?php */ ?>
                </ul> 
            </div>   
            <div class="dr"><span></span></div>                
        </div>   		
        <div id="inventory">
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/inventory)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/inventory\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/inventory'); ?>"><span class="glyphicon glyphicon-list"></span> Inventory Trend</a>
                <a  <?php if (preg_match('/^(admin\/items)/i', $this->uri->uri_string()) || preg_match('/^(admin\/items\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/items'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Manage Items</a>
                <a  <?php if (preg_match('/^(admin\/items_category)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/items_category\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/items_category'); ?>"><span class="glyphicon glyphicon-random"></span> Items Category</a>
                <a  <?php if (preg_match('/^(admin\/add_stock)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/add_stock\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/add_stock'); ?>"><span class="glyphicon glyphicon-edit"></span> Add Items (Stock)</a>
                <a  <?php if (preg_match('/^(admin\/give_items)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/give_items)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/give_items'); ?>"><span class="glyphicon glyphicon-book"></span> Giving Out Items</a>
                <a  <?php if (preg_match('/^(admin\/stock_taking)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/stock_taking\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/stock_taking'); ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Stock Takings</a>
            </div>	
        </div>
        <div id="files">
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/files)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/files'); ?>"><span class="glyphicon glyphicon-bullhorn"></span> File Management</a>
                <a  <?php if (preg_match('/^(admin\/folders)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/folders'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Folders Management</a>
                <a  <?php if (preg_match('/^(admin\/folders\/gallery)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/folders'); ?>"><span class="glyphicon glyphicon-picture"></span> Gallery Management</a>
            </div>		
        </div>
        <!--******************************LIBRARY MENU******************************************-->		
        <!--******************************LIBRARY MENU******************************************-->		
        <!--******************************LIBRARY MENU******************************************-->			
        <div id="lib">
            <div class="menu">
                <ul class="fmenu changed"  >
                    <li><a  <?php
                        if (preg_match('/^(admin\/books)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/books_stock)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/borrow_book)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/return_book)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/library_settings)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/books_category)/i', $this->uri->uri_string()))
                                echo 'class="active"';
                        ?> href="#"><span class="glyphicon glyphicon-book"></span> Books Library <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul style="display:block" >
                            <li> <a  <?php if (preg_match('/^(admin\/borrow_book)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/borrow_book\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/borrow_book'); ?>"><span class="glyphicon glyphicon-share"></span> Borrow Book</a> </li>
                            <li><a  <?php if (preg_match('/^(admin\/return_book)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/return_book\/create)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/return_book\/view)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/return_book\/edit)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/return_book'); ?>"><span class="glyphicon glyphicon-check"></span> Return Book</a></li>
                            <li>
                                <a  <?php if (preg_match('/^(admin\/books)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/books\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/books'); ?>"><span class="glyphicon glyphicon-book"></span> Books</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/books_stock)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/books_stock'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Manage Books Stock </a></li>
                            <li> <a  <?php if (preg_match('/^(admin\/books_category)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/books_category'); ?>"><span class="glyphicon glyphicon-random"></span> Books Category </a></li>
                            <li><a  <?php if (preg_match('/^(admin\/library_settings)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/library_settings'); ?>"><span class="glyphicon glyphicon-asterisk"></span> Library Settings</a></li>
                        </ul>
                    </li>
                </ul>	
                <div class="dr"><span></span></div> 
                <ul class="fmenu changed"  >
                    <li><a  <?php
                        if (preg_match('/^(admin\/book_fund)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/return_book_fund)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/borrow_book_fund)/i', $this->uri->uri_string()))
                                echo 'class="active"';
                        ?> href="#"><span class="glyphicon glyphicon-book"></span> Book Fund <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul style="display:block" >
                            <li><a  <?php if (preg_match('/^(admin\/book_fund)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_fund\/edit)/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_fund\/view)/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_fund\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/book_fund'); ?>"><span class="glyphicon glyphicon-list"></span> Books For Fund</a> </li>
                            <li>  <a  <?php if (preg_match('/^(admin\/borrow_book_fund)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/borrow_book_fund'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Give out Book Fund</a></li>
                            <li>  <a  <?php if (preg_match('/^(admin\/return_book_fund)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/return_book_fund'); ?>"><span class="glyphicon glyphicon-folder-close"></span> Return Book</a></li>
                            <li><a  <?php if (preg_match('/^(admin\/book_fund_stock)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/book_fund_stock'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Books Fund Stocks</a> </li>
                        </ul> 
                    </li>
                </ul>				
            </div>                                                              
            <div class="dr"><span></span></div> 
            <ul class="fmenu">
                <li>
                    <a href="<?php echo base_url('admin/books'); ?>">All Library Books </a>
                    <span class="caption blue"><?php
                        $bk = $this->ion_auth->count_books();
                        echo $bk->total;
                        ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/borrow_book'); ?>">All Borrowed Library Books</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_borrowed_books(); ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/books_category'); ?>">All Books Category</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_books_category(); ?></span>
                </li>               
            </ul>
            <div class="dr"><span></span></div> 
        </div> 
        <div id="media">
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/meetings)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/meetings'); ?>"><span class="glyphicon glyphicon-calendar"></span> Meetings</a>
                <a  <?php if (preg_match('/^(admin\/emails)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/emails/create'); ?>"><span class="glyphicon glyphicon-share"></span> Emails</a>
                <a  <?php if (preg_match('/^(admin\/sms)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/sms'); ?>"><span class="glyphicon glyphicon-envelope"></span> SMS Messaging</a>
                <a  <?php if (preg_match('/^(admin\/sms_templates)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/sms_templates'); ?>"><span class="glyphicon glyphicon-envelope"></span> SMS Templates</a>
                <div class="dr"><span></span></div> 
                <ul class="fmenu changed"  >
                    <li  <?php
                    if (preg_match('/^(admin\/address_book)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/address_book_category)/i', $this->uri->uri_string()))
                    )
                            echo 'class="active"';
                    ?>>
                        <a  <?php
                        if (preg_match('/^(admin\/address_book)/i', $this->uri->uri_string()) ||
                                     (preg_match('/^(admin\/address_book_category)/i', $this->uri->uri_string()))
                        )
                                echo 'class="active"';
                        ?> href="#"><span class="glyphicon glyphicon-th"></span> Contacts Directory <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                        <ul  style="display:block">
                            <li> <a <?php if (preg_match('/^(admin\/address_book)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book'); ?>"><span class="glyphicon glyphicon-book"></span> Address Book</a>      </li>              
                            <li> <a <?php if (preg_match('/^(admin\/address_book\/customers)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book/customers'); ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Customers</a> </li>                   
                            <li> <a <?php if (preg_match('/^(admin\/address_book\/suppliers)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book/suppliers'); ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Suppliers</a>   </li>                 
                            <li>  <a <?php if (preg_match('/^(admin\/others)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book/others'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Others</a>   </li>
                            <li>  <a <?php if (preg_match('/^(admin\/address_book_category)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/address_book_category'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Manage Categories</a></li>
                        </ul>
                </ul>
            </div>                                                              
            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <li>
                    <a href="<?php echo base_url('admin/meetings'); ?>">All Meetings </a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_meetings(); ?></span>
                </li>
                <li>
                    <a href="<?php echo base_url('admin/emails'); ?>">All Emails</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_emails(); ?></span>
                </li> 
                <li>
                    <a href="<?php echo base_url('admin/sms'); ?>">All SMS'</a>
                    <span class="caption blue"><?php echo $this->ion_auth->count_sms(); ?></span>
                </li>                
            </ul>
            <div class="dr"><span></span></div> 
        </div>
        <div id="reports">
            <div class="menu">
                <a href="<?php echo base_url('admin/reports/student_report'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/student_report)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-folder-open"></span> Student History Report</a>
                <a href="<?php echo base_url('admin/reports/fee'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/fee)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-list-alt"></span> Fee Payment Summary</a>
                <a href="<?php echo base_url('admin/reports/admission'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/admission)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-user"></span> Admission Report</a>   
                <a href="<?php echo base_url('admin/reports/fee_status'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/fee_status)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-briefcase"></span> Fee Status Report</a>   
                <a href="<?php echo base_url('admin/reports/arrears'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/arrears)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-question-sign"></span> Arrears Report</a> 
                <a href="<?php echo base_url('admin/reports/fee_extras'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/fee_extras)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-signal"></span> Fee Extras Report</a>   
                <a href="<?php echo base_url('admin/reports/paid'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/paid)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-list"></span> Fee Payments Report</a>   
                <a href="<?php echo base_url('admin/reports/exam'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/exam)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-star"></span> Exam Results Report</a> 
                <a href="<?php echo base_url('admin/reports/expenses'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/expenses)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-indent-left"></span> Expenses Summary Report</a> 
                <a href="<?php echo base_url('admin/reports/expense_trend'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/expense_trend)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-indent-left"></span> Detailed  Expenses Report</a> 
                <a href="<?php echo base_url('admin/reports/wages'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/wages)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-barcode"></span> Wages Report</a> 
                <a href="<?php echo base_url('admin/reports/assets'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/assets)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-indent-right"></span> Assets Report</a> 
                <a href="<?php echo base_url('admin/reports/book_fund'); ?>" 
                   <?php echo (preg_match('/^(admin\/reports\/book_fund)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> >
                    <span class="glyphicon glyphicon-book"></span> Book Funds Reports</a>    
            </div>                
            <div class="dr"><span></span></div>
        </div>
        <div id="users">
            <div class="menu">
                <a  <?php echo (preg_match('/^(admin\/employees_attendance)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/employees_attendance'); ?>"><span class="glyphicon glyphicon-time"></span> Employees Attendance</a>
                <a  <?php echo (preg_match('/^(admin\/teachers)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/teachers'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Teachers</a>
                <a  <?php echo (preg_match('/^(admin\/parents)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/parents'); ?>"><span class="glyphicon glyphicon-folder-open"></span> Parents</a>
                <a  <?php echo (preg_match('/^(admin\/admission)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/admission'); ?>"><span class="glyphicon glyphicon-list"></span> Students</a>
                <a  <?php echo (preg_match('/^(admin\/users\/create)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/users/create'); ?>"><span class="glyphicon glyphicon-plus"></span> Add Staff</a>
                <a  <?php echo (preg_match('/^(admin\/users)$/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/users'); ?>"><span class="glyphicon glyphicon-folder-close"></span> List all Users</a>
                <a  <?php echo (preg_match('/^(admin\/groups)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> href="<?php echo base_url('admin/groups'); ?>"><span class="glyphicon glyphicon-user"></span> User Groups</a>
            </div>
            <div class="dr"><span></span></div>
        </div>            
        <div id="other">
            <div class="menu">
                <a href="<?php echo base_url('admin/settings'); ?>"><span class="glyphicon glyphicon-cog"></span> Settings</a>
                <a href="<?php echo base_url('admin/permissions'); ?>"><span class="glyphicon glyphicon-lock"></span> Permissions</a>
                <a href="<?php echo base_url('admin/settings/backup'); ?>"><span class="glyphicon glyphicon-download-alt"></span> Data Backup</a>
                <a  <?php if (preg_match('/^(admin\/class_stream)/i', $this->uri->uri_string()) || preg_match('/^(admin\/class_groups)$/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/class_groups'); ?>"><span class="glyphicon glyphicon-home"></span> Class Groups</a>
            </div>
            <div class="dr"><span></span><?php echo $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end'); ?> sec.</div>
        </div>   
    </div>
</div>
