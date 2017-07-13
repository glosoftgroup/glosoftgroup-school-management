<?php

    class Class_attendance_m extends MY_Model
    {

         function __construct()
         {
              // Call the Model constructor
              parent::__construct();
         }

         function create($data)
         {
              $this->db->insert('class_attendance', $data);
              return $this->db->insert_id();
         }

         function create_list($data)
         {
              $this->db->insert('class_attendance_list', $data);
              return $this->db->insert_id();
         }

         //Get students
         public function get_students($id)
         {
              $this->select_all_key('admission');
              $results = $this->db->where($this->dx('class') . '=' . $id, NULL, FALSE)->where($this->dx('status') . '=1', NULL, FALSE)->get('admission')->result();
              $arr = array();
              foreach ($results as $r)
              {
                   $arr[$r->id] = $r->first_name . ' ' . $r->last_name;
              }
              return $arr;
         }

         function find($id)
         {
              return $this->db->where(array('id' => $id))->get('class_attendance')->row();
         }

         function get_by_class($id)
         {
              return $this->db->where(array('class_id' => $id))->get('class_attendance')->row();
         }

         function get_row($id)
         {
              return $this->db->where(array('id' => $id))->get('class_attendance')->row();
         }

         function get($id)
         {
              return $this->db->where(array('class_id' => $id))->order_by('created_on', 'DESC')->get('class_attendance')->result();
         }

         function get_register($id)
         {
              return $this->db->where(array('attendance_id' => $id))->get('class_attendance_list')->result();
         }

         function count_present($id)
         {
              return $this->db->where(array('attendance_id' => $id, 'status' => 'Present'))->get('class_attendance_list')->num_rows();
         }

         function count_absent($id)
         {
              return $this->db->where(array('attendance_id' => $id, 'status' => 'Absent'))->get('class_attendance_list')->num_rows();
         }

         function exists($id)
         {
              return $this->db->where(array('id' => $id))->count_all_results('class_attendance') > 0;
         }

         function count()
         {
              return $this->db->count_all_results('class_attendance');
         }

         function update_attributes($id, $data)
         {
              return $this->db->where('id', $id)->update('class_attendance', $data);
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
              return $this->db->delete('class_attendance', array('id' => $id));
         }

         function delete_list($id)
         {
              return $this->db->delete('class_attendance_list', array('attendance_id' => $id));
         }

         //Count records to be deleted
         function count_del($id)
         {
              return $this->db->where('attendance_id', $id)->count_all_results('class_attendance_list');
         }

         function get_class_stream()
         {
              return $this->db->select('classes.*')->order_by('class', 'DESC')->get('classes')->result();
         }

         function paginate_all($limit, $page)
         {
              $offset = $limit * ( $page - 1);
              $this->db->order_by('id', 'desc');
              $query = $this->db->get('class_attendance', $limit, $offset);
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

         //Teacher's Class
         function my_class($limit, $page)
         {
              $offset = $limit * ( $page - 1);
              $u = $this->ion_auth->get_user()->id;
              $cls = $this->db->where('class_teacher', $u)->get('classes')->row();
              $the_class = 0;
              if (!empty($cls->id))
              {
                   $the_class = $cls->id;
              }
              $this->db->where('id', $the_class);
              $this->db->order_by('class', 'desc');
              $query = $this->db->get('class_attendance', $limit, $offset);
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
    