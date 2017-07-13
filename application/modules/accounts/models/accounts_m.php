<?php
class Accounts_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        return $this->insert_key_data('accounts', $data);
    }

    function find($id)
    {
        $this->select_all_key('accounts');
        return $this->db->where(array('id' => $id))->get('accounts')->row();
    }

    /*     * **
     * **Get account details by account code
     * * */

    function get_by_code($id)
    {
        $this->select_all_key('accounts');
        return $this->db->where($this->dx('code') . '=' . $id, NULL, FALSE)->get('accounts')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('accounts') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('accounts');
    }

    function update_attributes($id, $data)
    {
        return $this->update_key_data($id, 'accounts', $data);
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

    function populate_enc($table, $option_val, $option_text)
    {
        $this->select_all_key('accounts');
        $query = $this->db->select($option_val . ',' . $this->dxa($option_text), FALSE)->order_by($this->dx($option_text), 'ASC', FALSE)->get($table);
        $dropdowns = $query->result();
        $options = array();
        foreach ($dropdowns as $dropdown)
        {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
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
        $aColumns = $this->db->list_fields('accounts');

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
                    $this->db->order_by($this->dx('accounts.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);
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
                    $this->db->or_like('CONVERT(' . $this->dx('accounts.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->select_all_key('accounts');
		$this->db->order_by($this->dx('accounts.code'),'ASC',FALSE);
        $rResult = $this->db->get('accounts');
		
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all('accounts');

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
        $types = $this->populate('account_types', 'id', 'name');

        $taxes = $this->populate('tax_config', 'id', 'name');
        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;
            $act = isset($types[$iCol->account_type]) ? $types[$iCol->account_type] : '';
            $taxx = isset($taxes[$iCol->tax]) ? $taxes[$iCol->tax] : '';
            $aaData[] = array(
                $iCol->id,
                $iCol->code,
                $iCol->name,
                $act,
                $taxx,
                number_format($iCol->balance, 2)
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Fetch Chart of Accounts For PNL
     * 
     * @return array
     */
    function get_pnl()
    {
        $this->select_all_key('accounts');
        $this->db->where($this->dx('code') . '< 600', NULL, FALSE)
                ->order_by($this->dx('code'), 'ASC', FALSE);
        $result = $this->db->get('accounts')->result();

        $accs = array();
         foreach ($result as $r)
        {
            if (TRUE)//$r->account_type && $r->balance)
            {
                $code = $this->worker->get_account_group($r->code);

                $accs[$code][] = array('account' => $r->name, 'code' => $r->code, 'balance' => $r->balance);
            }
        }
        $sorter = array('Revenue', 'Expenses');

        $fn = sort_by_array($accs, $sorter);

        return $fn;
    }

    /**
     * Fetch Chart of Accounts For Trial Balance
     * 
     * @return array
     */
    function get_accounts()
    {
        $this->select_all_key('accounts');
        $this->db->order_by($this->dx('code'), 'ASC', FALSE);
        $result = $this->db->get('accounts')->result();

        $accs = array();
        
        foreach ($result as $r)
        {
            if (TRUE)//$r->account_type && $r->balance)
            {
                if ($r->code < 400 || (($r->code > 799) || ($r->code > 799) ))
                {
                    $side = 1; //cr
                }
                else
                {
                    $side = 0;
                }
                $code = $this->worker->get_account_group($r->code);

                $accs[$code][] = array('account' => $r->name, 'code' => $r->code, 'balance' => $r->balance, 'side' => $side);
            }
        }
        $sorter = array('Revenue', 'Expenses', 'Assets', 'Liabilities', 'Equity');

        $fn = sort_by_array($accs, $sorter);

        return $fn;
    }

    /**
     * Fetch Chart of Accounts For  Balance Sheet
     * 
     * @return array
     */
    function get_balance_sheet()
    {
        $this->select_all_key('accounts');
        $this->db->where($this->dx('code') . '> 599', NULL, FALSE)
                ->order_by($this->dx('code'), 'ASC', FALSE);
        $result = $this->db->get('accounts')->result();

        $accs = array();
        
        $cats = $this->populate('account_types', 'id', 'name');
        foreach ($result as $r)
        {
            if (TRUE)//$r->account_type && $r->balance)
            {
                $code = $this->worker->get_account_group($r->code);
                $ttl = isset($cats[$r->account_type]) ? $cats[$r->account_type] : 'Others';
                $accs[$code][$ttl][] = array('account' => $r->name, 'code' => $r->code, 'balance' => $r->balance);
            }
        }
        $sorter = array('Assets', 'Liabilities', 'Equity');
        $fn = sort_by_array($accs, $sorter);

        return $fn;
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  accounts (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	code  varchar(256)  DEFAULT '' NOT NULL, 
	account_type  INT(9) NOT NULL, 
	tax  INT(9) NOT NULL, 
	balance  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('accounts', $limit, $offset);

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

}
