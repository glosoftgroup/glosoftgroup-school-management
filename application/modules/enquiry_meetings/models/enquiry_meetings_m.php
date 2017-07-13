<?php
class Enquiry_meetings_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('enquiry_meetings', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('enquiry_meetings')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('enquiry_meetings') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('enquiry_meetings');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('enquiry_meetings', $data);
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
        return $this->db->delete('enquiry_meetings', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  enquiry_meetings (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title  varchar(256)  DEFAULT '' NOT NULL, 
	person_to_meet  varchar(32)  DEFAULT '' NOT NULL, 
	proposed_date  INT(11), 
	time  varchar(256)  DEFAULT '' NOT NULL, 
	reason  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('enquiry_meetings', $limit, $offset);

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

	function meetings($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            $user = $this -> ion_auth -> get_user();
            $this->db->order_by('id', 'desc');
            $this->db->where('created_by', $user -> id);
            $query = $this->db->get('enquiry_meetings', $limit, $offset);

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
	function my_meetings($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            $user = $this -> ion_auth -> get_user();
            $this->db->order_by('id', 'desc');
            $this->db->where('person_to_meet', $user -> id);
            $query = $this->db->get('enquiry_meetings', $limit, $offset);

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