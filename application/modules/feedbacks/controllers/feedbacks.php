<?php defined('BASEPATH') OR exit('No direct script access allowed');

        class Feedbacks extends Public_Controller
        {
			
			
        function __construct()
        {
        parent::__construct();
			$this->template->set_layout('portal');
			$this->template->set_partial('sidebar','partials/sidebar.php');
			$this->template->set_partial('footer','partials/footer.php');
			$this->template->set_partial('header','partials/header.php')
                    -> set_partial('meta', 'partials/meta.php');
			if (!$this->ion_auth->logged_in())
				{
				redirect('login');
				}
			$this->load->model('feedbacks_m');
	   }



        function add($page = NULL)
        {
            //create control variables
            $data['updType'] = 'create';
            $form_data_aux  = array();
            $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
 
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

            //validate the fields of form
            if ($this->form_validation->run() )
         {         
	      //Validation OK!
          $user = $this -> ion_auth -> get_user();
          $form_data = array(
				'title' => $this->input->post('title'), 
				'feedback' => $this->input->post('feedback'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);

            $ok=  $this->feedbacks_m->create($form_data);

            if ( $ok ) 
            {
                $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('feedbacks/add');

	  	}else
                {
		$get = new StdClass();
		foreach ($this -> validation() as $field)
                {   
                         $get->{$field['field']}  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Feedbacks ' )->build('index/create', $data);
		}		
	}

 private function validation()
    {
$config = array(
                 array(
		 'field' =>'title',
                'label' => 'Title',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                array(
		 'field' =>'feedback',
                'label' => 'Feedback',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[500]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/feedbacks/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 10;
            $config['total_rows'] = $this->feedbacks_m->count();
            $config['uri_segment'] = 4 ;

            $config['first_link'] = lang('web_first');
            $config['first_tag_open'] = "<li>";
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = lang('web_last') ;
            $config['last_tag_open'] = "<li>";
            $config['last_tag_close'] = '</li>';
            $config['next_link'] = FALSE;
            $config['next_tag_open'] = "<li>";
            $config['next_tag_close'] = '</li>';
            $config['prev_link'] = FALSE;
            $config['prev_tag_open'] = "<li>";
            $config['prev_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active">  <a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = "<li>";
            $config['num_tag_close'] = '</li>';
            $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
            $config['full_tag_close'] = '</ul></div>';
            $choice = $config["total_rows"] / $config["per_page"];
            //$config["num_links"] = round($choice);

            return $config;
	} 
}