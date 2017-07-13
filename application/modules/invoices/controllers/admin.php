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

              $this->load->model('invoices_m');
         }

         public function index()
         {
              $data['page'] = '';
              //load view
              $this->template->title('Fee Invoices ')->build('admin/list', $data);
         }

         function create($page = NULL)
         {
              redirect('admin/invoices');
              //create control variables
              $data['updType'] = 'create';
              $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

              //Rules for validation
              $this->form_validation->set_rules($this->validation());

              //validate the fields of form
              if ($this->form_validation->run())
              {         //Validation OK!
                   $user = $this->ion_auth->get_user();
                   $form_data = array(
                           'term' => $this->input->post('term'),
                           'invoice_no' => $this->input->post('invoice_no'),
                           'fee_id' => $this->input->post('fee_id'),
                           'student_id' => $this->input->post('student_id'),
                           'check' => $this->input->post('check'),
                           'created_by' => $user->id,
                           'created_on' => time()
                   );

                   $ok = $this->invoices_m->create($form_data);

                   if ($ok) 
                   {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                   }

                   redirect('admin/invoices/');
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
                   $this->template->title('Add Invoices ')->build('admin/create', $data);
              }
         }

         function edit($id = FALSE, $page = 0)
         {
              redirect('admin/invoices');
              //get the $id and sanitize
              $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
              $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

              //redirect if no $id
              if (!$id)
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/invoices/');
              }
              if (!$this->invoices_m->exists($id))
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/invoices');
              }
              //search the item to show in edit form
              $get = $this->invoices_m->find($id);

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
                           'term' => $this->input->post('term'),
                           'invoice_no' => $this->input->post('invoice_no'),
                           'fee_id' => $this->input->post('fee_id'),
                           'student_id' => $this->input->post('student_id'),
                           'check' => $this->input->post('check'),
                           'modified_by' => $user->id,
                           'modified_on' => time());

                   $done = $this->invoices_m->update_attributes($id, $form_data);

                   
                   if ($done)
                   {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                        redirect("admin/invoices/");
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                        redirect("admin/invoices/");
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
              $this->template->title('Edit Invoices ')->build('admin/create', $data);
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
              if ($this->worker->get_version() == 1)
              {
                   $output = $this->invoices_m->get_qb_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
              }
              else
              {
                   $output = $this->invoices_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
              }
              echo json_encode($output);
         }

         function void($id = 0)
         {
              if (!$this->worker->qb)
              {
                   return FALSE;
              }
              //redirect if its not correct
              if (!$id)
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/invoices');
              }

              //search the item to delete
              if (!$this->invoices_m->iv_exists($id))
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/invoices');
              }

              $iv = $this->invoices_m->fetch_iv($id);
              $lines = $this->invoices_m->fetch_iv_item($id);
              $tempiv = $this->invoices_m->fetch_temp_iv($iv->txn_id);
              $tempivlines = $this->invoices_m->fetch_temp_ivlines($iv->txn_id);

              if ($iv && $lines && $tempiv && $tempivlines)
              {
                   //clear items
                   $this->invoices_m->clear_invoice($iv->id);
                   $this->invoices_m->clear_items($iv->id);
                   //clear QB Invoices
                   $this->invoices_m->clear_temp_invoice($iv->txn_id);
                   $this->invoices_m->clear_temp_invoice_lines($iv->txn_id);
                   $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
              }
              else
              {
                   $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed') . ' Invoice Items Not Found'));
              }

              redirect("admin/invoices/");
         }

         private function validation()
         {
              $config = array(
                      array(
                              'field' => 'term',
                              'label' => 'Term',
                              'rules' => 'xss_clean'),
                      array(
                              'field' => 'invoice_no',
                              'label' => 'Invoice No',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'fee_id',
                              'label' => 'Fee Id',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'student_id',
                              'label' => 'Student Id',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'check',
                              'label' => 'Check',
                              'rules' => 'xss_clean'),
              );
              $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
              return $config;
         }

         private function set_paginate_options()
         {
              $config = array();
              $config['base_url'] = site_url() . 'admin/invoices/index/';
              $config['use_page_numbers'] = TRUE;
              $config['per_page'] = 10;
              $config['total_rows'] = $this->invoices_m->count();
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
    