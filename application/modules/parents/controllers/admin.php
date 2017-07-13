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

                $this->load->model('parents_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['parents'] = $this->parents_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                $this->template->title(' Parents ')->build('admin/list', $data);
        }

        function random_pass($length)
        {
                $chars = "123GHJKLMkmnpqNPQRST456789abcdefghijrstuvwxyzABCDEFUVWXYZ";
                $thepassword = '';
                for ($i = 0; $i < $length; $i++)
                {
                        $thepassword .= $chars{rand() % (strlen($chars) - 1)};
                }
                return $thepassword;
        }

        function update_paro()
        {
                $this->parents_m->update_parent(104, array('user_id' => 1109));

                // redirect('admin/parents/view/')
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
                        $form_data = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'status' => $this->input->post('status'),
                            'email' => $this->input->post('email'),
                            'address' => $this->input->post('address'),
                            'phone' => $this->input->post('phone'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->parents_m->create($form_data);

                        if ($ok) 
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/parents/');
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
                        $this->template->title('Add Parents ')->build('admin/create', $data);
                }
        }

        //View Parents Details
        function view($id)
        {
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin', 'refresh');
                }
                if (!$this->parents_m->exists($id))
                {
                        $this->session->set_flashdata('error', lang('web_object_not_exist'));
                        redirect('admin/parents');
                }

                $data['p'] = $this->parents_m->find($id);
                //load the view and the layout
                $this->template->title('View Parents Details ')->build('admin/view', $data);
        }

        //Update user
        function edit($id, $user_id)
        {
                $this->load->model('users/users_m');
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin', 'refresh');
                }


                if (!$this->parents_m->exists($id))
                {
                        $this->session->set_flashdata('error', lang('web_object_not_exist'));
                        redirect('admin/parents');
                }
                /**
                 * * Details from Parents Table
                 * */
                $get = $this->parents_m->find($id);
                //$get = $this->parents_m->get($id);
                $this->data['result'] = $get;

                $the_user = $this->ion_auth->get_user($user_id);

                $usr_groups = $this->ion_auth->get_users_groups($id)->result();

                $glist = array();
                foreach ($usr_groups as $grp)
                {
                        $glist[] = $grp->id;
                }
                $gs = $this->users_m->populate('groups', 'id', 'name');

                $this->data['groups_list'] = $gs;
                $sl = array();
                $sl = isset($_POST['groups']) ? $_POST['groups'] : $glist;

                $this->data['selected'] = $sl;
                //validate form input
                $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
                $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
                $this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean|trim');
                $this->form_validation->set_rules('occupation', 'occupation', 'xss_clean|trim');
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

                        // UPDATE Parents'S TABLE
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'email' => $this->input->post('email'),
                            'status' => $this->input->post('status'),
                            'occupation' => $this->input->post('occupation'),
                            'phone' => $this->input->post('phone'),
                            'address' => $this->input->post('address'),
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'modified_by' => $user->id,
                            'modified_on' => time());
                        $done = $this->parents_m->update_parent($get->id, $form_data);


                        if (isset($user_id) && !empty($user_id))
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
                        }
                        else
                        {

                                /* Create Parent User */
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
                                $pid = $this->ion_auth->register($username, $password, $email, $additional_data);

                                $this->ion_auth->add_to_group(6, $pid);
                        }

                        // END UPDATE TEACHER
                        //redirect them back to the admin page
                        $this->session->set_flashdata('message', "User Updated Successfully");
                        redirect("admin/parents", 'refresh');
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
                        $this->template->title("Edit Details")->build('admin/edit', $this->data);
                }
        }

        function deactivate($id)
        {
                if (!$this->parents_m->exists($id))
                {
                        $this->session->set_flashdata('error', lang('web_object_not_exist'));
                        redirect('admin/parents');
                }

                $done = $this->parents_m->update_parent($id, array('status' => 0));
                //delete the item
                if ($done)
                {
                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => 'Parent successfully deactivated.'));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'An error occured please try again later'));
                }

                redirect('admin/parents');
        }

        function activate($id)
        {
                if (!$this->parents_m->exists($id))
                {
                        $this->session->set_flashdata('error', lang('web_object_not_exist'));
                        redirect('admin/parents');
                }

                $done = $this->parents_m->update_parent($id, array('status' => 1));
                //delete the item
                if ($done)
                {
                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => 'Parent successfully Activated.'));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'An error occured please try again later'));
                }

                redirect('admin/parents');
        }

        //Update user
        function edit_parent($id)
        {
                $this->load->model('users/users_m');

                /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
                  {
                  $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                  redirect('admin');
                  } */

                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin', 'refresh');
                }
                if (!$this->parents_m->exists_parent($id))
                {
                        $this->session->set_flashdata('error', lang('web_object_not_exist'));
                        redirect('admin/parents');
                }
                /**
                 * * Details from Parents Table
                 * */
                $get = $this->parents_m->get($id);
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
                $sl = array();
                $sl = isset($_POST['groups']) ? $_POST['groups'] : $glist;

                $this->data['selected'] = $sl;
                //validate form input
                $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
                $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
                $this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean|trim');
                $this->form_validation->set_rules('occupation', 'occupation', 'xss_clean|trim');
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
                            'email' => $email,
                            'status' => $this->input->post('status'),
                            'occupation' => $this->input->post('occupation'),
                            'phone' => $this->input->post('phone'),
                            'address' => $this->input->post('address'),
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'modified_by' => $user->id,
                            'modified_on' => time());
                        $done = $this->parents_m->update_parent($get->id, $form_data);

                        // END UPDATE TEACHER
                        //redirect them back to the admin page
                        $this->session->set_flashdata('message', "User Updated Successfully");
                        redirect("admin/parents", 'refresh');
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

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/parents');
                }

                //search the item to delete
                if (!$this->parents_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/parents');
                }

                //delete the item
                if ($this->parents_m->delete($id) == TRUE)
                {
                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/parents/");
        }

        function chat()
        {
                $users = $this->ion_auth->fetch_logged_in();
                $gs = array();
                foreach ($users as $key => $uid)
                {
                        if ($this->ion_auth->is_in_group($uid, 6))
                        {
                                $gs[] = $uid;
                        }
                }

                $data['staff'] = $gs;
                $this->template->set_layout('message')->title('Message Centre')->build('admin/message', $data);
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
                        'field' => 'status',
                        'label' => 'Status',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'occupation',
                        'label' => 'occupation',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'address',
                        'label' => 'Address',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                    array(
                        'field' => 'phone',
                        'label' => 'Phone',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/parents/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10000000000; //$this->list_size;
                $config['total_rows'] = $this->parents_m->count();
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

}
