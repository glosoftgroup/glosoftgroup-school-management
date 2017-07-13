<?php
class Uploads_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('uploads', $data);
        return $this->db->insert_id();
    }


	function delete_parent($id)
        {
                $query = $this->db->delete('parents', array('id' => $id));
				
                return $query;
        }
   function delete_user($id)
        {
                $query = $this->db->delete('users', array('id' => $id));
				
                return $query;
        }
		
		function delete_users_group($user_id)
        {
				if(!empty($user_id) && isset($user_id)){
				$this->db->where($this->dx('user_id').'='.$user_id,NULL,FALSE);
                $query =  $this->db->delete('users_groups');
                return $query;
				}
				else{
					  return 0;
				}
        }
		
		
		
	 function get_all_students()
         {
           
              $this->select_all_key('admission');
              $this->db->order_by('id', 'desc');
              //$this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
              $query = $this->db->get('admission')->result();
			  
			  return $query;

             
         }
		 
		 function get_all_parents()
         {
           
              $this->select_all_key('parents');
              $query = $this->db->get('parents')->result();
			  
			  return $query;

             
         }
		 
	//Assign
	function assign_parent($data)
    {
        $this->db->insert('assign_parent', $data);
        return $this->db->insert_id();
    }
	function create_logins($data)
    {
        $this->db->insert('parents_logins', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('uploads')->row();
     }
	 
	 function find_parent($id)
        {
			 $this->select_all_key('parents');
                return $this->db->where(array('id' => $id))->get('parents')->row();
        }
	 
	 function get_plogins(){
		 return $this->db->get('parents_logins')->result();
	 }
	 
	 function parent_id($id)
        {
                $this->select_all_key('admission');
                return $this->db->where($this->dx('parent_id').'='.$id,NULL,FALSE)->get('admission')->row();
        }
		
	   function all_parents()
        {
               
                $this->select_all_key('parents');
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('parents');

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


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('uploads') >0;
    }
	
	function exists_paro($email)
        {
                $this->select_all_key('users');
                return $this->db->where($this->dx('email').'='.$email,NULL,FALSE)->count_all_results('users') >0;
        }


    function count()
    {
        
        return $this->db->count_all_results('uploads');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('uploads', $data);
    }

	function update_pst($id, $data)
    {
         return  $this->db->where('student_id', $id) ->update('assign_parent', $data);
    }

	function update_logins($id, $data)
    {
         return  $this->db->where('parent_id', $id) ->update('parents_logins', $data);
    }
	
	//-------------------------------
	
	function update_status($id, $data)
    {
		 return $this->update_key_data($id, 'admission', $data);
        
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
        return $this->db->delete('uploads', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  uploads (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
	  
	   function get_all()
        {
                //$offset = $limit * ( $page - 1);
                $this->select_all_key('admission');
                $this->db->order_by('id', 'desc');
                //$this->db->where($this->dx('status') . ' = 3', NULL, FALSE);
                $query = $this->db->get('admission');

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
      
    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('uploads', $limit, $offset);

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