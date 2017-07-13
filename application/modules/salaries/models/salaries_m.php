<?php

    class Salaries_m extends MY_Model
    {

         function __construct()
         {
              // Call the Model constructor
              parent::__construct();
         }

         function create($data)
         {
              $this->db->insert('salaries', $data);
              return $this->db->insert_id();
         }

         //Insert Deductions
         function insert_deducs($data)
         {
              $this->db->insert('employee_deductions', $data);
              return $this->db->insert_id();
         }

         function get_emp_deductions($id)
         {
              return $this->db->where('salary_id', $id)->get('employee_deductions')->result();
         }

         function get_emp_allowances($id)
         {
              return $this->db->where('salary_id', $id)->get('employee_allowances')->result();
         }

         //Insert Deductions
         function insert_allws($data)
         {
              $this->db->insert('employee_allowances', $data);
              return $this->db->insert_id();
         }

         //List Deductions
         function list_deductions()
         {
              $results = $this->db->get('deductions')->result();
              $arr = array();
              foreach ($results as $r)
              {
                   $arr[$r->id] = $r->name . ' - ' . number_format($r->amount, 2);
              }
              return $arr;
         }

         //List Deductions
         function get_paye()
         {
              $results = $this->db->get('paye')->result();
              $arr = array();
              foreach ($results as $r)
              {
                   if (is_numeric($r->range_from) && is_numeric($r->range_to))
                   {
                        $arr[$r->id] = number_format($r->range_from, 2) . ' --- ' . number_format($r->range_to, 2) . ' ( ' . $r->tax . '% )';
                   }
                   else
                   {
                        $arr[$r->id] = $r->range_from . ' --- ' . $r->range_to . ' ( ' . $r->tax . '% )';
                   }
              }
              return $arr;
         }

         //List Allowances
         function list_allowances()
         {
              $results = $this->db->get('allowances')->result();
              $arr = array();
              foreach ($results as $r)
              {
                   $arr[$r->id] = $r->name . ' - ' . number_format($r->amount, 2);
              }
              return $arr;
         }

         function find($id)
         {
              return $this->db->where(array('id' => $id))->get('salaries')->row();
         }

         function get_all()
         {
              return $this->db->order_by('created_on', 'DESC')->get('salaries')->result();
         }

         //Get Employee deductions
         function get_deductions($id)
         {
              return $this->db->where(array('salary_id' => $id))->get('employee_deductions')->result();
         }

         //Get Employee allowances
         function get_allowance($id)
         {
              return $this->db->where(array('salary_id' => $id))->get('employee_allowances')->result();
         }

         function exists($id)
         {
              return $this->db->where(array('id' => $id))->count_all_results('salaries') > 0;
         }

         function exists_employee($id)
         {
              return $this->db->where(array('employee' => $id))->count_all_results('salaries') > 0;
         }

         function count()
         {
              return $this->db->count_all_results('salaries');
         }

         function update_attributes($id, $data)
         {
              return $this->db->where('id', $id)->update('salaries', $data);
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

         function delete($id)
         {
              return $this->db->delete('salaries', array('id' => $id));
         }

         function delete_deductions($id)
         {
              return $this->db->delete('employee_deductions', array('salary_id' => $id));
         }

         function delete_allowances($id)
         {
              return $this->db->delete('employee_allowances', array('salary_id' => $id));
         }

         function paginate_all($limit, $page)
         {
              $offset = $limit * ( $page - 1);
              $this->db->order_by('id', 'desc');
              $query = $this->db->get('salaries', $limit, $offset);
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
    