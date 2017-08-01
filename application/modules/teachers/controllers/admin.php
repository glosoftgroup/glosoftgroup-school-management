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

                $this->load->model('teachers_m');
        }

        public function index()
        {
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['page'] = $page;
                //load view
                $this->template->title(' Teachers ')->build('admin/list', $data);
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $t_username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
                        $temail = $this->input->post('email');
                        $tpassword = '12345678'; //temporary password
                        $us_data = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'phone' => $this->input->post('phone'),
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $tid = $this->ion_auth->register($t_username, $tpassword, $temail, $us_data);
                        //add to Teachers group
                        if ($tid)
                        {
                                $this->ion_auth->add_to_group(3, $tid);
                        }

                        $tt_data = array(
                            'user_id' => $tid,
                            'status' => $this->input->post('status'),
                            'designation' => $this->input->post('designation'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                        $ok = $this->teachers_m->create($tt_data);

                        if ($ok) 
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/teachers/');
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
                        $this->template->title('Add Teachers ')->build('admin/create', $data);
                }
        }

        //Update user
        function edit($id)
        {
                $this->load->model('users/users_m');
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin', 'refresh');
                }
                if (!$this->teachers_m->exists_teacher($id))
                {
                        $this->session->set_flashdata('error', lang('web_object_not_exist'));
                        redirect('admin/teachers');
                }
                /**
                 * * Details from Teachers Table
                 * */
                $get = $this->teachers_m->get($id);
                $this->data['result'] = $get;

                $the_user = $this->ion_auth->get_user($id);

                $usr_groups = $this->ion_auth->get_users_groups($id)->result();

                $glist = array();
                foreach ($usr_groups as $grp)
                {
                        $glist[] = $grp->id;
                }
                $gs = $this->users_m->populate('groups', 'id', 'name');

                $this->data['groups_list'] = $gs;
                $sl = isset($_POST['groups']) ? $_POST['groups'] : $glist;

                $this->data['selected'] = $sl;
                //validate form input
                $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
                $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
                $this->form_validation->set_rules('phone', 'Phone', 'xss_clean|trim');
                $this->form_validation->set_rules('designation', 'Designation', 'xss_clean|trim');
                //$this->form_validation->set_rules('phone3', 'Third Part of Phone', 'required|xss_clean|min_length[4]|max_length[4]');

                $this->form_validation->set_rules('groups', 'Groups', 'required');
                // $this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');
                if ($this->input->post('password'))
                {
                        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
                }
                if ($this->form_validation->run() == true)
                {
                        $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
                        $email = $this->input->post('email');
                        $password = $this->input->post('password');

                        $additional_data = array(
                            'username' => $username,
                            'email' => $email,
                            'phone' => $this->input->post('phone'),
                            'password' => $password,
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'modified_by' => $this->ion_auth->get_user()->id,
                            'modified_on' => time(),
                        );

                        if (empty($password))
                        {
                                unset($additional_data['password']);
                        }

                        $this->ion_auth->update_user($id, $additional_data);

                        if (count($sl))
                        {
                                if ((in_array(1, $sl)) && (in_array(4, $sl)))
                                {
                                        $this->session->set_flashdata('error', "Not Allowed!, ");
                                        redirect("admin/users", 'refresh');
                                }
                                if ((in_array(3, $sl)) && (in_array(4, $sl)))
                                {
                                        $this->session->set_flashdata('error', "Not Allowed!");
                                        redirect("admin/users", 'refresh');
                                }
                                //remove from existing groups
                                $this->ion_auth->remove_from_group(NULL, $id);
                                foreach ($sl as $d)
                                {
                                        $this->ion_auth->add_to_group($d, $id);
                                }
                        }


                        // UPDATE TEACHER'S TABLE
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'status' => $this->input->post('status'),
                            'designation' => $this->input->post('designation'),
                            'modified_by' => $user->id,
                            'modified_on' => time());
                        $done = $this->teachers_m->update_teacher($get->id, $form_data);

                        // END UPDATE TEACHER
                        //redirect them back to the admin page
                        $this->session->set_flashdata('message', "User Updated Successfully");
                        redirect("admin/teachers", 'refresh');
                }
                else
                { //display the create user form
                        //set the flash data error message if there is one
                        //$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                        $this->data['first_name'] = array('name' => 'first_name',
                            'id' => 'first_name',
                            'type' => 'text',
                            'value' => $this->input->post('first_name') ? $this->input->post('first_name') : $the_user->first_name,
                        );
                        $this->data['last_name'] = array('name' => 'last_name',
                            'id' => 'last_name',
                            'type' => 'text',
                            'value' => $this->input->post('last_name') ? $this->input->post('last_name') : $the_user->last_name,
                        );
                        $this->data['email'] = array('name' => 'email',
                            'id' => 'email',
                            'type' => 'text',
                            'value' => $this->input->post('email') ? $this->input->post('email') : $the_user->email,
                        );
                        $this->data['phone'] = array('name' => 'phone',
                            'id' => 'phone',
                            'type' => 'text',
                            'value' => $this->input->post('phone') ? $this->input->post('phone') : $the_user->phone,
                        );


                        $this->data['password'] = array('name' => 'password',
                            'id' => 'password',
                            'type' => 'password',
                            'value' => $this->form_validation->set_value('password'),
                        );
                        $this->data['password_confirm'] = array('name' => 'password_confirm',
                            'id' => 'password_confirm',
                            'type' => 'password',
                            'value' => $this->form_validation->set_value('password_confirm'),
                        );


                        $this->template->title("Edit Teacher's Details")->build('admin/edit', $this->data);
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

                $output = $this->teachers_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

                echo json_encode($output);
        }

        function edit_old($id = FALSE, $page = 0)
        {

                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/teachers/');
                }
                if (!$this->teachers_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/teachers');
                }
                //search the item to show in edit form
                $get = $this->teachers_m->find($id);
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
                            'name' => $this->input->post('name'),
                            'phone' => $this->input->post('phone'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //add the aux form data to the form data array to save
                        $form_data = array_merge($form_data_aux, $form_data);

                        //find the item to update

                        $done = $this->teachers_m->update_attributes($id, $form_data);

                        
                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/teachers/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/teachers/");
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
                $this->template->title('Edit Teachers ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/teachers');
                }

                //search the item to delete
                if (!$this->teachers_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/teachers');
                }

                //delete the item
                if ($this->teachers_m->delete($id) == TRUE)
                {
                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/teachers/");
        }

        function _valid_sid()
        {
                $ml = $this->input->post('email');
                if (!$this->teachers_m->exists_email($ml))
                {
                        return TRUE;
                }
                else
                {
                        $this->form_validation->set_message('_valid_sid', 'Email Already Exists.');
                        return FALSE;
                }
        }

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
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|callback__valid_sid'),
                    array(
                        'field' => 'phone',
                        'label' => 'Phone',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'status',
                        'label' => 'Status',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'designation',
                        'label' => 'Designation',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/teachers/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10;
                $config['total_rows'] = $this->teachers_m->count();
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
