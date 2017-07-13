<?php

class Admission_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function put_parent($data)
        {
                return $this->insert_key_data('parents', $data);
        }

        /**
         * New Student Admission Record
         * 
         * @param array $data
         * @return int - mysql insert id
         */
        function create($data)
        {
                return $this->insert_key_data('admission', $data);
        }

        function update_stud_balance($data)
        {
                return $this->insert_key_data('fee_arrears', $data);
        }

        /**
         * Record in History Table
         * 
         * @param array $data
         * @return void
         */
        function put_history($data)
        {
                return $this->insert_key_data('history', $data);
        }

        function put_arrears($data)
        {
                return $this->insert_key_data('fee_arrears', $data);
        }

        function update_paro($id, $data)
        {
                $this->db->where('id', $id);
                $query = $this->db->update('parents', $data);

                return $query;
        }

        /**
         * Assign Parent
         * 
         * @param type $data
         * @return void
         */
        function assign_parent($data)
        {
                return $this->db->insert('assign_parent', $data);
        }

        /**
         * New Parent
         * 
         * @param array $data
         * @return int - mysql insert id
         */
        function save_parent($data)
        {
                return $this->insert_key_data('parents', $data);
        }

        /**
         * Fetch Admission Row
         * 
         * @param int $id
         * @return object
         */
        function find($id, $qb = FALSE)
        {
                $this->select_all_key('admission');
                if ($qb)
                {
                        return $this->db->where($this->dx('list_id') . " ='" . $id . "'", NULL, FALSE)->get('admission')->row();
                }
                return $this->db->where(array('id' => $id))->get('admission')->row();
        }

//Get Student Class details
        function get_stud_class($id)
        {
                return $this->db->where(array('id' => $id))->get('class_groups')->row();
        }

        function get_my_class($id)
        {
                return $this->db->where(array('id' => $id))->get('classes')->row();
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
         * Fetch Class Row by ID
         * 
         * @class  int $id
         * @return object
         */
        function fetch_class($id)
        {
                return $this->db->where(array('id' => $id))->get('classes')->row();
        }

        /**
         * Fetch Current invoice for Student if it exists
         * 
         * @param type $id
         * @return type
         */
        function fetch_inv($id)
        {
                $row = $this->db->where(array('student_id' => $id, 'term' => get_term(date('m')), 'year' => date('Y')))->get('invoices')->row();
                return $row ? $row->id : FALSE;
        }

        /**
         * Fetch Student Waivers For Current Term
         * 
         * @param type $student
         * @param type $term
         */
        function get_waiver($student, $term)
        {
                return $this->db->select('sum(amount) as total')->where('student', $student)->where('term', $term)->get('fee_waivers')->row()->total;
        }

        function get_last_id()
        {
                //check empty
                $size = $this->count();
                $last = 0;
                if ($size)
                {
                        $res = $this->db
                                     ->select('MAX(id) as last ', FALSE)
                                     ->get('admission')
                                     ->row();
                        $this->select_all_key('admission');
                        $row = $this->find($res->last);
                        $last = intval(preg_replace("/[^0-9]/", "", $row->admission_number));
                }
                return $last;
        }

        function fx_reg()
        {
                //  return $this->update_key_data(364, 'admission', array('admission_number' => 1609));
        }

        //Passport
        function passport($id)
        {
                return $this->db->where(array('id' => $id))->get('passports')->row();
        }

        /**
         * Fetch Specific Row from Parents Table
         * 
         * @param int $id
         * @return object
         */
        function get_parent($id)
        {
                $this->select_all_key('parents');
                return $this->db->where(array('id' => $id))->get('parents')->row();
        }

        /**
         * Fetch Total Fee Payable for Class
         * 
         * @param int $id
         * @return object  /boolean false
         */
        function total_fees($id)
        {
                $row = $this->db->select('fee_id')->where('class_id', $id)->get('fee_class')->row();
                if ($row)
                {
                        $fid = $row->fee_id;
                }
                else
                {
                        return FALSE;
                }
                $dat = $this->db->select('fee_structure.*')
                             ->where('id', $fid)
                             ->get('fee_structure')
                             ->row();
                return $dat;
        }

        function get_paro($id)
        {
                $this->select_all_key('parents');
                return $this->db->where(array('id' => $id))->get('parents')->row();
        }

        function get_pid($id)
        {
                $ids = array();
                $this->select_all_key('parents');
                $links = $this->db->where($this->dx('slink') . "=" . $id, NULL, FALSE)->get('parents')->result();
                foreach ($links as $k)
                {
                        $ids[] = $k->id;
                }

                return $ids;
        }

        function locate_class($id, $stream)
        {
                if ($id == 3 || $id == 2)
                {
                        $st = 3;
                }
                else
                {
                        $st = $stream == 'NORTH' ? 1 : 2;
                }
                $rw = $this->db->where('class', $id)->where('stream', $st)->get('classes')->row();

                return $rw->id;
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('admission') > 0;
        }

        function parent_exists($email, $phone)
        {
                $this->select_all_key('parents');
                $rw = $this->db->where($this->dx('email') . "='" . $email . "'", NULL, FALSE)
                             ->where($this->dx('phone') . "='" . $phone . "'", NULL, FALSE)
                             ->get('parents')
                             ->row();
                return empty($rw) ? FALSE : $rw->id;
        }

        function user_email_exists($email)
        {
                return $this->db->where($this->dx('email') . "='" . $email . "'", NULL, FALSE)->count_all_results('users') > 0;
        }

        function count()
        {
                return $this->db->count_all_results('admission');
        }

        function count_my_students()
        {
                //get class ID that belongs to the logged in teacher
                $u = $this->ion_auth->get_user()->id;
                $cls = $this->db->where('class_teacher', $u)->get('classes')->row();
                $the_class = 0;
                if (!empty($cls->id))
                {
                        $the_class = $cls->id;
                }

                return $this->db->where($this->dx('admission.class') . ' = ' . $the_class, NULL, FALSE)->count_all_results('admission');
        }

        /**
         * Update Admission Record
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function update_attributes($id, $data)
        {
                return $this->update_key_data($id, 'admission', $data);
        }

        /**
         * Update Parent Record
         * 
         * @param type $id
         * @param type $data
         * @return type
         */
        function upd_parent($id, $data)
        {
                return $this->db->where('student_id', $id)->update('assign_parent', $data);
        }

        /**
         * Just Suspend Invoice For Suspended Student
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function suspend_invoice($id, $data)
        {
                return $this->db->where('id', $id)->update('invoices', $data);
        }

        /**
         * Update Parent
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function update_parent($id, $data)
        {
                return $this->update_key_data($id, 'parents', $data);
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

        /**
         * Fetch List of Parents
         * 
         * @return string
         */
        function fetch_parent_options()
        {
                $res = $this->db->select($this->dxa('first_name') . ', ' . $this->dxa('last_name') . ', id', FALSE)
                             //->where($this->dx('status') . ' =  0', NULL, FALSE)
                             ->order_by($this->dx('first_name'), 'ASC', FALSE)
                             ->get('parents')
                             ->result();
                $options = array();

                foreach ($res as $r)
                {
                        $options[$r->id] = $r->first_name . ' ' . $r->last_name;
                }
                return $options;
        }

        function delete($id)
        {
                return $this->db->delete('admission', array('id' => $id));
        }

        function get_history($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                $this->select_all_key('history');
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('history', $limit, $offset);

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

        function get_all()
        {

                $this->select_all_key('admission');
                $this->db->order_by('id', 'desc');
                //$this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
                $query = $this->db->get('admission');

                return $query;
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                $this->select_all_key('admission');
                $this->db->order_by('id', 'desc');
                $this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
                $query = $this->db->get('admission', $limit, $offset);

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
                $this->db->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname,' . $this->dx('parents.email') . ' as parent_email,' . $this->dx('parents.address') . ' as address,' . $this->dx('parents.phone') . ' as phone,', FALSE);
                $this->db->join('parents', 'parents.id= ' . $this->dx('parent_id'));
                $this->db->order_by('admission.id', 'desc');
                $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                $rResult = $this->db->get('admission');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->where($this->dx('status') . ' = 1', NULL, FALSE)->count_all_results('admission');

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
                        //$output['aaData'][] = $row;
                        $obData[] = $row;
                }
                $classes = $this->ion_auth->list_classes();
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
                                $adm = $iCol->admission_number;
                        }


                        $crow = $this->fetch_class($iCol->class);
                        if (!$crow)
                        {
                                $sft = ' - ';
                                $st = ' - ';
                        }
                        else
                        {
                                $sft = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
                        }
                        $aaData[] = array(
                            $iCol->id,
                            ucwords($iCol->first_name) . ' ' . ucwords($iCol->last_name),
                            $sft . ' ' . $st,
                            $adm,
                            $iCol->parent_fname . ' ' . $iCol->parent_lname,
                            $iCol->phone,
                            $iCol->parent_email . '<br>' . $iCol->address,
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

        /** STUDENTS PER CLASS TEACHER
         * Datatable Server Side Data Fetcher
         * 
         * @param int $iDisplayStart
         * @param int $iDisplayLength
         * @param type $iSortCol_0
         * @param int $iSortingCols
         * @param string $sSearch
         * @param int $sEcho
         */
        function get_my_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
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
                                        // $this->db->or_like($this->dx($aColumns[$i]), $sSearch, 'both', FALSE);
                                        $this->db->or_like('CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                                }
                        }
                }
//get class ID that belongs to the logged in teacher
                $u = $this->ion_auth->get_user()->id;
                $cls = $this->db->where('class_teacher', $u)->get('classes')->row();
                $the_class = 0;
                if (!empty($cls->id))
                {
                        $the_class = $cls->id;
                }
                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select_all_key('admission');
                $this->db->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname, ' . $this->dx('parents.email') . ' as parent_email, ' . $this->dx('parents.address') . ' as address, ' . $this->dx('parents.phone') . ' as phone, ', FALSE);
                $this->db->join('parents', 'parents.id = ' . $this->dx('parent_id'));
                $this->db->order_by('admission.id', 'desc');
                $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                $this->db->where($this->dx('admission.class') . ' = ' . $the_class, NULL, FALSE);
                $rResult = $this->db->get('admission');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->where($this->dx('status') . ' = 1', NULL, FALSE)->count_all_results('admission');

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
                        //$output['aaData'][] = $row;
                        $obData[] = $row;
                }

                $classes = $this->ion_auth->list_classes();
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
                                $adm = $iCol->admission_number;
                        }
                        $crow = $this->fetch_class($iCol->class);
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
                            ucwords($iCol->first_name) . ' ' . ucwords($iCol->last_name),
                            $sft . ' ' . $st,
                            $adm,
                            $iCol->parent_fname . ' ' . $iCol->parent_lname,
                            $iCol->phone,
                            $iCol->parent_email,
                            $iCol->address,
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
        function suspended($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
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
                                        // $this->db->or_like($this->dx($aColumns[$i]), $sSearch, 'both', FALSE);
                                        $this->db->or_like('CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                                }
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select_all_key('admission');
                //  $this->db->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname, ' . $this->dx('parents.email') . ' as parent_email, ' . $this->dx('parents.address') . ' as address, ' . $this->dx('parents.phone') . ' as phone, ', FALSE);
                //$this->db->join('parents', 'parents.id = ' . $this->dx('parent_id'));
                $this->db->order_by('admission.id', 'desc');
                $this->db->where($this->dx('admission.status') . ' = 0', NULL, FALSE);
                $rResult = $this->db->get('admission');

                //$this->db->select(' SQL_CALC_FOUND_ROWS ' . str_replace(', ', ' ', implode(', ', $aColumns)), false);
                //$rResult = $this->db->get('admission');
                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->where($this->dx('status') . ' = 0', NULL, FALSE)->count_all('admission');

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

                        //foreach ($aColumns as $col)
                        foreach ($aRow as $Key => $Value)
                        {
                                if ($Key && $Key !== ' ')
                                {

                                        $row[$Key] = $Value;
                                        //$row[$col] = $aRow[$col];
                                }
                        }
                        //$output['aaData'][] = $row;
                        $obData[] = $row;
                }

                $classes = $this->ion_auth->list_classes();
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
                                $adm = $iCol->admission_number;
                        }

                        $crow = $this->fetch_class($iCol->class);
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

                        $suspension_details = $this->get_suspended($iCol->id);
                        if (!empty($suspension_details))
                        {
                                $u = $this->ion_auth->get_user($suspension_details->created_by);
                        }
                        $fee = $this->fetch_balance($iCol->id);
                        $aaData[] = array(
                            $iCol->id,
                            isset($suspension_details->date) ? date('d M Y', $suspension_details->date) : '',
                            ucwords($iCol->first_name) . ' ' . ucwords($iCol->last_name),
                            $sft . ' ' . $st,
                            $adm,
                            isset($suspension_details->reason) ? $suspension_details->reason : '',
                            empty($suspension_details) ? '' : $u->first_name . ' ' . $u->last_name,
                            $fee->balance
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

        function fetch_balance($id)
        {
                $this->select_all_key('new_balances');
                $ret = $this->db->where($this->dx('student') . ' =' . $id, NULL, FALSE)
                                          ->get('new_balances')->row();

                return $ret;
        }

        function get_suspended($id)
        {
                return $this->db->where('student', $id)->order_by('id', 'DESC')->get('suspended')->row();
        }

        function save_photo($data)
        {
                $this->db->insert('passports', $data);
                return $this->db->insert_id();
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

        function pick_students($keyword, $limit)
        {
                $where = ' CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') LIKE '%" . $keyword . "%'  OR ";
                $where .= ' CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') LIKE '%" . $keyword . "%'  OR ";
                $where .= ' CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1')  LIKE '%" . $keyword . "%'  ";
                return $this->db->select('id,' . $this->dxa('first_name') . ' ,' . $this->dxa('last_name'), FALSE)
                                          ->where($where, NULL, FALSE)
                                          ->limit($limit)
                                          ->get('admission')
                                          ->result();
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
        function get_alumni($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
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
                                        // $this->db->or_like($this->dx($aColumns[$i]), $sSearch, 'both', FALSE);
                                        $this->db->or_like('CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                                }
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select_all_key('admission');
                //  $this->db->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname, ' . $this->dx('parents.email') . ' as parent_email, ' . $this->dx('parents.address') . ' as address, ' . $this->dx('parents.phone') . ' as phone, ', FALSE);
                //$this->db->join('parents', 'parents.id = ' . $this->dx('parent_id'));
                $this->db->order_by('admission.id', 'desc');
                $this->db->where($this->dx('admission.status') . ' = 3', NULL, FALSE);
                $rResult = $this->db->get('admission');

                //$this->db->select(' SQL_CALC_FOUND_ROWS ' . str_replace(', ', ' ', implode(', ', $aColumns)), false);
                //$rResult = $this->db->get('admission');
                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->where($this->dx('status') . ' = 3', NULL, FALSE)->count_all('admission');

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

                        //foreach ($aColumns as $col)
                        foreach ($aRow as $Key => $Value)
                        {
                                if ($Key && $Key !== ' ')
                                {

                                        $row[$Key] = $Value;
                                        //$row[$col] = $aRow[$col];
                                }
                        }
                        //$output['aaData'][] = $row;
                        $obData[] = $row;
                }

                $classes = $this->ion_auth->list_classes();
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
                                $adm = $iCol->admission_number;
                        }

                        $crow = $this->fetch_class($iCol->class);
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
                        //Set Gender
                        $gender = '';
                        if ($iCol->gender == 1)
                                $gender = 'Male';
                        else
                                $gender = 'Female';

                        //DOB
                        $dob = $iCol->dob > 1000 ? date('d M Y', $iCol->dob) : '';

                        $yr = $this->get_completion_yr($iCol->id);
                        $Cyr = isset($yr) ? $yr : ' ';

                        $aaData[] = array(
                            $iCol->id,
                            ucwords($iCol->first_name) . ' ' . ucwords($iCol->last_name),
                            $sft . ' ' . $st,
                            $adm,
                            $gender, //   $iCol->parent_fname . ' ' . $iCol->parent_lname,
                            $dob, //   $iCol->parent_fname . ' ' . $iCol->parent_lname,
                            date('M, d, Y', $iCol->admission_date),
                            $Cyr->year, //   $iCol->address,
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

        function get_completion_yr($id)
        {
                $this->select_all_key('history');
                return $this->db->where($this->dx('student') . '=' . $id, NULL, FALSE)->order_by('id', 'DESC')->get('history')->row();
        }

}
