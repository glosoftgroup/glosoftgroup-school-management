<!-- Main sidebar -->
			<div class="sidebar sidebar-main sidebar-primary sidebar-fixed">
				<div class="sidebar-content ">

					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
								<li>
                  <a
                  <?php
                  if ( preg_match('/^(admin)$/i', $this->uri->uri_string()))
                          echo 'class="active"';
                  ?>
                   href="<?=base_url();?>">
                    <i class="icon-home4"></i>
                    <span>Dashboard</span>
                  </a>
                </li>
                <!-- academics -->
								<li
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
									?>
								>
									<a href="#">
                    <i class="icon-bookmark"></i>
                    <span>Academics</span>
                  </a>
									<ul>
										<li <?php if (preg_match('/^(admin\/class_stream)/i', $this->uri->uri_string()) || preg_match('/^(admin\/class_groups\/classes)/i', $this->uri->uri_string())) echo 'class="active"'; ?> ><a href="<?php echo base_url('admin/class_groups/classes'); ?>">All Classes</a></li>
										<li <?php if (preg_match('/^(admin\/class_rooms)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/class_rooms'); ?>">Class Rooms</a></li>
                    <li <?php if (preg_match('/^(admin\/subjects)/i', $this->uri->uri_string())) echo 'class="active"'; ?> ><a href="<?php echo base_url('admin/subjects'); ?>">Subjects</a></li>
                    <li <?php if (preg_match('/^(admin\/grading)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/grading\/view)/i', $this->uri->uri_string()) || preg_match('/^(admin\/grades)/i', $this->uri->uri_string()) || preg_match('/^(admin\/grading\/edit)/i', $this->uri->uri_string()) || preg_match('/^(admin\/grading\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/grading'); ?>">Grading</a></li>
                    <li <?php if (preg_match('/^(admin\/grading_system)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/grading_system'); ?>">Grading System</a></li>
                    <li <?php if (preg_match('/^(admin\/exams)$/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/exams'); ?>">Exams</a></li>
                    <li <?php if (preg_match('/^(admin\/class_attendance)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/class_attendance'); ?>">Class Attendance</a></li>
                    <li <?php if (preg_match('/^(admin\/assignments)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/assignments'); ?>">Assignments</a></li>
                    <li <?php if (preg_match('/^(admin\/school_events)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/school_events'); ?>">School Events</a></li>
                    <li <?php if (preg_match('/^(admin\/school_events\/calendar)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/school_events/calendar'); ?>">Full Calendar</a></li>
									</ul>
                  <!--******************************ADMINISTRATION MENU******************************************-->
                  <li>
              		<a href="#">
                    <i class="icon-office"></i>
                    <span>Administration</span>
                  </a>
              		<ul>
              			<li
										<?php if (preg_match('/^(admin\/admission)$/i', $this->uri->uri_string())) echo 'class="active"'; ?>
													<?php if (preg_match('/^(admin\/admission\/edit)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
													<?php if (preg_match('/^(admin\/admission\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
													<?php if (preg_match('/^(admin\/admission\/student)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
													<?php if (preg_match('/^(admin\/admission\/inactive)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
													<?php if (preg_match('/^(admin\/admission\/view)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										>
                      <a href="<?php echo base_url('admin/admission'); ?>">
                                Student Admission
                        </a>
                    </li>
                    <li <?php if (preg_match('/^(admin\/admission\/alumni)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/admission/alumni'); ?>">Alumini Students</a></li>
              			<li <?php if (preg_match('/^(admin\/enquiries)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/enquiries'); ?>">Enquiries</a></li>
                    <li <?php if (preg_match('/^(admin\/house)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/house'); ?>">Student Houses</a></li>
                    <li <?php if (preg_match('/^(admin\/leaving_certificate)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/leaving_certificate'); ?>">Leaving Certificates</a></li>
                    <li <?php if (preg_match('/^(admin\/students_placement)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/students_placement'); ?>">Leadership Position</a></li>
                    <li <?php if (preg_match('/^(admin\/disciplinary)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/disciplinary'); ?>">Discipline</a></li>
                    <li <?php if (preg_match('/^(admin\/extra_curricular)/i', $this->uri->uri_string()) || preg_match('/^(admin\/activities)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/extra_curricular'); ?>">Extra Curriculum Activities</a></li>
                    <li <?php if (preg_match('/^(admin\/medical_records)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/medical_records'); ?>">Medical Records</a></li>
              			<li <?php if (preg_match('/^(admin\/enquiry_meetings)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/enquiry_meetings'); ?>">Parents Enquiry Meetings</a></li>
                    <li <?php if (preg_match('/^(admin\/feedbacks)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/feedbacks'); ?>">Feedback</a></li>
                    <li
                    <?php
                    if (preg_match('/^(admin\/hostels)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/hostel_rooms)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/assign_bed)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/hostel)/i', $this->uri->uri_string()))
                    )
                            echo 'class="active"';
                    ?>>
											<a <?php
                        if (preg_match('/^(admin\/hostels)/i', $this->uri->uri_string()) ||
                                     (preg_match('/^(admin\/hostel_rooms)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/assign_bed)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/hostel)/i', $this->uri->uri_string()))
                        )
                                echo 'class="active"';
                        ?> href="#">Hostels/Domitories</a>
											<ul>
												<li <?php if (preg_match('/^(admin\/hostels)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/hostels\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/hostels'); ?>">Manage Hostels</a></li>
												<li <?php if (preg_match('/^(admin\/hostel_rooms)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/hostel_rooms\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/hostel_rooms'); ?>">Manage Hostel Rooms</a></li>
                        <li <?php if (preg_match('/^(admin\/hostel_beds)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/hostel_beds\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/hostel_beds'); ?>">Manage Hostel Beds</a></li>
                        <li <?php if (preg_match('/^(admin\/assign_bed)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/assign_bed\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/assign_bed'); ?>">Assign Bed</a></li>
											</ul>
										</li>
                    <li <?php if (preg_match('/^(admin\/transport)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/transport\/routes)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/transport'); ?>">Transport</a></li>

              		</ul>
              	</li>
                  <!-- ./administration -->
                  <!--******************************ACCOUNTS MENU******************************************-->
                <li
                <?php
                    if (preg_match('/^(admin\/fee_payment)/i', $this->uri->uri_string()) ||
                                 preg_match('/^(admin\/fee_structure)/i', $this->uri->uri_string()) ||
                                 preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string()) ||
                                 preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string()))
                            echo 'class="active"';
                    ?> >
      					 <a href="#">
                   <i class="icon-coins"></i>
                   <span>Accounts</span></a>
          					<ul>
          						<li <?php if (preg_match('/^(admin\/fee_payment\/statement)/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_payment)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_payment\/view)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/fee_payment'); ?>">Fee Payment Status</a></li>
          						<li <?php if (preg_match('/^(admin\/fee_payment\/paid)/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_payment\/receipt)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/fee_payment/paid'); ?>">Payment List</a></li>
                      <li <?php if (preg_match('/^(admin\/fee_payment\/create)$/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/fee_payment/create'); ?>">Receive Payment</a></li>
          						<li <?php if (preg_match('/^(admin\/fee_structure)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_structure\/edit)/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_structure)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/fee_structure\/view)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/fee_structure'); ?>">Fee Structure</a></li>
                      <li <?php if (preg_match('/^(admin\/fee_extras)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/fee_extras'); ?>">Fee Extra Category</a></li>
          						<li <?php if (preg_match('/^(admin\/fee_structure\/extras)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/fee_structure/extras'); ?>">Fee Extra</a></li>
                      <li <?php if (preg_match('/^(admin\/invoices)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/invoices'); ?>">All invoices</a></li>
          						<li <?php if (preg_match('/^(admin\/fee_waivers)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/fee_waivers'); ?>">Fee Waiver</a></li>
                      <li <?php if (preg_match('/^(admin\/fee_arrears)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/fee_arrears'); ?>">Fee Arrears</a></li>
          						<li <?php if (preg_match('/^(admin\/fee_pledge)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/fee_pledge'); ?>">Fee Pledges</a></li>
                      <li <?php if (preg_match('/^(admin\/expenses)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/expenses'); ?>">Expenses</a></li>
                      <li <?php if (preg_match('/^(admin\/expenses\/requisitions)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/expenses/requisitions'); ?>">Requisition</a></li>
                      <li <?php if (preg_match('/^(admin\/petty_cash)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/petty_cash'); ?>">Petty Cash</a></li>
                      <li <?php if (preg_match('/^(admin\/purchase_order)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/purchase_order'); ?>">Purchase Orders</a></li>
                      <li <?php if (preg_match('/^(admin\/bank_accounts)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/bank_accounts'); ?>">Bank Accounts</a></li>
                      <li <?php if (preg_match('/^(admin\/tax_config)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/tax_config'); ?>">Tax Config</a></li>
                      <li
                      <?php
                    if (preg_match('/^(admin\/deductions)/i', $this->uri->uri_string()) ||
                                 (preg_match('/^(admin\/salaries)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/paye)/i', $this->uri->uri_string())) ||
                                 (preg_match('/^(admin\/allowances)/i', $this->uri->uri_string()))
                    )
                            echo 'class="active"';
                    ?>>
                        <a <?php
                        if (preg_match('/^(admin\/deductions)/i', $this->uri->uri_string()) ||
                                     (preg_match('/^(admin\/allowances)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/paye)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/salaries)/i', $this->uri->uri_string())) ||
                                     (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string()))
                        )
                                echo 'class="active"';
                        ?> href="">Payroll Management</a>
                        <ul>
												  <li <?php if (preg_match('/^(admin\/salaries)/i', $this->uri->uri_string()) || preg_match('/^(admin\/salaries)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/salaries'); ?>">Salaried Employees</a></li>
												  <li <?php if (preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string()) || preg_match('/^(admin\/record_salaries)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/record_salaries'); ?>">Process Salaries</a></li>
												  <li <?php if (preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string()) || preg_match('/^(admin\/advance_salary)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/advance_salary'); ?>">Advance Salaries</a></li>
                          <li <?php if (preg_match('/^(admin\/deductions)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/deductions'); ?>">Deductions</a></li>
                          <li <?php if (preg_match('/^(admin\/allowances)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/allowances'); ?>">Allowances</a></li>
                          <li <?php if (preg_match('/^(admin\/paye)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/paye'); ?>">PAYE configuration</a></li>
											  </ul>
                      </li>
                      <li <?php
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
                        ?> href="#">Sales</a>
                        <ul>
  												<li <?php if (preg_match('/^(admin\/sales_items)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/sales_items\/create)/i', $this->uri->uri_string()) || preg_match('/^(admin\/sales_items\/edit)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/sales_items'); ?>">Sales Items</a></li>
  												<li <?php if (preg_match('/^(admin\/sales_items_stock)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/sales_items_stock'); ?>">Sales Item Stock trend</a></li>
  												<li <?php if (preg_match('/^(admin\/record_sales)/i', $this->uri->uri_string())) echo 'class="active"'; ?>><a href="<?php echo base_url('admin/record_sales'); ?>">Record Sales</a></li>
  											</ul>
                      </li>


          					</ul>
      				    </li>
                 <!-- ./accounts -->
								
								<!-- inventory -->
								<li>
									<a href="#"><i class=" icon-list"></i> <span>Inventory</span></a>
									<ul>
										<li
										<?php if (preg_match('/^(admin\/inventory)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/inventory\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/inventory'); ?>">Inventory Trend</a></li>
										<li
										<?php if (preg_match('/^(admin\/items)/i', $this->uri->uri_string()) || preg_match('/^(admin\/items\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/items'); ?>">Manage Items</a></li>
										<li
										<?php if (preg_match('/^(admin\/items_category)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/items_category\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/items_category'); ?>">Items Category</a></li>
										<li
										<?php if (preg_match('/^(admin\/add_stock)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/add_stock\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/add_stock'); ?>">Add Items (Stock)</a></li>
										<li
										<?php if (preg_match('/^(admin\/give_items)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/give_items)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/give_items'); ?>">Giving Out Items</a></li>
										<li
										<?php if (preg_match('/^(admin\/stock_taking)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/stock_taking\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/stock_taking'); ?>">Stock Takings</a></li>

									</ul>
								</li>
								<!-- ./inventory -->
								<!--******************************LIBRARY MENU******************************************-->
								<li
								<?php
                        if (preg_match('/^(admin\/books)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/books_stock)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/borrow_book)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/return_book)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/library_settings)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/books_category)/i', $this->uri->uri_string()))
                                echo 'class="active"';
                        ?>
								 >
									<a href="#"><i class="icon-reading"></i> <span>Books Library</span></a>
									<ul>
										<li
										<?php if (preg_match('/^(admin\/borrow_book)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/borrow_book\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/borrow_book'); ?>">Borrow Book</a></li>
										<li
										<?php if (preg_match('/^(admin\/return_book)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/return_book\/create)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/return_book\/view)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/return_book\/edit)$/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/return_book'); ?>">Return Book</a></li>
										<li
										<?php if (preg_match('/^(admin\/books)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/books\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/books'); ?>">Books</a></li>
										<li
										<?php if (preg_match('/^(admin\/books_stock)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/books_stock'); ?>">Manage Books Stock</a></li>
										<li
										<?php if (preg_match('/^(admin\/books_category)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/books_category'); ?>">Books Category</a></li>
										<li
										<?php if (preg_match('/^(admin\/library_settings)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
										><a href="<?php echo base_url('admin/library_settings'); ?>">Library Settings</a></li>
										<li
										<?php
                        if (preg_match('/^(admin\/book_fund)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/return_book_fund)/i', $this->uri->uri_string()) ||
                                     preg_match('/^(admin\/borrow_book_fund)/i', $this->uri->uri_string()))
                                echo 'class="active"';
                        ?>
										>
											<a href="javascript:;" class='text-muted'>Book Refund</a>
											<ul>
												<li
													<?php if (preg_match('/^(admin\/book_fund)$/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_fund\/edit)/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_fund\/view)/i', $this->uri->uri_string()) || preg_match('/^(admin\/book_fund\/create)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
												><a href="<?php echo base_url('admin/book_fund'); ?>">Books For Fund</a></li>
												<li
												<?php if (preg_match('/^(admin\/borrow_book_fund)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
												><a href="<?php echo base_url('admin/borrow_book_fund'); ?>">Give out Book Fund</a></li>
												<li
												<?php if (preg_match('/^(admin\/return_book_fund)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
												><a href="<?php echo base_url('admin/return_book_fund'); ?>">Return Book</a></li>
												<li
												<?php if (preg_match('/^(admin\/book_fund_stock)/i', $this->uri->uri_string())) echo 'class="active"'; ?>
												><a href="<?php echo base_url('admin/book_fund_stock'); ?>">Books Fund Stocks</a></li>

											</ul>
										</li>

									</ul>
								</li>
								<!-- ./library -->
								<!-- users -->
								<li>
									<a href="#"><i class="icon-users"></i> <span>Users</span></a>
									<ul>
										<li
										<?php echo (preg_match('/^(admin\/employees_attendance)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?>
										><a href="<?php echo base_url('admin/employees_attendance'); ?>"> Employees Attendance</a></li>
										<li
										<?php echo (preg_match('/^(admin\/teachers)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?>
										><a href="<?php echo base_url('admin/teachers'); ?>">Teachers</a></li>
                    <li
                    <?php echo (preg_match('/^(admin\/parents)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> 
                    ><a href="<?php echo base_url('admin/parents'); ?>">Parents</a></li>
                    <li
                     <?php echo (preg_match('/^(admin\/admission)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?>
                    ><a href="<?php echo base_url('admin/admission'); ?>">Students</a></li>
                    <li
                    <?php echo (preg_match('/^(admin\/users\/create)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?> 
                    ><i class="icon-plus"></i><a href="<?php echo base_url('admin/users/create'); ?>">Add Staff</a></li>
                    <li
                    <?php echo (preg_match('/^(admin\/users)$/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?>
                    ><a href="<?php echo base_url('admin/users'); ?>">List all Users</a></li>
                    <li
                    <?php echo (preg_match('/^(admin\/groups)/i', $this->uri->uri_string())) ? 'class="active"' : ' ' ?>
                    ><a href="<?php echo base_url('admin/groups'); ?>">User Groups</a></li>
									</ul>
								</li>
								<!-- ./users -->
								<!-- /main -->

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->
