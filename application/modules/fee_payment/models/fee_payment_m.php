<?php

class Fee_payment_m extends MY_Model
{

        private $fts;

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
                $this->fts = array('1' => 'once', '2' => 'yearly', '3' => 'termly', '4' => 'Optional');
        }

        function create($data)
        {
                return $this->insert_key_data('fee_payment', $data);
        }

        function students_all_active_students()
        {
                $this->select_all_key('admission');
                return $this->db->where($this->dx('status') . '=1', NULL, FALSE)->get('admission')->result();
        }

        function has_paid($student, $amount, $date = 0)
        {
                $paid = array_sum($amount);
                $this->select_all_key('fee_receipt');
                $hs = $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                             ->where($this->dx('total') . '=' . $paid, NULL, FALSE)
                             ->where(" DATE_FORMAT(" . $this->dx('created_on') . " ,'%d-%m-%Y') =" . date('d-m-Y'), NULL, FALSE)
                             ->get('fee_receipt')
                             ->result();
                return count($hs) ? TRUE : FALSE;
        }

        function create_list($data)
        {
                $this->db->insert('fee_payment', $data);
                return $this->db->insert_id();
        }

        //Parent details
        function get_parent($id)
        {
                $this->select_all_key('parents');
                return $this->db->where('id', $id)->get('parents')->row();
        }

        //Student  Details
        function get_balance($id)
        {
                $this->select_all_key('new_balances');
                return $this->db->where($this->dx('student') . '=' . $id, NULL, FALSE)->get('new_balances')->row();
        }

        function filter_balance($range)
        {
                return $this->db->select($this->dxa('student') . ', ' . $this->dxa('balance'), FALSE)->where($this->dx('balance') . '>=' . $range, NULL, FALSE)->get('new_balances')->result();
        }

        //Insert receipt
        function insert_rec($data)
        {
                $this->db->insert('fee_receipt', $data);
                return $this->db->insert_id();
        }

        function get_last_id()
        {
                //check empty
                $size = $this->count_rec();
                $last = 0;
                if ($size)
                {
                        $res = $this->db
                                     ->select('MAX(id) as id ', FALSE)
                                     ->get('fee_receipt')
                                     ->row();

                        $last = intval(preg_replace("/[^0-9]/", "", $res->id));
                }
                return $last + 1;
        }

        function get_id_pay()
        {
                $this->select_all_key('fee_payment');
                $res = $this->db
                             ->get('fee_payment')
                             ->result();
                $fn = array();
                foreach ($res as $r)
                {
                        $fn[$r->reg_no][date('d-m-Y', $r->created_on)][] = $r->id;
                }
                return $fn;
        }

        function get_grouped_pay()
        {
                // Group into receipts by day & student
                $this->db->_protect_identifiers = FALSE;
                $res = $this->db->select($this->dxa('reg_no') . " ,count(*) as total,DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('created_on') . "),'%d-%m-%Y') as date ")        //->where('status', 1)
                             ->group_by("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('created_on') . "),'%d-%m-%Y') ", FALSE)
                             ->group_by($this->dx('reg_no'), FALSE)
                             ->get('fee_payment')
                             ->result();
                $this->db->_protect_identifiers = TRUE;
                return $res;
        }

        function total_payment($id)
        {
                return $this->db->where(array('id' => $id))->get('fee_receipt')->row();
        }

        //Select total fee for the term student was reg
        function get_fees($term)
        {
                return $this->db->select('fee_structure.*')->where('term', $term)->get('fee_structure')->row();
        }

        function total_fees($id)
        {
                $dat = $this->db->select('fee_structure.*')
                             ->where('school_class', $id)
                             ->get('fee_structure')
                             ->row();
                return $dat;
        }

        function full_total_fees()
        {
                $dat = $this->db->select('sum(' . $this->dx('amount') . ') as total', FALSE)
                             ->where_in("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('payment_date') . "),'%m-%Y')", gen_terms())
                             ->where($this->dx('status') . '=1', NULL, FALSE)
                             ->get('fee_payment')
                             ->row();
                return $dat;
        }

        /**
         * Get All Debits for this Student
         * @param type $student
         * @return type
         */
        function get_debs_list($student)
        {
                return $this->db->where('student_id', $student)
                                          ->where('check_st !=', 3)
                                          ->get('invoices')
                                          ->result();
        }

        /**
         * Sum of initial Arrears
         * 
         * @param type $student
         * @return type
         */
        function fetch_total_arrears($student = 0)
        {
                $this->db->select('sum(' . $this->dx('amount') . ') as total', FALSE);
                if ($student)
                {
                        $this->db->where($this->dx('student') . ' =' . $student, NULL, FALSE);
                }

                $rears = $this->db->get('fee_arrears')
                                          ->row()->total;
                return (float) $rears;
        }

        /**
         * Fetch Overall Debits
         * 
         * @return type
         */
        function get_total_debs()
        {
                return $this->db->where('check_st !=', 3)->get('invoices')->result();
        }

        /**
         * Fetch Fee Extras all (Waivers & Charges) for Student
         * 
         * @param type $student
         * @return type
         */
        function get_fee_extras($student)
        {
                $this->select_all_key('fee_extra_specs');
                return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                          ->get('fee_extra_specs')
                                          ->result();
        }

        /**
         * Fetch Fee Extras all (Waivers & Charges) for Student
         * 
         * @param type $student
         * @return type
         */
        function get_extras($student, $term, $year)
        {
                $this->select_all_key('fee_extra_specs');
                return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                          ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                                          ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                                          ->get('fee_extra_specs')
                                          ->result();
        }

        /**
         * Fetch Fee Extras all (Waivers & Charges) for Student
         * 
         * @param type $student
         * @return type
         */
        function get_next_waivers($student, $term, $year)
        {
                return $this->db->where('student', $student)
                                          ->where('term', $term)
                                          ->where('year', $year)
                                          ->get('fee_waivers')
                                          ->result();
        }

        /**
         * Fetch Extra Fee Row
         * 
         * @param type $id
         * @return type
         */
        function get_extra($id)
        {
                return $this->db->where(array('id' => $id))->get('fee_extras')->row();
        }

        /**
         * Get Waivers For Student
         * 
         * @param type $student
         * @return type
         */
        function get_waivers($student)
        {
                return $this->db->where('student', $student)
                                          ->get('fee_waivers')
                                          ->result();
        }

        /**
         * Total Waivers
         * 
         * @return type
         */
        function get_total_waivers()
        {
                return $this->db->get('fee_waivers')->result();
        }

        /**
         * Get Debits per year per term for this student
         * 
         * @param type $student
         * @param type $yr
         * @param type $term
         * @return type
         */
        function get_debits($student, $yr, $term)
        {
                $debs = $this->db->select('amount,created_on, fee_id , invoice_no')
                             ->where('student_id', $student)
                             ->where('YEAR(FROM_UNIXTIME(created_on)) ', $yr)
                             ->where('term', $term)
                             ->get('invoices')
                             ->result();

                $list = array();
                foreach ($debs as $d)
                {
                        $list[] = array('date' => $d->created_on, 'amount' => $d->amount, 'desc' => 'Tuition Fee Payable', 'refno' => $d->invoice_no);
                }
                return $list;
        }

        function list_banks()
        {
                $result = $this->db->select('bank_accounts.*')
                             ->order_by('created_on', 'DESC')
                             ->get('bank_accounts')
                             ->result();

                $rr = array();
                foreach ($result as $res)
                {
                        $rr[$res->id] = $res->bank_name . ' (' . $res->account_number . ')';
                }

                return $rr;
        }

        //Get All Payments Group by Reg No
        function get_all()
        {
                return $this->db->select('fee_payment.*')
                                          ->where('status', 1)
                                          ->order_by('created_on', 'DESC')
                                          ->group_by('reg_no')
                                          ->get('fee_payment')
                                          ->result();
        }

        //Calculate total aid Fees
        function total_paid($id)
        {
                $dat = $this->db->select('sum(' . $this->dx('amount') . ') as amount', FALSE)
                             ->where($this->dx('reg_no') . ' =' . $id, NULL, FALSE)
                             ->where($this->dx('status') . ' =1', NULL, FALSE)
                             ->get('fee_payment')
                             ->row();

                return $dat;
        }

        function fetch_balance($id)
        {
                $this->select_all_key('new_balances');
                $ret = $this->db->where($this->dx('student') . ' =' . $id, NULL, FALSE)
                                           ->get('new_balances')->row();

                return $ret;
        }

        public function banks()
        {
                $results = $this->db->select('bank_accounts.*')
                             ->get('bank_accounts')
                             ->result();

                $arr = array();
                foreach ($results as $res)
                {
                        $arr[$res->id] = $res->bank_name;
                }

                return $arr;
        }

        function find($id)
        {
                $this->select_all_key('fee_payment');
                return $this->db->where(array('id' => $id))->get('fee_payment')->row();
        }

        function fetch_receipt($id)
        {
                return $this->db->where(array('id' => $id))->get('fee_receipt')->row();
        }

        function find_fee($id)
        {
                return $this->db->where(array('id' => $id))->get('fee_structure')->row();
        }

        function get_student($id)
        {
                $this->select_all_key('admission');
                return $this->db->where(array('id' => $id))->get('admission')->row();
        }

        function students_in_class($id)
        {
                $this->select_all_key('admission');
                return $this->db->where($this->dx('class') . '=' . $id, NULL, FALSE)->get('admission')->result();
        }

        function get_row($id)
        {
                $this->select_all_key('fee_payment');
                return $this->db->where($this->dx('reg_no') . ' =' . $id, NULL, FALSE)->get('fee_payment')->row();
        }

        /**
         * Fetch All payments by this student
         * 
         * @param type $id
         * @return type'
         */
        function get_receipts($id)
        {
                $this->select_all_key('fee_payment');
                return $this->db->where($this->dx('reg_no') . ' =' . $id, NULL, FALSE)->where($this->dx('status') . ' = 1', NULL, FALSE)->get('fee_payment')->result();
        }

        /**
         * Fetch All non Voided Payments For Selected Term & Year 
         * @param type $term
         * @param type $year
         * @return type
         */
        function fetch_all_receipts($term, $year)
        {
                $this->select_all_key('fee_payment');
                if ($term)
                {
                        $this->db->where_in("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('payment_date') . "),'%m-%Y')", gen_terms_alt($term, $year));
                }
                if ($year)
                {
                        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('payment_date') . "),'%Y') =" . $year, NULL, FALSE);
                }
                return $this->db->where($this->dx('status') . ' = 1', NULL, FALSE)
                                          ->get('fee_payment')
                                          ->result();
        }

        /**
         * Get All Debits
         * 
         * @param type $term
         * @param type $year
         * @return type
         */
        function fetch_all_debs($term, $year)
        {
                if ($term)
                {
                        $this->db->where("term", $term);
                }
                if ($year)
                {
                        $this->db->where("year", $year);
                }
                return $this->db->where("check_st !=3", NULL, FALSE)
                                          ->get('invoices')
                                          ->result();
        }

        /**
         * Get Waivers
         * 
         * @param type $term
         * @param type $year
         * @return type
         */
        function fetch_all_waivers($term, $year)
        {
                if ($term)
                {
                        $this->db->where("term", $term);
                }
                if ($year)
                {
                        $this->db->where("year", $year);
                }
                return $this->db->get('fee_waivers')
                                          ->result();
        }

        /**
         * Fetch Fee Extras all (Waivers & Charges) for School
         * 
         * @param type $term
         * @param type $year
         * @return type
         */
        function fetch_all_exts($term, $year)
        {
                $this->select_all_key('fee_extra_specs');
                if ($term)
                {
                        $this->db->where($this->dx("term") . '=' . $term, NULL, FALSE);
                }
                if ($year)
                {
                        $this->db->where($this->dx("year") . '=' . $year, NULL, FALSE);
                }
                return $this->db->get('fee_extra_specs')
                                          ->result();
        }

        /**
         * Fetch Fee Balances for School
         * 
         * @param type $term
         * @param type $year
         * @return type
         */
        function fetch_all_bals($term, $year)
        {
                $this->select_all_key('keep_balances');
                if ($term)
                {
                        $this->db->where($this->dx("term") . '=' . $term, NULL, FALSE);
                }
                if ($year)
                {
                        $this->db->where($this->dx("year") . '=' . $year, NULL, FALSE);
                }
                return $this->db->get('keep_balances')
                                          ->result();
        }

        /**
         * Fetch All Payments
         * 
         * @return type
         */
        function get_total_receipts()
        {
                $this->select_all_key('fee_payment');
                return $this->db->get('fee_payment')->result();
        }

        function get($id)
        {
                $this->select_all_key('fee_payment');
                return $this->db->where('id', $id)->get('fee_payment')->row();
        }

        //Receipt by time
        function get_pays($id)
        {
                $this->select_all_key('fee_payment');
                return $this->db->where($this->dx('receipt_id') . '=' . $id, NULL, FALSE)->where($this->dx('status') . ' = 1', NULL, FALSE)->order_by('id', 'DESC')->get('fee_payment')->result();
        }

        //Receipt row by time
        function get_row_time($id)
        {
                $this->select_all_key('fee_payment');
                return $this->db->where($this->dx('receipt_id') . '=' . $id, NULL, FALSE)->where($this->dx('status') . ' = 1', NULL, FALSE)->order_by('id', 'DESC')->get('fee_payment')->row();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('fee_payment') > 0;
        }

        function exists_receipt($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('fee_receipt') > 0;
        }

        function student_exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('admission') > 0;
        }

        /**
         * Check if a balance entry exists for sudent
         * 
         * @param type $student
         * @return type
         */
        function bal_exists($student)
        {
                return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)->count_all_results('new_balances') > 0;
        }

        /**
         * Check if a Bal entry exists for student , term & Year
         * @param type $student
         * @param type $term
         * @param type $year
         * @return type
         */
        function term_bal_exists($student, $term, $year)
        {
                return $this->db->where($this->dx('student') . "='" . $student . "'", NULL, FALSE)
                                          ->where($this->dx('term') . "='" . $term . "'", NULL, FALSE)
                                          ->where($this->dx('year') . "='" . $year . "'", NULL, FALSE)
                                          ->count_all_results('keep_balances');
        }

        /**
         * Insert new Balance entry
         * 
         * @param array $data
         * @return boolean
         */
        function put_balances($data)
        {
                return $this->insert_key_data('new_balances', $data);
        }

        /**
         * Insert new Term Balance entry
         * 
         * @param array $data
         * @return boolean
         */
        function keep_term_balance($data)
        {
                $ins = $this->insert_key_data('keep_balances', $data);
        }

        /**
         * Update balance entry
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function update_balances($id, $data)
        {
                return $this->update_key_where($this->dx('student') . ' = ' . $id, 'new_balances', $data);
        }

        //Get Fee extras

        function all_fee_extras()
        {

                $result = $this->db->where('ftype', 1)->order_by('title', 'ASC')->get('fee_extras')->result();
                $res = array();

                foreach ($result as $r)
                {
                        $res[$r->id] = $r->title;
                }

                return $res;
        }

        /**
         * Update Term balance entry
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function update_term_balance($student, $term, $year, $data)
        {
                $where = $this->dx('student') . ' = ' . $student . ' AND  ' . $this->dx('term') . ' = ' . $term . ' AND  ' . $this->dx('year') . ' = ' . $year;
                return $this->update_key_where($where, 'keep_balances', $data);
        }

        function count()
        {
                return $this->db->count_all_results('fee_payment');
        }

        function count_rec()
        {
                return $this->db->count_all_results('fee_receipt');
        }

        function update_attributes($id, $data)
        {
                return $this->update_key_data($id, 'fee_payment', $data);
        }

        function update_fee_receipt($id, $data)
        {
                return $this->db->where('id', $id)->update('fee_receipt', $data);
        }

        /**
         * Datatable Server Side Data Fetcher
         * 
         * @param int $iDisplayStart
         * @param int $iDisplayLength
         * @param type $iSortCol_0
         * @param int $iSortingCols
         * @param string $sSearch
         * @param int $sEcho
         */
        function get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
        {
                $aColumns = $this->db->list_fields('fee_payment');

                // Paging
                if (isset($iDisplayStart) && $iDisplayLength != '-1')
                {
                        $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
                }

                // Ordering
                if (isset($iSortCol_0))
                {
                        for ($i = 0; $i < intval($iSortingCols); $i++)
                        {
                                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                                if ($bSortable == 'true')
                                {
                                        if ($aColumns[$i] == 'reg_no')
                                        {
                                                $this->db->join('admission', 'reg_no=admission.id');
                                                $this->db->order_by('CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') ", $this->db->escape_str($sSortDir), FALSE);
                                        }
                                        else
                                        {
                                                $this->db->_protect_identifiers = FALSE;
                                                $this->db->order_by('fee_payment.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
                                                $this->db->_protect_identifiers = TRUE;
                                        }
                                }
                        }
                }

                /*
                 * Filtering
                 * NOTE this does not match the built-in DataTables filtering which does it
                 * word by word on any field. It's possible to do here, but concerned about efficiency
                 * on very large tables, and MySQL's regex functionality is very limited
                 */
                if (isset($sSearch) && !empty($sSearch))
                {
                        $where = '';
                        for ($i = 0; $i < count($aColumns); $i++)
                        {
                                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                                // Individual column filtering
                                if (isset($bSearchable) && $bSearchable == 'true')
                                {
                                        $sSearch = $this->db->escape_like_str($sSearch);
                                        if ($aColumns[$i] == 'reg_no')
                                        {
                                                $this->db->join('admission', $this->dx('reg_no') . '=admission.id');
                                                $where = ' CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                                                $where .= ' CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                                                $where .= ' CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1')  LIKE '%" . $sSearch . "%'  ";
                                        }
                                        else
                                        {
                                                $where .= 'OR CONVERT(' . $this->dx('fee_payment.' . $aColumns[$i]) . " USING 'latin1') LIKE '%" . $sSearch . "%'  ";
                                        }
                                        //$sSearch = $this->db->escape_like_str($sSearch);
                                        // $this->db->or_like('CONVERT(' . $this->dx('fee_payment.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                                }
                        }
                        if (isset($where) && !empty($where))
                        {
                                $this->db->where('(' . $where . ')', NULL, FALSE);
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select_all_key('fee_payment');
                $this->db->where($this->dx('fee_payment.status') . ' = 1', NULL, FALSE);
                $this->db->order_by($this->dx('payment_date'), 'DESC', false);
                $rResult = $this->db->get('fee_payment');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->where($this->dx('fee_payment.status') . ' = 1', NULL, FALSE)->count_all_results('fee_payment');

                // Output
                $output = array(
                    'sEcho' => intval($sEcho),
                    'iTotalRecords' => $iTotal,
                    'iTotalDisplayRecords' => $iFilteredTotal,
                    'aaData' => array()
                );

                $aaData = array();
                $obData = array();
                foreach ($rResult->result_array() as $aRow)
                {
                        $row = array();

                        foreach ($aRow as $Key => $Value)
                        {
                                if ($Key && $Key !== ' ')
                                {
                                        $row[$Key] = $Value;
                                }
                        }
                        $obData[] = $row;
                }
                $classes = $this->ion_auth->list_classes();
                $bank = $this->fee_payment_m->list_banks();
                $streams = $this->ion_auth->get_stream();

                foreach ($obData as $iCol)
                {
                        $iCol = (object) $iCol;

                        $bk = isset($bank[$iCol->bank_id]) ? $bank[$iCol->bank_id] : ' - ';
                        $ccc = $this->get_student($iCol->reg_no);
                        $std = '';
                        if (!empty($ccc))
                        {
                                $stud = $ccc->first_name . ' ' . $ccc->last_name;
                                $std = isset($stud) ? $stud : ' ';
                        }
                        if (!isset($ccc->class))
                        {
                                $sft = ' - ';
                                $st = ' - ';
                        }
                        else
                        {
                                $crow = $this->portal_m->fetch_class($ccc->class);
                                if (!$crow)
                                {
                                        $sft = ' - ';
                                        $st = ' - ';
                                }
                                else
                                {
                                        $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                                        $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                                        $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
                                }
                        }
                        $extras = $this->all_fee_extras();
                        if ($iCol->description == 0)
                                $desc = 'Tuition Fee Payment';
                        elseif (is_numeric($iCol->description))
                                $desc = $extras[$iCol->description];
                        else
                                $desc = $iCol->description;

                        $aaData[] = array(
                            $iCol->id,
                            $iCol->payment_date ? date('d M Y ', $iCol->payment_date) : ' ',
                            $std . ' ' . $sft . ' ' . $st,
                            $iCol->amount > 0 ? number_format($iCol->amount, 2) : $iCol->amount,
                            $bk,
                            $iCol->payment_method,
                            $desc,
                            $iCol->receipt_id
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

        /**
         * Datatable Server Side Data Fetcher
         * 
         * @param int $iDisplayStart
         * @param int $iDisplayLength
         * @param type $iSortCol_0
         * @param int $iSortingCols
         * @param string $sSearch
         * @param int $sEcho
         */
        function get_voided($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
        {
                $aColumns = $this->db->list_fields('fee_payment');

                // Paging
                if (isset($iDisplayStart) && $iDisplayLength != '-1')
                {
                        $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
                }

                // Ordering
                if (isset($iSortCol_0))
                {
                        for ($i = 0; $i < intval($iSortingCols); $i++)
                        {
                                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                                if ($bSortable == 'true')
                                {
                                        $this->db->_protect_identifiers = FALSE;
                                        $this->db->order_by($this->dx('fee_payment.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);
                                        $this->db->_protect_identifiers = TRUE;
                                }
                        }
                }

                /*
                 * Filtering
                 * NOTE this does not match the built-in DataTables filtering which does it
                 * word by word on any field. It's possible to do here, but concerned about efficiency
                 * on very large tables, and MySQL's regex functionality is very limited
                 */
                if (isset($sSearch) && !empty($sSearch))
                {
                        for ($i = 0; $i < count($aColumns); $i++)
                        {
                                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                                // Individual column filtering
                                if (isset($bSearchable) && $bSearchable == 'true')
                                {
                                        $sSearch = $this->db->escape_like_str($sSearch);
                                        $this->db->or_like('CONVERT(' . $this->dx('fee_payment.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                                }
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select_all_key('fee_payment');
                //$this->db->group_by('receipt_id');
                $this->db->where($this->dx('status') . ' = 0', NULL, FALSE);
                $this->db->order_by($this->dx('created_on'), 'DESC', false);
                $rResult = $this->db->get('fee_payment');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->count_all('fee_payment');

                // Output
                $output = array(
                    'sEcho' => intval($sEcho),
                    'iTotalRecords' => $iTotal,
                    'iTotalDisplayRecords' => $iFilteredTotal,
                    'aaData' => array()
                );

                $aaData = array();
                $obData = array();
                foreach ($rResult->result_array() as $aRow)
                {
                        $row = array();

                        foreach ($aRow as $Key => $Value)
                        {
                                if ($Key && $Key !== ' ')
                                {

                                        $row[$Key] = $Value;
                                }
                        }
                        $obData[] = $row;
                }

                // $all = $this->ion_auth->students_full_details();

                $bank = $this->list_banks();
                //$streams = $this->ion_auth->get_stream();

                foreach ($obData as $iCol)
                {
                        $iCol = (object) $iCol;
                        $st = $this->worker->get_student($iCol->reg_no);
                        if (empty($st))
                        {
                                $st = new stdClass();
                                $st->first_name = '';
                                $st->last_name = '';
                        }
                        $u = $this->ion_auth->get_user($iCol->modified_by);
                        $stdd = $st->first_name . ' ' . $st->last_name;
                        $bk = isset($bank[$iCol->bank_id]) ? $bank[$iCol->bank_id] : ' - ';
                        $byname = $u->first_name . ' ' . $u->last_name;
                        $aaData[] = array(
                            '',
                            $iCol->payment_date ? date('d M Y ', $iCol->payment_date) : ' ',
                            $stdd,
                            $iCol->amount > 0 ? number_format($iCol->amount, 2) : $iCol->amount,
                            $bk,
                            $iCol->payment_method,
                            $iCol->description,
                            $iCol->modified_on ? date('d M Y ', $iCol->modified_on) : ' ',
                            $byname,
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

        /**
         * Datatable Server Side Data Fetcher For Student Balance Status
         * 
         * @param int $iDisplayStart
         * @param int $iDisplayLength
         * @param type $iSortCol_0
         * @param int $iSortingCols
         * @param string $sSearch
         * @param int $sEcho
         */
        function get_bals($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
        {
                $aColumns = $this->db->list_fields('admission');

                // Paging
                if (isset($iDisplayStart) && $iDisplayLength != '-1')
                {
                        $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
                }

                // Ordering
                if (isset($iSortCol_0))
                {
                        for ($i = 0; $i < intval($iSortingCols); $i++)
                        {
                                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                                if ($bSortable == 'true')
                                {
                                        $this->db->_protect_identifiers = FALSE;
                                        $this->db->order_by($this->dx('admission.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);

                                        $this->db->_protect_identifiers = TRUE;
                                }
                        }
                }

                /*
                 * Filtering
                 * NOTE this does not match the built-in DataTables filtering which does it
                 * word by word on any field. It's possible to do here, but concerned about efficiency
                 * on very large tables, and MySQL's regex functionality is very limited
                 */
                if (isset($sSearch) && !empty($sSearch))
                {
                        for ($i = 0; $i < count($aColumns); $i++)
                        {
                                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                                // Individual column filtering
                                if (isset($bSearchable) && $bSearchable == 'true')
                                {
                                        $sSearch = $this->db->escape_like_str($sSearch);
                                        $this->db->or_like('CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                                }
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select_all_key('admission');
                $this->db->select($this->dx('new_balances.balance') . ' as balance, ' . $this->dx('new_balances.invoice_amt') . ' as invoice_amt,' . $this->dx('new_balances.paid') . ' as paid', FALSE);
                $this->db->join('new_balances', 'admission.id= ' . $this->dx('student'));
                $this->db->order_by('admission.id', 'desc');
                if ($this->session->userdata('pw'))
                {
                        $pop = $this->session->userdata('pw');
                        $this->db->where($this->dx('admission.class') . ' =' . $pop, NULL, FALSE);
                }
                $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                $rResult = $this->db->get('admission');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                if ($this->session->userdata('pw'))
                {
                        $pop = $this->session->userdata('pw');
                        $this->db->where($this->dx('admission.class') . ' =' . $pop, NULL, FALSE);
                }
                $iTotal = $this->db->join('new_balances', 'admission.id= ' . $this->dx('student'))
                             ->where($this->dx('admission.status') . ' = 1', NULL, FALSE)
                             ->count_all_results('admission');

                // Output
                $output = array(
                    'sEcho' => intval($sEcho),
                    'iTotalRecords' => $iTotal,
                    'iTotalDisplayRecords' => $iFilteredTotal,
                    'aaData' => array()
                );

                $aaData = array();
                $obData = array();
                foreach ($rResult->result_array() as $aRow)
                {
                        $row = array();

                        foreach ($aRow as $Key => $Value)
                        {
                                if ($Key && $Key !== ' ')
                                {

                                        $row[$Key] = $Value;
                                }
                        }
                        $obData[] = $row;
                }

                $classes = $this->get_class_options();
                $streams = $this->ion_auth->get_stream();

                foreach ($obData as $iCol)
                {
                        $iCol = (object) $iCol;
                        $adm = '';
                        if (!empty($iCol->old_adm_no))
                        {
                                $adm = $iCol->old_adm_no;
                        }
                        else
                        {
                                if ($iCol->admission_number > 99)
                                {
                                        $adm = $iCol->admission_number;
                                }
                                else
                                {
                                        $adm = '' . $iCol->admission_number;
                                }
                        }
                        $crow = $this->portal_m->fetch_class($iCol->class);
                        if (!$crow)
                        {
                                $sft = ' - ';
                                $st = ' - ';
                        }
                        else
                        {
                                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
                        }
                        $aaData[] = array(
                            $iCol->id,
                            $iCol->first_name . ' ' . $iCol->last_name,
                            $sft . ' ' . $st,
                            $adm,
                            number_format($iCol->invoice_amt, 2),
                            number_format($iCol->paid, 2),
                            is_numeric($iCol->balance) ? number_format($iCol->balance, 2) : $iCol->balance
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

        /**
         * Fetch Classes
         * 
         * @return type
         */
        function get_class_options()
        {
                $list = $this->db->select('id, name')
                             ->where('status', 1)
                             ->order_by('id')
                             ->get('class_groups')
                             ->result();
                $cls = array();
                foreach ($list as $l)
                {
                        $cls[$l->id] = $l->name;
                }
                return $cls;
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

        function get_payments()
        {
                $this->select_all_key('fee_payment');
                return $this->db->where($this->dx('status') . '= 1', NULL, FALSE)
                                          ->order_by($this->dx('payment_date'), 'DESC', FALSE)
                                          ->limit(6)
                                          ->get('fee_payment')
                                          ->result();
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('fee_payment', $limit, $offset);

                $result = array();

                foreach ($query->result() as $row)
                {
                        $result[] = $row;
                }

                if ($result)
                {
                        return $result;
                }
                else
                {
                        return FALSE;
                }
        }

        function fix_balance_db()
        {
                $que = "
            ALTER TABLE `new_balances` ADD COLUMN `invoice_amt` BLOB NOT NULL AFTER `student`;
            ALTER TABLE `new_balances` ADD COLUMN `paid` BLOB NOT NULL AFTER `balance`;";
                $this->db->query($que);
        }

}
