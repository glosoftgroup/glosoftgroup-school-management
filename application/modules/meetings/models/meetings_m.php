<?php
class Meetings_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('meetings', $data);
        return $this->db->insert_id();
    }
	//Get all Items and populate in the calendar
	   function get_all()
    {

        return $this->db->select('meetings.*')
                        ->order_by('created_on', 'DESC')
                        ->get('meetings')
                        ->result();
    }

 
   function find($id)
    {
        return $this->db->where(array('id' => $id))->get('meetings')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('meetings') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('meetings');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('meetings', $data);
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();

    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('meetings', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('meetings', $limit, $offset);

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