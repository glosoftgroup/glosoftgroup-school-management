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
              $this->load->model('meetings_m');
               $this->load->model('email_templates/email_templates_m');
              $this->load->library('pmailer');
              $this->load->library('image_cache');
         }

         public function index()
         {
              $config = $this->set_paginate_options();
              $this->pagination->initialize($config);

              $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
              $data['meetings'] = $this->meetings_m->paginate_all($config['per_page'], $page);
              //create pagination links
              $data['links'] = $this->pagination->create_links();

              //page number  variable
              $data['page'] = $page;
              $data['per'] = $config['per_page'];

              //load view
              if ($this->ion_auth->is_in_group($this->user->id, 3))
              {
                   $this->template->title(' Meeting')
				   	->set_layout('teachers')
				->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
				->set_partial('teachers_top', 'partials/teachers_top.php')
				   ->build('admin/list', $data);
              }
              else
              {
                   $this->template->title(' Meetings ')->build('admin/list', $data);
              }
         }

         //Details view function
         function view($id)
         {

              //redirect if no $id
              if (!$id)
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/meetings/');
              }
              if (!$this->meetings_m->exists($id))
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/meetings');
              }

              $data['meetings'] = $this->meetings_m->get_all();
              $data['p'] = $this->meetings_m->find($id);

              if ($this->ion_auth->is_in_group($this->user->id, 3))
              {
                   $this->template->title(' Meeting Details')
				   	->set_layout('teachers')
				->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
				->set_partial('teachers_top', 'partials/teachers_top.php')
				   ->build('admin/view', $data);
              }
              else
              {
                   $this->template->title(' Meeting Details ')->build('admin/view', $data);
              }
         }

         //User Calendar Function
         function calendar()
         {


              $events = $this->meetings_m->get_all();
              $data['events'] = $events;
              if ($this->ion_auth->is_in_group($this->user->id, 3))
              {
                   $this->template->title(' Calendar')
				   	->set_layout('teachers')
				->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
				->set_partial('teachers_top', 'partials/teachers_top.php')
				   ->build('admin/calendar', $data);
              }
              else
              {
                   $this->template->title('Calendar')->build('admin/calendar', $data);
              }
         }

         //Create New Item

         function create($page = NULL)
         {
              /* if (!$this->ion_auth->is_in_group($this->user->id, 1))
                {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to create a meeting!!</b>'));
                redirect('admin/meetings');
                } */

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

                   $user_id = $this->input->post('user_id');

                   //Type 1 is for school staff
                   //Type 2 is for parents
                   //Type 0 is for combined eg all parents etc
                   $type = 0;

                   if ($this->input->post('send_to') == 'Parents and Staff')
                   {
                        $user_id = 'Parents and Staff';
                   }
                   if ($this->input->post('send_to') == 'All Parents')
                   {
                        $user_id = 'All Parents';
                   }
                   if ($this->input->post('send_to') == 'All Teachers')
                   {
                        $user_id = 'All Teachers';
                   }
                   if ($this->input->post('send_to') == 'All Staff')
                   {
                        $user_id = 'All Staff';
                   }
                   if ($this->input->post('send_to') == 'Staff')
                   {
                        $user_id = $this->input->post('staff');
                        $type = 1;
                   }
                   if ($this->input->post('send_to') == 'Parent')
                   {
                        $user_id = $this->input->post('parent');
                        $type = 2;
                   }

                   //TYPE 1 is staff while TYPE 2 is Parent

                   $form_data = array(
                           'title' => $this->input->post('title'),
                           'start_date' => strtotime($this->input->post('start_date')),
                           'end_date' => strtotime($this->input->post('end_date')),
                           'venue' => $this->input->post('venue'),
                           'importance' => $this->input->post('importance'),
                           'status' => $this->input->post('status'),
                           'type' => $type,
                           'guests' => $user_id,
                           'description' => $this->input->post('description'),
                           'created_by' => $user->id,
                           'created_on' => time()
                   );

                   $ok = $this->meetings_m->create($form_data);

                   if ($ok) 
                   {
                        $title = $this->input->post('title');
                        $start_date = $this->input->post('start_date');
                        $end_date = $this->input->post('end_date');

                        if ($this->input->post('send_to') == 'All Parents')
                        {

                             $members = $this->ion_auth->get_parent();

                             foreach ($members as $member)
                             {



                                  //SEND SMS

                                  $recipient = $member->phone;
                                  $country_code = '254';
                                  $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                                  $to = $member->parent_fname;
                                  $message = 'Hi ' . $to . ', you are being invited for a ' . $this->input->post('title') . ' Starting on ' . $start_date . ' To ' . $end_date;
                                  $from = "SMARTSHULE";
                                  $this->sms_m->send_sms($new_number, $message, $from);

                                  //SEND EMAIL

                                  $subject = 'Meeting Notification';
                                  $to = $member->parent_fname . ' ' . $member->parent_lname . " <" . $member->parent_email . " > ";
                                  $from = $user->first_name . ' ' . $user->last_name . " <" . $user->email . " > ";

                                  $email_body = $this->email_templates_m->template('meetings', array(
                                          'SUBJECT' => $subject,
                                          'TO' => $to,
                                          'FROM' => $from,
                                          'MEETING TITLE' => $title,
                                          'DATE FROM' => $start_date,
                                          'DATE TO' => $end_date,
                                          'VENUE' => $this->input->post('venue'),
                                          'IMPORTANCE' => $this->input->post('importance'),
                                          'DESCRIPTION' => $this->input->post('description'),
                                  ));
                                  //print_r($email_body);die;
                                  $mail_from = 'no-reply@school.com';
                                  $html_msg = $this->image_cache->get_embed($email_body, 1);
                                  $this->pmailer->send_mail($member->parent_email, $subject, $html_msg['content'], $mail_from, $attmnt, '', '', $html_msg['embed']);
                                  //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
                             }
                        }

                        if ($this->input->post('send_to') == 'All Teachers')
                        {

                             $members = $this->ion_auth->get_teacher();

                             foreach ($members as $member)
                             {
                                  $subject = 'Meeting Notification';
                                  $to = $member->first_name . ' ' . $member->last_name . " <" . $member->email . " > ";


                                  $from = $user->first_name . ' ' . $user->last_name . " <" . $user->email . " > ";

                                  $content = '';

                                  $year = date('Y');
                                  $email_body = $this->email_templates_m->template('meetings', array(
                                          'SUBJECT' => $subject,
                                          'TO' => $to,
                                          'FROM' => $from,
                                          'MEETING TITLE' => $title,
                                          'DATE FROM' => $start_date,
                                          'DATE TO' => $end_date,
                                          'VENUE' => $this->input->post('venue'),
                                          'IMPORTANCE' => $this->input->post('importance'),
                                          'DESCRIPTION' => $this->input->post('description'),
                                  ));

                                  //print_r($email_body);die;

                                  $mail_from = 'no-reply@school.com';
                                  $html_msg = $this->image_cache->get_embed($email_body, 1);
                                  $this->pmailer->send_mail($member->email, $subject, $html_msg['content'], $mail_from, $attmnt, '', '', $html_msg['embed']);
                                  //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
                             }
                        }
                        //Send to all staff
                        if ($this->input->post('send_to') == 'All Staff')
                        {

                             $members = $this->ion_auth->get_users();

                             foreach ($members as $member)
                             {
                                  $subject = 'Meeting Notification';
                                  $to = $member->first_name . ' ' . $member->last_name . " <" . $member->email . " > ";
                                  $from = $user->first_name . ' ' . $user->last_name . " <" . $user->email . " > ";

                                  $content = '';

                                  $year = date('Y');
                                  $email_body = $this->email_templates_m->template('meetings', array(
                                          'SUBJECT' => $subject,
                                          'TO' => $to,
                                          'FROM' => $from,
                                          'MEETING TITLE' => $title,
                                          'DATE FROM' => $start_date,
                                          'DATE TO' => $end_date,
                                          'VENUE' => $this->input->post('venue'),
                                          'IMPORTANCE' => $this->input->post('importance'),
                                          'DESCRIPTION' => $this->input->post('description'),
                                  ));

                                  $mail_from = 'no-reply@school.com';
                                  $html_msg = $this->image_cache->get_embed($email_body, 1);
                                  $this->pmailer->send_mail($member->email, $subject, $html_msg['content'], $mail_from, $attmnt, '', '', $html_msg['embed']);
                                  //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
                             }
                        }


                        if ($this->input->post('send_to') == 'Staff')
                        {


                             $member = $this->ion_auth->get_user($this->input->post('staff'));



                             $subject = 'Meeting Notification';
                             $to = $member->first_name . ' ' . $member->last_name . " <" . $member->email . " > ";


                             $from = $user->first_name . ' ' . $user->last_name . " <" . $user->email . " > ";

                             $content = '';

                             $year = date('Y');
                             $email_body = $this->email_templates_m->template('meetings', array(
                                     'SUBJECT' => $subject,
                                     'TO' => $to,
                                     'FROM' => $from,
                                     'MEETING TITLE' => $title,
                                     'DATE FROM' => $start_date,
                                     'DATE TO' => $end_date,
                                     'VENUE' => $this->input->post('venue'),
                                     'IMPORTANCE' => $this->input->post('importance'),
                                     'DESCRIPTION' => $this->input->post('description'),
                             ));

                             //print_r($email_body);die;

                             $mail_from = 'no-reply@school.com';
                             $html_msg = $this->image_cache->get_embed($email_body, 1);
                             $this->pmailer->send_mail($member->email, $subject, $html_msg['content'], $mail_from, $attmnt, '', '', $html_msg['embed']);
                             //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
                        }
                        if ($this->input->post('send_to') == 'Parent')
                        {


                             $member = $this->ion_auth->get_single_parent($this->input->post('parent'));

                             //SEND SMS	
                             $recipient = $member->phone;
                             $country_code = '254';
                             $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                             $to = $member->parent_fname;
                             $message = 'Hi ' . $to . ', you are being invited for a ' . $this->input->post('title') . ' Starting on ' . $start_date . ' To ' . $end_date;
                             $from = "SMARTSHULE";
                             $this->sms_m->send_sms($new_number, $message, $from);
                             //SEND EMAIL

                             $subject = 'Meeting Notification';
                             $to = $member->parent_fname . ' ' . $member->parent_lname . " <" . $member->parent_email . " > ";


                             $from = $user->first_name . ' ' . $user->last_name . " <" . $user->email . " > ";

                             $content = '';

                             $year = date('Y');
                             $email_body = $this->email_templates_m->template('meetings', array(
                                     'SUBJECT' => $subject,
                                     'TO' => $to,
                                     'FROM' => $from,
                                     'MEETING TITLE' => $title,
                                     'DATE FROM' => $start_date,
                                     'DATE TO' => $end_date,
                                     'VENUE' => $this->input->post('venue'),
                                     'IMPORTANCE' => $this->input->post('importance'),
                                     'DESCRIPTION' => $this->input->post('description'),
                             ));

                             //print_r($email_body);die;

                             $mail_from = 'no-reply@school.com';
                             $html_msg = $this->image_cache->get_embed($email_body, 1);
                             $this->pmailer->send_mail($member->parent_email, $subject, $html_msg['content'], $mail_from, $attmnt, '', '', $html_msg['embed']);
                             //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
                        }


                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Meeting saved and alert Sent Successfully'));
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                   }

                   redirect('admin/meetings/');
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
                   if ($this->ion_auth->is_in_group($this->user->id, 3))
                   {
                        $this->template->title('Add Meeting')
							->set_layout('teachers')
				->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
				->set_partial('teachers_top', 'partials/teachers_top.php')
						->build('admin/create', $data);
                   }
                   else
                   {
                        $this->template->title('Add Meetings ')->build('admin/create', $data);
                   }
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
                   redirect('admin/meetings/');
              }
              if (!$this->meetings_m->exists($id))
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/meetings');
              }
              //search the item to show in edit form
              $get = $this->meetings_m->find($id);
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
                           'title' => $this->input->post('title'),
                           'start_date' => strtotime($this->input->post('start_date')),
                           'end_date' => strtotime($this->input->post('end_date')),
                           'venue' => $this->input->post('venue'),
                           'importance' => $this->input->post('importance'),
                           'status' => $this->input->post('status'),
                           'guests' => $this->input->post('guests'),
                           'description' => $this->input->post('description'),
                           'modified_by' => $user->id,
                           'modified_on' => time());

                   //add the aux form data to the form data array to save
                   $form_data = array_merge($form_data_aux, $form_data);

                   //find the item to update

                   $done = $this->meetings_m->update_attributes($id, $form_data);

                   
                   if ($done)
                   {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                        redirect("admin/meetings/");
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                        redirect("admin/meetings/");
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
              if ($this->ion_auth->is_in_group($this->user->id, 3))
              {
                   $this->template->title(' Edit Meeting')
				   	->set_layout('teachers')
				->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
				->set_partial('teachers_top', 'partials/teachers_top.php')
				   ->build('admin/create', $data);
              }
              else
              {
                   $this->template->title('Edit Meetings ')->build('admin/create', $data);
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

                   redirect('admin/meetings');
              }

              //search the item to delete
              if (!$this->meetings_m->exists($id))
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                   redirect('admin/meetings');
              }

              //delete the item
              if ($this->meetings_m->delete($id) == TRUE)
              {
                   $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
              }
              else
              {
                   $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
              }

              redirect("admin/meetings/");
         }

         private function validation()
         {
              $config = array(
                      array(
                              'field' => 'title',
                              'label' => 'Title',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'start_date',
                              'label' => 'Start Date',
                              'rules' => 'required|xss_clean'),
                      array(
                              'field' => 'send_to',
                              'label' => 'Send To',
                              'rules' => 'trim|required|xss_clean',
                      ),
                      array(
                              'field' => 'end_date',
                              'label' => 'End Date',
                              'rules' => 'required|xss_clean'),
                      array(
                              'field' => 'venue',
                              'label' => 'Venue',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'importance',
                              'label' => 'Importance',
                              'rules' => 'xss_clean'),
                      array(
                              'field' => 'status',
                              'label' => 'Status',
                              'rules' => 'xss_clean'),
                      array(
                              'field' => 'guests',
                              'label' => 'Guests',
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
              $config['base_url'] = site_url() . 'admin/meetings/index/';
              $config['use_page_numbers'] = TRUE;
              $config['per_page'] = 100;
              $config['total_rows'] = $this->meetings_m->count();
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
    