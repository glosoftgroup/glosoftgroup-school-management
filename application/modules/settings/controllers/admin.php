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

                $this->load->model('settings_m');
        }

        function post_theme()
        {

                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'theme_color' => $this->input->post('theme'),
                    'modified_by' => $user->id,
                    'modified_on' => time());

                $this->settings_m->update_settings($form_data);
        }

        function post_bg()
        {
                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'background' => $this->input->post('bg'),
                    'modified_by' => $user->id,
                    'modified_on' => time());

                $this->settings_m->update_settings($form_data);
        }

        function index()
        {
                //check For POST
                if ($this->input->post())
                {
                        $user = $this->ion_auth->get_user();
                        //Rules for validation
                        $this->form_validation->set_rules($this->validation());
                        // build array for the model
                        $document = '';

                        if (!empty($_FILES['document']['name']))
                        {
                                $this->load->library('files_uploader');
                                $upload_data = $this->files_uploader->upload('document');
                                $document = $upload_data['file_name'];
                        }

                        $form_data = array(
                            'school' => $this->input->post('school'),
                            'postal_addr' => $this->input->post('postal_addr'),
                            'email' => $this->input->post('email'),
                            'tel' => $this->input->post('tel'),
                            'message_initial' => $this->input->post('message_initial'),
                            'pre_school' => $this->input->post('pre_school'),
                            'cell' => $this->input->post('cell'),
                            'sender_id' => $this->input->post('sender_id'),
                            'document' => $document,
                            'motto' => $this->input->post('motto'),
                            'currency' => $this->input->post('currency'),
                            'employees_time_in' => $this->input->post('employees_time_in'),
                            'employees_time_out' => $this->input->post('employees_time_out'),
                            'website' => $this->input->post('website'),
                            'list_size' => $this->input->post('list_size'),
                            'prefix' => $this->input->post('prefix'),
                            'fax' => $this->input->post('fax'),
                            'town' => $this->input->post('town'),
                            'mobile_pay' => $this->input->post('mobile_pay'),
                            'school_code' => $this->input->post('school_code'),
                            'modified_by' => $user->id,
                            'modified_on' => time());
                }
                //check For Settings
                if (!$this->settings_m->is_setup())
                {
                        //Insert Settings
                        if ($this->form_validation->run())
                        {        //Validation OK!
                                $ok = $this->settings_m->create($form_data);

                                if ($ok) 
                                {
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                }
                                if (!$this->settings_m->laid_cables())
                                {
                                        $this->settings_m->commence($this->throttle);
                                }
                                //head to Setup Wizard
                                redirect('admin/setup/');
                        }
                        else
                        {
                                $get = new StdClass();
                                foreach ($this->validation() as $field)
                                {
                                        $get->{$field['field']} = set_value($field['field']);
                                }
                        }
                        $data['updType'] = 'create';
                }
                else
                {
                        //edit Settings
                        $get = $this->settings_m->fetch();
                        $document = $get->document;
                        $user = $this->ion_auth->get_user();

                        if (!empty($_FILES['document']['name']))
                        {
                                $this->load->library('files_uploader');
                                $upload_data = $this->files_uploader->upload('document');
                                $document = $upload_data['file_name'];
                        }

                        $form_data = array(
                            'school' => $this->input->post('school'),
                            'postal_addr' => $this->input->post('postal_addr'),
                            'email' => $this->input->post('email'),
                            'tel' => $this->input->post('tel'),
                            'cell' => $this->input->post('cell'),
                            'sender_id' => $this->input->post('sender_id'),
                            'pre_school' => $this->input->post('pre_school'),
                            'message_initial' => $this->input->post('message_initial'),
                            'document' => $document,
                            'employees_time_in' => $this->input->post('employees_time_in'),
                            'employees_time_out' => $this->input->post('employees_time_out'),
                            'motto' => $this->input->post('motto'),
                            'currency' => $this->input->post('currency'),
                            'website' => $this->input->post('website'),
                            'list_size' => $this->input->post('list_size'),
                            'prefix' => $this->input->post('prefix'),
                            'fax' => $this->input->post('fax'),
                            'town' => $this->input->post('town'),
                            'mobile_pay' => $this->input->post('mobile_pay'),
                            'school_code' => $this->input->post('school_code'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        if ($this->form_validation->run())  //validation has been passed
                        {
                                $done = $this->settings_m->update_settings($form_data);
                                // the information has   been successfully saved in the db
                                if ($done)
                                {
                                        //head bak to dashboard
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                        redirect("admin/");
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "An error occured kindly consult IT "));
                                        redirect("admin/settings/");
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
                        $data['updType'] = 'edit';
                }

                $data['result'] = $get;
                //load the view and the layout
                $this->template->title('School & System Settings')->build('admin/create', $data);
        }
 
        /**
         * SMS CODE Page
         */
        function sms_code()
        {
                $this->load->library('Pad');

                $data['ct'] = $this->settings_m->get_by_current();
                $this->template
                             ->title('SMS Code')
                             ->build('admin/active', $data);
        }

        function parse_sm()
        {
                if ($this->input->post('sm_code'))
                {
                        $lii = $this->input->post('sm_code');
                        if (strlen($lii) > 1000)
                        {
                                $user = $this->ion_auth->get_user();
                                $padl = new Padl\License(true, true, true, true);

                                $lice = $padl->validate($lii);
                                $lc = json_decode(json_encode($lice));

                                if ($lc->RESULT == 'OK')
                                {
                                        if (isset($lc->DATA) && isset($lc->DATA->sms) && isset($lc->DATA->client) && isset($lc->DATA->key) && isset($this->school->hash) && !empty($this->school->hash))
                                        {
                                                if ($lc->DATA->client == $this->school->hash)
                                                {
                                                        $ct = $lc->DATA->sms;
                                                        $hash = $lc->ID;
                                                        $form_data = array(
                                                            'client' => $lc->DATA->client,
                                                            'count' => $ct,
                                                            'ref' => $lc->DATA->key,
                                                            'hash' => $hash,
                                                            'raw_str' => $lii,
                                                            'created_by' => $user->id,
                                                            'created_on' => time()
                                                        );

                                                        if ($this->settings_m->sm_exists($lc->DATA->client, $lc->DATA->key, $hash))
                                                        {
                                                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'CODE HAS ALREADY BEEN USED!'));
                                                        }
                                                        else
                                                        {
                                                                $dd = $this->settings_m->save_sm($form_data);
                                                                if ($dd)
                                                                {
                                                                        //update nwbks count 
                                                                        if ($this->settings_m->bk_exists())
                                                                        {
                                                                                $row = $this->settings_m->find_bk();

                                                                                $bk = array(
                                                                                    'total_count' => $ct + $row->total_count,
                                                                                    'modified_by' => $user->id,
                                                                                    'modified_on' => time()
                                                                                );

                                                                                $this->settings_m->update_bk($bk);
                                                                        }

                                                                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => 'Top up Successful'));
                                                                }
                                                        }
                                                }
                                                else
                                                {
                                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'ILLEGAL CODE'));
                                                }
                                        }
                                        else
                                        {
                                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'MISSING PARAMETERS'));
                                        }
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'INVALID CODE'));
                                }
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'INVALID CODE'));
                        }
                }

                redirect('admin/settings/sms_code');
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'school',
                        'label' => 'School Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'postal_addr',
                        'label' => 'Postal Address',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[350]'),
                    array(
                        'field' => 'currency',
                        'label' => 'Currency',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'sender_id',
                        'label' => 'SMS Sender ID',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'tel',
                        'label' => 'Telephone',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'cell',
                        'label' => 'cell phone',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'motto',
                        'label' => 'Motto',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'document',
                        'label' => 'Document',
                        'rules' => ''),
                    array(
                        'field' => 'list_size',
                        'label' => 'list_size',
                        'rules' => ''),
                    array(
                        'field' => 'pre_school',
                        'label' => 'pre_school',
                        'rules' => ''),
                    array(
                        'field' => 'website',
                        'label' => 'Official Website',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'fax',
                        'label' => 'Fax',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'message_initial',
                        'label' => 'message initial',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'town',
                        'label' => 'Town',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'employees_time_in',
                        'label' => 'employees time in',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'employees_time_out',
                        'label' => 'employees time out',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'school_code',
                        'label' => 'School Code',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        /**
         * GZIPs a file on disk (appending .gz to the name)
         *
         * From http://stackoverflow.com/questions/6073397/how-do-you-create-a-gz-file-using-php
         * Based on function by Kioob at:
         * http://www.php.net/manual/en/function.gzwrite.php#34955
         * 
         * @param string $source Path to file that should be compressed
         * @param integer $level GZIP compression level (default: 9)
         * @return string New filename (with .gz appended) if success, or false if operation fails
         */
        function gzFile($source, $level = 9)
        {
                $dest = $source . '.gz';
                $mode = 'wb' . $level;
                $error = false;
                if ($fp_out = gzopen($dest, $mode))
                {
                        if ($fp_in = fopen($source, 'rb'))
                        {
                                while (!feof($fp_in))
                                        gzwrite($fp_out, fread($fp_in, 1024 * 512));
                                fclose($fp_in);
                        }
                        else
                        {
                                $error = true;
                        }
                        gzclose($fp_out);
                }
                else
                {
                        $error = true;
                }
                if ($error)
                        return false;
                else
                        return $dest;
        }
  
        function backup()
        {
                $this->load->library('Dump');
                $dump = new Ifsnop\Mysqldump\Mysqldump($this->db->database, $this->db->username, $this->db->password);

                @mkdir(FCPATH . 'uploads/dump', 777, TRUE);
                $dump->start(FCPATH . 'uploads/dump/' . date('d_M_Y_H_i') . '');

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Backup Complete'));
                redirect('admin');
        }

}
