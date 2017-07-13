<?php

class Portal_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function get_groups($id)
        {
                return $this->db->select($this->dx('users_groups.group_id') . ' as id, groups.name, groups.description', FALSE)
                                          ->where($this->dx('users_groups.user_id') . ' =' . $id, NULL, FALSE)
                                          ->join('groups', $this->dx('users_groups.group_id') . ' = groups.id')
                                          ->get('users_groups')
                                          ->result();
        }

        function check_invoiced($term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->count_all_results('invoices') > 0;
        }

        function get_my_class($id)
        {
                return $this->db->where(array('id' => $id))->get('classes')->row();
        }

        /**
         * Determine if Student is Invoiced for current term
         * 
         * @param type $student
         * @param type $term
         * @return type
         */
        function is_invoiced($student, $term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->where('student_id', $student)->count_all_results('invoices') > 0;
        }

        /**
         * Best way to determine if term is in the future or past
         * 
         * @param int $term
         * @return boolean
         */
        function has_invoices($term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->count_all_results('invoices') > 0;
        }

        /**
         * Get Student Invoices for current Term
         * 
         * @param type $student
         * @param type $term
         * @return type
         */
        function get_my_invoices($student, $term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->where('student_id', $student)->get('invoices')->result();
        }

        function get_row($term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->get('invoices')->row();
        }

        function find($id)
        {
                $this->select_all_key('admission');
                return $this->db->where(array('id' => $id))->get('admission')->row();
        }

        /**
         * Fetch All Active Students in the school
         * as per admissions Table
         * 
         * @param type $sus
         * @return type
         */
        function get_all_students($sus = TRUE)
        {
                $this->db->select('id');
                if ($sus)
                {
                        $this->db->where($this->dx('status') . '=1', NULL, FALSE);
                }
                $list = $this->db->get('admission')->result();
                $students = array();
                foreach ($list as $l)
                {
                        $students[] = $l->id;
                }
                return $students;
        }

        function history_exists($student, $class, $stream)
        {
                return $this->db->where($this->dx('student') . " = '" . $student . "'", NULL, FALSE)
                                          ->where($this->dx('class') . " = '" . $class . "'", NULL, FALSE)
                                          ->where($this->dx('stream') . " = '" . $stream . "'", NULL, FALSE)
                                          ->where($this->dx('year') . " = '" . date('Y') . "'", NULL, FALSE)
                                          ->count_all_results('history') > 0;
        }

        function history_current($student)
        {
                $row = $this->db->where($this->dx('student') . " = '" . $student . "'", NULL, FALSE)
                             ->where($this->dx('year') . " = '" . date('Y') . "'", NULL, FALSE)
                             ->get('history')
                             ->row();
                return empty($row) ? FALSE : $row;
        }

        function key_exists($key)
        {
                $this->select_all_key(lang('active'));
                return $this->db->where($this->dx('license') . " = '" . $key . "'", NULL, FALSE)
                                          ->count_all_results(lang('active')) > 0;
        }

        function count_ivs()
        {
                return $this->db->count_all_results('invoices');
        }

        function get_max_invoice()
        {
                $size = $this->count_ivs();
                $max = 0;
                if ($size)
                {
                        $res = $this->db->select('max(id) as max', FALSE)->get('invoices')->row();
                        $max = $res->max;
                }

                return $max;
        }

        /**
         * Insert History For Students already In Admission Table
         * 
         * @return string
         */
        function make_history()
        {
                //get all students , zero flag to include suspended
                $pop = $this->get_all_students(0);

                $i = 0;
                foreach ($pop as $kid)
                {
                        $row = $this->find($kid);
                        $cls = $this->fetch_class($row->class);
                        //Check if history for this kid is made
                        $made = $this->history_exists($row->id, $cls->class, $cls->stream);

                        if (!$made)
                        {
                                $hiss = array(
                                    'student' => $row->id,
                                    'class' => $cls->class,
                                    'stream' => $cls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->insert_key_data('history', $hiss);
                                $i++;
                        }
                }
                return 'Found ' . count($pop) . ' Student(s). Made History for ' . $i . ' Students';
        }

        /**
         * Sync History Changes Within the Current Year
         * 
         * @return string
         */
        function sync_history()
        {
                //get all students , zero flag to include suspended
                $pop = $this->get_all_students(0);

                $i = 0;
                $s = 0;
                $f = 0;
                $fids = [];
                foreach ($pop as $kid)
                {
                        $row = $this->find($kid);
                        $cls = $this->fetch_class($row->class);
                        if (empty($cls))
                        {
                                $f++;
                                $fids[] = $kid;
                        }
                        //Check if history for this kid is made for current year
                        $has = $this->history_current($row->id);
                        if ($has && isset($cls->class))
                        {
                                $upd = array(
                                    'class' => $cls->class,
                                    'stream' => $cls->stream,
                                    'modified_on' => time(),
                                    'modified_by' => $this->ion_auth->get_user()->id
                                );

                                $this->update_key_data($has->id, 'history', $upd);
                                $s++;
                        }
                        else
                        {
                                $hiss = array(
                                    'student' => $row->id,
                                    'class' => $cls->class,
                                    'stream' => $cls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->insert_key_data('history', $hiss);
                                $i++;
                        }
                }
                $nf = '';
                if (count($fids))
                {
                        $nf = print_r($fids, TRUE) . ' no class(' . $f . ')!';
                }
                return 'Found ' . count($pop) . ' Student(s). Made History for ' . $i . ' Students, Sync ' . $s . ' Existing ' . $nf;
        }

        function save_key($data)
        {
                if (!$this->key_exists($data['license']))
                {
                        $this->update_key_all(lang('active'), array('status' => 0));
                        $this->insert_key_data(lang('active'), $data);
                }
        }

        function get_active_key()
        {
                $this->select_all_key(lang('active'));
                return $this->db->where($this->dx('status') . '=1', NULL, FALSE)
                                          ->get(lang('active'))
                                          ->row();
        }

        function fetch_keys()
        {
                $this->select_all_key(lang('active'));
                return $this->db->get(lang('active'))
                                          ->result();
        }

        /**
         * Insert Class Details to History Table
         * e.g. upon Promotion to new Class
         * 
         * @param int $student
         * @return boolean
         */
        function insert_history($student)
        {
                $row = $this->find($student);

                //Check if history for this kid is made
                $made = $this->history_exists($row->id, $row->class, $row->stream);

                if (!$made)
                {
                        //insert history
                        $hiss = array(
                            'student' => $row->id,
                            'class' => $row->class,
                            'stream' => $row->stream,
                            'year' => date('Y'),
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );
                        $this->insert_key_data('history', $hiss);
                        return TRUE;
                }
                else
                {
                        return FALSE;
                }
        }

        /**
         * Fetch Class by class_id & Stream 
         * 
         * @param type $class
         * @param type $stream
         * @return type
         */
        function get_class_stream($class, $stream)
        {
                return $this->db->where(array('class' => $class, 'stream' => $stream))->get('classes')->row();
        }

        function get_fee_structure($class, $term)
        {
                $res = $this->db->select('id, amount')
                             ->where('class_id', $class)
                             ->where('term', $term)
                             ->get('fee_class')
                             ->row();

                if (!empty($res))
                {
                        return $res;
                }
                else
                {
                        return FALSE;
                }
        }

        /**
         * Fetch Current Students in Specified Class  (All Streams)
         * 
         * @param type $class
         * @return type
         */
        function fetch_students($class, $sus = FALSE)
        {
                if (!$class)
                {
                        return array();
                }
                $cid = $this->db->where('class', $class)->get('classes')->result();

                $clist = array();
                foreach ($cid as $c)
                {
                        $clist[] = $c->id;
                }

                if (!count($clist))
                {
                        return array();
                }

                $this->db->select('id');
                $wh = ' ( ';
                $i = 0;
                foreach ($clist as $cc)
                {
                        $i++;
                        $wh .= $this->dx('class') . '=' . $cc;
                        if ($i != count($clist))
                        {
                                $wh .= ' OR ';
                        }
                }
                $this->db->where($wh . ' ) ', NULL, FALSE);

                if ($sus)
                {
                        $this->db->where($this->dx('admission.status') . ' != 1', NULL, FALSE);
                }
                else
                {
                        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                }

                $list = $this->db->get('admission')->result();

                $students = array();
                foreach ($list as $l)
                {
                        $students[] = $l->id;
                }
                return $students;
        }

        function list_students($id, $sus = FALSE)
        {
                if (!$id)
                {
                        return array();
                }

                $this->db->select('id')->where($this->dx('class') . '=' . $id, NULL, FALSE);

                if ($sus)
                {
                        $this->db->where($this->dx('admission.status') . ' != 1', NULL, FALSE);
                }
                else
                {
                        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                }

                $list = $this->db->get('admission')->result();

                $students = array();
                foreach ($list as $l)
                {
                        $students[] = $l->id;
                }
                return $students;
        }

        /**
         * Count Current Students in Specified Class  
         * 
         * @param int $class
         * @return type
         */
        function count_students($class)
        {
                return $this->db->where($this->dx('class') . '=' . $class, NULL, FALSE)
                                          ->where($this->dx('status') . ' = 1', NULL, FALSE)->count_all_results('admission');
        }

        function fetch_class($id)
        {
                return $this->db->where(array('id' => $id))->get('classes')->row();
        }

        /**
         * Fetch Classes
         * 
         * @return array
         */
        function get_all_classes()
        {
                $scl = $this->get_class_options();
                $strms = $this->populate('class_stream', 'id', 'name');
                $list = $this->db->select('id, class, stream')
                             ->where('status', 1)
                             ->order_by('class')
                             ->get('classes')
                             ->result();
                $cls = array();
                foreach ($list as $l)
                {
                        $size = $this->count_students($l->id);

                        $name = isset($scl[$l->class]) ? $scl[$l->class] : ' -';
                        $strr = isset($strms[$l->stream]) ? $strms[$l->stream] : ' ';
                        $cls[$l->id] = array('name' => $name . ' ' . $strr, 'size' => $size);
                }
                return $cls;
        }

        function get_all_streams()
        {
                $ops = array();
                $list = $this->get_all_classes();
                foreach ($list as $key => $obj)
                {
                        $obj = (object) $obj;
                        $ops[$key] = $obj->name;
                }
                return $ops;
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

        /**
         * Fetch Class Options
         * 
         * @return type
         */
        function get_class_options()
        {
                $list = $this->db->select('id, name')
                             ->where('status', 1)
                             ->order_by('id')
                             ->get('class_groups')
                             ->result();
                $cls = array();
                foreach ($list as $l)
                {
                        $cls[$l->id] = $l->name;
                }
                return $cls;
        }

        function invoice_me($data)
        {
                $this->db->insert('invoices', $data);
                return $this->db->insert_id();
        }

        function get_classes()
        {
                $list = $this->db->select('id')->get('class_groups')->result();
                $classes = array();
                foreach ($list as $l)
                {
                        $classes[] = $l->id;
                }
                return $classes;
        }

        function get_class_ids()
        {
                $list = $this->db->select('id')->get('classes')->result();
                $classes = array();
                foreach ($list as $l)
                {
                        $classes[] = $l->id;
                }
                return $classes;
        }

        /**
         * Generate Dummy Data
         * 
         * @param type $id
         * @param type $data
         * @param type $where
         * @return type
         */
        function mashup($id, $data, $where)
        {
                $this->db->where('id', $id);
                $query = $this->db->update($where, $data);
                return $query;
        }

        function update_check($id, $data)
        {
                return $this->db->where('id', $id)->update('invoices', $data);
        }

        /**
         * Update_receivables
         * 
         * @param float $bal Update Array
         */
        function add_receivables($bal)
        {
                $acc = 610;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . '  =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid)
                {
                        $id = $acid->id;
                        $rcv = array('balance' => ($bal + $acid->balance), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                }
                else
                {
                        return FALSE;
                }
        }

        /**
         * Update_receivables -Decrement
         * 
         * @param float $bal Update Array
         */
        function dec_receivables($bal)
        {
                $acc = 610;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . '  =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid)
                {
                        $id = $acid->id;
                        $rcv = array('balance' => ($acid->balance - $bal ), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                }
                else
                {
                        return FALSE;
                }
        }

        /**
         * Update Sales Account (Fees)
         * @param type $bal
         * @return boolean
         */
        function add_sales($bal)
        {
                $acc = 200;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . '  =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid)
                {
                        $id = $acid->id;
                        $rcv = array('balance' => ($bal + $acid->balance), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                }
                else
                {
                        return FALSE;
                }
        }

        /**
         * Update Sales Account (Fees) decrement
         * @param type $bal
         * @return boolean
         */
        function dec_sales($bal)
        {
                $acc = 200;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . ' =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid)
                {
                        $id = $acid->id;
                        $rcv = array('balance' => ($acid->balance - $bal ), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                }
                else
                {
                        return FALSE;
                }
        }

        /**
         * Update Sales Account (Fees) decrement
         * @param type $bal
         * @return boolean
         */
        function update_waiver($bal)
        {
                $acc = 450;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . '  =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid)
                {
                        $id = $acid->id;
                        $rcv = array('balance' => ($acid->balance + $bal ), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                }
                else
                {
                        return FALSE;
                }
        }

        /**
         * Fetch all students Sponsored by This Parent
         * 
         * @param int $parent The Parent id
         * @return object
         */
        function get_kids($parent)
        {
                /* $res = $this->db->select('id,' . $this->dxa('admission_number') . ', ' . $this->dxa('old_adm_no') . ', ' . $this->dxa('user_id') . ', ' . $this->dxa('class') . ', ' . $this->dxa('email'), FALSE)
                  ->where($this->dx('parent_user') . ' = ' . $parent, NULL, FALSE)
                  ->get('admission')
                  ->result(); */

                $pid = $this->db->where($this->dx('user_id') . '=' . $parent, NULL, FALSE)->get('parents')->row();

                $res = $this->db->where('parent_id', $pid->id)->get('assign_parent')->result();

                foreach ($res as $r)
                {
                        $row = $this->worker->fetch_balance($r->student_id);
                        $r->balance = $row ? $row->balance : 0;
                        $r->invoice_amt = $row ? $row->invoice_amt : 0;
                        $r->paid = $row ? $row->paid : 0;
                }

                return $res;
        }

        /**
         * Fetch Parent Profile From Parents Table
         * 
         * @param int $parent
         * @return object
         */
        function get_profile($parent)
        {
                $this->select_all_key('parents');
                return $this->db
                                          ->where($this->dx('user_id') . ' = ' . $parent, NULL, FALSE)
                                          ->get('parents')
                                          ->row();
        }

        /**
         * Fetch Parent Profile From Parents Table
         * 
         * @param int $parent
         * @return object
         */
        function get_parent($parent)
        {
                $this->select_all_key('parents');
                return $this->db
                                          ->where('id', $parent)
                                          ->get('parents')
                                          ->row();
        }

        /**
         * Monthly Admissions Graph
         * 
         * @return object
         */
        function get_monthly_admissions()
        {
                return $this->db->select('MONTH(FROM_UNIXTIME(' . $this->dx('admission_date') . ' )) as mt, count(*) as total', FALSE)
                                          ->where('YEAR(FROM_UNIXTIME(' . $this->dx('admission_date') . ')) =' . date('Y'), NULL, FALSE)
                                          ->group_by('mt')
                                          ->order_by('mt', 'ASC', FALSE)
                                          ->get('admission')
                                          ->result();
        }

        /**
         * Fetch Admission Row
         * 
         * @param int $id
         * @return object
         */
        function get_student($id)
        {
                $this->select_all_key('admission');
                return $this->db->where($this->dx('user_id') . '=' . $id, NULL, FALSE)->get('admission')->row();
        }

        /**
         * Log Invoice Cron Run
         * 
         * @param type $data
         * @return type
         */
        function log_exec($data)
        {
                return $this->insert_key_data('crontab', $data);
        }

        function log_statement($data)
        {
                return $this->insert_key_data('statement', $data);
        }

        /**
         * Fetch SMS Status
         * @return boolean
         */
        function get_text_status()
        {
                $row = $this->db->select($this->dxa('can_text'), FALSE)
                             ->where('id', 1)
                             ->get('config')
                             ->row();
                if ($row)
                {
                        return $row->can_text == 1;
                }
                else
                {
                        return FALSE;
                }
        }

        /** check if config row exists
         * 
         * @return type
         */
        function check_config()
        {
                return $this->db->count_all_results('config') > 0;
        }

        function has_exec()
        {
                return $this->db->where($this->dx('exec') . '=1', NULL, FALSE)
                                          ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('created_on') . "), '%d %b %Y') ='" . date('d M Y') . "'", NULL, FALSE)
                                          ->count_all_results('crontab') > 0;
        }

        /**
         * Check if Automatic Promotion has been Done
         * 
         * @return type
         */
        function check_movement()
        {
                return $this->db->where($this->dx('moved') . ' = 1', NULL, FALSE)
                                          ->where($this->dx('year') . '=' . date('Y'), NULL, FALSE)
                                          ->count_all_results('movements') > 0;
        }

        /**
         * Fetch Population to move
         * 
         * @return type
         */
        function fetch_moving_targets()
        {
                $list = $this->db->select('id,' . $this->dxa('class'), FALSE)
                             ->where($this->dx('status') . '=1', NULL, FALSE)
                             ->get('admission')
                             ->result();
                $pops = array();
                foreach ($list as $l)
                {
                        $pops[$l->id] = $l->class;
                }
                return $pops;
        }

        /**
         * Insert a new Class
         * 
         * @param array $data
         * @return int
         */
        function make_class($data)
        {
                $this->db->insert('classes', $data);
                return $this->db->insert_id();
        }

        /**
         * Log promotion
         * 
         * @param type $data
         * @return type
         */
        function log_movement($data)
        {
                return $this->insert_key_data('movements', $data);
        }

        function put_config()
        {
                $q1 = 'TRUNCATE `config`';
                $sts = 'INSERT INTO `config` VALUES
	(1, _binary 0x9E0C3309C8FB9A2C9E37ECDA3339171B, _binary 0xD2E2A642D748763BB80322744FE09E4A, NULL, NULL, NULL);';
                $this->db->query($q1);
                return $this->db->query($sts);
        }

        /**
         * Update Student Info
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function upd_student($id, $data)
        {
                return $this->update_key_data($id, 'admission', $data);
        }

        /**
         * Void Current Invoice
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function void_invoice($id, $data)
        {
                return $this->update_key_data($id, 'invoices', $data);
        }

        //Calculate total paid Fees
        function total_stock()
        {
                return $this->db->select('sum(total) as total')
                                          ->get('add_stock')
                                          ->row();
        }

        //Calculate total quatity
        function total_quantity($id)
        {
                $dat = $this->db->select('sum(quantity) as quantity')
                             ->where('add_stock.product_id', $id)
                             ->get('add_stock')
                             ->row();

                //print_r($dat);die;

                return $dat;
        }

        //Calculate total quatity
        function total_given($id)
        {
                $dat = $this->db->select('sum(quantity) as quantity')
                             ->where('item', $id)
                             ->get('give_items')
                             ->row();

                return $dat;
        }

        //Calculate total cost
        function total_cost($id)
        {
                $dat = $this->db->select('sum(total) as totals')
                             ->where('product_id', $id)
                             ->get('add_stock')
                             ->row();

                //print_r($dat);die;

                return $dat;
        }

        //Get product QNTY of the selected product
        function total_closing_stock($id)
        {

                return $this->db->select('sum(closing_stock) as quantity')
                                          ->where('product_id', $id)
                                          ->get('stock_taking')
                                          ->row();
        }

        function student_exams($student)
        {

                return $this->db->where('student', $student)->order_by('created_on', 'ASC')->get('exams_management_list')->result();
        }

}
