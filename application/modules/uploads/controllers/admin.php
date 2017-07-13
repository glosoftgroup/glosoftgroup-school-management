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
                $this->load->model('uploads_m');
                $this->load->model('admission/admission_m');
                $this->load->model('parents/parents_m');
                $this->load->model('fee_arrears/fee_arrears_m');
        }

        //Upload Student			
        function upload_students_only()
        {

                $class = $this->input->post('class');
                $campus = $this->input->post('campus_id');

                if (empty($campus))
                {

                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Campus before upload. Kindly Try Again."));
                        redirect('admin/uploads');
                }
                if (empty($class))
                {

                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Class before upload. Kindly Try Again."));
                        redirect('admin/uploads');
                }

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");

                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;


                        $fname = $fileop[0];
                        $lname = $fileop[1];
                        $gender = $fileop[2];
                        $dob = $fileop[3];
                        $type = $fileop[4];
                        $admission_date = $fileop[5];
                        $admission_number = $fileop[6];
                        $arrears = $fileop[7];


                        //Father Details
                        $pfname = $fileop[8];
                        $plname = $fileop[9];
                        $pemail = $fileop[10];
                        $pphone = $fileop[11];
                        $paddress = $fileop[12];

                        //Mother Details
                        $mfname = $fileop[13];
                        $mlname = $fileop[14];
                        $memail = $fileop[15];
                        $mphone = $fileop[16];
                        $maddress = $fileop[17];

                        /* Create Parent User */

                        if (empty($dob) || $dob == 'N/A')
                        {

                                $dob = time();
                        }
                        if (empty($admission_date) || $admission_date == 'N/A')
                        {

                                $admission_date = time();
                        }

                        $username = strtolower($pfname);
                        if (empty($pemail) || $pemail == 'N/A')
                        {
                                $pemail = strtolower($fname) . '.' . strtolower($plname) . '.' . $i . '@laiserhillacademy.com';
                        }

                        $password = '12345678'; //temporary password - will require to be changed on first login


                        $additional_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'phone' => '0' . $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $puid = $this->ion_auth->register($username, $password, $pemail, $additional_data);

                        $this->ion_auth->add_to_group(6, $puid);
                        /* Create Parent Record */


                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'email' => $pemail,
                            'mother_fname' => $mfname,
                            'mother_lname' => $mlname,
                            'phone' => '0' . $pphone,
                            'mother_phone' => '0' . $mphone,
                            'address' => $paddress,
                            'mother_address' => $maddress,
                            'status' => 1,
                            'user_id' => $puid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        //print_r($form_data);die;

                        $pid = $this->admission_m->save_parent($form_data);



                        /* Create Student User */
                        $username = strtolower($fname);
                        $semail = strtolower($fname) . '.' . strtolower($lname) . '-' . $i . '@outeringschools.sc.ke';
                        $password = '12345678'; //temporary password - will require to be changed on first login

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => '0' . $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $u_id = $this->ion_auth->register($username, $password, $semail, $additional_data);

                        $this->ion_auth->add_to_group(8, $u_id);
                        /* Create Student User */


                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'gender' => $gender,
                            'email' => $semail,
                            'dob' => strtotime($dob),
                            'type' => $type,
                            'campus_id' => $campus,
                            'user_id' => $u_id,
                            'old_adm_no' => $admission_number,
                            'parent_id' => $pid,
                            'status' => 1,
                            'phone' => '0' . $pphone,
                            'admission_date' => strtotime($admission_date),
                            'class' => $class,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $ok = $this->admission_m->create($form_data);

                        //Insert student assign parents table
                        $assg = array(
                            'student_id' => $ok,
                            'status' => 1,
                            'parent_id' => $pid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $this->uploads_m->assign_parent($assg);

                        //Update student ADM No.
                        $last_adm = $this->admission_m->get_last_id();
                        $number = $last_adm + 1;
                        $adno = $this->adm_prefix . '-' . str_pad($ok, 3, '0', 0);

                        $this->admission_m->update_attributes($ok, array('admission_number' => $adno));

                        //Update Arrears
                        if ($arrears > 0)
                        {

                                $form_data = array(
                                    'student' => $ok,
                                    'amount' => $arrears,
                                    'term' => 3,
                                    'year' => 2016,
                                    'created_by' => $this->ion_auth->get_user()->id,
                                    'created_on' => time()
                                );

                                $this->fee_arrears_m->create($form_data);
                                $this->worker->calc_balance($ok);
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

                redirect('admin/admission/');
        }

     

        //Upload Student			
        function upload_students()
        {
                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");

                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;

                        $fname = $fileop[0];
                        $mname = $fileop[1];


                        if (empty($mname))
                        {
                                $mname = '';
                        }

                        $lname = $mname . ' ' . $fileop[2];
                        $gender = $fileop[3];
                        $dob = $fileop[4];
                        if (empty($dob))
                        {
                                $dob = '';
                        }
                        $class = $fileop[5];
                        $phone = $fileop[6];
                        $residence = $fileop[7];
                        $allergies = $fileop[8];
                        $doctor_name = $fileop[9];
                        $doctor_phone = $fileop[10];
                        $parent_id = $fileop[11];
                        $adm_date = '05 Jan 2013';

                        /* Create Student User */
                        $username = strtolower($fname);
                        $email = strtolower($fname) . '-' . strtolower($this->adm_prefix) . '@pcas.co.ke';
                        $password = '12345678'; //temporary password - will require to be changed on first login

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => '0' . $phone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $u_id = $this->ion_auth->register($username, $password, $email, $additional_data);


                        $this->ion_auth->add_to_group(8, $u_id);
                        /* Create Student User */


                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'dob' => strtotime($dob),
                            'gender' => $gender,
                            'residence' => $residence,
                            'phone' => '0' . $phone,
                            'allergies' => $allergies,
                            'doctor_name' => $doctor_name,
                            'doctor_phone' => $doctor_phone,
                            'house' => '',
                            'email' => strtolower($fname) . '-' . strtolower($this->adm_prefix) . '@pcas.co.ke',
                            'user_id' => $u_id,
                            'parent_id' => $parent_id,
                            'status' => 1,
                            'admission_date' => strtotime($adm_date),
                            'class' => $class,
                            'former_school' => '',
                            'entry_marks' => '',
                            'campus_id' => 2,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $ok = $this->admission_m->create($form_data);

                        //Insert student Balance
                        $bal = array(
                            'student' => $ok,
                            'term' => 3,
                            'amount' => 0,
                            'year' => 2015,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $this->admission_m->update_stud_balance($bal);

                        //Update student ADM No.
                        $last_adm = $this->admission_m->get_last_id();
                        $number = $last_adm + 1;
                        $adno = 'BBN-' . str_pad($ok, 3, '0', 0);

                        $this->admission_m->update_attributes($ok, array('admission_number' => $adno));
                }

                if ($ok) 
                {


                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/admission/');
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

        function parent_logins()
        {
                $all_parents = $this->uploads_m->all_parents();

                foreach ($all_parents as $p)
                {

                        $pemail = $this->ion_auth->get_user($p->user_id);
                        $pswd = strtoupper($this->random_pass(8));

                        //print_r($pemail->email.' '.$pswd);die;

                        $additional_data = array(
                            'password' => $pswd,
                            'modified_by' => $this->ion_auth->get_user()->id,
                            'modified_on' => time(),
                        );

                        $ok = $this->ion_auth->update_user($p->user_id, $additional_data);

                        if ($ok)
                        {
                                $form_data = array(
                                    'parent_id' => $p->id,
                                    'name' => $p->first_name . ' ' . $p->last_name,
                                    'phone' => $p->phone,
                                    'username' => $pemail->email,
                                    'password' => $pswd,
                                    'created_by' => $this->ion_auth->get_user()->id,
                                    'created_on' => time(),
                                );

                                $this->uploads_m->create_logins($form_data);
                        }
                }
                redirect('admin/parents');
        }

        function parent_user_logins()
        {
                $all_parents = $this->uploads_m->all_parents();
                foreach ($all_parents as $p)
                {
                        $pswd = strtoupper($this->random_pass(8));
                        $mai = strtoupper($this->random_pass(5));

                        //print_r($pemail->email.' '.$pswd);die;
                        $email = $p->email;

                        if ($this->ion_auth->email_check($email))
                        {
                                $email = $mai . '-BBN@pcas.co.ke';

                                //print_r('Exixst..'.$p->email);die;
                        }
                        elseif (empty($email))
                        {
                                $email = $mai . '-BBN@pcas.co.ke';

                                //print_r('Empty...'.$p->email);die;
                        }
                        elseif ($email == 'N/A')
                        {
                                $email = $mai . '-BBN@pcas.co.ke';
                                //print_r('N/A...'.$p->email);die;
                        }
                        else
                        {
                                $email = $p->email;
                        }

                        $additional_data = array(
                            'email' => $email,
                            'password' => $pswd,
                            'modified_by' => $this->ion_auth->get_user()->id,
                            'modified_on' => time(),
                        );

                        $ok = $this->ion_auth->update_user($p->user_id, $additional_data);

                        if ($ok)
                        {
                                $form_data = array(
                                    'parent_id' => $p->id,
                                    'name' => $p->first_name . ' ' . $p->last_name,
                                    'phone' => $p->phone,
                                    'username' => $email,
                                    'password' => $pswd,
                                    'created_by' => $this->ion_auth->get_user()->id,
                                    'created_on' => time(),
                                );

                                $this->uploads_m->create_logins($form_data);
                        }
                }
                redirect('admin/parents');
        }

        function update_parents_students()
        {

                $studs = $this->uploads_m->get_all();
                //print_r($studs);die;

                $user = $this->ion_auth->get_user();
                foreach ($studs as $s)
                {
                        $form_data = array(
                            'parent_id' => $s->parent_id,
                            'student_id' => $s->id,
                            'status' => 1,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->uploads_m->assign_parent($form_data);
                }
        }

        public function send_credentials()
        {
                $settings = $this->ion_auth->settings();
                $parents = $this->uploads_m->get_plogins();

                $count = 0;
                foreach ($parents as $p)
                {
                        $count ++;
                        $skul = $this->ion_auth->settings();

                        $recipient = $p->phone;
                        $country_code = '254';
                        $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                        $to = $p->name;
                        $dat = explode(' ', $to);

                        $message = 'Dear ' . $dat[0] . ', welcome to busy bee school parents portal. Your login credentials are: portal: system.pcas.co.ke username: ' . $p->username . ' password:' . $p->password . ' .Please reset your password after logging in. For any queries contact us at: it@pcas.co.ke or 0720578842';
                        //$this->sms_m->send_sms($recipient, $message);
                }
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Credentials Successfully Sent. </b><span style='color:#fff; '>( Number of Parents Notified " . $count . ')</span>'));

                redirect('admin/sms');
        }

      
        //Upload Parents
        function upload_parents()
        {

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");

                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;

                        $fname = $fileop[0];
                        $mname = $fileop[1];

                        if (empty($mname))
                        {
                                $mname = '';
                        }

                        $lname = $mname . ' ' . $fileop[2];

                        $email = $fileop[3];

                        if (empty($email))
                        {

                                $email = strtolower($fname) . '-' . strtolower($this->adm_prefix) . '@pcas.co.ke';
                        }

                        $phone = $fileop[4];
                        $phone2 = $fileop[5];
                        $address = $fileop[6];
                        $parent_id = $fileop[7];

                        $mom_fname = $fileop[8];
                        $mom_mname = $fileop[9];

                        if (!empty($mom_mname))
                        {
                                $mom_mname = '';
                        }

                        $mom_lname = $mom_mname . ' ' . $fileop[10];

                        $mom_email = $fileop[11];
                        $mom_phone = $fileop[12];
                        $mom_phone2 = $fileop[13];


                        /* Create Student User */
                        $username = strtolower($fname);
                        $password = '12345678'; //temporary password - will require to be changed on first login

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => '0' . $phone,
                            'me' => $this->ion_auth->get_user()->id,
                        );

                        $this->uploads_m->create_logins($form_data);
                }
                redirect('admin/parents');
        }

        public function index()
        {
                $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['uploads'] = $this->uploads_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();


                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['campus'] = $this->uploads_m->populate('campus', 'id', 'name');


                //load view
                $this->template->title(' Uploads ')->build('admin/list', $data);
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $form_data_aux = array();
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'description' => $this->input->post('description'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->uploads_m->create($form_data);

                        if ($ok) 
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/uploads/');
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
                        $this->template->title('Add Uploads ')->build('admin/create', $data);
                }
        }

        function edit($id = FALSE, $page = 0)
        {

                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/uploads/');
                }
                if (!$this->uploads_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/uploads');
                }

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

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/uploads/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10;
                $config['total_rows'] = $this->uploads_m->count();
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
