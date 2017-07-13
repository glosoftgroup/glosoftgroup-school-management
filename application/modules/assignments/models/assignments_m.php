<?php
class Assignments_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('assignments', $data);
        return $this->db->insert_id();
    }
	
	
    function insert_classes($data)
    {
        $this->db->insert('assignment_list', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('assignments')->row();
     } 
	 
	 function get_my()
    {
        $u=$this->ion_auth->get_user()->id;
        $this->db->where('created_by', $u);
		return $this->db->get('assignments')->result();
     }
  function get_classes($id)
    {
        return $this->db->where(array('assgn_id' => $id))->get('assignment_list')->result();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('assignments') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('assignments');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('assignments', $data);
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();
    $options=array();
    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('assignments', array('id' => $id));
    }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
			$u=$this->ion_auth->get_user()->id;
            
           
            $this->db->where('created_by', $u);
			 $this->db->order_by('id', 'desc');
            $query = $this->db->get('assignments', $limit, $offset);

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