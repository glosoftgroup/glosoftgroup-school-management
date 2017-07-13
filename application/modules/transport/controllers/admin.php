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
                $this->load->model('transport_m');
                if ($this->input->get('sw'))
                {
                        $valid = $this->portal_m->get_class_ids();
                        $pop = $this->input->get('sw');
                        //limit to available classes only
                        if (!in_array($pop, $valid))
                        {
                                $pop = $valid[0];
                        }
                        $this->session->set_userdata('pop', $pop);
                }
                else if ($this->session->userdata('pop'))
                {
                        $pop = $this->session->userdata('pop');
                }
                else
                {
                        
                }
        }

        function add_route()
        {
                $name = $this->input->post('name');
                //validate the fields of form
                if (!empty($name))
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'name' => $name,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->transport_m->create_route($form_data);
                        if ($ok)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Route Name cannot be Blank'));
                }
                redirect('admin/transport/routes/');
        }

        function students($id)
        {
                $data['routes'] = $this->transport_m->get_routes();
                $data['students'] = $this->transport_m->get_route_students($id);
                $data['top'] = 1;
                $data['row'] = $this->transport_m->find_route($id);
                $this->template->title('Transport Routes')->build('admin/routes', $data);
        }

        public function index()
        {
                $this->form_validation->set_rules($this->ex_validation());
                if ($this->input->post())
                {
                        if ($this->form_validation->run())
                        {
                                $slist = $this->input->post('sids');
                                $route = $this->input->post('route');
                                $term = $this->input->post('term');
                                $year = $this->input->post('year');
                                $i = 0;
                                $j = 0;
                                if (is_array($slist) && count($slist))
                                {

                                        foreach ($slist as $s)
                                        {
                                                $rt = array(
                                                    'student' => $s,
                                                    'term' => $term,
                                                    'year' => $year,
                                                    'route' => $route,
                                                    'created_on' => time(),
                                                    'created_by' => $this->ion_auth->get_user()->id
                                                );
                                                $has_rt = $this->transport_m->has_route($route, $s, $term, $year);
                                                if ($has_rt)
                                                {
                                                        $put = $this->transport_m->set_route_update($has_rt, $rt);
                                                        $j++;
                                                }
                                                else
                                                {
                                                        $put = $this->transport_m->create($rt);
                                                        if ($put)
                                                        {
                                                                $i++;
                                                        }
                                                }
                                        }
                                }

                                $mess = 'Status:  ' . $i . ' new and Updated ' . $j . ' Existing Routes ';
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                        }
                        redirect('admin/transport/');
                }
                $range = range(date('Y') - 1, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['list'] = $this->transport_m->populate('transport_routes', 'id', 'name');
                //load view
                $this->template->title(' Transport ')->build('admin/home', $data);
        }

        public function routes()
        {
                if ($this->input->post())
                {
                        $name = $this->input->post('name');
                        //validate the fields of form
                        if (!empty($name))
                        {         //Validation OK!
                                $user = $this->ion_auth->get_user();
                                $form_data = array(
                                    'name' => $name,
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $ok = $this->transport_m->create_route($form_data);
                                if ($ok)
                                {
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                }
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Route Name cannot be Blank'));
                        }
                        redirect('admin/transport/routes/');
                }
                $data['routes'] = $this->transport_m->get_routes();
                //load view
                $this->template->title('Transport Routes')->build('admin/routes', $data);
        }

        function edit_route($id = 0)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/transport/routes');
                }
                if (!$this->transport_m->route_exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/transport/routes');
                }
                $get = $this->transport_m->find_route($id);

                if ($this->input->post())
                {
                        if (empty($this->input->post('name')))
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Route name cannot be Blank"));
                                redirect("admin/transport/");
                        }
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->transport_m->update_route($id, $form_data);
                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Error'));
                        }
                        redirect("admin/transport/routes");
                }
                $data['result'] = $get;

                //load the view and the layout
                $this->template->title('Edit Route ')->build('admin/routes', $data);
        }

        function delete_route($id = 0)
        {
                if (!$id || !$this->transport_m->route_exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/transport/routes');
                }
                //delete the item
                if ($this->transport_m->delete($id, 'transport_routes') == TRUE)
                {
                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }
                redirect("admin/transport/routes/");
        }

        private function ex_validation()
        {
                $config = array(
                    array(
                        'field' => 'sids',
                        'label' => 'Student List',
                        'rules' => 'xss_clean|callback__valid_sid'),
                    array(
                        'field' => 'route',
                        'label' => 'Route',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'year',
                        'label' => 'Year',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'term',
                        'label' => 'Term',
                        'rules' => 'required|xss_clean')
                );
                $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
                return $config;
        }

        function _valid_sid()
        {
                $sid = $this->input->post('sids');
                if (is_array($sid) && count($sid))
                {
                        return TRUE;
                }
                else
                {
                        $this->form_validation->set_message('_valid_sid', 'Please Select at least one Student.');
                        return FALSE;
                }
        }

}
