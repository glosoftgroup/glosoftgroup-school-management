<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();

                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }
                $this->load->model('admission_m');
                $this->load->model('fee_payment/fee_payment_m');
                $this->load->model('sms/sms_m');
                // $this->load->model('fee_payment/fee_payment_m');
                $this->load->model('fee_waivers/fee_waivers_m');
                $this->load->model('assign_bed/assign_bed_m');
                $this->load->model('hostel_beds/hostel_beds_m');
                $this->load->model('students_placement/students_placement_m');
                $this->load->model('disciplinary/disciplinary_m');
                $this->load->model('email_templates/email_templates_m');
                $this->load->library('pmailer');
                $this->load->library('image_cache');
        }

        //Student ID
        function student_id($id = 0)
        {
                if (!$this->admission_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/admission');
                }
                $data['u'] = $this->admission_m->find($id);
                $u = $this->admission_m->find($id);
                $data['passport'] = $this->admission_m->passport($u->photo);
                $this->template->title('Student Pass ')->build('admin/student_id', $data);
        }

        /**
         * View Admission Record
         * 
         * @param int $id record ID
         * @param int $page - the pagination offset
         */
        function view($id = 0)
        {
                if (!$this->admission_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/admission');
                }
                $data['extras'] = $this->fee_payment_m->all_fee_extras();
                $stud = $this->admission_m->find($id);
                $data['passport'] = $this->admission_m->passport($stud->photo);
                $student = $this->admission_m->find($id);
                $data['student'] = $student;

                $parent_id = $this->admission_m->find($id);
                $data['parent_details'] = $this->admission_m->get_parent($parent_id->parent_id);
                $data['cl'] = $this->admission_m->fetch_class($parent_id->class);
                $data['title'] = 'Fee Statement';

                $data['p'] = $this->fee_payment_m->get_receipts($id);
                //Beds
                $data['bed'] = $this->assign_bed_m->get($id);
                $data['beds'] = $this->assign_bed_m->get_hostel_beds();
                //Placement position
                $data['position'] = $this->students_placement_m->get($id);
                $data['st_pos'] = $this->students_placement_m->get_positions();
                //Exams Results
                $exams = array(); //$this->exams_management_m->get_by_student($id);

                $data['exams'] = $exams;
                //Exams Type
                $data['type'] = $this->admission_m->populate('exams', 'id', 'year');
                $data['term'] = $this->admission_m->populate('exams', 'id', 'term');
                $data['type_details'] = $this->admission_m->populate('exams', 'id', 'title');

                //Disciplinary
                $data['disciplinary'] = $this->disciplinary_m->get($id);
                $tm = get_term(date('m'));
                $data['waiver'] = $this->admission_m->get_waiver($id, $tm);

                $data['amt'] = $this->admission_m->total_fees($student->class);
                $data['post'] = $this->fee_payment_m->get_row($id);
                $data['banks'] = $this->fee_payment_m->banks();
                $this->worker->calc_balance($id);
                // $data['paid'] = $this->fee_payment_m->fetch_balance($student->id);
                $data['fee'] = $this->fee_payment_m->fetch_balance($student->id);
                $data['paro'] = $this->admission_m->get_paro($stud->parent_id);

                $this->template->title('View Student')->build('admin/student', $data);
        }

        /**
         * View Admission Record
         * 
         * @param int $id record ID
         * @param int $page - the pagination offset
         */
        function quick_nav()
        {
                $id = $this->input->post('student');
                redirect('admin/admission/view/' . $id);
        }

        /**
         * View Admission Record
         * 
         * @param int $id record ID
         * @param int $page - the pagination offset
         */
        function my_student_details($id = 0)
        {
                if (!$this->admission_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/admission');
                }
                $data['extras'] = $this->fee_payment_m->all_fee_extras();
                $stud = $this->admission_m->find($id);
                $data['passport'] = $this->admission_m->passport($stud->photo);
                $student = $this->admission_m->find($id);
                $data['student'] = $student;

                $parent_id = $this->admission_m->find($id);
                $data['parent_details'] = $this->admission_m->get_parent($parent_id->parent_id);
                $data['cl'] = $this->admission_m->fetch_class($parent_id->class);
                $data['title'] = 'Fee Statement';

                $data['p'] = $this->fee_payment_m->get_receipts($id);
                //Beds
                $data['bed'] = $this->assign_bed_m->get($id);
                $data['beds'] = $this->assign_bed_m->get_hostel_beds();
                //Placement position
                $data['position'] = $this->students_placement_m->get($id);
                $data['st_pos'] = $this->students_placement_m->get_positions();
                //Exams Results
                $exams = array(); //$this->exams_management_m->get_by_student($id);

                $data['exams'] = $exams;
                //Exams Type
                $data['type'] = $this->admission_m->populate('exams', 'id', 'year');
                $data['term'] = $this->admission_m->populate('exams', 'id', 'term');
                $data['type_details'] = $this->admission_m->populate('exams', 'id', 'title');

                //Disciplinary
                $data['disciplinary'] = $this->disciplinary_m->get($id);
                $tm = get_term(date('m'));
                $data['waiver'] = $this->admission_m->get_waiver($id, $tm);
                $data['amt'] = $this->admission_m->total_fees($student->class);
                $data['post'] = $this->fee_payment_m->get_row($id);
                $data['banks'] = $this->fee_payment_m->banks();
                $this->worker->calc_balance($id);
                // $data['paid'] = $this->fee_payment_m->fetch_balance($student->id);
                $data['fee'] = $this->fee_payment_m->fetch_balance($student->id);
                $data['paro'] = $this->admission_m->get_paro($stud->parent_id);

                $this->template->title('View Student')
                             ->set_layout('teachers')
                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                             ->build('admin/my_student_details', $data);
        }

        public function suspended()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->admission_m->suspended($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

                echo json_encode($output);
        }

        public function completed()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->admission_m->get_alumni($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

                echo json_encode($output);
        }

        /**
         * *Load suspended students view
         * *Public function
         * */
        public function alumni()
        {
                $this->template->title('Alumni Students')->build('admin/alumni');
        }

        /**
         * New Admission
         * 
         * @param int $page
         */
        function create($page = 0)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['parents'] = $this->admission_m->fetch_parent_options();

                $data['class_stream'] = $this->admission_m->populate('class_stream', 'id', 'name');
                $data['house'] = $this->admission_m->populate('house', 'id', 'name');
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                $rules = $this->validation();
                //Rules for validation
                if ($this->input->post('ptype') == 1)
                {
                        $rules = array_merge($this->validation(), $this->ext_validation());
                }
                $this->form_validation->set_rules($rules);
                $last_adm = $this->admission_m->get_last_id();
                $number = $last_adm + 1;
 
                $adno = $this->school->prefix . '-' . str_pad($number, 3, '0', 0);
                //validate the fields of form
                if ($this->form_validation->run())
                { 
                        //Validation OK!                       
                        $paro_unique = str_pad($number, 3, '0', 0);

                        if ($this->input->post('ptype') == 2)
                        {
                                $ps_id = $this->input->post('parent_id');
                                $pid = $this->admission_m->get_parent($ps_id)->user_id;
                        }
                        else if ($this->input->post('ptype') == 1) //new
                        {
                                /* Add Parent to  Users */
                                $p_username = strtolower($this->input->post('parent_fname')) . ' ' . strtolower($this->input->post('parent_lname'));
                                $pemail = $this->input->post('parent_email');
                                $sch_info = explode('@', $this->school->email);
                                if (empty($pemail))
                                {
                                        if (isset($sch_info[1]))
                                        {
                                                $mail = $sch_info[1];
                                                $pemail = strtolower($this->input->post('parent_fname') . '-' . $paro_unique . '@' . $mail);
                                        }
                                        else
                                        {
                                                $suff = underscore($this->school->school);
                                                $pemail = $this->input->post('parent_fname') . '-' . $paro_unique . '@' . $suff . '.com';
                                        }
                                }
			
                                $ppassword = '12345678'; //temporary password - will require to be changed on first login
                                $additional = array(
                                    'first_name' => $this->input->post('parent_fname'),
                                    'last_name' => $this->input->post('parent_lname'),
                                    'me' => $this->ion_auth->get_user()->id,
                                );

                                $pid = $this->ion_auth->register($p_username, $ppassword, $pemail, $additional);
                               //add to Parents group
                                if ($pid)
                                {
                                        $this->ion_auth->add_to_group(6, $pid);

                                        /* End Parent Add to Users */
                                        $pdata = array(
                                            'first_name' => $this->input->post('parent_fname'),
                                            'last_name' => $this->input->post('parent_lname'),
                                            'email' => $pemail,
                                            'occupation' => $this->input->post('occupation'),
                                            'mother_fname' => $this->input->post('mother_fname'),
                                            'mother_lname' => $this->input->post('mother_lname'),
                                            'mother_email' => $this->input->post('mother_email'),
                                            'mother_phone' => $this->input->post('mother_phone'),
                                            'mother_occupation' => $this->input->post('mother_occupation'),
                                            'mother_address' => $this->input->post('mother_address'),
                                            'status' => 1,
                                            'user_id' => $pid,
                                            'phone' => $this->input->post('phone'),
                                            'address' => $this->input->post('address'),
                                            'created_on' => time(),
                                            'created_by' => $this->ion_auth->get_user()->id
                                        );

                                        $ps_id = $this->admission_m->save_parent($pdata); //parent id
                                }
                        }
                        else
                        {
                            //
                        }
			    
                        if (!$pid)
                        {
                            return FALSE;
                        }
			
                        /* Create Student User */
                        $username = strtolower($this->input->post('first_name')) . '.' . $adno;
                        $sch_info = explode('@', $this->school->email);
                        if ($this->input->post('email') == "")
                        {
                                if (isset($sch_info[1]))
                                {
                                        $mail = $sch_info[1];
                                        $email = strtolower($username . '@' . $mail);
                                }
                                else
                                {
                                        $suff = underscore($this->school->school);
                                        $email = $username . '@' . $suff . '.com';
                                }
                        }
                        else
                        {
                                $email = $this->input->post('email');
                        }

                        //$email = $this->input->post('email');
                        $password = '12345678'; //temporary password - will require to be changed on first login

                        $additional_data = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $u_id = $this->ion_auth->register($username, $password, $email, $additional_data);
                        /* Create Student User */

                        $cls = $this->input->post('class');

                        $sdata = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'dob' => strtotime($this->input->post('dob')),
                            'gender' => $this->input->post('gender'),
                            'house' => $this->input->post('house'),
                            'old_adm_no' => $this->input->post('old_adm_no'),
                            'allergies' => $this->input->post('allergies'),
                            'hospital' => $this->input->post('hospital'),
                            'former_school' => $this->input->post('former_school'),
                            'entry_marks' => $this->input->post('entry_marks'),
                            'doctor_name' => $this->input->post('doctor_name'),
                            'doctor_phone' => $this->input->post('doctor_phone'),
                            'residence' => $this->input->post('residence'),
                            'email' => $email,
                            'user_id' => $u_id,
                            'parent_id' => $ps_id,
                            'parent_user' => $pid,
                            'status' => 1,
                            'admission_date' => strtotime($this->input->post('admission_date')),
                            'class' => $cls,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );
                        if ($this->input->post('photo'))
                        {
                                $sdata['photo'] = $this->input->post('photo');
                        }
                        $rec = $this->admission_m->create($sdata); //student admission id

                        if (!$rec)
                        {
                                return FALSE;
                        }
                        else
                        {
                                $skul = $this->ion_auth->settings();
                                $recipient = $this->input->post('phone');
                                $to = $this->input->post('parent_fname');
                                $stud = $this->input->post('first_name') . ' ' . $this->input->post('last_name');

                                //Get Class student was admitted
                                $scls = $this->admission_m->get_my_class($cls);
                                $this->worker->invoice_student($rec, $scls->class);

                                $st_cls = $this->admission_m->get_stud_class($scls->class);
                                $message = $skul->message_initial . ' ' . $to . ', ' . $stud . ' has been admitted in ' . $st_cls->name . ' and you are his/her parent/guardian. Your Login details Link:' . base_url() . ' Username:' . $pemail . ' Password:' . $ppassword . ' Thanks for choosing ' . $skul->school;

                                $this->sms_m->send_sms($recipient, $message);

                                /** Put in History ** */
                                $hiss = array(
                                    'student' => $rec,
                                    'class' => $scls->class,
                                    'stream' => $scls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->admission_m->put_history($hiss);

                                //assign parent
                                $fss = array(
                                    'parent_id' => $ps_id,
                                    'student_id' => $rec,
                                    'status' => 1,
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->admission_m->assign_parent($fss);
                        }

                        //add to students group
                        $this->ion_auth->add_to_group(8, $u_id);
                        $this->admission_m->update_attributes($rec, array('admission_number' => $adno));
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'New Student Added'));
                        redirect('admin/admission/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }
                }

                $data['result'] = $get;
                $data['reg'] = $adno;
                $this->template->title(' New Student ')->build('admin/newizz', $data);
        }

        public function index()
        {
                $config = $this->set_paginate_options();
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['admission'] = $this->admission_m->paginate_all($config['per_page'], $page);
                //page number  variable
                $data['page'] = $page;
                //load view

                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' All Students')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/list', $data);
                }
                else
                {
                        $this->template->title(' Admission ')->build('admin/list', $data);
                }
        }

        /**
         * Get Datatable
         * 
         */
        public function get_table()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->admission_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

                echo json_encode($output);
        }

        /**
         * Get Teachers Student
         * 
         */
        public function get_teachers_student()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->admission_m->get_my_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

                echo json_encode($output);
        }

        /**
         * *Load teachers students list
         * *Public function
         * */
        public function my_students()
        {
                $config = $this->set_paginate_options();
                // $this->pagination->initialize($config); //Initialize the pagination config
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['admission'] = $this->admission_m->paginate_all($config['per_page'], $page);

                //page number  variable
                $data['page'] = $page;
                //$data['per'] = $config['per_page'];
                //load view
                $this->template->title(' My Students ')
                             ->set_layout('teachers')
                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                             ->build('admin/teachers_students', $data);
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/admission/');
                }
                if (!$this->admission_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/admission');
                }
                //search the item to show in edit form
                $get = $this->admission_m->find($id);
                $data['pero'] = $this->admission_m->get_parent($get->parent_id);
                //$data['school_classes'] = $this->admission_m->populate('school_classes', 'id', 'class_name');
                $data['house'] = $this->admission_m->populate('house', 'id', 'name');
                $data['class_stream'] = $this->admission_m->populate('class_stream', 'id', 'name');
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['updType'] = 'edit';
                $data['rec'] = $id;
                $data['pid'] = $get->parent_id;
                $data['parents'] = $this->admission_m->fetch_parent_options();
                $data['updType'] = 'edit';
                $data['page'] = $page;

                $data['result'] = $get;
                //load the view and the layout
                $this->template->title('Edit Student Details ')->build('admin/wizard', $data);
        }

        /**
         * *Load suspended students view
         * *Public function
         * */
        public function inactive()
        {$fee = $this->fee_payment_m->fetch_balance(72);
 
                $this->template->title(' Admission ')->build('admin/suspended');
        }

        /**
         * Receive Payment From Suspended Student
         * 
         * @param type $id
         */
        function sus_payment($id)
        {
                $data['updType'] = 'create';
                //Rules for validation
                $this->form_validation->set_rules($this->pay_validation());
                $this->load->model('fee_payment/fee_payment_m');
                $this->load->model('accounts/accounts_m');
                //validate the fields of form
                if ($this->form_validation->run())
                {       //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $length = $this->input->post('amount');
                        $size = count($length);

                        $now = time();
                        $t_array = $this->input->post('amount');
                        $total = array_sum($t_array);

                        $receipt = array(
                            'total' => $total,
                            'student' => $id,
                            'created_by' => $user->id,
                            'created_on' => $now
                        );

                        $rec_id = $this->fee_payment_m->insert_rec($receipt);

                        for ($i = 0; $i < $size; ++$i)
                        {
                                $payment_date = $this->input->post('payment_date');
                                $amount = $this->input->post('amount');
                                $payment_method = $this->input->post('payment_method');
                                $transaction_no = $this->input->post('transaction_no');
                                $bank_id = $this->input->post('bank_id');
                                $description = $this->input->post('description');
                                $table_list = array(
                                    'payment_date' => strtotime($payment_date[$i]),
                                    'reg_no' => $id,
                                    'amount' => $amount[$i],
                                    'payment_method' => $payment_method[$i],
                                    'transaction_no' => $transaction_no[$i],
                                    'bank_id' => $bank_id[$i],
                                    'receipt_id' => $rec_id,
                                    'status' => 1,
                                    'description' => $description[$i],
                                    'created_by' => $user->id,
                                    'created_on' => $now
                                );
                                $data = $this->fee_payment_m->create($table_list);
                        }

                        if ($data)
                        {
                                /**
                                 *   Add amount paid to Fee Payment A/C (Revenue account)
                                 */
                                $get_account = $this->accounts_m->get_by_code(200);
                                $balance = $get_account->balance;

                                $rbal = $balance + $total;
                                $bal_details = array(
                                    'balance' => $rbal,
                                    'modified_by' => $user->id,
                                    'modified_on' => time());
                                $this->accounts_m->update_attributes($get_account->id, $bal_details);
                                $total = $this->fee_payment_m->total_payment($rec_id);

                                $stud = $this->worker->get_student($id);
                                $sname = $stud->first_name . ' ' . $stud->last_name;
                                //update student Balance
                                $this->worker->calc_balance($id);

                                $paro = $this->admission_m->find($id);
                                $bal = $this->fee_payment_m->get_balance($id);

                                $member = $this->ion_auth->get_single_parent($paro->parent_id);

                                if (!empty($member))
                                {
                                        $recipient = $member->phone;
                                        $to = $member->first_name;

                                        if ($bal->balance < 0)
                                        {
                                                $message = $this->school->message_initial . ' ' . $to . ', a sum of Ksh. ' . number_format($total->total) . ' has been received as a fee payment for ' . $sname . '. You have an overpay of ' . number_format($bal->balance) . '. Thanks for being one of us';
                                        }
                                        elseif ($bal->balance == 0)
                                        {
                                                $message = $this->school->message_initial . ' ' . $to . ', a sum of Ksh. ' . number_format($total->total) . ' has been received as a fee payment for ' . $sname . '. You do not have fee balance for this term. Thanks for being one of us';
                                        }
                                        else
                                        {
                                                $message = $this->school->message_initial . ' ' . $to . ', a sum of Ksh. ' . number_format($total->total) . ' has been received as a fee payment for ' . $sname . '. You have a fee balance of ' . number_format($bal->balance) . '. Thanks for being one of us';
                                        }

                                        $this->sms_m->send_sms($recipient, $message);
                                        redirect('admin/fee_payment/receipt/' . $rec_id);
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b style='color:red'>Sorry Parent cannot get notification since this student doesn't have Parent/Guardian details recorded in the system !!</b>"));
                                        redirect('admin/fee_payment/receipt/' . $rec_id);
                                }
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/fee_payment/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        $data['rec'] = $id;
                        $data['bank'] = $this->fee_payment_m->list_banks();
                        //load the view and the layout
                        $this->template->title('Add Fee Payment ')->build('admin/sus_pay', $data);
                }
        }

        /**
         * Get activate
         * 
         */
        function activate($id)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/admission/');
                }
                if (!$this->admission_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/admission');
                }

                $user = $this->ion_auth->get_user();
                $inv = $this->admission_m->fetch_inv($id);
                if ($inv)
                {
                        $finv = array(
                            'check_st' => 1,
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );
                        $this->admission_m->suspend_invoice($inv, $finv);
                }
                $form_data = array(
                    'status' => 1,
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );

                //Do update
                $this->admission_m->upd_parent($id, $form_data);
                $done = $this->admission_m->update_attributes($id, $form_data);

                
                if ($done)
                {
                        $this->worker->calc_balance($id);
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Student was successfully activated'));
                        redirect("admin/admission/");
                }
        }

        /**
         * Update Student Details from Ajax Wizard
         * 
         * @return boolean
         */
        function ajax_edit($id)
        {
                $pid = $this->input->post('pid');

                $pdata = array(
                    'first_name' => $this->input->post('parent_fname'),
                    'last_name' => $this->input->post('parent_lname'),
                    'email' => $this->input->post('parent_email'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                    'occupation' => $this->input->post('occupation'),
                    'mother_fname' => $this->input->post('mother_fname'),
                    'mother_lname' => $this->input->post('mother_lname'),
                    'mother_email' => $this->input->post('mother_email'),
                    'mother_phone' => $this->input->post('mother_phone'),
                    'mother_occupation' => $this->input->post('mother_occupation'),
                    'mother_address' => $this->input->post('mother_address'),
                    'modified_on' => time(),
                    'modified_by' => $this->ion_auth->get_user()->id
                );
                $sdata = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'dob' => strtotime($this->input->post('dob')),
                    'gender' => $this->input->post('gender'),
                    'allergies' => $this->input->post('allergies'),
                    'former_school' => $this->input->post('former_school'),
                    'entry_marks' => $this->input->post('entry_marks'),
                    'doctor_name' => $this->input->post('doctor_name'),
                    'doctor_phone' => $this->input->post('doctor_phone'),
                    'residence' => $this->input->post('residence'),
                    'house' => $this->input->post('house'),
                    'old_adm_no' => $this->input->post('old_adm_no'),
                    'photo' => $this->input->post('photo'),
                    'email' => $this->input->post('email'),
                    'admission_date' => strtotime($this->input->post('admission_date')),
                    'class' => $this->input->post('class'),
                    'modified_on' => time(),
                    'modified_by' => $this->ion_auth->get_user()->id
                );
                if ($pid)
                {
                        $this->admission_m->update_parent($pid, $pdata);
                        $psid = $this->admission_m->get_parent($pid)->user_id;

                        if ($this->input->post('photo'))
                        {
                                $sdata ['photo'] = $this->input->post('photo');
                        }
                        $sdata['parent_id'] = $pid;
                        $sdata['parent_user'] = $psid;
                        $res = $this->admission_m->update_attributes($id, $sdata);
                        return $res;
                }
                else
                {
                        $pemail = $this->input->post('parent_email');
                        $sch_info = explode('@', $this->school->email);
                        if (empty($pemail))
                        {
                                if (isset($sch_info[1]))
                                {
                                        $mail = $sch_info[1];
                                        $pemail = strtolower($this->input->post('parent_fname') . '@' . $mail);
                                }
                                else
                                {
                                        $suff = underscore($this->school->school);
                                        $pemail = $this->input->post('parent_fname') . '@' . $suff . '.com';
                                }
                        }
                        $p_username = strtolower($this->input->post('parent_fname')) . ' ' . strtolower($this->input->post('parent_lname'));
                        $ppassword = '12345678'; //temporary password - will require to be changed on first login
                        $additional = array(
                            'first_name' => $this->input->post('parent_fname'),
                            'last_name' => $this->input->post('parent_lname'),
                            'me' => 1
                        );
                        $pid = $this->ion_auth->register($p_username, $ppassword, $pemail, $additional);
                        if ($pid)
                        {
                                $this->ion_auth->add_to_group(6, $pid);

                                /* End Parent Add to Users */
                                $pdata = array(
                                    'first_name' => $this->input->post('parent_fname'),
                                    'last_name' => $this->input->post('parent_lname'),
                                    'email' => $pemail,
                                    'occupation' => $this->input->post('occupation'),
                                    'mother_fname' => $this->input->post('mother_fname'),
                                    'mother_lname' => $this->input->post('mother_lname'),
                                    'mother_email' => $this->input->post('mother_email'),
                                    'mother_phone' => $this->input->post('mother_phone'),
                                    'mother_occupation' => $this->input->post('mother_occupation'),
                                    'mother_address' => $this->input->post('mother_address'),
                                    'status' => 1,
                                    'user_id' => $pid,
                                    'phone' => $this->input->post('phone'),
                                    'address' => $this->input->post('address'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );

                                $ps_id = $this->admission_m->save_parent($pdata); //parent id

                                $sdata['parent_id'] = $ps_id;
                                $sdata['parent_user'] = $pid;
                                $res = $this->admission_m->update_attributes($id, $sdata);
                        }
                }
                return $this->worker->calc_balance($id);
        }

        function fix_history()
        {
                $hiss = $this->portal_m->make_history();
                echo '<pre>';
                print_r($hiss);
                echo '</pre>';
        }

        function sync()
        {
                $hiss = $this->portal_m->sync_history();
                echo '<pre>';
                print_r($hiss);
                echo '</pre>';
        }

        /**
         * Build up the Validation Config
         * 
         * @return array
         */
        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'first_name',
                        'label' => 'First Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'last_name',
                        'label' => 'Last Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'dob',
                        'label' => 'Dob',
                        'rules' => 'trim|xss_clean'),
                    array(
                        'field' => 'house',
                        'label' => 'house',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'residence',
                        'label' => 'residence',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'allergies',
                        'label' => 'allergies',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'mother_fname',
                        'label' => 'mother_fname',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'mother_lname',
                        'label' => 'mother_lname',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'mother_email',
                        'label' => 'mother_email',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'mother_phone',
                        'label' => 'mother_phone',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'mother_occupation',
                        'label' => 'mother_occupation',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'mother_address',
                        'label' => 'mother_address',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'former_school',
                        'label' => 'former_school',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'entry_marks',
                        'label' => 'entry_marks',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'doctor_name',
                        'label' => 'doctor_name',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'hospital',
                        'label' => 'hospital',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'doctor_phone',
                        'label' => 'doctor_phone',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'old_adm_no',
                        'label' => 'Old ADM No',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'gender',
                        'label' => 'Gender',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'email',
                        'label' => 'Student Email',
                        'rules' => 'trim|xss_clean|is_email|_valid_st_email'),
                    array(
                        'field' => 'admission_date',
                        'label' => 'Year',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'class',
                        'label' => 'Class',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'photo',
                        'label' => 'Photo',
                        'rules' => 'xss_clean')
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function ext_validation()
        {
                $config = array(
                    array(
                        'field' => 'parent_fname',
                        'label' => 'Parent First Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'parent_lname',
                        'label' => 'Parent Last Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'phone',
                        'label' => 'Parent Phone',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'parent_email',
                        'label' => 'Parent Email',
                        'rules' => 'is_email|trim'),
                    array(
                        'field' => 'address',
                        'label' => 'Address',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]')
                );
                $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
                return $config;
        }

        function _valid_email()
        {
                $sid = $this->input->post('parent_email');
                if ($this->admission_m->user_email_exists($sid))
                {
                        $this->form_validation->set_message('_valid_email', 'Parent Email already Exists.');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }

        function _valid_st_email()
        {
                $sid = $this->input->post('email');
                if ($this->admission_m->user_email_exists($sid))
                {
                        $this->form_validation->set_message('_valid_st_email', 'Student Email already Exists.');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }

        /**
         * Build up the Pagination Config for the Module
         * 
         * @return array
         */
        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/admission/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 88000000000;
                $config['total_rows'] = $this->admission_m->count();
                $config['uri_segment'] = 4;
                $config['first_link'] = lang('web_first');
                $config['first_tag_open'] = "<li>";
                $config['first_tag_close'] = '</li>';
                $config['last_link'] = lang('web_last');
                $config['last_tag_open'] = "<li>";
                $config['last_tag_close'] = '</li>';
                $config['next_link'] = FALSE;
                $config['next_tag_open'] = "<li>";
                $config['next_tag_close'] = '</li>';
                $config['prev_link'] = FALSE;
                $config['prev_tag_open'] = "<li>";
                $config['prev_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li class="active">  <a href="#">';
                $config['cur_tag_close'] = '</a></li>';
                $config['num_tag_open'] = "<li>";
                $config['num_tag_close'] = '</li>';
                $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
                $config['full_tag_close'] = '</ul></div>';
                //$choice = $config["total_rows"] / $config["per_page"];
                //$config["num_links"] = round($choice);

                return $config;
        }

        /**
         * Function to void student  - Updates admission table status to zero
         * 
         * @param int $id
         */
        function suspend($id)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/admission/');
                }
                if (!$this->admission_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/admission');
                }

                $user = $this->ion_auth->get_user();
                $inv = $this->admission_m->fetch_inv($id);
                if ($inv)
                {
                        $finv = array(
                            'check_st' => 3,
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );
                        $this->admission_m->suspend_invoice($inv, $finv);
                }

                $form_data = array(
                    'status' => 0,
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );

                //Do update
                $this->admission_m->upd_parent($id, $form_data);
                $done = $this->admission_m->update_attributes($id, $form_data);

                
                if ($done)
                {
                        $this->worker->calc_balance($id);
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Student was successfully suspended'));
                        redirect("admin/admission/");
                }
        }

        /**
         * Shows a Sane File Size 
         * 
         * @param double $kb
         * @param int $precision
         * @return double
         */
        function file_sizer($kb, $precision = 2)
        {
                $base = log($kb) / log(1024);
                $suffixes = array('', ' kb', ' MB', ' GB', ' TB');

                return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        /**
         * Return File Extension
         * 
         * @param string $filename
         * @return string
         */
        public function get_extension($filename)
        {
                $x = explode('.', $filename);
                return end($x);
        }

        function pick_students()
        {
                $keyw = $this->input->get('term');
                $lim = $this->input->get('page_limit');
                $results = $this->admission_m->pick_students($keyw, $lim);
                $fn = array();
                foreach ($results as $r)
                {
                        $fn[] = array('id' => (int) $r->id, 'text' => $r->first_name . ' ' . $r->last_name);
                }

                echo json_encode($fn);
        }

        /**
         * Helper For Email Validator
         */
        function check_unique_mail()
        {
                $field = $_REQUEST['fieldId'];
                $val = $_REQUEST['fieldValue'];

                /* RETURN VALUE */
                $json = array();
                $json[0] = $field;

                if (!$this->admission_m->user_email_exists($val))
                {
                        $json[1] = true;
                        echo json_encode($json);   // RETURN ARRAY WITH success
                }
                else
                {
                        $json[1] = false;
                        echo json_encode($json);  // RETURN ARRAY WITH ERROR
                }
        }

        /**
         * Upload Student Passport
         * 
         * @return json Status Information
         */
        public function save_photo()
        {
                $status = "";
                $msg = "";
                $pid = "";
                $file_element_name = 'userfile';
                $dest = FCPATH . "/uploads/student/" . date('Y') . '/';
                if (!is_dir($dest))
                {
                        mkdir($dest, 0777, true);
                }
                if ($status != "error")
                {
                        $config['upload_path'] = $dest;
                        $config['allowed_types'] = 'jpg|png';
                        $config['max_size'] = 1024 * 8;
                        $config['encrypt_name'] = FALSE;

                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload($file_element_name))
                        {
                                $status = 'error';
                                $msg = $this->upload->display_errors('', '');
                        }
                        else
                        {
                                $data = $this->upload->data();

                                $file_id = $this->admission_m->save_photo(
                                             array(
                                                 'filename' => $data['file_name'],
                                                 'filesize' => $this->file_sizer($data['file_size']),
                                                 'fpath' => 'student/' . date('Y') . '/',
                                                 'created_by' => $this->ion_auth->get_user()->id,
                                                 'created_on' => now()
                                ));
                                if ($file_id)
                                {
                                        $status = "success";
                                        $pid = $file_id;
                                        $msg = "File successfully uploaded";
                                }
                                else
                                {
                                        unlink($data['full_path']);
                                        $status = "error";
                                        $msg = "Something went wrong when saving the file, please try again.";
                                }
                        }
                        @unlink($_FILES[$file_element_name]);
                }
                echo json_encode(array('status' => $status, 'msg' => $msg, 'pid' => $pid));
        }

        private function pay_validation()
        {
                $config = array(
                    array(
                        'field' => 'payment_date[]',
                        'label' => 'Payment Date',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'reg_no',
                        'label' => 'Reg No',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'bank_slip[]',
                        'label' => 'Bank Slip',
                        'rules' => 'trim'),
                    array(
                        'field' => 'bank_id[]',
                        'label' => 'Bank',
                        'rules' => 'trim'),
                    array(
                        'field' => 'payment_method[]',
                        'label' => 'Payment Method',
                        'rules' => ''),
                    array(
                        'field' => 'transaction_no[]',
                        'label' => 'Transaction Number',
                        'rules' => 'trim'),
                    array(
                        'field' => 'description[]',
                        'label' => 'Description',
                        'rules' => 'trim'),
                    array(
                        'field' => 'amount[]',
                        'label' => 'Amount',
                        'rules' => 'required|trim|xss_clean|numeric|max_length[20]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

}
