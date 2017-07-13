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

                $this->load->model('sms_m');
                $this->load->model('class_groups/class_groups_m');
                $this->load->model('email_templates/email_templates_m');
                $this->load->library('pmailer');
                $this->load->library('image_cache');
                if ($this->input->get('sw'))
                {
                        $pop = $this->input->get('sw');
                        $valid = $this->portal_m->get_class_ids();
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
                        
                }
        }
        function balance()
        {
                $this->load->library('Req');
                if (empty($this->config->item('sms_pass')) || empty($this->config->item('sms_id')))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'SMS Module is not configured'));
                        redirect('admin/sms/create');
                }
                $tok = md5($this->config->item('sms_pass'));
                $userid = $this->config->item('sms_id');
                $url = 'http://197.248.4.47/smsapi/balance.php?UserID=' . $userid . '&Token=' . $tok;
                $balance = $this->req->get($url);

                $res = json_decode($balance->body);
                $bal = round($res->Balance);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Your SMS Account has <span style="font-size:17px; font-weight:bold; color:#00008b;">' . $bal . ' </span> SMS available.'));
                redirect('admin/sms/create');
        }

        public function index()
        {
                redirect('admin/sms/create');
                //set the title of the page
                $data['title'] = 'Sms List';

                $config = $this->set_paginate_options();
                //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                //find all the categories with paginate and save it in array to past to the view
                $data['sms'] = $this->sms_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //number page variable
                $data['page'] = $page;

                //load view
                $this->template->title('All Sms')->build('admin/create', $data);
        }

        public function log()
        {
                $config = $this->set_paginate_options();
                //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 1;
                //find all the categories with paginate and save it in array to past to the view
                $data['sms'] = $this->sms_m->paginate_log($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //number page variable
                $data['page'] = $page;

                //load view
                $this->template->title('All Sms Sent')->build('admin/log', $data);
        }

        /**
         * Send SMS to Specific Parents
         * 
         */
        public function custom()
        {
                if ($this->input->post())
                {
                        $i = 0;
                        $students = $this->input->post('sids');
                        $sms = $this->input->post('sms');
                        if (strlen($sms) < 20)
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Message too Short'));
                                redirect('admin/sms/custom');
                        }
                        if (count($students) < 1)
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No recipients Selected'));
                                redirect('admin/sms/custom');
                        }
                        foreach ($students as $s)
                        {
                                $i++;
                                $adm = $this->worker->get_student($s);
                                $parent = $this->portal_m->get_parent($adm->parent_id);
                                $phone = $parent->phone;
                                if (empty($phone))
                                {
                                        $phone = $parent->mother_phone;
                                }
                                $this->sms_m->send_sms($phone, $sms);
                        }
                        $this->session->set_flashdata('message', array('type' => 'info', 'text' => 'Sent ' . $i . ' SMS'));
                        redirect('admin/sms/custom');
                }
                $data['page'] = '';

                $this->template->title('Custom SMS')->build('admin/custom', $data);
        }

        //Send Email General Function
        function create($page = NULL)
        {
                //create control variables
                $data['title'] = 'Create sms';
                $data['updType'] = 'create';
                $data['classes'] = $this->class_groups_m->get_classes();
                $data['the_class'] = $this->classes;
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                $initial = isset($this->school->message_initial) && !empty($this->school->message_initial) ? $this->school->message_initial : 'Hi';
                ///LIST ALL Sms
                $data['title'] = 'Sms List';

                $config = $this->set_paginate_options();
                //Initialize the pagination class
                $this->pagination->initialize($config);
                //find all the categories with paginate and save it in array to past to the view
                $data['sms'] = $this->sms_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //number page variable
                $data['page'] = $page;
                $data['parents'] = $this->sms_m->get_active_parents();
                $data['users'] = $this->sms_m->get_users_phone();
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {
                        $user = $this->ion_auth->get_user();
                        $user_id = $this->input->post('user_id');
                        $type = 0;

                        if ($this->input->post('send_to') == 'All Parents')
                        {
                                $user_id = 'All Parents';
                                $type = 3; //All parents
                        }
                        if ($this->input->post('send_to') == 'All Teachers')
                        {
                                $user_id = 'All Teachers';
                                $type = 4; //All Teachers
                        }
                        if ($this->input->post('send_to') == 'All Staff')
                        {
                                $user_id = 'All Staff';
                                $type = 5; //All Staff
                        }
                        if ($this->input->post('send_to') == 'Staff')
                        {
                                $user_id = $this->input->post('staff');
                                $type = 1; //To Staff
                        }
                        if ($this->input->post('send_to') == 'Parent')
                        {
                                $user_id = $this->input->post('parent');
                                $type = 2; //To Parent
                        }

                        if ($this->input->post('send_to') == 'Class')
                        {
                                $user_id = $this->input->post('class');
                                $type = 6; //To Class
                        }

                        //TYPE 1 is staff while TYPE 2 is Parent
                        if ($this->input->post('status') == 'draft')
                        {
                                $form_data = array(
                                    'recipient' => $user_id,
                                    'description' => $this->input->post('description'),
                                    'type' => $type,
                                    'status' => $this->input->post('status'),
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $ok = $this->sms_m->create($form_data);
                                redirect('admin/sms');
                        }
                        else
                        {
                                $form_data = array(
                                    'recipient' => $user_id,
                                    'description' => $this->input->post('description'),
                                    'type' => $type,
                                    'status' => 'sent',
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $ok = $this->sms_m->create($form_data);

                                if ($ok) 
                                {
                                        //Send to parents
                                        if ($this->input->post('send_to') == 'All Parents')
                                        {
                                                $members = $this->sms_m->active_parent();

                                                foreach ($members as $member)
                                                {
                                                        $recipient = $member->phone;
                                                        $to = $member->first_name . ' ' . $member->last_name;
                                                        $message = $initial . ' ' . $to . ', ' . $this->input->post('description');

                                                        if (empty($recipient) || $recipient == 'N/A')
                                                        {
                                                                //print_r($member->id.' '. $member->phone);die;
                                                        }
                                                        else
                                                        {
                                                                $this->sms_m->send_sms($recipient, $message);
                                                        }
                                                }
                                        }
                                        elseif ($this->input->post('send_to') == 'All Teachers')
                                        {
                                                $members = $this->ion_auth->get_teacher();
                                                foreach ($members as $member)
                                                {
                                                        $recipient = $member->phone;
                                                        $to = $member->first_name;
                                                        $message = $initial . ' ' . $to . ', ' . $this->input->post('description');
                                                        $this->sms_m->send_sms($recipient, $message);
                                                }
                                        }
                                        //Send to all staff
                                        elseif ($this->input->post('send_to') == 'All Staff')
                                        {
                                                $members = $this->sms_m->get_all_staff();
                                                foreach ($members as $member)
                                                {
                                                        $recipient = $member->phone;
                                                        $to = $member->first_name;
                                                        $message = $initial . ' ' . $to . ', ' . $this->input->post('description');
                                                        $this->sms_m->send_sms($recipient, $message);
                                                }
                                        }
                                        elseif ($this->input->post('send_to') == 'Staff')
                                        {
                                                $member = $this->ion_auth->get_user($this->input->post('staff'));
                                                $recipient = $member->phone;
                                                $to = $member->first_name;
                                                $message = $initial . ' ' . $to . ', ' . $this->input->post('description');

                                                $this->sms_m->send_sms($recipient, $message);
                                        }
                                        elseif ($this->input->post('send_to') == 'Parent')
                                        {
                                                $member = $this->ion_auth->get_single_parent($this->input->post('parent'));

                                                $recipient = $member->phone;
                                                $to = $member->first_name;
                                                $message = $initial . ' ' . $to . ', ' . $this->input->post('description');

                                                $this->sms_m->send_sms($recipient, $message);
                                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'SMS Sent Successfully'));
                                        }
                                        elseif ($this->input->post('send_to') == 'Class')
                                        {
                                                $students = $this->class_groups_m->get_population($this->input->post('class'));
                                                //Get each student's parent and send SMS
                                                foreach ($students as $st)
                                                {
                                                        $member = $this->ion_auth->get_single_parent($st->parent_id);
                                                        $recipient = $member->phone;
                                                        $to = $member->first_name;
                                                        $message = $initial . ' ' . $to . ', ' . $this->input->post('description');

                                                        $this->sms_m->send_sms($recipient, $message);
                                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'SMS Sent Successfully'));
                                                }
                                        }
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_success')));
                                }
                                redirect('admin/sms/');
                        }
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['sms_m'] = $get;
                        $data['inbox'] = $this->sms_m->get_inbox();
                        $data['sent'] = $this->sms_m->get_sent();
                        $data['draft'] = $this->sms_m->get_draft();
                        $data['trash'] = $this->sms_m->get_trash();

                        //load the view and the layout
                        $this->template->title('Compose SMS ')->build('admin/create', $data);
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms/');
                }
                if (!$this->sms_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms');
                }
                //search the item to show in edit form
                $get = $this->sms_m->find($id);

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['title'] = lang('web_edit');
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'id' => $id,
                            'user_id' => $this->input->post('user_id'),
                            'cc' => $this->input->post('cc'),
                            'subject' => $this->input->post('subject'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //find the item to update
                        $sms_m = $this->sms_m->update_attributes($id, $form_data);

                        
                        if ($sms_m)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/sms/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $sms_m->errors->full_messages()));
                                redirect("admin/sms/");
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
                $data['sms_m'] = $get;
                //load the view and the layout
                $this->template->title('Edit Sms ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms');
                }

                //search the item to delete
                if (!$this->sms_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms');
                }

                //delete the item
                if ($this->sms_m->delete($id) == TRUE)
                {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/sms/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'user_id',
                        'label' => 'User Id',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'cc',
                        'label' => 'Cc',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'send_to',
                        'label' => 'Send To',
                        'rules' => 'trim|required|xss_clean',
                    ),
                    array(
                        'field' => 'subject',
                        'label' => 'Subject',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[255]'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function email_validation()
        {
                $config = array(
                    array(
                        'field' => 'parent',
                        'label' => 'Parent',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'staff',
                        'label' => 'Staff',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'cc',
                        'label' => 'Cc',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'status',
                        'label' => 'status',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'subject',
                        'label' => 'Subject',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[255]'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]')
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/sms/log/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
                $config['total_rows'] = $this->sms_m->count_log();
                $config['uri_segment'] = 5;

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
                $config['full_tag_open'] = "<div class='pagination  pagination-centered'><ul>";
                $config['full_tag_close'] = '</ul></div>';

                return $config;
        }

}
