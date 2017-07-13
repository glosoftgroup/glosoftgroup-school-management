<?php

class Sms_m extends MY_Model
{

        /**
         * Model Constructor
         */
        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function my_sms()
        {
                $this->db->order_by('id', 'desc');

                $all = $this->db->where('recipient', 'All Parents')->get('sms')->result();
                $user = $this->ion_auth->get_user();
                $one = $this->db->where('recipient', $user->id)->where('type', 2)->get('sms')->result();

                if (empty($one))
                {
                        return $all;
                }
                else
                {
                        $res = array_merge($all, $one);
                        return $res;
                }
        }

        function my_sms_new()
        {
                $this->select_all_key('parents');
                $usr = $this->ion_auth->get_user();
                $parent = $this->db->where('user_id', $usr->id)->get('parents')->row();
                $country_code = '254';
                $recipient = $parent->phone;

                $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));
                $this->select_all_key('text_log');
                $this->db->order_by('id', 'desc');
                $all = $this->db->where('dest', $new_number)->get('text_log')->result();

                return $all;
        }

        /**
         * Log Status
         * 
         * @param type $data
         * @return type
         */
        function create($data)
        {
                $query = $this->db->insert('sms', $data);
                return $query;
        }

        /**
         * Send SMS
         * 
         * @param string $phone
         * @param string $message
         * @return boolean
         */
        function send_sms($phone, $message)
        {
                $this->load->library('Req');
                $this->load->library('Fone');

                if (empty($this->config->item('sms_pass')) || empty($this->config->item('sms_id')))
                {
                        $this->session->set_flashdata('error', array('type' => 'error', 'text' => 'SMS Module is not configured'));
                        redirect('admin/sms/create');
                }

                $userid = $this->config->item('sms_id');
                $token = md5($this->config->item('sms_pass'));
                $from = empty($this->config->item('sender')) ? 'KEYPAD' : $this->config->item('sender');

                if (empty($phone))
                {
                        return FALSE;
                }

                $coma = ',';
                $pos = strpos($phone, $coma);

                if ($pos >= 0)
                {
                        $data = explode(',', $phone);
                        $phone = $data[0];
                }

                $util = \libphonenumber\PhoneNumberUtil::getInstance();
                $no = $util->parse($phone, 'KE', null, true);
                $req = FALSE;

                $is_valid = $util->isValidNumber($no);
                if ($is_valid == 1)
                {
                        $code = $no->getcountryCode();
                        $nat = $no->getNationalNumber();
                        $phone = $code . $nat;

                        $url = 'http://197.248.4.47/smsapi/submit.php';
                        $stamp = date('YmdHis');
                        $json = '{
                                "AuthDetails": [{
                                        "UserID": "' . $userid . '",
                                        "Token": "' . $token . '",
                                        "Timestamp": "' . $stamp . '"
                                }],
                                "MessageType": ["2"],
                                "BatchType": ["0"],
                                "SourceAddr": ["' . $from . '"],
                                "MessagePayload": [
                                {
                                          "Text":"' . $message . '"  
                                }],
                                "DestinationAddr": [
                                {
                                        "MSISDN": "' . $phone . '",
                                        "LinkID": ""
                                }]
                           }';

                        if (!$sock = @fsockopen('www.example.com', 80))
                        {
                                return FALSE;
                        }

                        $parts = array(
                            'source' => $from,
                            'dest' => $phone,
                            'relay' => $message,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );
                        $this->log_text($parts);
                        $headers = array('Content-Type' => 'application/json');
                        $req = $this->req->post($url, $headers, $json);
                }

                return $req;
        }

        /**
         * Log Text to DB
         * 
         * @param array $data
         * @return int
         */
        function log_text($data)
        {
                return $this->insert_key_data('text_log', $data);
        }

        function count_down()
        {
                $this->select_all_key(lang('script'));
                $row = $this->db->where('id', 1)->get(lang('script'))->row();
                if (!empty($row))
                {
                        $rem = $row->total_count - 1;
                        $bk = array(
                            'total_count' => $rem,
                            'modified_by' => $this->ion_auth->get_user()->id,
                            'modified_on' => time()
                        );
                        $this->update_key_data(1, lang('script'), $bk);
                }
                return TRUE;
        }

        //Get all parents
        function active_parent()
        {
                $this->select_all_key('parents');
                return $results = $this->db->where($this->dx('status') . '=1', NULL, FALSE)
                             ->order_by('id', 'ASC')
                             ->get('parents')
                             ->result();
        }

        function get_active_parents()
        {
                $this->select_all_key('parents');
                $results = $this->db
                             ->where($this->dx('status') . '=1', NULL, FALSE)
                             ->get('parents')
                             ->result();
                $arr = array();

                foreach ($results as $res)
                {
                        $arr[$res->id] = $res->first_name . ' ' . $res->last_name . ' (' . $res->phone . ')';
                }

                return $arr;
        }

        /**
         * Get All Active Staff
         * 
         * @return mixed
         */
        public function get_all_staff()
        {
                $this->select_all_key('users');
                return $this->db->select($this->dx('users_groups.group_id') . ' as gid', FALSE)->where($this->dx('users.active') . '= 1', NULL, FALSE)
                                          ->where($this->dx('users_groups.group_id') . '!= 8', NULL, FALSE)//student
                                          ->where($this->dx('users_groups.group_id') . '!= 6', NULL, FALSE)//parent
                                          ->where($this->dx('users_groups.group_id') . '!= 2', NULL, FALSE)//member
                                          ->join('users_groups', 'users.id=' . $this->dx('user_id'))
                                          ->get('users')
                                          ->result();

                foreach ($results as $res)
                {
                        $arr[] = $res->first_name . ' ' . $res->last_name . ' (' . $res->phone . ')';
                }

                return $arr;
        }

        /**
         * Return All Active Users along with Phone No.
         * 
         * @return string
         */
        function get_users_phone()
        {
                $this->select_all_key('users');
                $results = $this->db->where($this->dx('active') . '= 1', NULL, FALSE)
                             ->get('users')
                             ->result();
                $arr = array();

                foreach ($results as $res)
                {
                        if (!empty($res->phone))
                        {
                                $arr[$res->id] = $res->first_name . ' ' . $res->last_name . ' (' . $res->phone . ')';
                        }
                }

                return $arr;
        }

        // Get applicant Email address	
        function get_applicant()
        {
                $data = $this->db->select('applications.*')
                             ->get('applications')
                             ->result();
                $arr = array();

                foreach ($data as $dat)
                {
                        $arr[$dat->id] = $dat->first_name . ' ' . $dat->last_name . ' (' . $dat->email . ' )';
                }
                return $arr;
        }

        function get_inbox()
        {
                return $this->db->count_all_results('sms');
        }

        function get_sent()
        {
                return $this->db->where('status', 'sent')->count_all_results('sms');
        }

        function get_draft()
        {
                return $this->db->where('status', 'draft')->count_all_results('sms');
        }

        function get_trash()
        {
                return $this->db->where('status', 'trash')->count_all_results('sms');
        }

        function get_job()
        {
                $data = $this->db->select('jobs.*')
                             ->get('jobs')
                             ->result();
                $arr = array();

                foreach ($data as $dat)
                {
                        $arr[$dat->id] = $dat->job_title . ' ( Ref No.: ' . $dat->reference_no . ' )';
                }
                return $arr;
        }

        function get_applicant_details($applicant_id, $job_id)
        {
                $query = $this->db->select('applications.*')
                             ->where('applications.id', $applicant_id)
                             ->where('applications.job_id', $job_id)
                             ->get('applications')
                             ->row();
                return $query;
        }

        function find($id)
        {
                $query = $this->db->get_where('sms', array('id' => $id));
                return $query->row();
        }

        function exists($id)
        {
                $query = $this->db->get_where('sms', array('id' => $id));
                $result = $query->result();

                if ($result)
                        return TRUE;
                else
                        return FALSE;
        }

        function count()
        {
                return $this->db->count_all_results('sms');
        }

        function count_log()
        {
                return $this->db->count_all_results('text_log');
        }

        function update_attributes($id, $data)
        {
                $this->db->where('id', $id);
                $query = $this->db->update('sms', $data);

                return $query;
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
                $query = $this->db->delete('sms', array('id' => $id));

                return $query;
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('sms', $limit, $offset);

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

        function paginate_log($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                $this->select_all_key('text_log');
                $this->db->order_by('id', 'desc');

                $query = $this->db->get('text_log', $limit, $offset);

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
