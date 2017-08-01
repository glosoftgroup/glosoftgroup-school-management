<?php

class Teachers_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                return $this->insert_key_data('teachers', $data);
        }

        function find($id)
        {
                $this->select_all_key('teachers');
                return $this->db->where(array('id' => $id))->get('teachers')->row();
        }

        function get($id)
        {
                $this->select_all_key('teachers');
                return $this->db->where($this->dx('user_id') . ' = ' . $id, NULL, FALSE)->get('teachers')->row();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('teachers') > 0;
        }

        function exists_teacher($id)
        {
                return $this->db->where($this->dx('user_id') . ' = ' . $id, NULL, FALSE)->count_all_results('teachers') > 0;
        }

        function exists_email($email)
        {
                return $this->db->where($this->dx('email') . " = '" . $email . "'", NULL, FALSE)->count_all_results('users') > 0;
        }

        function count()
        {

                return $this->db->count_all_results('teachers');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('teachers', $data);
        }

        /**
         * Update Teacher Record
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function update_teacher($id, $data)
        {
                return $this->update_key_data($id, 'teachers', $data);
        }

        function populate($table, $option_val, $option_text)
        {
                $query = $this->db->select('*')->order_by($option_text)->get($table);
                $dropdowns = $query->result();

                foreach ($dropdowns as $dropdown)
                {
                        $options[$dropdown->$option_val] = $dropdown->$option_text;
                }
                return $options;
        }

        function delete($id)
        {
                return $this->db->delete('teachers', array('id' => $id));
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
                $aColumns = $this->db->list_fields('teachers');

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
                                        $this->db->order_by($this->dx('teachers.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);

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
                                        $this->db->or_like('CONVERT(' . $this->dx('teachers.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                                }
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
                $this->select_all_key('teachers');
                $this->db->order_by('created_on', 'DESC');
                $rResult = $this->db->get('teachers');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->where($this->dx('status') . ' = 1', NULL, FALSE)->count_all('teachers');

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

                foreach ($obData as $iCol)
                {
                        $iCol = (object) $iCol;
                        $u = $this->ion_auth->get_user($iCol->user_id);
                        $st = isset($status[$iCol->status]) ? $status[$iCol->status] : ' - ';
                        $status = 'Active';

                        if ($st == 1)
                        {
                                $status = 'Inactive';
                        }


                        $aaData[] = array(
                            $iCol->user_id,
                            $u->first_name . ' ' . $u->last_name,
                            $u->phone,
                            $u->email,
                            $u->active ? 'Active' : 'Suspended',
                            $iCol->designation,
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

}
