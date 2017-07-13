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
                $this->load->model('grading_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['grading'] = $this->grading_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['grades'] = $this->grading_m->grades();
                $data['list_grades'] = $this->grading_m->list_grades();

                //load view
                $data['grading_system'] = $this->grading_m->get_grading_system();
                $this->template->title(' Grading ')->build('admin/list', $data);
        }

        function view($id = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading/');
                }
                if (!$this->grading_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading');
                }

                //search the item to show in edit form
                $data['grading_id'] = $id;
                $data['post'] = $this->grading_m->get_grades($id);
                $data['dat'] = $this->grading_m->find($id);
                $data['sys'] = $this->grading_m->get_grading_system();

                $this->template->title(' Grading ')->build('admin/view', $data);
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                $data['grades'] = $this->grading_m->grades();
                $data['list_grades'] = $this->grading_m->list_grades();
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'grading_system' => $this->input->post('grading_system'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->grading_m->create($form_data);

                        if ($ok) 
                        {
                                $length = $this->input->post('grade');
                                $size = count($length);

                                for ($i = 0; $i < $size; ++$i)
                                {
                                        $grade = $this->input->post('grade');
                                        $max = $this->input->post('maximum_marks');
                                        $min = $this->input->post('minimum_marks');

                                        $dat = array(
                                            'grading_id' => $ok,
                                            'grade' => $grade[$i],
                                            'maximum_marks' => $max[$i],
                                            'minimum_marks' => $min[$i],
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $this->grading_m->insert_records($dat);
                                }

                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/grading/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        $data['grading'] = $this->grading_m->get_grading_system();
                        //load the view and the layout
                        $this->template->title('Add Grading ')->build('admin/create', $data);
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                $data['grades'] = $this->grading_m->grades();
                $data['list_grades'] = $this->grading_m->list_grades();
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading/');
                }
                if (!$this->grading_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading');
                }
                //search the item to show in edit form
                $get = $this->grading_m->find($id);
                //variables for check the upload
                $form_data_aux = array();
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
                            'grading_system' => $this->input->post('grading_system'),
                            'grade' => $this->input->post('grade'),
                            'maximum_marks' => $this->input->post('maximum_marks'),
                            'minimum_marks' => $this->input->post('minimum_marks'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->grading_m->update_attributes($id, $form_data);

                        
                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/grading/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/grading/");
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
                $data['grading'] = $this->grading_m->get_grading_system();
                //load the view and the layout
                $this->template->title('Edit Grading ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading');
                }

                //search the item to delete
                if (!$this->grading_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading');
                }

                //delete the item
                if ($this->grading_m->delete($id) == TRUE)
                {
                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/grading/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'grading_system',
                        'label' => 'Grading Sytem',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'grade[]',
                        'label' => 'Grade',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'maximum_marks[]',
                        'label' => 'Maximum Marks',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'minimum_marks[]',
                        'label' => 'Minimum Marks',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/grading/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
                $config['total_rows'] = $this->grading_m->count();
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
