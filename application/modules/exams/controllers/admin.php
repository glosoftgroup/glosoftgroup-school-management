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
                if ($this->input->get('sb'))
                {
                        $pop = $this->input->get('sb');
                        $this->session->set_userdata('sub', $pop);
                }
                else
                {
                        
                }
                $this->load->model('exams_m');
                $valid = $this->portal_m->get_class_ids();
                if ($this->input->get('sw'))
                {
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
                        //just list All
                }
        }

        /**
         * Module Index
         */
        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['exams'] = $this->exams_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['classes'] = $this->exams_m->list_classes();

                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Exams ')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/list', $data);
                }
                else
                {
                        //load view
                        $this->template->title('Exams ')->build('admin/list', $data);
                }
        }

        /**
         * Record Exam Marks
         * 
         * @param int $exid Exam ID
         * @param int $id Class
         */
        function rec_upper($exid = 0, $id = 0)
        {
                if (!$exid || !$id)
                {
                        redirect('admin/exams');
                }
                if ($this->exams_m->rec_exists($exid, $id))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'You have already Recorded Marks For that Class/Exam. Use Edit Marks Instead'));
                        redirect('admin/exams');
                }
                $students = array();
                $sb = 0;
                //push class name to next view
                $class_name = $this->exams_m->populate('class_groups', 'id', 'name');
                $tar = $this->exams_m->get_stream($id);
                $exam = $this->exams_m->find($exid);
                $class_id = $tar->class;
                $stream = $tar->stream;
                $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . '</span>';

                $subjects = $this->exams_m->get_subjects($id, $exam->term);

                if ($this->input->get('sb'))
                {
                        $sb = $this->input->get('sb');
                        $data['selected'] = isset($subjects[$sb]) ? $subjects[$sb] : array();
                        $row = $this->exams_m->fetch_subject($sb);
                        $rrname = $row ? ' - ' . $row->name : '';
                        $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . $rrname . '</span>';
                        if ($row->is_optional == 2)
                        {
                                $students = $this->exams_m->get_assigned_students($sb);
                        }
                        else
                        {
                                $students = $this->exams_m->get_students($class_id, $stream);
                        }
                }

                $data['list_subjects'] = $this->exams_m->list_subjects();
                $data['subjects'] = $subjects;
                $data['class_name'] = $heading;
                $data['count_subjects'] = $this->exams_m->count_subjects($class_id, $exam->term);
                $data['full_subjects'] = $this->exams_m->get_full_subjects();

                //create control variables
                $data['updType'] = 'create';
                $data['page'] = '';
                $data['exams'] = $this->exams_m->list_exams();
                $data['grading'] = $this->exams_m->get_grading_system();
                //Rules for validation
                $this->form_validation->set_rules($this->rec_validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        if ($this->input->get('sb'))
                        {
                                $sb = $this->input->get('sb');
                                $gd_id = $this->input->post('grading');
                                $marks = $this->input->post('marks');
                                $units = $this->input->post('units');

                                $user = $this->ion_auth->get_user();
                                $form_data = array(
                                    'exam_type' => $exid,
                                    'class_id' => $id,
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );
                                $ok = $this->exams_m->create_ex($form_data);
                                $this->exams_m->set_grading($exid, $id, $sb, $gd_id, $user->id);

                                $perf_list = $this->_prep_marks($sb, $ok, $marks, $units);

                                foreach ($perf_list as $dat)
                                {
                                        $dat = (object) $dat;
                                        $values = array(
                                            'exams_id' => $dat->exams_id,
                                            'student' => $dat->student,
                                            // 'total' => $dat->total,
                                            // 'remarks' => $dat->remarks,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $list_id = $this->exams_m->create_list($values);

                                        $mm = (object) $dat->marks;
                                        $fvalues = array(
                                            'exams_list_id' => $list_id,
                                            'marks' => $mm->marks ? $mm->marks : 0,
                                            'subject' => $mm->subject,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $this->exams_m->insert_marks($fvalues);

                                        if (isset($dat->units) && count($dat->units))
                                        {
                                                foreach ($dat->units as $sm)
                                                {
                                                        $sm = (object) $sm;
                                                        $svalues = array(
                                                            'marks_list_id' => $list_id,
                                                            'parent' => $sm->parent,
                                                            'unit' => $sm->unit,
                                                            'marks' => $sm->marks,
                                                            'created_by' => $user->id,
                                                            'created_on' => time()
                                                        );
                                                        $this->exams_m->insert_subs($svalues);
                                                }
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
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Subject Not Specified'));
                        }
                        redirect('admin/exams/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->rec_validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['sb'] = $sb;
                        $data['result'] = $get;
                        $data['students'] = $students;
                        //load the view and the layout
                        if ($this->ion_auth->is_in_group($this->user->id, 3))
                        {
                                $this->template->title('Record Exam Marks')
                                             ->set_layout('teachers')
                                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                                             //->set_layout('wide.php')
                                             ->build('admin/upper_rec', $data);
                        }
                        else
                        {
                                $this->template->title('Record Exam Marks')->build('admin/upper_rec', $data);
                        }
                }
        }

        function _prep_marks($subject, $exm_mgmt_id, $marks = array(), $units = array())
        {
                $perf_list = array();
                $sub_marks = array();
                $user = $this->ion_auth->get_user();
                if ($units && !empty($units))
                {
                        foreach ($units as $stid => $unmarks)
                        {
                                foreach ($unmarks as $uid => $mk)
                                {
                                        $sunits[] = array(
                                            'parent' => $subject,
                                            'unit' => $uid,
                                            'marks' => $mk
                                        );
                                }
                        }
                }

                foreach ($marks as $std => $score)
                {
                        $sunits = array();
                        $sub_marks = array(
                            'subject' => $subject,
                            'marks' => $score
                        );
                        if ($units && isset($units[$std]))
                        {
                                $mine = $units[$std];
                                foreach ($mine as $uid => $mk)
                                {
                                        $sunits[] = array(
                                            'parent' => $subject,
                                            'unit' => $uid,
                                            'marks' => $mk
                                        );
                                }
                        }
                        $perf_list[] = array(
                            'exams_id' => $exm_mgmt_id,
                            'student' => $std,
                            'marks' => $sub_marks,
                            'units' => $sunits,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                }
                return $perf_list;
        }

        /**
         * Generate Report Forms  - Bulk
         * 
         * @param $exam
         * @param $student
         */
        function bulk($exam)
        {
                $flag = FALSE;
                if ($this->input->post() && $this->input->post('student'))
                {
                        $student = $this->input->post('student');
                        $xm = $this->exams_m->find($exam);
                        $obst = $this->worker->get_student($student);
                        $tar = $this->exams_m->get_stream($obst->class);

                        $rec = $this->exams_m->is_recorded($exam);
                        $has = TRUE;
                        if (!$xm || !$rec)
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
                                $has = FALSE;
                        }

                        $data['report'] = $this->exams_m->get_report($exam, $student);

                        $data['exam'] = $xm;
                        $data['subjects'] = $this->exams_m->get_subjects($tar->id, $xm->term, 1);
                        $data['full'] = $this->exams_m->list_subjects_alt(1);
                        $st = $this->worker->get_student($student);
                        $this->load->model('reports/reports_m');
                        $dcl = $this->reports_m->get_class_by_year($student, $xm->year);
                        $did = $this->exams_m->get_by_class($dcl->class, $dcl->stream);

                        $streams = $this->exams_m->populate('class_stream', 'id', 'name');

                        $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
                        $data['student'] = $st;
                        $data['proc'] = $has;
                        $data['streams'] = $streams;
                        $data['cls'] = $did;
                }
                else if ($this->input->post() && $this->input->post('class'))
                {
                        $flag = 1;
                        $class = $this->input->post('class');
                        $list = $this->portal_m->list_students($class);

                        $payload = array();
                        $xm = $this->exams_m->find($exam);
                        $rec = $this->exams_m->is_recorded($exam);
                        $has = TRUE;
                        if (!$xm || !$rec)
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
                                $has = FALSE;
                        }
                        $this->load->model('reports/reports_m');
                        foreach ($list as $key => $sid)
                        {
                                $obst = $this->worker->get_student($sid);
                                $tar = $this->exams_m->get_stream($obst->class);
                                $report = $this->exams_m->get_report($exam, $sid);
                                $st = $this->worker->get_student($sid);
                                $dcl = $this->reports_m->get_class_by_year($sid, $xm->year);
                                $mcl = '';
                                if (!empty($dcl))
                                {
                                        $mcl = $this->exams_m->get_by_class($dcl->class, $dcl->stream);
                                }
                                $report['cls'] = $mcl;
                                $report['student'] = $st;
                                $payload[] = $report;
                        }

                        $streams = $this->exams_m->populate('class_stream', 'id', 'name');
                        $data['proc'] = $has;
                        $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
                        $data['subjects'] = $this->exams_m->get_subjects($tar->id, $xm->term, 1);
                        $data['exam'] = $xm;
                        $data['full'] = $this->exams_m->list_subjects_alt(1);
                        $data['streams'] = $streams;
                        foreach ($payload as $kk => $p)
                        {
                                if (!isset($p['marks']))
                                {
                                        unset($payload[$kk]);
                                }
                        }

                        $data['payload'] = sort_by_field($payload, 'total', 3);
                }
                else
                {
                        
                }


                $data['flag'] = $flag;
                $data['classes'] = $this->classlist;
                $range = range(date('Y') - 1, date('Y') + 1);
                $data['yrs'] = array_combine($range, $range);
                $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');

                $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');

                $data['subject_title'] = $this->exams_m->populate('subjects', 'id', 'short_name');
                $data['years_exams'] = $this->exams_m->years_exams();
                $data['exams_name'] = $this->exams_m->exam_details('exams', 'id', 'title');
                $data['exams_type_id'] = $this->exams_m->populate('exams_management', 'id', 'exam_type');
                //load the view and the layout
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template
                                     ->title('Generate Report Forms')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/bulk', $data);
                }
                else
                {
                        $this->template->title('Generate Report Forms')->build('admin/bulk', $data);
                }
        }

        /**
         * Bulk Edit Exam Marks
         * 
         * @param int $exid Exam ID
         * @param int $id Class
         */
        function bulk_edit($exid = 0, $id = 0)
        {
                if (!$exid || !$id)
                {
                        redirect('admin/exams');
                }
                if (!$this->exams_m->rec_exists($exid, $id))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'You have Not Recorded Marks For that Class/Exam. Record Marks First'));
                        redirect('admin/exams');
                }
                $students = array();
                $rest = array();
                $sb = 0;
                $class_name = $this->exams_m->populate('class_groups', 'id', 'name');
                $tar = $this->exams_m->get_stream($id);
                $exam = $this->exams_m->find($exid);
                $xm = $this->exams_m->fetch_rec($exid, $id);
                $xm OR redirect('admin/exams');
                $class_id = $tar->class;
                $stream = $tar->stream;
                $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . '</span>';
                $subjects = $this->exams_m->get_subjects($id, $exam->term);

                $gdd = 0;
                if ($this->input->get('sb'))
                {
                        $sb = $this->input->get('sb');
                        $data['selected'] = isset($subjects[$sb]) ? $subjects[$sb] : array();
                        $row_gd = $this->exams_m->fetch_grading($exid, $id, $sb);
                        if (!empty($row_gd))
                        {
                                $gdd = $row_gd->grading;
                        }
                        $row = $this->exams_m->fetch_subject($sb);
                        $rrname = $row ? ' - ' . $row->name : '';
                        $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . $rrname . '</span>';
                        if ($row->is_optional == 2)
                        {
                                $students = $this->exams_m->get_assigned_students($sb);
                        }
                        else
                        {
                                $students = $this->exams_m->get_students($class_id, $stream);
                        }
                        $list = $this->exams_m->fetch_list($exid, $id);
                        if (!$list)
                        {
                                redirect('admin/exams');
                        }

                        $pps = $this->exams_m->fetch_student_list($list->id);
                        foreach ($pps as $mk)
                        {
                                $marks = $this->exams_m->fetch_done_list($sb, $mk->id);
                                $rest[$mk->student]['marks'] = $marks;
                                $rest[$mk->student]['total'] = $mk->total;
                                $rest[$mk->student]['remarks'] = $mk->remarks;
                        }
                }
                $data['sel_gd'] = $gdd;
                $data['list_subjects'] = $this->exams_m->list_subjects();
                $data['subjects'] = $subjects;
                $data['count_subjects'] = $this->exams_m->count_subjects($class_id, $exam->term);
                $data['full_subjects'] = $this->exams_m->get_full_subjects();
                $data['grading'] = $this->exams_m->get_grading_system();
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = '';
                $data['exams'] = $this->exams_m->list_exams();
                //Rules for validation
                $this->form_validation->set_rules($this->rec_validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        if ($this->input->get('sb'))
                        {
                                $sbj = $this->input->get('sb');
                                $marks = $this->input->post('marks');
                                $units = $this->input->post('units');
                                $gd_id = $this->input->post('grading');
                                //$remarks = $this->input->post('remarks');
                                $user = $this->ion_auth->get_user();
                                $this->exams_m->set_grading($exid, $id, $sbj, $gd_id, $user->id); //update grading system
                                $perf_list = array();
                                $sub_marks = array();

                                if ($units)
                                {
                                        foreach ($units as $stid => $unmarks)
                                        {
                                                foreach ($unmarks as $uid => $mk)
                                                {
                                                        $sunits[] = array(
                                                            'parent' => $sbj,
                                                            'unit' => $uid,
                                                            'marks' => $mk
                                                        );
                                                }
                                        }
                                }

                                foreach ($marks as $std => $score)
                                {
                                        $sunits = array();
                                        $sub_marks = array(
                                            'subject' => $sb,
                                            'marks' => $score
                                        );
                                        if ($units && isset($units[$std]))
                                        {
                                                $mine = $units[$std];
                                                foreach ($mine as $uid => $mk)
                                                {
                                                        $sunits[] = array(
                                                            'parent' => $sbj,
                                                            'unit' => $uid,
                                                            'marks' => $mk
                                                        );
                                                }
                                        }
                                        $perf_list[] = array(
                                            'exams_id' => $xm->id,
                                            'student' => $std,
                                            'marks' => $sub_marks,
                                            'units' => $sunits,
                                                     // 'remarks' => isset($remarks[$std]) ? $remarks[$std] : ''
                                        );
                                }

                                foreach ($perf_list as $dat)
                                {
                                        $dat = (object) $dat;
                                        $list_id = $this->exams_m->get_update_target($dat->student, $dat->exams_id);
                                        $mm = (object) $dat->marks;

                                        $mod = array(
                                            'marks' => $mm->marks ? $mm->marks : 0,
                                            'modified_by' => $user->id,
                                            'modified_on' => time()
                                        );
                                        if ($this->exams_m->has_rec($list_id, $mm->subject))
                                        {
                                                $this->exams_m->update_marks($list_id, $mm->subject, $mod);

                                                if (isset($dat->units) && count($dat->units))
                                                {
                                                        foreach ($dat->units as $sm)
                                                        {
                                                                $sm = (object) $sm;
                                                                $svalues = array(
                                                                    'marks' => $sm->marks,
                                                                    'modified_by' => $user->id,
                                                                    'modified_on' => time()
                                                                );
                                                                $this->exams_m->update_sub_marks($list_id, $sm->parent, $sm->unit, $svalues);
                                                        }
                                                }
                                        }
                                        else
                                        {
                                                $mklist = $this->_prep_marks($sb, $xm->id, $marks, $units);

                                                foreach ($mklist as $dat)
                                                {
                                                        $dat = (object) $dat;
                                                        $values = array(
                                                            'exams_id' => $dat->exams_id,
                                                            'student' => $dat->student,
                                                            // 'total' => $dat->total,
                                                            // 'remarks' => $dat->remarks,
                                                            'created_by' => $user->id,
                                                            'created_on' => time()
                                                        );
                                                        $list_id = $this->exams_m->create_list($values);

                                                        $mm = (object) $dat->marks;
                                                        $fvalues = array(
                                                            'exams_list_id' => $list_id,
                                                            'marks' => $mm->marks ? $mm->marks : 0,
                                                            'subject' => $mm->subject,
                                                            'created_by' => $user->id,
                                                            'created_on' => time()
                                                        );
                                                        $this->exams_m->insert_marks($fvalues);

                                                        if (isset($dat->units) && count($dat->units))
                                                        {
                                                                foreach ($dat->units as $sm)
                                                                {
                                                                        $sm = (object) $sm;
                                                                        $svalues = array(
                                                                            'marks_list_id' => $list_id,
                                                                            'parent' => $sm->parent,
                                                                            'unit' => $sm->unit,
                                                                            'marks' => $sm->marks,
                                                                            'created_by' => $user->id,
                                                                            'created_on' => time()
                                                                        );
                                                                        $this->exams_m->insert_subs($svalues);
                                                                }
                                                        }
                                                }
                                        }
                                }

                                if (TRUE)//$dd)
                                {
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Update Successful'));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Update Failed'));
                                }
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Subject Not Specified'));
                        }
                        redirect('admin/exams/');
                }
                else
                {
                        $data['class_name'] = $heading;
                        $data['result'] = $rest;
                        $data['students'] = $students;
                        $data['sb'] = $sb;
                        if ($this->ion_auth->is_in_group($this->user->id, 3))
                        {
                                $this->template
                                             ->title('Update Exam Marks')
                                             ->set_layout('teachers')
                                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                                             ->build('admin/upper_edit', $data);
                        }
                        else
                        {
                                $this->template->title('Update Exam Marks')->set_layout('wide')->build('admin/upper_edit', $data);
                        }
                }
        }

        /**
         * Record Class Teacher's Remarks for Pre School Exams
         * 
         * @param int $exam_id Exam ID
         * @param int $id Class
         */
        function rec_lower($exam_id, $id)
        {
                $tar = $this->exams_m->get_stream($id);

                $class = $tar->class;
                $stream = $tar->stream;
                $data['students'] = $this->exams_m->get_students($class, $stream);

                //create control variables
                $data['updType'] = 'create';
                $data['page'] = '';
                $this->form_validation->set_rules($this->lower_validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {
                        //
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        $data['class'] = $id;
                        $data['exm'] = $exam_id;
                        //load the view and the layout
                        if ($this->ion_auth->is_in_group($this->user->id, 3))
                        {
                                $this->template
                                             ->title('Record Performance')
                                             ->set_layout('teachers')
                                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                                             ->build('admin/rec_lower', $data);
                        }
                        else
                        {
                                $this->template->title('Record Performance')->build('admin/rec_lower', $data);
                        }
                }
        }

        /**
         * Show Report Form
         * 
         * @param type $exam
         * @param type $student
         */
        public function report($exam, $student)
        {
                if (!$exam || !$student)
                {
                        redirect('admin/exams');
                }
                $xm = $this->exams_m->find($exam);
                $obst = $this->worker->get_student($student);
                $tar = $this->exams_m->get_stream($obst->class);

                $rec = $this->exams_m->is_recorded($exam);
                $has = TRUE;
                if (!$xm || !$rec)
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
                        $has = FALSE;
                }

                $data['report'] = $this->exams_m->get_report($exam, $student);
                $data['exam'] = $xm;
                $data['subjects'] = $this->exams_m->get_subjects($tar->class, $xm->term, 1);
                $data['full'] = $this->exams_m->list_subjects(1);
                $st = $this->worker->get_student($student);
                $this->load->model('reports/reports_m');
                $dcl = $this->reports_m->get_class_by_year($student, $xm->year);
                $did = $this->exams_m->get_by_class($dcl->class, $dcl->stream);

                $streams = $this->exams_m->populate('class_stream', 'id', 'name');
                $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
                $data['student'] = $st;
                $data['proc'] = $has;
                $data['streams'] = $streams;
                $data['cls'] = $did;

                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template
                                     ->title('Report Form')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/show', $data);
                }
                else
                {
                        $this->template->title('Report Form ')->set_layout('print')->build('admin/show', $data);
                }
        }

        /**
         * Generate Report Forms
         * 
         * @param $exam
         */
        public function results($exam)
        {
                $get = new StdClass();

                $data['result'] = $get;
                $data['exam'] = $exam;
                $data['classes'] = $this->classlist;
                $range = range(date('Y') - 1, date('Y') + 1);
                $data['yrs'] = array_combine($range, $range);
                //load view
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template
                                     ->title('Generate Report Forms')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/reports', $data);
                }
                else
                {
                        $this->template->title('Generate Report Forms ')->build('admin/reports', $data);
                }
        }

        /**
         * Record Remarks
         * 
         * @param int $exam
         * @param int $id Class ID
         * @param int $student
         */
        function create_lower($exam, $id, $student)
        {
                $tar = $this->exams_m->get_stream($id);

                $class = $tar->class;
                $stream = $tar->stream;
                $exm = $this->exams_m->find($exam);
                $data['students'] = $this->exams_m->get_students($class, $stream);
                $data['subjects'] = $this->exams_m->get_subjects($class, $exm->term);
                $data['list_subjects'] = $this->exams_m->list_subjects();
                $data['subtests'] = $this->exams_m->fetch_sub_tests();
                $data['count_subjects'] = $this->exams_m->count_subjects($class, $exm->term);
                $data['full_subjects'] = $this->exams_m->get_full_subjects();
                //create control variables
                $data['updType'] = 'create';
                $data['exams'] = $this->exams_m->list_exams();
                $data['remarks'] = $this->exams_m->fetch_by_exam($exam, $student);
                $get = new StdClass();
                foreach ($this->validation() as $field)
                {
                        $get->{$field['field']} = set_value($field['field']);
                }

                $data['result'] = $get;
                $data['student'] = $student;
                $data['class'] = $class;
                $data['stream'] = $stream;
                $data['exam'] = $exam;
                //load the view and the layout
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template
                                     ->title('Record Performance')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/lower', $data);
                }
                else
                {
                        $this->template->title('Record Performance')->build('admin/lower', $data);
                }
        }

        /**
         * Process Quick Edits
         * 
         * @param int $exam
         */
        function push_lower($exam = 0)
        {
                $tarr = $this->input->post('name');
                $student = $this->input->post('pk');
                $dta = $this->input->post('value');
                $user = $this->ion_auth->get_user();
                if ($tarr && $exam && $student && $dta)
                {
                        $dest = explode('_', $tarr);
                        if (count($dest))
                        {
                                $par = $dest[1];
                                if (count($dest) == 3)
                                {
                                        $subb = $dest[2];
                                }
                                elseif (count($dest) == 2)
                                {
                                        $subb = 9999;
                                }
                                else
                                {
                                        ///
                                }
                                $rmk = array(
                                    'sub_id' => $subb,
                                    'remarks' => $dta,
                                    'student' => $student,
                                    'exam' => $exam,
                                    'parent' => $par,
                                );
                                $ex_id = $this->exams_m->rmak_exists($par, $subb, $exam, $student);
                                if ($ex_id)
                                {
                                        //update marks
                                        $this->exams_m->update_remarks($ex_id, $rmk, array('created_by' => $user->id, 'created_on' => time()));
                                }
                                else
                                {
                                        //fresh insert
                                        $this->exams_m->save_remarks($rmk + array('modified_by' => $user->id, 'modified_on' => time()));
                                }
                        }
                }
        }

        /**
         * Add New Exam
         * 
         * @param type $page
         */
        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                $range = range(date('Y') - 50, date('Y'));
                $data['yrs'] = array_combine($range, $range);
                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'title' => $this->input->post('title'),
                            'term' => $this->input->post('term'),
                            'year' => $this->input->post('year'),
                            'start_date' => strtotime($this->input->post('start_date')),
                            'end_date' => strtotime($this->input->post('end_date')),
                            'description' => $this->input->post('description'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->exams_m->create($form_data);

                        if ($ok)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/exams/');
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
                                $this->template
                                             ->title('Add Exams')
                                             ->set_layout('teachers')
                                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                                             ->build('admin/create', $data);
                        }
                        else
                        {
                                $this->template->title('Add Exams')->build('admin/create', $data);
                        }
                }
        }

        /**
         * Edit Exam 
         * 
         * @param type $id
         * @param type $page
         */
        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/exams/');
                }
                if (!$this->exams_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/exams');
                }
                //search the item to show in edit form
                $get = $this->exams_m->find($id);

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
                            'term' => $this->input->post('term'),
                            'year' => $this->input->post('year'),
                            'start_date' => strtotime($this->input->post('start_date')),
                            'end_date' => strtotime($this->input->post('end_date')),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->exams_m->update_attributes($id, $form_data);


                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/exams/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/exams/");
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
                $range = range(date('Y') - 50, date('Y'));
                $data['yrs'] = array_combine($range, $range);
                $data['result'] = $get;
                //load the view and the layout

                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template
                                     ->title('Edit Exams')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/create', $data);
                }
                else
                {
                        $this->template->title('Edit Exams ')->build('admin/create', $data);
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

                        redirect('admin/exams');
                }

                //search the item to delete
                if (!$this->exams_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/exams');
                }

                //delete the item
                if ($this->exams_m->delete($id) == TRUE)
                {
                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/exams/");
        }

        /**
         * Validation for Record Remarks
         * 
         * @return array
         */
        private function lower_validation()
        {
                $config = array(
                    array(
                        'field' => 'student',
                        'label' => 'Student',
                        'rules' => '')
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'term',
                        'label' => 'Term',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'year',
                        'label' => 'Year',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'start_date',
                        'label' => 'Start Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'end_date',
                        'label' => 'End Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        /**
         * Get Datatable
         * 
         */
        public function get_table($id)
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->exams_m->list_results($id, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

                echo json_encode($output);
        }

        /**
         * Record Exams Validation
         * 
         * @return array
         */
        private function rec_validation()
        {

                $config = array(
                    array(
                        'field' => 'record_date',
                        'label' => 'Record Date',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'exam_type',
                        'label' => 'The Exam',
                        'rules' => 'trim|xss_clean'),
                    array(
                        'field' => 'subject[]',
                        'label' => 'Subject',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'student[]',
                        'label' => 'student',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'total[]',
                        'label' => 'Total',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'marks[]',
                        'label' => 'Marks',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'grading',
                        'label' => 'Grading',
                        'rules' => 'required'),
                    array(
                        'field' => 'remarks[]',
                        'label' => 'Remarks',
                        'rules' => 'xss_clean'),
                );
                $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/exams/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10;
                $config['total_rows'] = $this->exams_m->count();
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

                return $config;
        }

}
