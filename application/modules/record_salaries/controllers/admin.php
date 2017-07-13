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
                $this->load->model('record_salaries_m');
                $this->load->model('advance_salary/advance_salary_m');
                $this->load->model('accounts/accounts_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['record_salaries'] = $this->record_salaries_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                //load view
                $this->template->title(' Processed Salaries ')->build('admin/list', $data);
        }

        //List all processed salaries
        function employees($id)
        {
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                //page number  variable
                $data['page'] = $page;
                $data['record_salaries'] = $this->record_salaries_m->get_all($id);
                //load view
                $this->template->title(' Processed Salaries ')->build('admin/employees', $data);
        }

        //List all processed salaries
        function my_slips()
        {
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                //page number  variable
                $data['page'] = $page;
                $data['record_salaries'] = $this->record_salaries_m->get_my_slip();
                //load view
                $this->template->title(' My Salaries Slips')
                             ->set_layout('teachers')
                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                             ->build('admin/employees', $data);
        }

        function slip($id)
        {
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                //page number  variable
                $data['page'] = $page;
                $data['post'] = $this->record_salaries_m->find($id);
                $data['tax'] = $this->record_salaries_m->get_tax();
                $data['ranges'] = $ranges = $this->record_salaries_m->get_paye_ranges();
                $data['paye'] = $this->record_salaries_m->populate('paye', 'id', 'tax');
                //load view
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Pay Slip')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/slip', $data);
                }
                else
                {
                        $this->template->title(' Pay Slip ')->build('admin/slip', $data);
                }
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                $data['employees'] = $this->record_salaries_m->list_employees();
                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                //validate the fields of form
                if ($this->form_validation->run())
                {
                        //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $ranges = $this->record_salaries_m->get_paye_ranges();

                        if ($this->input->post('salo') == 0)
                        {
                                $emp = $this->input->post('employee');
                                //Get employee salary details
                                $post = $this->record_salaries_m->salary_details($emp);

                                //Check if there is advance salary
                                $advance = $this->record_salaries_m->get_advance($emp);
                                $adv = 0;
                                if ($advance)
                                {
                                        $adv = $advance->amount;
                                }
                                //Get Deductions and Allowances
                                //--------------DEDUCTIONS DETAILS ----------///
                                $deductions = $this->record_salaries_m->salary_deductions($post->id);
                                $the_deductions = 0;
                                $dedcs = 0;
                                if (!empty($deductions))
                                {
                                        $total_deductions = $this->record_salaries_m->total_deductions($post->id);
                                        //Deductions details
                                        $decs_arr = array();
                                        $decs_ids = array();
                                        $dec_details = $this->record_salaries_m->list_deductions();
                                        foreach ($deductions as $dec)
                                        {
                                                $decs_ids[] = $dec->deduction_id;
                                                $decs_arr[] = $dec_details[$dec->deduction_id];
                                        }
                                        $dedcs = implode(',', $decs_arr);
                                        //$total_deductions = $this->record_salaries_m->total_deductions($decs_ids);
                                        $the_deductions = $total_deductions->totals;
                                }
                                //----------------Allowances details--------------------------///
                                $allowances = $this->record_salaries_m->salary_allowances($post->id);
                                $the_allowance = 0;
                                $allwnces = 0;
                                if (!empty($allowances))
                                {
                                        $all_arr = array();
                                        $all_ids = array();
                                        $all_details = $this->record_salaries_m->list_allowances();
                                        foreach ($allowances as $alls)
                                        {
                                                $all_ids[] = $alls->allowance_id;
                                                $all_arr[] = $all_details[$alls->allowance_id];
                                        }
                                        $allwnces = implode(',', $all_arr);
                                        //Get Total Allowances
                                        $total_allowances = $this->record_salaries_m->total_allowances($all_ids);
                                        $the_allowance = $total_allowances->totals;
                                }
                                //------OTHER DETAILS ----------------///
                                $bank_d = $post->bank_name . '<br>' . $post->bank_account_no;
                                $j = 0;
                                $wtx = 0;
                                foreach ($ranges as $n)
                                {
                                        $j++;
                                        if ($j == count($ranges)) //5
                                        {
                                                $ramount = $post->basic_salary - ($n->range_from - 1);
                                                $rtx = $ramount * ($n->tax / 100);
                                        }
                                        else
                                        {
                                                if ($post->basic_salary >= $n->range_to)
                                                {
                                                        $rtx = $n->amount * ($n->tax / 100);
                                                }
                                        }
                                        $wtx += $rtx;
                                }

                                // <editor-fold defaultstate="collapsed" desc="comment">
                                $form_data = array(
                                    'salary_date' => strtotime($this->input->post('salary_date')),
                                    'month' => $this->input->post('month'),
                                    'year' => $this->input->post('year'),
                                    'paye' => $wtx,
                                    'employee' => $emp,
                                    'basic_salary' => $post->basic_salary,
                                    'nhif' => $post->nhif,
                                    'staff_deduction' => $post->staff_deduction,
                                    'bank_details' => $bank_d,
                                    'advance' => $adv,
                                    'deductions' => $dedcs,
                                    'total_deductions' => $the_deductions,
                                    'allowances' => $allwnces,
                                    'total_allowance' => $the_allowance,
                                    'nhif_no' => $post->nhif_no,
                                    'nssf_no' => $post->nssf_no,
                                    'salary_method' => $post->salary_method,
                                    'comment' => $this->input->post('comment'),
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                ); // </editor-fold>

                                $ok = $this->record_salaries_m->create($form_data);
                                if ($ok) 
                                {
                                        //Calculate total amount paid as salary
                                        $tax = $this->record_salaries_m->get_tax();
                                        $tax_ded = ($post->basic_salary * $tax->amount) / 100;
                                        $total_salay_paid = ($post->basic_salary + $tax_ded + $total_deductions->totals + $total_allowances->totals + $post->nhif) - ($adv);
                                        /**
                                         *  Add amount paid to Salaries and Wages Account (Expense)
                                         * */
                                        $wg_account = $this->accounts_m->get_by_code(477);
                                        $wbalance = $wg_account->balance;
                                        $wbal = $wbalance + $total_salay_paid;
                                        $bal_details = array(
                                            'balance' => $wbal,
                                            'modified_by' => $user->id,
                                            'modified_on' => time());
                                        $this->accounts_m->update_attributes($wg_account->id, $bal_details);
                                        /**
                                         * Reduce amount paid from Fee Payment account (Revenue)
                                         * */
                                        $sal_account = $this->accounts_m->get_by_code(200);
                                        $balance = $sal_account->balance;
                                        $bal = $balance - $total_salay_paid;
                                        $balsal = array(
                                            'balance' => $bal,
                                            'modified_by' => $user->id,
                                            'modified_on' => time());
                                        $this->accounts_m->update_attributes($sal_account->id, $balsal);
                                        /**
                                         * *Update Advance salary with the amount paid
                                         * */
                                        $update_status = array(
                                            'status' => 0,
                                            'modified_by' => $user->id,
                                            'modified_on' => time());
                                        $this->advance_salary_m->update_attributes($advance->id, $update_status);
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                }
                                redirect('admin/record_salaries/');
                        }
                        elseif ($this->input->post('salo') == 1)
                        {
                                //Bulk Salary Processing
                                $all_emps = $this->record_salaries_m->get_employees();
                                foreach ($all_emps as $post)
                                {
                                        $advance = $this->record_salaries_m->get_advance($post->employee);
                                        //Check if there is advance salary
                                        $adv = 0;
                                        if ($advance)
                                        {
                                                $adv = $advance->amount;
                                        }

                                        //Get Deductions and Allowances
                                        //--------------DEDUCTIONS DETAILS ----------///
                                        $deductions = $this->record_salaries_m->salary_deductions($post->id);
                                        $the_deductions = 0;
                                        $dedcs = 0;
                                        if (!empty($deductions))
                                        {
                                                // $total_deductions = $this->record_salaries_m->total_deductions($post->id);
                                                //Deductions details
                                                $decs_arr = array();
                                                $decs_ids = array();
                                                $dec_details = $this->record_salaries_m->list_deductions();
                                                foreach ($deductions as $dec)
                                                {
                                                        $decs_ids[] = $dec->deduction_id;
                                                        $decs_arr[] = $dec_details[$dec->deduction_id];
                                                }
                                                $dedcs = implode(',', $decs_arr);
                                                //Get Total Deductions
                                                $total_deductions = $this->record_salaries_m->total_deductions($decs_ids);
                                                $the_deductions = $total_deductions->totals;
                                        }
                                        //----------------Allowances details--------------------------///
                                        $allowances = $this->record_salaries_m->salary_allowances($post->id);
                                        $the_allowance = 0;
                                        $allwnces = 0;
                                        if (!empty($allowances))
                                        {
                                                $all_arr = array();
                                                $all_ids = array();
                                                $all_details = $this->record_salaries_m->list_allowances();
                                                foreach ($allowances as $alls)
                                                {
                                                        $all_ids[] = $alls->allowance_id;
                                                        $all_arr[] = $all_details[$alls->allowance_id];
                                                }
                                                $allwnces = implode(',', $all_arr);
                                                //Get Total Allowances
                                                $total_allowances = $this->record_salaries_m->total_allowances($all_ids);
                                                $the_allowance = $total_allowances->totals;
                                        }
                                        //------OTHER DETAILS ----------------///
                                        $bank_d = $post->bank_name . '<br>' . $post->bank_account_no;
                                        // <editor-fold defaultstate="collapsed" desc="comment">
                                        $form_data = array(
                                            'salary_date' => strtotime($this->input->post('salary_date')),
                                            'month' => $this->input->post('month'),
                                            'year' => $this->input->post('year'),
                                            'employee' => $post->employee,
                                            'basic_salary' => $post->basic_salary,
                                            'paye' => isset($post->paye) ? $post->paye : '',
                                            'staff_deduction' => $post->staff_deduction,
                                            'nhif' => $post->nhif,
                                            'bank_details' => $bank_d,
                                            'advance' => $adv,
                                            'deductions' => $dedcs,
                                            'total_deductions' => $the_deductions,
                                            'allowances' => $allwnces,
                                            'total_allowance' => $the_allowance,
                                            'nhif_no' => $post->nhif_no,
                                            'nssf_no' => $post->nssf_no,
                                            'salary_method' => $post->salary_method,
                                            'comment' => $this->input->post('comment'),
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        // </editor-fold>
                                        $ok = $this->record_salaries_m->create($form_data);
                                        //Calculate total amount paid as salary
                                        $tax = $this->record_salaries_m->get_tax();
                                        $tax_ded = ($post->basic_salary * $tax->amount) / 100;
                                        $total_salay_paid = ($post->basic_salary + $tax_ded + $total_deductions->totals + $total_allowances->totals + $post->nhif) - ($adv);
                                        /**
                                         * * Add amount paid to Salaries and Wages Account (Expense)
                                         * */
                                        $get_account = $this->accounts_m->get_by_code(477);
                                        $balance = $get_account->balance;
                                        $bal = $balance + $total_salay_paid;
                                        $bal_details = array(
                                            'balance' => $bal,
                                            'modified_by' => $user->id,
                                            'modified_on' => time());
                                        $this->accounts_m->update_attributes($get_account->id, $bal_details);
                                        /**
                                         * * Reduce amount paid from Fee Payment account (Revenue)
                                         * */
                                        $get_account = $this->accounts_m->get_by_code(200);
                                        $balance = $get_account->balance;
                                        $bal = $balance - $total_salay_paid;
                                        $bal_details = array(
                                            'balance' => $bal,
                                            'modified_by' => $user->id,
                                            'modified_on' => time());
                                        $this->accounts_m->update_attributes($get_account->id, $bal_details);
                                        //Update Salary account
                                        $update_status = array(
                                            'status' => 0,
                                            'modified_by' => $user->id,
                                            'modified_on' => time());
                                        if (isset($advance->id) && $advance->id)
                                        {
                                                $this->advance_salary_m->update_attributes($advance->id, $update_status);
                                        }
                                }
                                if ($ok) 
                                {
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                }
                                redirect('admin/record_salaries/');
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => '<b style="color:red">Select Process Type!!</b>'));
                                redirect('admin/record_salaries/create/1');
                        }
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $prop = $field['field'];
                                $get->$prop = set_value($field['field']);
                        }
                        $data['result'] = $get;
                        //load the view and the layout
                        $this->template->title('Add Record Salaries ')->build('admin/create', $data);
                }
        }

        function edit_removed($id = FALSE, $page = 0)
        {
                /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
                  {
                  $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                  redirect('admin');
                  } */
                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/record_salaries/');
                }
                if (!$this->record_salaries_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/record_salaries');
                }
                //search the item to show in edit form
                $get = $this->record_salaries_m->find($id);
                //variables for check the upload
                $form_data_aux = array();
                $files_to_delete = array();
                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;
                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'salary_date' => strtotime($this->input->post('salary_date')),
                            'employee' => $this->input->post('employee'),
                            'comment' => $this->input->post('comment'),
                            'modified_by' => $user->id,
                            'modified_on' => time());
                        //add the aux form data to the form data array to save
                        $form_data = array_merge($form_data_aux, $form_data);
                        //find the item to update
                        $done = $this->record_salaries_m->update_attributes($id, $form_data);
                        
                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/record_salaries/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/record_salaries/");
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
                //load the view and the layout
                $this->template->title('Edit Record Salaries ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
                  {
                  $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                  redirect('admin');
                  } */
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/record_salaries');
                }
                //search the item to delete
                if (!$this->record_salaries_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/record_salaries');
                }
                //delete the item
                if ($this->record_salaries_m->delete($id) == TRUE)
                {
                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }
                redirect("admin/record_salaries/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'salary_date',
                        'label' => 'Salary Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'employee',
                        'label' => 'Employee',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'month',
                        'label' => 'month',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'year',
                        'label' => 'year',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'comment',
                        'label' => 'Comment',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/record_salaries/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 20;
                $config['total_rows'] = $this->record_salaries_m->count();
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

}
