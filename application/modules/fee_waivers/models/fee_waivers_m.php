<?php

class Fee_waivers_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('fee_waivers', $data);
        return $this->db->insert_id();
    }

    //Calculate total  Fee waiver
    function total_waiver()
    {
        $tm = get_term(date('m'));
        return $this->db->select('sum(amount) as total')
                                  ->where('status', 1)
                                  ->where('term', $tm)
                                  ->where('year', date('Y'))
                                  ->get('fee_waivers')
                                  ->row();
    }

    //Parent details
    function get_parent($id)
    {
        $this->select_all_key('parents');

        return $this->db->where('id', $id)->get('parents')->row();
    }

    //Student  Details
    function get_student($id)
    {
        $this->select_all_key('admission');
        return $this->db->where('id', $id)->get('admission')->row();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('fee_waivers')->row();
    }

    //get by student ID
    function get($id)
    {
        $current_date = date('Y', time());
        return $this->db->where(array('student' => $id, 'year' => $current_date))->get('fee_waivers')->row();
    }

//get by student ID
    function get_student_waivers($id)
    {
        $current_date = date('Y', time());
        return $this->db->where(array('student' => $id, 'year' => $current_date))->get('fee_waivers')->result();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('fee_waivers') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('fee_waivers');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('fee_waivers', $data);
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
        return $this->db->delete('fee_waivers', array('id' => $id));
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('fee_waivers', $limit, $offset);

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
