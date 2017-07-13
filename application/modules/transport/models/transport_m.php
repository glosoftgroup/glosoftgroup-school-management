<?php

class Transport_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('transport', $data);
                return $this->db->insert_id();
        }

        function create_route($data)
        {
                $this->db->insert('transport_routes', $data);
                return $this->db->insert_id();
        }

        function get_routes()
        {
                return $this->db->get('transport_routes')->result();
        }

        function has_route($route, $student, $term, $year)
        {
                $row = $this->db
                             ->where('route', $route)
                             ->where('student', $student)
                             ->where('term', $term)
                             ->where('year', $year)
                             ->get('transport')
                             ->row();
                if (empty($row))
                {
                        return FALSE;
                }
                else
                {
                        return $row->id;
                }
        }

        function get_route_students($route)
        {
                return $this->db
                                          ->where('route', $route)
                                          ->get('transport')
                                          ->result();
        }

        function set_route_update($rt_id, $data)
        {
                return $this->db->where('id', $rt_id)->update('transport', $data);
        }

        function find_route($id)
        {
                return $this->db->where(array('id' => $id))->get('transport_routes')->row();
        }

        function route_exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('transport_routes') > 0;
        }

        function update_route($id, $data)
        {
                return $this->db->where('id', $id)->update('transport_routes', $data);
        }

        function delete($id, $table)
        {
                return $this->db->delete($table, array('id' => $id));
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('transport')->row();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('transport') > 0;
        }

        function count()
        {
                return $this->db->count_all_results('transport');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('transport', $data);
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

}
