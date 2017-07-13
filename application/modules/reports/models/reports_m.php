<?php

class Reports_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function find($id)
        {
                $query = $this->db->get_where('reports', array('id' => $id));
                return $query->row();
        }

        /**
         * 
         * @param type $id
         * @param type $table
         * @return type
         */
        function find_row($id, $table)
        {
                return $this->db->where(array('id' => $id))->get($table)->row();
        }

        function class_history($id)
        {
                $this->select_all_key('history');
                return $this->db->where($this->dx('student') . '=' . $id, NULL, FALSE)
                                          ->get('history')
                                          ->result();
        }

        function get_exam($id)
        {
                $query = $this->db->get_where('exams', array('id' => $id));
                return $query->row();
        }

        /**
         * Expenses Summary Report
         * 
         * @param int $term
         * @param int $year
         * @return type
         */
        function get_expenses($term = 0, $year = 0)
        {
                if ($term)
                {
                        $mts = term_months($term);
                        $this->db->where_in('MONTH(FROM_UNIXTIME(expense_date)) ', $mts, NULL, FALSE);
                }
                if ($year)
                {
                        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%Y')", $year, NULL, FALSE);
                }

                return $this->db->where('status', 1)->group_by('category')->order_by('created_on', 'DESC')->get('expenses')->result();
        }

        /**
         * Fetch Expenses by Category
         * 
         * @param type $cat
         * @param type $term
         * @param type $year
         * @return type
         */
        function fetchx_by_category($cat = 0, $term = 0, $year = 0)
        {
                if ($term)
                {
                        $mts = term_months($term);
                        $this->db->where_in('MONTH(FROM_UNIXTIME(expense_date)) ', $mts, NULL, FALSE);
                }
                if ($year)
                {
                        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%Y')", $year, NULL, FALSE);
                }
                if ($cat)
                {
                        $this->db->where("category", $cat);
                }

                return $this->db->where(array('status' => 1))->get('expenses')->result();
        }

        function total_expense_amount($cat, $term = 0, $year = 0)
        {
                if ($term)
                {
                        $mts = term_months($term);
                        $this->db->where_in('MONTH(FROM_UNIXTIME(expense_date)) ', $mts, NULL, FALSE);
                }
                if ($year)
                {
                        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%Y')", $year, NULL, FALSE);
                }
                return $this->db->select('sum(amount) as total')->where(array('category' => $cat, 'status' => 1))->get('expenses')->row();
        }

        function expense_categories()
        {
                $result = $this->db->select('expenses_category.*')
                             ->order_by('created_on', 'DESC')
                             ->get('expenses_category')
                             ->result();

                $rr = array();
                foreach ($result as $res)
                {
                        $rr[$res->id] = $res->title;
                }

                return $rr;
        }

        /**
         * Get Salaries report
         * 
         * @return type
         */
        function get_salaries()
        {
                return $this->db->select('record_salaries.*')->group_by('salary_date')->order_by('salary_date', 'DESC')->get('record_salaries')->result();
        }

        function count_employees($date)
        {
                return $this->db->where(array('salary_date' => $date))->count_all_results('record_salaries');
        }

        function total_basic($date)
        {
                return $this->db->select('sum(basic_salary) as basic')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        function total_deductions($date)
        {
                return $this->db->select('sum(total_deductions) as ded')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        function total_allowances($date)
        {
                return $this->db->select('sum(total_allowance) as allws')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        function total_nhif($date)
        {
                return $this->db->select('sum(nhif) as nhif')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        function total_advance($date)
        {
                return $this->db->select('sum(advance) as advs')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        //********************END WAGES ***********************//
        function exists($id)
        {
                $query = $this->db->get_where('reports', array('id' => $id));
                $result = $query->result();

                return $result;
        }

        /**
         * Fetch Admission History Report
         * 
         * @param type $class
         * @param type $year
         * @return type
         */
        function fetch_adm_history($class = FALSE, $year = FALSE)
        {
                $this->select_all_key('history');
                $this->db->select($this->dx('admission.first_name') . ' as first_name, ' . $this->dx('admission.last_name') . ' as last_name,' . $this->dx('admission.admission_number') . ' as admission_number,' . $this->dx('admission.dob') . ' as dob,' . $this->dx('admission.old_adm_no') . ' as old_adm_no,', FALSE);
                $this->db->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname,' . $this->dx('parents.email') . ' as parent_email,' . $this->dx('parents.address') . ' as address,' . $this->dx('parents.phone') . ' as phone,' . $this->dx('admission.house') . ' as house', FALSE);
                $this->db->join('admission', 'admission.id= ' . $this->dx('student'));
                $this->db->join('parents', 'parents.id= ' . $this->dx('admission.parent_id'));
                $this->db->order_by($this->dx('admission.first_name'), 'ASC', FALSE);
                $this->db->order_by($this->dx('admission.last_name'), 'ASC', FALSE);
                $this->db->where($this->dx('admission.status') . ' != 0', NULL, FALSE); //allow active & alumni

                if ($year)
                {
                        $this->db->where($this->dx('history.year') . ' = ' . $year, NULL, FALSE);
                }

                if ($class)
                {
                        $this->db->where($this->dx('history.class') . ' = ' . $class, NULL, FALSE);
                }

                $result = $this->db->get('history')->result();

                $adm = array();
                foreach ($result as $sd)
                {
                        $yr = date('Y');
                        $st = $this->get_class_by_year($sd->id, $yr);
                        if (!$st)
                        {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $adm[$sd->class][$sd->stream][] = $sd;
                }

                return $adm;
        }

        /**
         * Fetch Fee Status 
         * 
         * @param int $class
         * @return type
         */
        function fetch_fee_status($class = FALSE, $sus = FALSE)
        {
                $this->select_all_key('admission');
                $this->db->select($this->dx('new_balances.balance') . ' as balance, ' . $this->dx('new_balances.invoice_amt') . ' as invoice_amt,' . $this->dx('new_balances.paid') . ' as paid', FALSE);
                $this->db->join('new_balances', 'admission.id= ' . $this->dx('student'));
                if ($class)
                {
                        $this->db->join('classes', 'classes.id= ' . $this->dx('admission.class'));
                        $this->db->where($this->dx('classes.class') . ' = ' . $class, NULL, FALSE);
                }
                $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                if ($sus)
                {
                        $this->db->or_where($this->dx('admission.status') . ' = 0', NULL, FALSE);
                }
                $this->db->order_by($this->dx('admission.first_name'), 'ASC', FALSE);
                $this->db->order_by($this->dx('admission.last_name'), 'ASC', FALSE);

                $result = $this->db->get('admission')->result();

                $fbal = array();

                foreach ($result as $sd)
                {
                        $yr = date('Y');
                        $st = $this->get_class_by_year($sd->id, $yr);
                        if (!$st)
                        {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $fbal[$st->class][$st->stream][] = $sd;
                }

                return $fbal;
        }

        /**
         * Fetch Payments
         * 
         */
        function fetch_payments($from = 0, $to = 0)
        {
                $this->select_all_key('fee_payment');

                if (($from && $to) && $from == $to)
                {
                        $dt = date('d-m-Y', $from);
                        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('payment_date') . "),'%d-%m-%Y') ='" . $dt . "'", NULL, FALSE);
                }
                else
                {
                        if ($from)
                        {
                                $this->db->where($this->dx('payment_date') . '>' . $from, NULL, FALSE);
                        }
                        if ($to)
                        {
                                $this->db->where($this->dx('payment_date') . '<' . $to, NULL, FALSE);
                        }
                }
                $this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
                $this->db->order_by($this->dx('payment_date'), 'DESC', false);
                $result = $this->db->limit(250)->get('fee_payment')->result();
                $paid = array();

                foreach ($result as $p)
                {
                        $yr = date('Y', $p->payment_date);
                        $st = $this->get_class_by_year($p->reg_no, $yr);
                        if (!$st)
                        {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $paid[$st->class][$st->stream][] = $p;
                }

                return $paid;
        }

        /**
         * Determine if Such Class Exists
         * 
         * @param int $id
         * @return boolean
         */
        function such_class($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('class_groups') > 0;
        }

        function update_arrears($id, $data)
        {
                return $this->update_key_data($id, 'fee_arrears', $data);
        }

        /**
         * Fee Extras Roster Report
         * 
         * @param int $fee
         * @param int $class
         * @param int $term
         * @param int $yr
         * @return array
         */
        function get_fee_extras($fee, $class, $term, $yr)
        {
                $list = $this->portal_m->fetch_students($class);
                if ($class && empty($list))
                {
                        return array();
                }
                if ($term)
                {
                        $this->db->where($this->dx('term') . '=' . $term, NULL, FALSE);
                }
                if ($yr)
                {
                        $this->db->where($this->dx('year') . '=' . $yr, NULL, FALSE);
                }
                if ($fee)
                {
                        $this->db->where($this->dx('fee_id') . '=' . $fee, NULL, FALSE);
                }

                if ($class)
                {
                        $this->db->_protect_identifiers = FALSE;
                        $this->db->where_in($this->dx('student'), $list, FALSE);
                        $this->db->_protect_identifiers = TRUE;
                }
                $this->select_all_key('fee_extra_specs');
                $res = $this->db->get('fee_extra_specs')->result();

                $ros = array();
                foreach ($res as $r)
                {
                        $cls = $this->get_student_class($r->student);
                        if ($cls)
                        {
                                $ros[$cls->class][] = array('student' => $r->student, 'amount' => $r->amount);
                        }
                        else
                        {
                                $ros['Other'][] = array('student' => $r->student, 'amount' => $r->amount);
                        }
                }
                return $ros;
        }

        /**
         * Fetch Fee Arrears
         * 
         * @param type $class
         * @param type $term
         * @param type $yr
         * @return type
         */
        function get_arrears($class, $term, $yr, $sus = FALSE)
        {
                $list = $this->portal_m->fetch_students($class, $sus);

                if ($class && empty($list))
                {
                        return array();
                }
                if ($term)
                {
                        $this->db->where($this->dx('term') . '=' . $term, NULL, FALSE);
                }
                if ($yr)
                {
                        $this->db->where($this->dx('year') . '=' . $yr, NULL, FALSE);
                }

                if ($class)
                {
                        $this->db->_protect_identifiers = FALSE;
                        $this->db->where_in($this->dx('student'), $list, FALSE);
                        $this->db->_protect_identifiers = TRUE;
                }
                $this->db->select($this->dx('keep_balances.balance') . ' as balance, ' . $this->dx('keep_balances.student') . ' as student,' . $this->dx('keep_balances.paid') . ' as paid', FALSE);
                $this->db->select($this->dx('keep_balances.term') . ' as term, ' . $this->dx('keep_balances.year') . ' as year', FALSE);
                $this->db->join('admission', 'admission.id= ' . $this->dx('student'));
                if ($sus)
                {
                        $this->db->where($this->dx('admission.status') . ' != 1', NULL, FALSE);
                }
                else
                {
                        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                }
                $res = $this->db->get('keep_balances')->result();

                $reas = array();
                foreach ($res as $r)
                {
                        $cls = $this->get_class_by_year($r->student, $r->year);
                        if ($r->balance)
                        {
                                $frear = array(
                                    'student' => $r->student,
                                    'amount' => $r->balance,
                                    'paid' => $r->paid,
                                    'term' => $r->term,
                                    'year' => $r->year,
                                );
                                if ($cls)
                                {
                                        $reas[$cls->class][] = $frear;
                                }
                                else
                                {
                                        $reas['Other'][] = $frear;
                                }
                        }
                }

                return $reas;
        }

        function count()
        {
                return $this->db->count_all_results('reports');
        }

        function update_attributes($id, $data)
        {
                $this->db->where('id', $id);
                $query = $this->db->update('reports', $data);

                return $query;
        }

        function populate($table, $option_val, $option_text)
        {
                $query = $this->db->select('*')->order_by($option_text)->get($table);
                $dropdowns = $query->result();

                $options = array();
                foreach ($dropdowns as $dropdown)
                {
                        $options[$dropdown->$option_val] = $dropdown->$option_text;
                }
                return $options;
        }

        function populate_exams()
        {
                $query = $this->db->select('id,title, term, year ')->order_by('id', 'DESC')->get('exams');
                $dropdowns = $query->result();

                $options = array();
                foreach ($dropdowns as $dp)
                {
                        $options[$dp->id] = $dp->title . '  - Term ' . $dp->term . ' ' . $dp->year;
                }
                return $options;
        }

        function get_labels()
        {
                $query = $this->db->select('id,title, term, year ')->order_by('id', 'DESC')->get('exams');
                $dropdowns = $query->result();

                $options = array();
                foreach ($dropdowns as $dp)
                {
                        $options[$dp->id] = array('title' => $dp->title, 'term' => $dp->term);
                }
                $options[999999] = array('title' => 'Average', 'term' => 'Average');
                return $options;
        }

        /**
         * Exams Marks Printout For School
         * 
         * @param type $id
         * @return type
         */
        function fetch_exam_results($id, $class = 0)
        {
                if ($class)
                {
                        $this->db->where('class_id', $class);
                }
                $ls = $this->db->where('exam_type', $id)->get('exams_management')->result();
                if (empty($ls))
                {
                        return array();
                }
                $classes = array();
                $ids = array();

                foreach ($ls as $l)
                {
                        $classes[] = $l->class_id;
                        $ids[] = $l->id;
                }
                $exam_supply = $this->db->where_in('exams_id', $ids)->get('exams_management_list')->result();
                $exxams = array();

                foreach ($exam_supply as $x)
                {
                        $st = $this->get_student_class($x->student);

                        if (!$st)
                        {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $mine = $this->_get_marks_list($x->id);

                        $ct = 0;
                        if (isset($mine['mks']))
                        {
                                $ct = count($mine['mks']);
                                foreach ($mine['mks'] as $ll)
                                {
                                        $dt = (object) $ll;
                                        if (isset($dt->units))
                                        {
                                                $ct += count($dt->units);
                                        }
                                }
                        }
                        $exxams[$st->class][$st->stream][$x->student] = $mine;
                }
                $fnn = array('xload' => $exxams, 'max' => $ct);

                return $fnn;
        }

        /**
         * Process invoices, waivers & payments for Whole School
         * 
         * @param int $student
         * @return array payload
         */
        function fee_summary($term = 0, $year = 0)
        {
                $paid = $this->fee_payment_m->fetch_all_receipts($term, $year);
                $payload = array();
                $debs = $this->fee_payment_m->fetch_all_debs($term, $year);
                $wvs = $this->fee_payment_m->fetch_all_waivers($term, $year);
                $xtra = $this->fee_payment_m->fetch_all_exts($term, $year);
                $bals = $this->fee_payment_m->fetch_all_bals($term, $year);

                foreach ($debs as $d)
                {
                        $yr = date('Y', $d->created_on);
                        $st = $this->get_class_by_year($d->student_id, $yr);
                        if (!$st)
                        {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }

                        $payload[$yr][$d->term][$st->class][$st->stream]['debit'][] = $d->amount;
                }

                foreach ($xtra as $f)
                {
                        $st = $this->get_class_by_year($f->student, $f->year);
                        if (!$st)
                        {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $exfee = $this->fee_payment_m->get_extra($f->fee_id);
                        if ($exfee->ftype == 1)
                        {
                                //charge
                                $payload[$f->year][$f->term][$st->class][$st->stream]['extra_c'][] = $f->amount;
                        }
                        else
                        {       //waiver
                                $payload[$f->year][$f->term][$st->class][$st->stream]['extra_w'][] = $f->amount;
                        }
                }

                foreach ($wvs as $w)
                {
                        $st = $this->get_class_by_year($w->student, $w->year);
                        if (!$st)
                        {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $payload[$w->year][$w->term][$st->class][$st->stream]['waivers'][] = $w->amount;
                }

                foreach ($paid as $p)
                {
                        $yr = date('Y', $p->payment_date);
                        $st = $this->get_class_by_year($p->reg_no, $yr);
                        if (!$st)
                        {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $mt = date('m', $p->payment_date);
                        $mon = get_term($mt);

                        $payload[$yr][$mon][$st->class][$st->stream]['credit'][] = $p->amount;
                }
                $mw = array();
                foreach ($bals as $mb)
                {
                        /* if ($st->class == 4 && $st->stream == 1)
                          {
                          $mw[$st->stream][$mb->student] = $mb->balance;
                          } */
                        $st = $this->get_class_by_year($mb->student, $mb->year);
                        if (!$st)
                        {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $payload[$mb->year][$mb->term][$st->class][$st->stream]['bal'][] = $mb->balance;
                }

                return $payload;
        }

        /**
         * Get Student Class Group
         * 
         * @param int $student ID
         * @return int Class ID
         */
        function get_student_class($student)
        {
                $kla = $this->db->select($this->dxa('class'), FALSE)->where('id', $student)->get('admission')->row();

                if ($kla)
                {
                        $cid = $kla->class;
                        $std = $this->db->select('class,stream')->where('id', $cid)->get('classes')->row();
                        if ($std)
                        {
                                $cl = $std;
                        }
                        else
                        {
                                $cl = FALSE;
                        }
                }
                else
                {
                        $cl = FALSE;
                }

                return $cl;
        }

        function get_class_by_year($student, $year)
        {
                $std = $this->db->select($this->dxa('class') . ' ,' . $this->dxa('stream'), FALSE)
                             ->where($this->dx('student') . '=' . $student, NULL, FALSE)
                             ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                             ->get('history')
                             ->row();
                if ($std)
                {
                        $cl = $std;
                }
                else
                {
                        $cl = FALSE;
                }

                return $cl;
        }

        function populate_admission()
        {
                $query = $this->db->select('id, ' . $this->dxa('first_name') . ' ,' . $this->dxa('last_name'), FALSE)->order_by($this->dx('first_name'), 'ASC', FALSE)->get('admission');
                $dropdowns = $query->result();

                $options = array();
                foreach ($dropdowns as $dp)
                {
                        $options[$dp->id] = $dp->first_name . '  ' . $dp->last_name;
                }
                return $options;
        }

        /**
         * Get Classes Options For Dropdown List
         * 
         * @param array $classes
         * @param array $streams
         * @return array
         */
        function get_classes($classes, $streams = FALSE)
        {
                $ops = $this->db->select('id,stream, class')->order_by('class')->get('classes')->result();

                $options = array();
                foreach ($ops as $p)
                {
                        if ($streams)
                        {
                                if (isset($streams[$p->stream]) && isset($classes[$p->class_id]))
                                {
                                        $options[$p->id] = $classes[$p->class_id] . ' ' . $streams[$p->stream];
                                }
                        }
                        else
                        {
                                if (isset($classes[$p->class_id]))
                                {
                                        $options[$p->id] = $classes[$p->class_id];
                                }
                        }
                }
                return $options;
        }

        /**
         * Get Class names
         * 
         * @return array
         */
        function get_class_names()
        {
                $ops = $this->db->select('id, class_name')->order_by('id')->get('school_classes')->result();

                $options = array();
                foreach ($ops as $p)
                {
                        $options[$p->id] = $p->class_name;
                }
                return $options;
        }

        function get_by_assoc($alert, $assoc_id, $tbl, $type)
        {
                $qr = $this->db->select('id, company_id')
                             ->where(array('alert_id' => $alert, 'type' => $type))
                             ->get($tbl)
                             ->result();
                $cos = array();
                foreach ($qr as $q)
                {
                        $cos[] = $q->$assoc_id;
                }
                return $cos;
        }

        function get_users()
        {
                return $this->db->select('id, first_name, last_name, client_id')
                                          ->where('active', 1)
                                          ->order_by('first_name ', 'ASC')
                                          ->order_by('last_name ', 'ASC')
                                          ->get('users')->result();
        }

        function get_tasks()
        {
                return $this->db->where("DATE_FORMAT(FROM_UNIXTIME(task_date), '%d %b %Y')='" . date('d M Y') . "'", NULL, FALSE)->get('tasks')->result();
        }

        /**
         * Get Number of Students Admitted in Specified Class
         * 
         * @param int $class the Class ID
         */
        function count_population($class, $stream = FALSE)
        {
                $this->db->where($this->dx('class') . '=' . $class, NULL, FALSE);
                if ($stream)
                {
                        $this->db->where($this->dx('stream') . '=' . $stream, NULL, FALSE);
                }
                $res = $this->db->count_all_results('admission');
                return $res;
        }

        /**
         * Get List of Students Admitted in Specified Class
         * 
         * @param int $class the Class ID
         */
        function get_population($class, $stream = FALSE)
        {
                //$this->select_all_key('admission');
                $this->db->where($this->dx('class') . '=' . $class, NULL, FALSE);
                if ($stream)
                {
                        $this->db->where($this->dx('stream') . '=' . $stream, NULL, FALSE);
                }
                return $this->db->get('classes')->result();
        }

        /**
         * Fetch Class Marks
         * 
         * @param int $class
         * @param int $term
         * @return object
         */
        function get_marks($class, $term = FALSE)
        {
                $term = get_term(date('m'));
                $info = $this->db->select('*')
                             ->where('class_id', $class)
                             // ->where('MONTH(FROM_UNIXTIME(exams_management.created_on))', $term)
                             ->join('exams_management', 'exams_management_list.exams_id = exams_management.id')
                             ->get('exams_management_list')
                             ->result();
                $perf_list = array();

                foreach ($info as $f)
                {
                        $perf_list[] = array(
                            'student' => $f->student,
                            'exams_id' => $f->exams_id,
                            'term' => get_term(date('m', $f->record_date)),
                            'grading' => $f->grading,
                            'marks' => $this->_fetch_by_marks($f->exams_id, $f->student),
                            'total' => $f->total,
                            'remarks' => $f->remarks,
                            'created_by' => $f->created_by,
                            'record_date' => $f->record_date
                        );
                }

                return $perf_list;
        }

        /**
         * Helper Fuction To Get Specific Marks and inject them to main array
         * 
         * @param int $exam
         * @param int $student
         * @return array
         */
        function _fetch_by_marks($exam, $student)
        {
                $list = $this->db->select('id, student')
                             ->where('exams_id', $exam)
                             ->where('student', $student)
                             ->get('exams_management_list')
                             ->result();
                if (empty($list))
                {
                        return array();
                }
                else
                {
                        $ids = array();
                        foreach ($list as $l)
                        {
                                $ids[$l->id] = $l->student;
                        }
                        $marks = array();
                        foreach ($ids as $id => $student)
                        {
                                $marks = $this->_get_marks_list($id);
                        }

                        aasort($marks, 'subject');
                        return $marks;
                }
        }

        /**
         * Fetch Exam Info
         * 
         * @param type $id
         * @return type
         */
        function _get_exam_info($id)
        {
                $res = $this->db->where('id', $id)
                             ->get('exams_management_list')
                             ->row();

                return $this->db->select('class_id, exam_type as exam', FALSE)
                                          ->where('id', $res->exams_id)
                                          ->get('exams_management')
                                          ->row();
        }

        /**
         * Helper function to dig deeper into marks list table based on its relationship with 
         * Exams_management_list table
         * 
         * @param int $id
         * @return array
         */
        function _get_marks_list($id)
        {
                $props = $this->_get_exam_info($id);

                $res = $this->db->select('exams_marks_list.id as id,exams_marks_list.subject, exams_marks_list.marks, subjects.is_optional')
                             ->join('subjects', 'subjects.id = subject')
                             //->where('subjects.is_optional', 0)
                             ->where('exams_list_id', $id)
                             ->get('exams_marks_list')
                             ->result_array();
                $remids = array(); //ids to remove of duplicate marks

                $finite = array();
                $lsu = 0;
                $xsub = array();
                foreach ($res as $key => $varr)
                {
                        $ff = (object) $varr;
                        if (in_array($ff->subject, $xsub))
                        {
                                $remids[] = $ff->id; //store ids marked for removal from db
                                continue;
                        }
                        $sgrade = $this->fetch_grading($props->exam, $props->class_id, $ff->subject);
                        $grading = empty($sgrade) ? 0 : $sgrade->grading;

                        $lsu += $ff->is_optional ? 0 : $ff->marks;
                        $units = $this->fetch_sub_marks($id, $ff->subject);
                        if (count($units))
                        {
                                $finite['mks'][$ff->subject] = array('units' => $units, 'marks' => $ff->marks, 'grading' => $grading, 'opt' => $ff->is_optional);
                        }
                        else
                        {
                                $finite['mks'][$ff->subject] = array('marks' => $ff->marks, 'grading' => $grading, 'opt' => $ff->is_optional);
                        }
                        $xsub[] = $ff->subject;
                }
                $finite['tots'] = $lsu;

                return $finite;
        }

        /**
         * fetch_grading System
         * 
         * @param int $exam
         * @param int $class
         * @param int $subject
         * @return type
         */
        function fetch_grading($exam, $class, $subject)
        {
                return $this->db->where(array('exam' => $exam, 'class' => $class, 'subject' => $subject))->get('exam_grading')->row();
        }

        /**
         * Get Grading records 
         * 
         * @param type $id
         * @param type $title
         * @return type
         */
        function get_grading_records($id)
        {
                $row = $this->db->where(array('grading_system' => $id))->get('grading')->row();
                if ($row)
                {
                        $records = $this->db->where(array('grading_id' => $row->id))->get('grading_records')->result();
                        $options = array();

                        foreach ($records as $r)
                        {
                                $grade = $this->find_row($r->grade, 'grades');

                                $title = empty($grade) || !isset($grade->title) ? '-' : $grade->title;
                                $options[] = array('min' => $r->minimum_marks, 'max' => $r->maximum_marks, 'title' => $title);
                        }
                        return $options;
                }
                else
                {
                        return array();
                }
        }

        /**
         * Fetch Marks Sub
         * @param type $subject
         * @return type
         */
        function fetch_sub_marks($id, $subject)
        {
                $ss = $this->db->where('parent', $subject)
                             ->where('marks_list_id', $id)
                             ->get('sub_marks')
                             ->result();
                $ret = array();
                foreach ($ss as $s)
                {
                        $ret[$s->unit] = $s->marks;
                }
                return $ret;
        }

        function get_subjects($class)
        {
                return $this->db->where(array('class_id' => $class))->get('subjects_classes')->result();
        }

        function list_subjects()
        {
                $results = $this->db->order_by('id', 'ASC')->get('subjects')->result();
                $rr = array();
                foreach ($results as $res)
                {
                        $rr[$res->id] = $res->title;
                }

                return $rr;
        }

        /**
         * Fetch Class by class_id & Stream 
         * 
         * @param type $class
         * @param type $stream
         * @return type
         */
        function get_class_stream($class, $stream)
        {
                return $this->db->where(array('class' => $class, 'stream' => $stream))->get('classes')->row();
        }

        /**
         * Fetch Current Students in Specified Stream  
         * 
         * @param type $id
         * @return type
         */
        function fetch_stream_students($id)
        {
                if (!$id)
                {
                        return array();
                }

                $list = $this->db->select('id')
                                          ->where($this->dx('class') . '=' . $id, NULL, FALSE)
                                          ->where($this->dx('status') . '=1', NULL, FALSE)
                                          ->get('admission')->result();

                $students = array();
                foreach ($list as $l)
                {
                        $students[] = $l->id;
                }
                return $students;
        }

        /**
         * Fetch Student Balance Status
         * 
         * @param int $student
         */
        function get_bal_status($student)
        {
                $this->select_all_key('new_balances');
                return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                          ->get('new_balances')
                                          ->row();
        }

        /**
         * Get Starting Balances
         * 
         * @return result object
         * 
         */
        function fetch_starting_balances()
        {
                $this->select_all_key('fee_arrears');
                return $this->db->get('fee_arrears')
                                          ->result();
        }

        function insert_rear($data)
        {
                return $this->insert_key_data('fee_arrears', $data);
        }

}
