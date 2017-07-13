<?php

class Index extends Public_Controller
{

        public $data;

        function __construct()
        {
                parent::__construct();
                $this->template
                             ->set_layout('default.php')
                             ->set_partial('meta', 'partials/meta.php')
                             ->set_partial('header', 'partials/header.php')
                             ->set_partial('sidebar', 'partials/sidebar.php')
                             ->set_partial('footer', 'partials/footer.php');

                $this->load->model('student_portal_m');
                $this->load->model('school_events/school_events_m');
                if ($this->ion_auth->logged_in())
                {
                        //send everyone away from from student portal if they are not students or parents
                        if ((!$this->is_student && !$this->is_parent) && $this->uri->segment(1) != 'fee_payment')
                        {
                                redirect('admin');
                        }
                }
        }

        public function index()
        {
                redirect('login');
                //show frontend
                /* $this->template
                  ->title('Homepage ')
                  ->build('index/main'); */
        }

        public function my_sms()
        {
                if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }

                $this->load->model('sms/sms_m');
                $data['sms'] = $this->sms_m->my_sms();

                //load the view and the layout
                $this->template->title('My Messages ')->set_layout('portal')->build('index/my_sms', $data);
        }

        public function contact($result = NULL)
        {
                $this->template->title(lang('web_contact'));
                $this->_set_rules();

                if ($this->form_validation->run() == FALSE)
                {
                        $this->template->build('index/contact');
                }
                else
                {
                        $form_data = array(
                            'name' => $this->input->post('name', TRUE),
                            'lastname' => $this->input->post('lastname', TRUE),
                            'email' => $this->input->post('email', TRUE),
                            'phone' => $this->input->post('phone', TRUE),
                            'comments' => $this->input->post('comments', TRUE)
                        );

                        $this->load->library('email');

                        $this->email->from('admin@admin.com', 'Codeigniter');
                        $this->email->to('ben@benside.co.cc');

                        $this->email->subject('Contact Form');

                        $message = $this->load->view('index/email/formcontact.tpl.php', $form_data, TRUE);

                        $this->email->message($message);

                        if ($this->email->send())
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_mail_ok')));
                                redirect('contact');
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_mail_ko')));
                                redirect('contact');
                        }
                }
        }

        /**
         * Set rules for form
         * @return void
         */
        private function _set_rules()
        {
//validate form input
                $this->form_validation->set_rules('name', 'lang:web_name', 'required|trim|xss_clean|min_length[2]|max_length[100]');
                $this->form_validation->set_rules('lastname', 'lang:web_lastname', 'required|trim|xss_clean|min_length[2]|max_length[100]');
                $this->form_validation->set_rules('email', 'lang:web_email', 'required|trim|valid_email|xss_clean');
                $this->form_validation->set_rules('phone', 'lang:web_phone', 'required|trim|numeric|xss_clean');
                $this->form_validation->set_rules('comments', 'lang:web_comments', 'required|trim|xss_clean');

                $this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');
        }
  

        /**
         * My Profile
         */
        function profile()
        {
                if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }

                $user = $this->ion_auth->get_user();
                $data['streams'] = $this->student_portal_m->populate('class_stream', 'id', 'name');
                $data['post'] = $this->student_portal_m->fetch($user->admission_number);
                $this->template->set_layout('portal')
                             ->title('My Profile', $user->first_name . ' ' . $user->last_name)
                             ->build('index/profile', $data);
        }

        function update_parent()
        {


                $this->load->model('parents/parents_m');
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {

                        $user = $this->ion_auth->get_user();
                        $u = $this->ion_auth->parent_profile($user->id);
                        $form_data = array(
                            'email' => $this->input->post('email'),
                            'phone' => $this->input->post('phone'),
                            'occupation' => $this->input->post('occupation'),
                            'mother_occupation' => $this->input->post('mother_occupation'),
                            'address' => $this->input->post('address'),
                            'mother_address' => $this->input->post('mother_address'),
                            'mother_email' => $this->input->post('mother_email'),
                            'mother_phone' => $this->input->post('mother_phone'),
                            'modified_on' => time(),
                            'modified_by' => $this->ion_auth->get_user()->id
                        );

                        //print_r($form_data);die;

                        $ok = $this->parents_m->update_parent($u->id, $form_data);

                        if ($ok) 
                        {

                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));

                                redirect('parent_profile');
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));

                                redirect('parent_profile');
                        }
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
                        $this->template->title('Add Uploads ')->build('index/parent_profile', $data);
                }
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'email',
                        'label' => 'email',
                        'rules' => 'required|trim|xss_clean|valid_email'),
                    array(
                        'field' => 'occupation',
                        'label' => 'occupation',
                        'rules' => 'trim|xss_clean'),
                    array(
                        'field' => 'address',
                        'label' => 'address',
                        'rules' => 'trim|xss_clean'),
                    array(
                        'field' => 'mother_address',
                        'label' => 'mother_address',
                        'rules' => 'trim|xss_clean'),
                    array(
                        'field' => 'mother_email',
                        'label' => 'mother_email',
                        'rules' => 'trim|xss_clean|valid_email'),
                    array(
                        'field' => 'mother_phone',
                        'label' => 'mother_phone',
                        'rules' => 'trim|xss_clean'),
                    array(
                        'field' => 'mother_occupation',
                        'label' => 'mother_occupation',
                        'rules' => 'trim|xss_clean'),
                    array(
                        'field' => 'phone',
                        'label' => 'Description',
                        'rules' => 'required|trim'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        /**
         * My Profile
         */
        function parent_profile()
        {
                if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }


                $this->template->set_layout('portal')
                             ->title('My Profile')
                             ->build('index/parent_profile');
        }

        /**
         * School Calendar
         */
        function calendar()
        {
                if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }

                $user = $this->ion_auth->get_user();
                $data[''] = '';
                $this->template->set_layout('portal')
                             ->title('School Calendar')
                             ->build('index/calendar', $data);
        }
 
        /**
         * Login Page
         */
        function login()
        {
                if ($this->ion_auth->logged_in())
                {
                        //already logged in so no need to access this page
                        redirect('account');
                }
                //validate form input
                $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if ($this->form_validation->run() == true)
                { //check to see if the user is logging in
                        //check for "remember me"
                        $remember = (bool) $this->input->post('remember');

                        if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
                        { //if the login is successful
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                                redirect('account');
                        }
                        else
                        { //if the login was un-successful
                                //redirect them back to the login page
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                                redirect('login', 'refresh');
                        }
                }
                else
                {  //the user is not logging in so display the login page
                        //set the flash data error message if there is one
                        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                        $this->data['email'] = array('name' => 'email',
                            'id' => 'username', //class="input-large col-md-10" name="username" id="username"
                            'type' => 'text',
                            'class' => 'input-large col-md-10',
                            'type' => 'text',
                            'value' => $this->form_validation->set_value('email'),
                        );
                        $this->data['password'] = array('name' => 'password',
                            'id' => 'password',
                            'type' => 'password',
                            'class' => 'input-large col-md-10',
                        );

                        $this->template
                                     ->title('Welcome', 'Login')
                                     ->set_layout('login')
                                     ->build('index/login', $this->data);
                }
        }

        /**
         * User Logout
         * 
         */
        function logout()
        {
                $this->data['title'] = "Logout";
                //log the user out
                $logout = $this->ion_auth->logout();
                //redirect them back to the page they came from
                redirect('/', 'refresh');
        }

        function change_password()
        {
                $this->form_validation->set_rules('old', 'Old password', 'required');
                $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
                $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

                if (!$this->ion_auth->logged_in())
                {
                        redirect('login', 'refresh');
                }
                $user = $this->ion_auth->get_user($this->session->userdata('user_id'));
                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');

                if ($this->form_validation->run() == FALSE)
                { //display the form
                        //set the flash data error message if there is one
                        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                        $this->data['old_password'] = array('name' => 'old',
                            'id' => 'old',
                            'class' => 'col-md-7',
                            'type' => 'password',
                        );
                        $this->data['new_password'] = array('name' => 'new',
                            'id' => 'new',
                            'class' => 'col-md-7',
                            'type' => 'password',
                        );
                        $this->data['new_password_confirm'] = array('name' => 'new_confirm',
                            'id' => 'new_confirm',
                            'class' => 'col-md-7',
                            'type' => 'password',
                        );
                        $this->data['user_id'] = array('name' => 'user_id',
                            'id' => 'user_id',
                            'type' => 'hidden',
                            'value' => $user->id,
                        );

                        $this->template
                                     ->set_layout('portal')
                                     ->title('Change Password')
                                     ->build('index/change_password', $this->data);
                }
                else
                {
                        $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

                        $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

                        if ($change)
                        { //if the password was successfully changed
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                                $this->logout();
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                                redirect('change_password', 'refresh');
                        }
                }
        }

        //forgot password
        function forgot_password()
        {
                //get the identity type from config and send it when you load the view
                $identity = $this->config->item('identity', 'ion_auth');
                $identity_human = ucwords(str_replace('_', ' ', $identity)); //if someone uses underscores to connect words in the column names
                $this->form_validation->set_rules($identity, $identity_human, 'required|valid_email');
                if ($this->form_validation->run() == false)
                {
                        //setup the input
                        $this->data[$identity] = array('name' => $identity,
                            'id' => $identity, //changed
                        );
                        //set any errors and display the form
                        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                        $this->data['identity'] = $identity;
                        $this->data['identity_human'] = $identity_human;
                        $this->template
                                     ->title('Forgot Password')
                                     ->build('index/forgot_password', $this->data);
                }
                else
                {
                        //run the forgotten password method to email an activation code to the user
                        $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

                        if ($forgotten)
                        { //if there were no errors
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                                redirect('login', 'refresh'); //we should display a confirmation page here instead of the login page
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                                redirect('forgot_password', 'refresh');
                        }
                }
        }

        //reset password - final step for forgotten password
        public function reset_password($code)
        {
                $reset = $this->ion_auth->forgotten_password_complete($code);

                if ($reset)
                {  //if the reset worked then send them to the login page
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                        redirect('admin/login', 'refresh');
                }
                else
                { //if the reset didnt work then send them back to the forgot password page
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                        redirect('forgot_password', 'refresh');
                }
        }

        /**
         * My Account (for Logged in User)
         * 
         */
        function account()
        {
                if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }

                if ($this->ion_auth->logged_in())
                {
                        $events = $this->school_events_m->get_all();
                        $data['events'] = $events;
                        if ($this->ion_auth->is_in_group($this->user->id, 6))
                        {
                                //parent
                                $this->template
                                             ->title('Parent')
                                             ->build('admin/parent', $data);
                        }
                        elseif ($this->ion_auth->is_in_group($this->user->id, 8))
                        {
                                //stud
                                $this->template
                                             ->title('My Account')
                                             ->build('admin/student', $data);
                        }
                }
        }

        /**
         * View Results
         * 
         */
        function results()
        {
                $data[''] = '';

                $this->template->set_layout('portal')->title(' View Results')->build('index/results', $data);
        }

        /**
         * Fetch Calendar Events
         * 
         */
        function get_events()
        {
                $events = $this->student_portal_m->get_events();
                $event_data = array();

                foreach ($events as $event)
                {
                        $user = $this->ion_auth->get_user($event->created_by);
                        $end_date = $event->end_date;

                        if ($end_date < time())
                        {
                                $event_data[] = array(
                                    'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
                                    'start' => date('d M Y H:i', $event->start_date),
                                    'end' => date('d M Y H:i', $event->end_date),
                                    'venue' => $event->venue,
                                    'event_title' => $event->title,
                                    'cache' => true,
                                    'backgroundColor' => 'black',
                                    'description' => strip_tags($event->description),
                                    'user' => $user->first_name . ' ' . $user->last_name,
                                );
                        }
                        else
                        {
                                $event_data[] = array(
                                    'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
                                    'start' => date('d M Y H:i', $event->start_date),
                                    'end' => date('d M Y H:i', $event->end_date),
                                    'venue' => $event->venue,
                                    'event_title' => $event->title,
                                    'cache' => true,
                                    'backgroundColor' => $event->color,
                                    'description' => strip_tags($event->description),
                                    'user' => $user->first_name . ' ' . $user->last_name,
                                );
                        }
                }

                echo json_encode($event_data);
        }

        private function set_paginate_options($ct)
        {
                $config = array();
                $config['base_url'] = site_url() . 'exam_timetable/page/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10;
                $config['total_rows'] = $ct;
                $config['uri_segment'] = 3;

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
                // $choice = $config["total_rows"] / $config["per_page"];
                //$config["num_links"] = round($choice);

                return $config;
        }

        /**
         * Catch 404s
         * 
         */
        function gotcha()
        {
                /*  if (!$this->ion_auth->logged_in())
                  {
                  $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
                  redirect('login');
                  } */
                $this->template
                             ->title('Not Found')
                             ->set_layout('default')
                             ->build('admin/error');
        }

}
