<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends Admin_Controller
    {

         function __construct()
         {
              parent::__construct();
              /* $this->template->set_layout('default');
                $this->template->set_partial('sidebar', 'partials/sidebar.php')
                ->set_partial('top', 'partials/top.php'); */

              if (!$this->ion_auth->logged_in())
              {
                   redirect('admin/login');
              }

              $this->load->model('accounts_m');

              /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
                {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                redirect('admin');
                } */
         }

         public function index()
         {


              $config = $this->set_paginate_options();  //Initialize the pagination class
              $this->pagination->initialize($config);

              $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

              $data['accounts'] = $this->accounts_m->paginate_all($config['per_page'], $page);

              //create pagination links
              $data['links'] = $this->pagination->create_links();

              //page number  variable
              $data['page'] = $page;
              $data['per'] = $config['per_page'];

              //load view
              $this->template->title(' Accounts ')->build('admin/list', $data);
         }

         public function trial()
         {
              $accounts = $this->worker->fetch_accounts();
              $data['accounts'] = $accounts;

              //load view
              $this->template->title('Accounts - Trial Balance')->build('admin/trialb', $data);
         }

         public function pnl()
         {
              $accounts = $this->worker->fetch_pnl();
              $data['accounts'] = $accounts;

              //load view
              $this->template->title('Accounts - Profit & Loss')->build('admin/pnl', $data);
         }

         public function balance()
         {
              $data['sheet'] = $this->worker->fetch_bsheet();

              //load view
              $this->template->title('Accounts - Balance Sheet')->build('admin/balance_sheet', $data);
         }

         function create($page = NULL)
         {

              /* if (!$this->ion_auth->is_in_group($this->user->id, 1))
                {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                redirect('admin/admission/my_students');
                } */
              //create control variables
              $data['updType'] = 'create';

              $data['account_types'] = $this->accounts_m->populate('account_types', 'id', 'name');

              $data['tax_config'] = $this->accounts_m->populate('tax_config', 'id', 'name');
              $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

              //Rules for validation
              $this->form_validation->set_rules($this->validation());

              //validate the fields of form
              if ($this->form_validation->run())
              {         //Validation OK!
                   $user = $this->ion_auth->get_user();
                   $form_data = array(
                           'name' => $this->input->post('name'),
                           'code' => $this->input->post('code'),
                           'account_type' => $this->input->post('account_type'),
                           'tax' => $this->input->post('tax'),
                           'balance' => $this->input->post('balance'),
                           'created_by' => $user->id,
                           'created_on' => time()
                   );

                   $ok = $this->accounts_m->create($form_data);

                   if ($ok) 
                   {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                   }

                   redirect('admin/accounts/');
              }
              else
              {
                   $get = new StdClass();
                   foreach ($this->validation() as $field)
                   {
                   $get->{$field['field']} = set_value($field['field']);
                   }

                   $data['result'] = $get;
                   //load the view and the layout
                   $this->template->title('Add Accounts ')->build('admin/create', $data);
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

              $output = $this->accounts_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
              echo json_encode($output);
         }

         function edit($id = FALSE, $page = 0)
         {

              /* if (!$this->ion_auth->is_in_group($this->user->id, 1))
                {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                redirect('admin/admission/my_students');
                } */

              //get the $id and sanitize
              $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

              $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

              //redirect if no $id
              if (!$id)
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/accounts/');
              }
              if (!$this->accounts_m->exists($id))
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/accounts');
              }
              //search the item to show in edit form
              $get = $this->accounts_m->find($id);
              //variables for check the upload
              $form_data_aux = array();
              $files_to_delete = array();
              $data['account_types'] = $this->accounts_m->populate('account_types', 'id', 'name');

              $data['tax_config'] = $this->accounts_m->populate('tax_config', 'id', 'name');

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
                           'name' => $this->input->post('name'),
                           'code' => $this->input->post('code'),
                           'account_type' => $this->input->post('account_type'),
                           'tax' => $this->input->post('tax'),
                           'balance' => $this->input->post('balance'),
                           'modified_by' => $user->id,
                           'modified_on' => time());

                   //add the aux form data to the form data array to save
                   $form_data = array_merge($form_data_aux, $form_data);

                   //find the item to update

                   $done = $this->accounts_m->update_attributes($id, $form_data);

                   
                   if ($done)
                   {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                        redirect("admin/accounts/");
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                        redirect("admin/accounts/");
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
              $this->template->title('Edit Accounts ')->build('admin/create', $data);
         }
 
          private function validation()
         {
              $config = array(
                      array(
                              'field' => 'name',
                              'label' => 'Name',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'code',
                              'label' => 'Code',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'account_type',
                              'label' => 'Account Type',
                              'rules' => 'required|xss_clean'),
                      array(
                              'field' => 'tax',
                              'label' => 'Tax',
                              'rules' => 'required|xss_clean'),
                      array(
                              'field' => 'balance',
                              'label' => 'Balance',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
              );
              $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
              return $config;
         }

         private function set_paginate_options()
         {
              $config = array();
              $config['base_url'] = site_url() . 'admin/accounts/index/';
              $config['use_page_numbers'] = TRUE;
              $config['per_page'] = 10;
              $config['total_rows'] = $this->accounts_m->count();
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
    