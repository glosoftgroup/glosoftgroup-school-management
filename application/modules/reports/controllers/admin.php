<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        /**
         * Class Constructor
         */
        function __construct()
        {
                parent::__construct();
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }

                $this->load->model('reports_m');
                $this->load->model('exams/exams_m');
        }

        /**
         * Reports Homepage
         * 
         */
        public function index()
        {
                redirect('admin/reports/fee');
                $data[''] = '';
                //load view
                $this->template->title('Reports')->build('admin/hm_stats', $data);
        }

        /**
         * Load student report
         *
         */
        function student_report()
        {
                $this->form_validation->set_rules('student', 'Student ', 'required|xss_clean');
                if ($this->form_validation->run() == true)
                {
                        $id = $this->input->post('student');
                        $this->load->model('admission/admission_m');
                        $this->load->model('borrow_book_fund/borrow_book_fund_m');
                        $this->load->model('medical_records/medical_records_m');
                        $this->load->model('fee_payment/fee_payment_m');
                        $this->load->model('fee_waivers/fee_waivers_m');
                        $this->load->model('assign_bed/assign_bed_m');
                        $this->load->model('hostel_beds/hostel_beds_m');
                        $this->load->model('students_placement/students_placement_m');
                        $this->load->model('disciplinary/disciplinary_m');
                        $this->load->model('assign_transport_facility/assign_transport_facility_m');

                        $data['extras'] = $this->fee_payment_m->all_fee_extras();
                        if (!$this->admission_m->exists($id))
                        {
                                $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                                redirect('admin/reports/student_report');
                        }
                        $stud = $this->admission_m->find($id);
                        $data['passport'] = $this->admission_m->passport($stud->photo);
                        $student = $this->admission_m->find($id);
                        $data['student'] = $student;

                        $parent_id = $this->admission_m->find($id);
                        $data['parent_details'] = $this->admission_m->get_parent($parent_id->parent_id);
                        $data['cl'] = $this->admission_m->fetch_class($parent_id->class);
                        $data['title'] = 'Fee Statement';

                        $data['p'] = $this->fee_payment_m->get_receipts($id);
                        //Beds
                        $data['bed'] = $this->assign_bed_m->get($id);
                        $data['beds'] = $this->assign_bed_m->get_hostel_beds();
                        //Placement position
                        $data['position'] = $this->students_placement_m->get($id);
                        $data['st_pos'] = $this->students_placement_m->get_positions();
                        //Exams Results
                        $exams = array(); //$this->exams_management_m->get_by_student($id);

                        $data['exams'] = $exams;
                        //Exams Type
                        $data['type'] = $this->admission_m->populate('exams', 'id', 'year');
                        $data['term'] = $this->admission_m->populate('exams', 'id', 'term');
                        $data['type_details'] = $this->admission_m->populate('exams', 'id', 'title');

                        //Disciplinary
                        $data['disciplinary'] = $this->disciplinary_m->get($id);
                        //Medical Records
                        $data['medical'] = $this->medical_records_m->by_student($id);

                        $tm = get_term(date('m'));
                        $data['waiver'] = $this->admission_m->get_waiver($id, $tm);
                        //Transport Details
                        $data['transport'] = $this->assign_transport_facility_m->get($id);
                        $data['transport_facility'] = $this->assign_transport_facility_m->get_transport_facility();
                        $data['amt'] = $this->admission_m->total_fees($student->class);
                        $data['post'] = $this->fee_payment_m->get_row($id);
                        $data['banks'] = $this->fee_payment_m->banks();
                        $this->worker->calc_balance($id);
                        // $data['paid'] = $this->fee_payment_m->fetch_balance($student->id);
                        $data['fee'] = $this->fee_payment_m->fetch_balance($student->id);
                        $data['paro'] = $this->admission_m->get_paro($stud->parent_id);

                        //Book Fund
                        $data['books'] = $this->reports_m->populate('book_fund', 'id', 'title');
                        $data['student_books'] = $this->borrow_book_fund_m->by_student($id);

                        $data['class_history'] = $this->reports_m->class_history($id);

                        $data['classes_groups'] = $this->reports_m->populate('class_groups', 'id', 'name');
                        $data['classes'] = $this->reports_m->populate('classes', 'id', 'class');
                        $data['class_str'] = $this->reports_m->populate('classes', 'id', 'stream');
                        $data['stream_name'] = $this->reports_m->populate('class_stream', 'id', 'name');

                        $this->template->title('View Student')->build('admin/student_report', $data);
                }
                else
                {

                        $this->template->title('View Student')->build('admin/student_report');
                }
        }

        /**
         * Admission Report
         */
        function admission()
        {
                $class = $this->input->post('class');
                $year = $this->input->post('year');
                $cols = array();
                if (!$year)
                {
                        $year = date('Y');
                }
                if ($this->input->post())
                {
                        $cols = $this->input->post('cols');
                }
                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['str_opts'] = $this->reports_m->populate('class_stream', 'id', 'name');
                $data['year'] = $year;
                $data['class'] = $class;
                $data['cols'] = $cols;
                $data['houses'] = $this->reports_m->populate('house', 'id', 'name');
                $data['adm'] = $this->reports_m->fetch_adm_history($class, $year);
                //load view
                $this->template->title('Admission Report ')->build('admin/adm', $data);
        }

        /**
         * fee_status Report
         */
        function fee_status()
        {
                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                $sus = $this->input->post('sus');
                krsort($yrs);
                $data['str_opts'] = $this->reports_m->populate('class_stream', 'id', 'name');

                $data['yrs'] = $yrs;
                $data['fee'] = $this->reports_m->fetch_fee_status(0, $sus);
                //load view
                $this->template->title('Fee Status Report ')->build('admin/balance', $data);
        }

        /**
         * Payments Report
         */
        function paid()
        {
                $from = 0;
                $to = 0;
                if ($this->input->post('from'))
                {
                        $from = strtotime($this->input->post('from'));
                }
                if ($this->input->post('to'))
                {
                        $to = strtotime($this->input->post('to'));
                }
                $data['paid'] = $this->reports_m->fetch_payments($from, $to);
                $data['bank'] = $this->fee_payment_m->list_banks();
                $data['extras'] = $this->fee_payment_m->all_fee_extras();
                //load view
                $this->template->title('Fee Payments Report ')->build('admin/paid', $data);
        }

        /**
         * Fee Payment Summary Per Class Report
         * 
         */
        function fee()
        {
                $yr = date('Y');
                $term = get_term(date('m'));
                if ($this->input->post())
                {
                        $term = $this->input->post('term');
                        $yr = $this->input->post('year');
                }

                $data['classes'] = $this->portal_m->get_class_options();
                $data['streams'] = $this->reports_m->populate('class_stream', 'id', 'name');
                $range = range(date('Y'), date('Y') - 10);
                $data['yrs'] = array_combine($range, $range);
                $pool = $this->reports_m->fee_summary($term, $yr);

                $data['arrs'] = $this->fee_payment_m->fetch_total_arrears();
                $data['payload'] = $pool;
                $this->template->title('School Fee Status Report')->build('admin/fees', $data);
        }

        /**
         * Exam Report
         * 
         */
        function exam()
        {
                $hide = 1;
                $exam = $this->input->post('exam');
                $class = $this->input->post('class');
                $show = $this->input->post('grade');

                $subs = array();
                if ($exam)
                {
                        $tar = $this->exams_m->get_stream($class);
                        $res = $this->reports_m->fetch_exam_results($exam, $class);
                        $ex = $this->reports_m->get_exam($exam);
                        $subs = $hide ? $this->exams_m->get_subjects_alt($tar->id, $ex->term) : $this->exams_m->get_subjects($tar->id, $ex->term);
                }
                else
                {
                        $res = array();
                        $ex = FALSE;
                }
                $ccc = array();
                foreach ($this->classlist as $key => $value)
                {
                        $sp = (object) $value;
                        $ccc[$key] = $sp->name;
                }

                $data['ccc'] = $ccc;
                $data['ex'] = $ex;
                $data['res'] = $res;
                $data['points'] = $this->map_grades();

                $data['subjects'] = $subs;
                $data['show'] = $show ? 1 : 0;
                $data['classes'] = $this->portal_m->get_class_options();
                $data['subtots'] = $this->reports_m->populate('sub_cats', 'id', 'title');
                $data['streams'] = $this->reports_m->populate('class_stream', 'id', 'name');
                $data['exams'] = $this->reports_m->populate_exams();
                $data['subs'] = $this->reports_m->populate('subjects', 'id', 'short_name');
                $data['adm'] = $this->reports_m->populate_admission();
                $data['grades'] = $this->exams_m->populate('grades', 'id', 'title');
                $this->template->title('Exam Results Report ')->build('admin/result', $data);
        }

        /**
         * Exam Report
         * 
         */
        function sms_exam()
        {
                $hide = 1;
                $exam = $this->input->post('exam');
                $class = $this->input->post('class');
                $show = $this->input->post('grade');

                $subs = array();
                if ($exam)
                {
                        $tar = $this->exams_m->get_stream($class);
                        $res = $this->reports_m->fetch_exam_results($exam, $class);
                        $ex = $this->reports_m->get_exam($exam);
                        $subs = $hide ? $this->exams_m->get_subjects_alt($tar->id, $ex->term) : $this->exams_m->get_subjects($tar->id, $ex->term);
                }
                else
                {
                        $res = array();
                        $ex = FALSE;
                }
                $ccc = array();
                foreach ($this->classlist as $key => $value)
                {
                        $sp = (object) $value;
                        $ccc[$key] = $sp->name;
                }

                $data['ccc'] = $ccc;
                $data['ex'] = $ex;
                $data['res'] = $res;

                $data['subjects'] = $subs;
                $data['show'] = $show ? 1 : 0;
                $data['classes'] = $this->portal_m->get_class_options();
                $data['subtots'] = $this->reports_m->populate('sub_cats', 'id', 'title');
                $data['streams'] = $this->reports_m->populate('class_stream', 'id', 'name');
                $data['exams'] = $this->reports_m->populate_exams();
                $data['subs'] = $this->reports_m->populate('subjects', 'id', 'short_name');
                $data['adm'] = $this->reports_m->populate_admission();
                $data['grades'] = $this->exams_m->populate('grades', 'id', 'title');
                $this->template->title('Exam Results Report ')->build('admin/sms', $data);
        }

        /**
         * grade_analysis Report
         * 
         */
        function grade_analysis()
        {
                $hide = 1;
                $exam = $this->input->post('exam');
                $class = $this->input->post('class');
                $cs_grades = $this->reports_m->populate('grades', 'id', 'title');
                $points = $this->map_grades();
                $grades = $this->exams_m->populate('grades', 'id', 'title');

                $final = array();
                $subs = array();
                $size = 0;
                $ipoints = array();
                $mapped = array();
                if ($exam)
                {
                        $tar = $this->exams_m->get_stream($class);
                        $res = $this->reports_m->fetch_exam_results($exam, $class);
                        $ex = $this->reports_m->get_exam($exam);
                        $subs = $hide ? $this->exams_m->get_subjects_alt($tar->id, $ex->term) : $this->exams_m->get_subjects($tar->id, $ex->term);

                        if (isset($res['xload']))
                        {
                                $post = $res['xload'];
                                $classmarks = array_values($post);
                                if (isset($classmarks[0]))
                                {
                                        $streammarks = array_values($classmarks[0]);
                                        if (isset($streammarks[0]))
                                        {
                                                $marklist = $streammarks[0];

                                                $perf = array();
                                                $subjects = array();
                                                $grading = array();
                                                foreach ($subs as $sid => $sb)
                                                {
                                                        $subjects[$sid] = $sb['title'];
                                                }
                                                $size = count($marklist);
                                                foreach ($marklist as $st => $score)
                                                {
                                                        $cspoints = 0;
                                                        $mks = $score['mks'];
                                                        foreach ($mks as $subj => $smk)
                                                        {
                                                                $fsc = (object) $smk;
                                                                if (isset($subjects[$subj]))
                                                                {
                                                                        $perf[$subjects[$subj]][] = $fsc->marks;
                                                                        $grading[$subjects[$subj]] = $fsc->grading;

                                                                        $rgd = $this->ion_auth->remarks($fsc->grading, $fsc->marks);
                                                                        $hs_grade = isset($rgd->grade) && isset($grades[$rgd->grade]) ? $grades[$rgd->grade] : '';

                                                                        $mk_grade = str_replace(' ', '', $hs_grade);
                                                                        $pt = !empty($mk_grade) && isset($points[$mk_grade]) ? $points[$mk_grade] : 0;
                                                                        $cspoints += $pt;
                                                                }
                                                        }
                                                        $ipoints[] = round($cspoints / count($subjects), 3);
                                                }


                                                $temp = array();
                                                foreach ($ipoints as $p)
                                                {
                                                        @$temp[round($p)] ++;
                                                }
                                                krsort($temp);

                                                $flip = array_flip($points);
                                                foreach ($temp as $t => $stds)
                                                {
                                                        if (isset($flip[$t]))
                                                        {
                                                                $mapped[$flip[$t]] = $stds;
                                                        }
                                                }

                                                $sub_grade = array();
                                                $sheet = array();

                                                foreach ($grading as $title => $id)
                                                {
                                                        $wgrd = $this->reports_m->get_grading_records($id);
                                                        $sub_grade[$title] = $wgrd;
                                                }

                                                foreach ($perf as $subtt => $scmarks)
                                                {
                                                        if (!isset($sub_grade[$subtt]))
                                                        {
                                                                continue;
                                                        }
                                                        $sel_grading = $sub_grade[$subtt];
                                                        foreach ($scmarks as $val)
                                                        {
                                                                foreach ($sel_grading as $ix => $rowx)
                                                                {
                                                                        $row = (object) $rowx;
                                                                        if (($row->min <= $val) && ($val <= $row->max))
                                                                        {
                                                                                $sheet[$subtt][$row->title][] = $val;
                                                                        }
                                                                }
                                                        }
                                                }

                                                foreach ($cs_grades as $g)
                                                {
                                                        foreach ($sheet as $subb => $res)
                                                        {
                                                                $final[$subb][$g] = isset($res[$g]) ? $res[$g] : array();
                                                        }
                                                }
                                        }
                                }
                        }
                }
                else
                {
                        $res = array();
                        $ex = FALSE;
                }
                $ccc = array();
                foreach ($this->classlist as $key => $value)
                {
                        $sp = (object) $value;
                        $ccc[$key] = $sp->name;
                }

                $data['ccc'] = $ccc;
                $data['class'] = $class;
                $data['ex'] = $ex;
                $data['res'] = $final;
                $data['titles'] = $cs_grades;
                $data['points'] = $points;
                $data['ipoints'] = $ipoints;
                $data['summary'] = $mapped;
                $data['size'] = $size;

                $data['classes'] = $this->portal_m->get_class_options();
                $data['streams'] = $this->reports_m->populate('class_stream', 'id', 'name');
                $data['exams'] = $this->reports_m->populate_exams();
                $data['subs'] = $this->reports_m->populate('subjects', 'id', 'short_name');
                $this->template->title('Exam Results Report ')->build('admin/grade', $data);
        }

        /**
         *  Book Fund Reports
         * 
         */
        public function book_fund()
        {
                $this->load->model('book_fund/book_fund_m');
                $data['book_fund'] = $this->book_fund_m->get_all();
                $data['category'] = $this->book_fund_m->populate('books_category', 'id', 'name');

                //load view
                $this->template->title('Book Fund')->build('admin/book_fund', $data);
        }

        public function joint()
        {
                $exams = $this->input->post('exams');
                $class = $this->input->post('class');
                $subjr = array();
                $subfn = array();
                $mks = [];
                $fn = array();
                $xnames = array();
                if ($exams && $class)
                {
                        sort($exams);
                        foreach ($exams as $x)
                        {
                                $xm = $this->exams_m->find($x);
                                $xnames[] = $xm;
                                $subjr[] = $this->exams_m->get_subjects($class, $xm->term, 1);
                        }
                        foreach ($subjr as $wk => $xsubs)
                        {
                                foreach ($xsubs as $sib => $sdets)
                                {
                                        $subfn[$sib] = $sdets;
                                }
                        }

                        $list = $this->portal_m->list_students($class);
                        foreach ($list as $key => $sid)
                        {
                                foreach ($subfn as $skey => $sbdet)
                                {
                                        $units = array();
                                        $sr = $this->exams_m->fetch_subject($skey);
                                        $sn = empty($sr) ? ' -- ' : $sr->name;
                                        $mks[$sid][$sn]['subject'] = $sn;
                                        foreach ($exams as $xx)
                                        {
                                                $sgrade = $this->exams_m->fetch_grading($xx, $class, $skey);
                                                $fsmark = $this->exams_m->get_subject_result($xx, $sid, $skey);
                                                $mks[$sid][$sn]['grading'] = empty($sgrade) ? 0 : $sgrade->grading;
                                                $mks[$sid][$sn]['maks'][$xx] = $fsmark;
                                                $units[$xx] = isset($fsmark['units']) ? $fsmark['units'] : array();
                                        }
                                        $wun = array();
                                        foreach ($units as $wx => $desc)
                                        {
                                                $b = 0;
                                                $ut = array();
                                                $wn = array();
                                                foreach ($desc as $ix => $un)
                                                {
                                                        if (!isset($ut[$un['name']]))
                                                        {
                                                                $ut[$un['name']] = 0;
                                                        }
                                                        $b++;
                                                        $wun[$un['name']][] = $un['marks'];
                                                        $ut[$un['name']] += $un['marks'];
                                                        $wn[] = $un['name'];
                                                }
                                                if ($b)
                                                {
                                                        foreach ($wn as $www)
                                                        {
                                                                $uvg = $b ? round($ut[$www] / $b) : 0;
                                                        }
                                                }
                                        }
                                        $wfinal = array();
                                        if (count($wun))
                                        {
                                                foreach ($wun as $wkey => $wx)
                                                {
                                                        $untot = 0;
                                                        $t = 0;
                                                        foreach ($wx as $mx)
                                                        {
                                                                $t++;
                                                                $untot += $mx;
                                                        }
                                                        $uvg = $t ? round($untot / $t) : 0;
                                                        $wx[] = $uvg;
                                                        $wfinal[$wkey] = $wx;
                                                }
                                        }
                                        $mks[$sid][$sn]['units'] = $wfinal;
                                }
                        }
                        $data['list'] = $xnames;
                        foreach ($mks as $student => $subdesc)
                        {
                                foreach ($subdesc as $subject => $desc)
                                {
                                        $i = 0;
                                        $rg = 0;
                                        $sb = '';
                                        $opt = 0;
                                        foreach ($desc['maks'] as $exam => $det)
                                        {
                                                $i++;
                                                $rg += $det['marks'];
                                                $sb = isset($det['subject']) ? $det['subject'] : '';
                                                $opt = $det['opt'];
                                        }
                                        $svg = round($rg / $i);
                                        $desc['maks'][999999] = array('subject' => $sb, 'marks' => $svg, 'opt' => $opt);
                                        $fn[$student][$subject] = $desc;
                                }
                        }
                }
                $wmks = $this->_analyze_marks($fn, $xnames);

                $data['mks'] = aasort($wmks, 'avg', SORT_DESC);
                $data['exams'] = $this->reports_m->populate_exams();
                $data['titles'] = $this->reports_m->get_labels();
                $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');
                $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');

                $this->template->title('Joint Exam Report')->build('admin/joint', $data);
        }

        /**
         * Process & analyze
         * 
         * @param array $marks
         * @param array $list
         */
        function _analyze_marks($marks, $list)
        {
                $mklist = array();
                foreach ($marks as $student => $smarks)
                {
                        $tot = [];
                        $bars = [];
                        $tf = 0;
                        foreach ($list as $l)
                        {
                                $tf++;
                                $tot[$tf] = 0;
                        }
                        $tot[(count($tot) + 1)] = 0;

                        $i = 0;
                        foreach ($smarks as $sub => $spms)
                        {
                                $sp = (object) $spms;
                                $i++;
                                if (isset($sp->units) && !empty($sp->units))
                                {
                                        $k = 0;
                                        foreach ($sp->maks as $xid => $xres)
                                        {
                                                if (!isset($bars[$xid]))
                                                {
                                                        $bars[$xid] = 0;
                                                }
                                                $k++;
                                                $rs = (object) $xres;
                                                $tot[$k] += $rs->opt ? 0 : $rs->marks;
                                                $bars[$xid] += $rs->opt ? 0 : $rs->marks;
                                        }
                                }
                                else
                                {
                                        $k = 0;
                                        foreach ($sp->maks as $xid => $xres)
                                        {
                                                if (!isset($bars[$xid]))
                                                {
                                                        $bars[$xid] = 0;
                                                }
                                                $k++;
                                                $rs = (object) $xres;
                                                $tot[$k] += $rs->opt ? 0 : $rs->marks;
                                                $bars[$xid] += $rs->opt ? 0 : $rs->marks;
                                        }
                                }
                        }

                        $mklist[$student]['res'] = $smarks;
                        $mklist[$student]['tots'] = $tot;
                        $mklist[$student]['bars'] = $bars;
                        $mklist[$student]['avg'] = $tot[(count($tot))]; //cos non zero array keys
                }
                return $mklist;
        }

        function _get_exam_class($exam, $class)
        {
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

                foreach ($list as $key => $sid)
                {
                        $st = $this->worker->get_student($sid);
                        $tar = $this->exams_m->get_stream($st->class);

                        $report = $this->exams_m->get_report($exam, $sid);
                        $dcl = $this->reports_m->get_class_by_year($sid, $xm->year);

                        $did = $this->exams_m->get_by_class($dcl->class, $dcl->stream);
                        $report['cls'] = $did;
                        $report['student'] = $st;
                        $payload[] = $report;
                }

                $streams = $this->exams_m->populate('class_stream', 'id', 'name');
                $data['proc'] = $has;
                $data['grading'] = $xm ? $this->exams_m->get_grading($xm->grading) : array();
                $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
                $data['subjects'] = $this->exams_m->get_subjects($class, $xm->term, 1);

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

                return sort_by_field($payload, 'total', 3);
        }

        /**
         * Fee Extras Roster Report
         * 
         */
        function fee_extras()
        {
                $fee = $this->input->post('fee');
                $yr = $this->input->post('year');
                $term = $this->input->post('term');
                $class = $this->input->post('class');

                if (!$yr)
                {
                        $yr = date('Y');
                }
                if (!$fee)
                {
                        $roster = array();
                }
                else
                {
                        $roster = $this->reports_m->get_fee_extras($fee, $class, $term, $yr);
                }

                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['fee'] = $fee;
                $data['class'] = $class;
                $data['yr'] = $yr;
                $data['term'] = $term;
                $data['roster'] = $roster;
                $data['list'] = $this->reports_m->populate('fee_extras', 'id', 'title');
                $data['adm'] = $this->reports_m->populate_admission();
                $this->template->title('Fee Extras Report ')->build('admin/fee_extras', $data);
        }

        function arrears()
        {
                $yr = $this->input->post('year');
                $term = $this->input->post('term');
                $class = $this->input->post('class');
                $sus = $this->input->post('sus');
                if (!$yr)
                {
                        $yr = date('Y');
                }
                $rearr = $this->reports_m->get_arrears($class, $term, $yr, $sus);

                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['class'] = $class;
                $data['yr'] = $yr;
                $data['term'] = $term;
                $data['rearr'] = $rearr;
                $data['adm'] = $this->reports_m->populate_admission();
                $this->template->title('Fee Arrears Report ')->build('admin/feerears', $data);
        }

        /**
         *   Wages Report
         *  
         */
        public function wages()
        {
                $post = $this->reports_m->get_salaries();

                foreach ($post as $p)
                {
                        $basic = $this->reports_m->total_basic($p->salary_date);
                        $no_employees = $this->reports_m->count_employees($p->salary_date);
                        $deductions = $this->reports_m->total_deductions($p->salary_date);

                        $allowances = $this->reports_m->total_allowances($p->salary_date);
                        $nhif = $this->reports_m->total_nhif($p->salary_date);
                        $advance = $this->reports_m->total_advance($p->salary_date);

                        $total_paid = (($basic->basic + $allowances->allws ) - $advance->advs);
                        $fully_paid = ($basic->basic + $allowances->allws );
                        //+ $nhif->nhif
                        //+ $deductions->ded
                        //print_r($nhif->nhif);die;
                        $p->total_paid = $fully_paid;
                        $p->no_employees = $no_employees;
                        $p->advance = $advance->advs;
                        $p->nhif = $nhif->nhif;
                        $p->all_deductions = $deductions->ded;
                }
                $data['post'] = $post;
                $this->template->title('Wages Reports ')->build('admin/wages', $data);
        }

        /**
         * Expenses Summary Report
         * 
         */
        public function expenses()
        {
                $yr = $this->input->post('year');
                $term = $this->input->post('term');

                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['yr'] = $yr;
                $data['term'] = $term;

                $post = $this->reports_m->get_expenses($term, $yr);
                foreach ($post as $p)
                {
                        $expense_total = $this->reports_m->total_expense_amount($p->category, $term, $yr);
                        $p->expense_total = $expense_total->total;
                }
                $data['post'] = $post;
                $data['cats'] = $this->reports_m->expense_categories();
                $this->template->title('Expense Summary Report')->build('admin/expenses', $data);
        }

        /**
         * Detailed Expenses Report
         * 
         */
        public function expense_trend()
        {
                $cat = $this->input->post('cat');
                $yr = $this->input->post('year');
                $term = $this->input->post('term');

                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['yr'] = $yr;
                $data['term'] = $term;
                $post = $this->reports_m->fetchx_by_category($cat, $term, $yr);

                $data['post'] = $post;
                $data['cats'] = $this->reports_m->expense_categories();
                $this->template->title('Detailed Expenses Report ')->build('admin/ex_trend', $data);
        }

        /**
         * Assets Report
         * 
         */
        function assets()
        {
                if ($this->ion_auth->logged_in())
                {
                        $this->load->model('add_stock/add_stock_m');

                        //find all the categories with paginate and save it in array to past to the view
                        $data['add_stock'] = $this->add_stock_m->get_all();
                        $data['product'] = $this->add_stock_m->get_products();
                        $this->template->title('School Inventory')->set_layout('default.php')->build('admin/inventory', $data);
                }
        }

        /**
         * Classes Report
         * 
         */
        public function classes()
        {
                $id = $this->input->post('class');
                if ($id && !$this->reports_m->such_class($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/reports/classes', 'refresh');
                }
                if (!$id)
                {
                        $id = 1;
                        if (!$this->reports_m->such_class($id))
                        {
                                $id = $id + 1;
                        }
                }
                $streams = $this->reports_m->populate('class_stream', 'id', 'name');
                $cnames = $this->reports_m->get_class_names();
                if (!$streams)
                {
                        $streams = FALSE;
                }
                $data['classes'] = $this->reports_m->get_classes($cnames, $streams);

                $get = $this->reports_m->get_class($id);

                $data['streams'] = $streams;
                $data['post'] = $get;
                if (!isset($get->stream))
                {
                        $get->stream = FALSE;
                }
                $data['size'] = $this->reports_m->count_population($id, $get->stream);
                $data['students'] = $this->reports_m->get_population($id, $get->stream);
                $data['teachers'] = $this->ion_auth->get_teachers();
                $data[''] = '';
                //load view
                $this->template->title('Class Report ')->build('admin/classes', $data);
        }

        /**
         * List Balances Breakdown
         * 
         * @param int $class
         * @param int $stream
         */
        function list_bals($class, $stream)
        {
                $row = $this->reports_m->get_class_stream($class, $stream);
                if ($row)
                {
                        $pool = $this->reports_m->fetch_stream_students($row->id);
                        $qbal = array();

                        foreach ($pool as $student)
                        {
                                $sb = $this->reports_m->get_bal_status($student);
                                $qbal[] = array('student' => $student, 'amount' => $sb->balance);
                        }
                }

                $data['bals'] = $qbal;
                $this->template->title('Fee Balances Breakdown Report ')->build('admin/balist', $data);
        }

        /**
         * Fix Arrears
         * 
         */
        function fix_arrears()
        {
                $get = $this->reports_m->fetch_starting_balances();
                $data['result'] = $get;
                //load the view and the layout
                $this->template->title('Fix Arrears ')->build('admin/arfix', $data);
        }

        /**
         * Save Arrears ajax
         */
        function put_arrear()
        {
                $tarr = $this->input->post('name');
                $amt = $this->input->post('value');
                $user = $this->ion_auth->get_user();
                if ($tarr && $amt)
                {
                        $dest = explode('_', $tarr);
                        if (count($dest))
                        {
                                $sid = $dest[1];
                                $rmk = array(
                                    'amount' => $amt,
                                    'modified_on' => time(),
                                    'modified_by' => $user->id,
                                );

                                //update marks
                                $this->reports_m->update_arrears($sid, $rmk);
                        }
                }
        }

        function new_arrear($page = NULL)
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
                        $amt = $this->input->post('amount');
                        $tm = $this->input->post('term');
                        $yr = $this->input->post('year');


                        $reg = $this->input->post('student');
                        $rear = array(
                            'student' => $reg,
                            'amount' => $amt,
                            'term' => $tm,
                            'year' => $yr,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $rec = $this->reports_m->insert_rear($rear);

                        if ($rec)
                        {
                                //update student Balance
                                $this->worker->calc_balance($reg);

                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/reports/');
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
                        $this->template->title('Add Fee Arrear ')->build('admin/new_rear', $data);
                }
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'student',
                        'label' => 'Student',
                        'rules' => 'required'),
                    array(
                        'field' => 'term',
                        'label' => 'term',
                        'rules' => 'required'),
                    array(
                        'field' => 'year',
                        'label' => 'year',
                        'rules' => 'required'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

}
