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

                $this->load->model('fee_payment_m');
                $this->load->model('admission/admission_m');
                $this->load->model('sms/sms_m');

                $this->load->library('pmailer');
                $this->load->library('image_cache');
                $this->load->model('accounts/accounts_m');
                $valid = $this->portal_m->get_class_ids();
                if ($this->input->get('pw'))
                {
                        $pop = $this->input->get('pw');
                        //limit to available classes only
                        if (!in_array($pop, $valid))
                        {
                                $pop = $valid[0];
                        }
                        $this->session->set_userdata('pw', $pop);
                }
                else if ($this->session->userdata('pw'))
                {
                        $pop = $this->session->userdata('pw');
                }
                else
                {
                        //$pop = $valid[0];
                        //$this->session->set_userdata('pw', $pop);
                }
        }

        public function paid()
        {
                $data['bank'] = $this->fee_payment_m->list_banks();
                //load view
                $this->template->title(' Fee Payment ')->build('admin/list', $data);
        }

        /**
         * Fee Balances & statements
         */
        public function index()
        {
                //load view
                $this->template->title(' Fee Payment Status ')->build('admin/bal');
        }

        /**
         * Get Datatable
         * 
         */
        public function get_paid()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->fee_payment_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
                echo json_encode($output);
        }

        /**
         * Get Datatable
         * 
         */
        public function get_voided()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->fee_payment_m->get_voided($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
                echo json_encode($output);
        }

        /**
         * Fee Balances & statements
         */
        public function all_voided()
        {
                //load view
                $this->template->title(' Fee Payment Status ')->build('admin/voided');
        }

        /**
         * Get Datatable for Payment Status
         * 
         */
        public function get_by_student()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->fee_payment_m->get_bals($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
                echo json_encode($output);
        }

        /**
         * Send SMS to Specific Parents
         * 
         */
        public function bulk()
        {
                if ($this->input->post())
                {
                        $bal = $this->input->post('bal');
                        if ($bal)
                        {
                                if ($bal == 999999)
                                {
                                        $bal = 1; //coz filter_bal >=
                                }
                                $list = $this->fee_payment_m->filter_balance($bal);
                                $i = 0;
                                foreach ($list as $r)
                                {
                                        $i++;
                                        $adm = $this->worker->get_student($r->student);
                                        $stud = $adm->first_name . ' ' . $adm->last_name;
                                        $parent = $this->portal_m->get_parent($adm->parent_id);
                                        $phone = $parent->phone;
                                        $to = $parent->first_name;
                                        if (empty($phone))
                                        {
                                                $phone = $parent->mother_phone;
                                        }
                                        $message = $this->school->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee balance of ' . number_format($r->balance) . '. Kindly ensure it is paid. Thanks for choosing ' . $this->school->school;
                                        $this->sms_m->send_sms($phone, $message);
                                }

                                $this->session->set_flashdata('message', array('type' => 'info', 'text' => 'Found ' . $i . ' Students'));
                                redirect('admin/fee_payment/');
                        }
                }
                $data['page'] = '';

                $this->template->title('Bulk SMS Reminder')->build('admin/custom', $data);
        }

        //SEND REMINDER

        public function reminder($id = FALSE, $flag = FALSE)
        {
                $settings = $this->ion_auth->settings();
                $st_details = $this->fee_payment_m->get_student($id);
                $bal = $this->fee_payment_m->get_balance($id);
                $parent_details = $this->fee_payment_m->get_parent($st_details->parent_id);

                if (!empty($parent_details))
                {
                        $class = $this->ion_auth->list_classes();
                        $skul = $this->ion_auth->settings();
                        $recipient = $parent_details->phone;

                        $to = $parent_details->first_name;
                        $stud = $st_details->first_name . ' ' . $st_details->last_name;
                        if ($bal->balance < 0)
                        {
                                $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee overpay of ' . number_format($bal->balance) . ', this will be forwarded to next term. Thanks for choosing ' . $skul->school;
                        }
                        elseif ($bal->balance == 0)
                        {
                                $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has no fee balance. Thanks for choosing ' . $skul->school;
                        }
                        else
                        {
                                if ($flag)
                                {
                                        $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee balance of ' . number_format($bal->balance) . ', kindly ensure it is paid. ' . $skul->school;
                                }
                                else
                                {
                                        $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee balance of ' . number_format($bal->balance) . ', kindly ensure it is paid. Thanks for choosing ' . $skul->school;
                                }
                        }

                        $this->sms_m->send_sms($recipient, $message);
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Reminder Successfully Sent</b>"));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b style='color:red'>Sorry, the selected student doesn't have Parent/Guardian details !!</b>"));
                }
                if ($flag)
                {
                        redirect('admin/admission/inactive/');
                }
                else
                {
                        redirect('admin/fee_payment/');
                }
        }

        //SEND REMINDER WITHOUT BALANCE
        public function reminder_without_bal()
        {
                $settings = $this->ion_auth->settings();

                $student = $this->fee_payment_m->students_all_active_students();

                foreach ($student as $st_details)
                {

                        $bal = $this->fee_payment_m->get_balance($st_details->id);

                        $parent_details = $this->fee_payment_m->get_parent($st_details->parent_id);

                        if (!empty($parent_details))
                        {
                                $class = $this->ion_auth->list_classes();
                                $skul = $this->ion_auth->settings();

                                $recipient = $parent_details->phone;
                                $country_code = '254';
                                $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                                $to = $parent_details->first_name;
                                $count = 0;
                                $count += count($parent_details);

                                $stud = $st_details->first_name . ' ' . $st_details->last_name;

                                if ($bal->balance > 0)
                                {
                                        $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee balance, kindly ensure it is paid. Thank you for choosing ' . $skul->school;

                                        print_r($message);
                                        die;
                                        //$this->sms_m->send_sms($recipient, $message);
                                        //$this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Reminder Successfully Sent. </b><span style='color:#fff; '>( Number of Parents Notified " . $count . ')</span>'));
                                }
                        }
                        else
                        {
                                //Do Nothing
                        }
                }
                redirect('admin/fee_payment');
        }

        //SEND REMINDER PLUS BALANCE

        public function reminder_with_bal()
        {

                $settings = $this->ion_auth->settings();

                $student = $this->fee_payment_m->students_all_active_students();

                //print_r($student);die;

                foreach ($student as $st_details)
                {

                        $bal = $this->fee_payment_m->get_balance($st_details->id);

                        $parent_details = $this->fee_payment_m->get_parent($st_details->parent_id);

                        if (!empty($parent_details))
                        {
                                $class = $this->ion_auth->list_classes();
                                $skul = $this->ion_auth->settings();

                                $recipient = $parent_details->phone;

                                $to = $parent_details->first_name;
                                $count = 0;
                                $count += count($parent_details);

                                $stud = $st_details->first_name . ' ' . $st_details->last_name;

                                if ($bal->balance > 0)
                                {
                                        $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee balance of ' . number_format($bal->balance) . ', kindly ensure it is paid. Thank you for choosing ' . $skul->school;
                                        print_r($message);
                                        die;
                                        //$this->sms_m->send_sms($recipient, $message);
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Reminder Successfully Sent. </b><span style='color:#fff; '>( Number of Parents Notified " . $count . ')</span>'));
                                }
                        }
                        else
                        {
                                //Do Nothing
                        }
                }
                redirect('admin/fee_payment');
        }

        //Good 

        function view($id)
        {
                redirect('admin/fee_payment/receipt/' . $id);
                if (!$this->fee_payment_m->exists($id))
                {
                        redirect('admin/fee_payment');
                }
                $data['title'] = 'Fee Statement';
                $data['post'] = $this->fee_payment_m->get($id);
                $data['banks'] = $this->fee_payment_m->banks();

                $this->template->title(' Fee payment')->build('admin/view', $data);
        }

        /**
         * Student Fee Statement
         * 
         * @param int $id
         */
        function statement($id)
        {
                if (!$this->fee_payment_m->student_exists($id))
                {
                        redirect('admin/fee_payment');
                }

                $post = $this->fee_payment_m->get_student($id);
                $data['banks'] = $this->fee_payment_m->banks();
                $data['post'] = $post;
                $data['class'] = $this->portal_m->fetch_class($post->class);
                $data['cl'] = $this->portal_m->get_class_options();
                $data['arrs'] = $this->fee_payment_m->fetch_total_arrears($id);
                $data['extras'] = $this->fee_payment_m->all_fee_extras();

                $payload = $this->worker->process_statement($id);

                $data['payload'] = $payload;
                $this->template->title(' Fee Statement')->build('admin/statement', $data);
        }

        function receipt($rec_id)
        {
                if (!$this->fee_payment_m->exists_receipt($rec_id))
                {
                        redirect('admin/fee_payment');
                }

                $data['extras'] = $this->fee_payment_m->all_fee_extras();
                $data['title'] = 'Fee Receipt';
                $data['total'] = $this->fee_payment_m->total_payment($rec_id);
                $data['p'] = $this->fee_payment_m->get_pays($rec_id);
                $post = $this->fee_payment_m->get_row_time($rec_id);
                $data['post'] = $post;

                $data['banks'] = $this->fee_payment_m->banks();
                $classes = $this->ion_auth->list_classes();
                $streams = $this->ion_auth->get_stream();
                $ccc = $this->fee_payment_m->get_student($post->reg_no);
                if (!isset($ccc->class))
                {
                        $sft = ' - ';
                        $st = ' - ';
                }
                else
                {
                        $crow = $this->portal_m->fetch_class($ccc->class);
                        if (!$crow)
                        {
                                $sft = ' - ';
                                $st = ' - ';
                        }
                        else
                        {
                                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
                        }
                }
                $data['class'] = $sft . '  ' . $st;
                $rect = $this->fee_payment_m->fetch_receipt($rec_id);
                $data['fee'] = $this->fee_payment_m->fetch_balance($rect->student);
                $this->template->title(' Fee payment')->build('admin/receipt', $data);
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                $next = $this->fee_payment_m->get_last_id();
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $settings = $this->ion_auth->settings();

                        $user = $this->ion_auth->get_user();
                        $length = $this->input->post('payment_date');
                        $size = count($length);

                        $now = time();
                        $t_array = $this->input->post('amount');
                        $total = array_sum($t_array);

                        $reg = $this->input->post('reg_no');
                        $receipt = array(
                            'total' => $total,
                            'student' => $reg,
                            'created_by' => $user->id,
                            'created_on' => $now
                        );
                        $payment_date = $this->input->post('payment_date');
                        $amount = $this->input->post('amount');
                        //Handle Accidental Double Click
                        if ($this->fee_payment_m->has_paid($reg, $amount, $payment_date))
                        {
                                redirect('admin/fee_payment/');
                        }
                        $rec_id = $this->fee_payment_m->insert_rec($receipt);

                        $payment_method = $this->input->post('payment_method');
                        $transaction_no = $this->input->post('transaction_no');
                        $bank_id = $this->input->post('bank_id');
                        $description = $this->input->post('description');
                        $totm = 0;
                        for ($i = 0; $i < $size; ++$i)
                        {
                                $bank_slip = '';
                                if (!empty($_FILES['bank_slip']['name']))
                                {
                                        $this->load->library('files_uploader');
                                        $upload_data = $this->files_uploader->upload('bank_slip');
                                        $bank_slip = $upload_data['file_name'];
                                }

                                $table_list = array(
                                    'payment_date' => strtotime($payment_date[$i]),
                                    'reg_no' => $reg,
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
                                $pid = $this->fee_payment_m->create($table_list);
                                $totm += $amount[$i];
                        }

                        if ($pid)
                        {
                                $total = $this->fee_payment_m->total_payment($rec_id);
                                $st = $this->worker->get_student($reg);
                                $stud = $st->first_name . ' ' . $st->last_name;

                                //update student Balance
                                $this->worker->calc_balance($reg);

                                $paro = $this->admission_m->find($reg);
                                $bal = $this->fee_payment_m->get_balance($reg);

                                $member = $this->ion_auth->get_single_parent($paro->parent_id);
                                if (!empty($member))
                                {
                                        $to = $member->first_name;

                                        if ($bal->balance < 0)
                                        {
                                                $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received ' . number_format($total->total) . ' being fee payment for ' . $stud . '. You have an overpay of ' . number_format($bal->balance) . '. Thanks for choosing ' . $settings->school;
                                        }
                                        elseif ($bal->balance == 0)
                                        {
                                                $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received  ' . number_format($total->total) . ' being fee payment for ' . $stud . '. Your balance is 0.00. Thanks for choosing ' . $settings->school;
                                        }
                                        else
                                        {
                                                $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received  ' . number_format($total->total) . ' being fee payment for ' . $stud . '. Your balance is ' . number_format($bal->balance) . '. Thanks for choosing ' . $settings->school;
                                        }

                                        $this->sms_m->send_sms($member->phone, $message);
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

                        $data['next'] = $next;
                        $data['result'] = $get;
                        $data['bank'] = $this->fee_payment_m->list_banks();
                        $data['extras'] = $this->fee_payment_m->all_fee_extras();
                        //load the view and the layout
                        $this->template->title('Add Fee Payment ')->build('admin/create', $data);
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                // redirect('admin/fee_payment/');
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_payment/');
                }
                if (!$this->fee_payment_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_payment');
                }
                //search the item to show in edit form
                $get = $this->fee_payment_m->find($id);

                //Rules for validation
                $this->form_validation->set_rules($this->validation_edit());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $data['fee_payment_m'] = $this->fee_payment_m->find($id);

                        $this->load->library('upload');
                        $this->load->library('image_lib');

                        $user = $this->ion_auth->get_user();
                        // build array for the model

                        $form_data = array(
                            'payment_date' => strtotime($this->input->post('payment_date')),
                            'amount' => $this->input->post('amount'),
                            'payment_method' => $this->input->post('payment_method'),
                            'transaction_no' => $this->input->post('transaction_no'),
                            'bank_id' => $this->input->post('bank_id'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );
                        //find the item to update
                        $done = $this->fee_payment_m->update_attributes($id, $form_data);



                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/fee_payment/paid");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/fee_payment/paid");
                        }
                }
                else
                {
                        foreach (array_keys($this->validation()) as $field)
                        {
                                if (isset($_POST[$field]))
                                {
                                        $get->$field = $this->form_validation->$field;
                                }
                        }
                }
                $data['result'] = $get;
                $data['bank'] = $this->fee_payment_m->list_banks();
                //load the view and the layout
                $this->template->title('Edit Fee Payment ')->build('admin/data_edit', $data);
        }

        function void($id)
        {

//redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_payment/');
                }

                if (!$this->fee_payment_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_payment');
                }


                $user = $this->ion_auth->get_user();

                //search the item 
                $get = $this->fee_payment_m->find($id);

                //Get Receipt details
                $rec = $this->fee_payment_m->fetch_receipt($get->receipt_id);
                //Balance from Receipt
                $reduce_amount = $rec->total - $get->amount;

                $form_data = array(
                    'status' => 0,
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );

                $this->fee_payment_m->update_attributes($id, $form_data);

                $update_fee_receipt = array(
                    'total' => $reduce_amount,
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );

                $done = $this->fee_payment_m->update_fee_receipt($rec->id, $update_fee_receipt);


                if ($done)
                {

                        $this->worker->calc_balance($rec->student);
                        $this->worker->log_journal(0, 'fee_payment', $id, array(1101 => 'debit', 1102 => 'credit'), 999);
                        /**
                         * * Reduce accounts chart by the balance 
                         * * Update Accounts Chart Balances
                         * */
                        $get_account = $this->accounts_m->get_by_code(200);

                        $balance = $get_account->balance;
                        $initial_amount = $get->amount;
                        $actual_amt = $balance - $initial_amount;

                        $bal_details = array(
                            'balance' => $actual_amt,
                            'modified_by' => $user->id,
                            'modified_on' => time());
                        $this->accounts_m->update_attributes($get_account->id, $bal_details);

                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Record successfully voided'));
                        redirect("admin/fee_payment/paid");
                }
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'payment_date[]',
                        'label' => 'Payment Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'reg_no',
                        'label' => 'Reg No',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
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
                        'rules' => 'required'),
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

        private function validation_edit()
        {
                $config = array(
                    array(
                        'field' => 'payment_date[]',
                        'label' => 'Payment Date',
                        'rules' => 'required|xss_clean'),
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
                        'rules' => 'required'),
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

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/fee_payment/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 300;
                $config['total_rows'] = $this->fee_payment_m->count();
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
                $choice = $config["total_rows"] / $config["per_page"];
//$config["num_links"] = round($choice);

                return $config;
        }

        /**
         * Fix Payments to Receipts
         * insert records from payments table into newly created receipts table
         * to allow multiple payments for one receipt
         * 
         */
        function fee_fix()
        {
                //count_payments
                $tot = $this->fee_payment_m->count();
                //group into receipts
                $fn = $this->fee_payment_m->get_id_pay();
                //$recs = $this->fee_payment_m->get_grouped_pay();
                $i = 0;
                $j = 0;
                foreach ($fn as $student => $fee)
                {
                        foreach ($fee as $date => $ids)
                        {
                                $tot = 0;
                                foreach ($ids as $id)
                                {
                                        //fetch total
                                        $tot += $this->fee_payment_m->get($id)->amount;
                                }
                                $receipt = array(
                                    'student' => $student,
                                    'total' => $tot,
                                    'created_on' => now(),
                                    'created_by' => 1
                                );
                                $receipt_id = $this->fee_payment_m->insert_rec($receipt);
                                if ($receipt_id)
                                {
                                        $i++;
                                        //update receipt Ids
                                        foreach ($ids as $kid)
                                        {
                                                $dta = array(
                                                    'receipt_id' => $receipt_id,
                                                    'modified_on' => now(),
                                                    'modified_by' => 1
                                                );
                                                $tot += $this->fee_payment_m->update_attributes($kid, $dta);
                                                $j++;
                                        }
                                }
                        }
                }
                echo '<pre>';
                echo 'Made ' . $i . ' Receipts for ' . $j . ' Payments';
                echo '</pre>';
        }

}
