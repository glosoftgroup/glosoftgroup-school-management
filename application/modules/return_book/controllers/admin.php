<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
function __construct()
{
parent::__construct();
			/*$this->template->set_layout('default');
			$this->template->set_partial('sidebar','partials/sidebar.php')
                    -> set_partial('top', 'partials/top.php');*/ 
			if (!$this->ion_auth->logged_in())
	{
	redirect('admin/login');
	}
	
	/* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
        {
             $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
			redirect('admin');
        }*/
	
			$this->load->model('return_book_m');
			$this->load->model('borrow_book/borrow_book_m');
	}


	public function index()
	{
	   $config = $this->set_paginate_options(); 	//Initialize the pagination class
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

 		$data['return_book'] = $this->return_book_m->get_borrowed();

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];
				 $data['books']=$this->borrow_book_m->populate('books','id','title');
				 $data['fine']=$this->borrow_book_m->lib_settings();

            //load view
            $this->template->title(' Return Book ' )->build('admin/index', $data);
	}
	
	public function listing()
	{
	   $config = $this->set_paginate_options(); 	//Initialize the pagination class
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

 		$data['return_book'] = $this->return_book_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Return Book ' )->build('admin/list', $data);
	}

	function create($id,$page = NULL)
	{
            
			 //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/return_book/');
            }
			//create control variables
            $data['id'] = $id;
            $data['updType'] = 'create';
            $form_data_aux  = array();
            $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
           $data['b_books']=$this->return_book_m-> student_books($id);
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

            //validate the fields of form
            if ($this->form_validation->run() )
            {         //Validation OK!
                    $user = $this -> ion_auth -> get_user();
					
					  $length=array();
					$length=$this->input->post('return_date');
		            if(!empty($length)){
					$size=count($length);}
					//print_r($size);die;
		for($i=0; $i < $size ; $i++){
					
						 $return_date=$this->input->post('return_date');
						 $book=$this->input->post('book');
						 $remarks=$this->input->post('remarks');
					
						 $form_data = array(
									'return_date' => strtotime($return_date[$i]), 
									'student' => $id, 
									'borrowed_book_id' => $book[$i], 
									'remarks' => $remarks[$i], 
									'created_by' => $user -> id ,   
									'created_on' => time()
								); 
								
								$ok=  $this->return_book_m->create($form_data);
								//Update book status
					  
					 $form_update = array( 
							
							'status' => 2, 
							 'modified_by' => $user -> id ,   
							 'modified_on' => time() );

							//find the item to update
							$done = $this->borrow_book_m->update_attributes($book[$i], $form_update);
						}	
			     

            if ( $ok ) 
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Successfully updated' ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/return_book/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get->{$field['field']}  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
                 $data['student'] = $id; 
				  $data['books']=$this->borrow_book_m->populate('books','id','title');
				 $data['fine']=$this->borrow_book_m->lib_settings();
		 //load the view and the layout
		 $this->template->title('Add Return Book ' )->build('admin/create', $data);
		}		
	}

	function edit($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/return_book/');
            }
         if(!$this->return_book_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/return_book');
              }
        //search the item to show in edit form
        $get =  $this->return_book_m->find($id); 
		 $data['books']=$this->borrow_book_m->populate('books','id','title');
				 $data['fine']=$this->borrow_book_m->lib_settings();
            //variables for check the upload
            $form_data_aux = array();
            $files_to_delete  = array(); 
            //Rules for validation
            $this->form_validation->set_rules($this->validation());

            //create control variables
            $data['updType'] = 'edit';
            $data['page'] = $page;

            if ($this->form_validation->run() )  //validation has been passed
             {
			$user = $this -> ion_auth -> get_user();
            // build array for the model
            $form_data = array( 
				'return_date' => strtotime($this->input->post('return_date')), 
							'borrowed_book_id' => $this->input->post('book'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->return_book_m->update_attributes($id, $form_data);

        
        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/return_book/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/return_book/");
			}
	  	}
             else
             {
                 foreach (array_keys($this -> validation()) as $field)
                {
                        if (isset($_POST[$field]))
                        {  
                                $get -> $field = $this -> form_validation -> $field;
                        }
                }
		}
               $data['result'] = $get;
             //load the view and the layout
             $this->template->title('Edit Return Book ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/return_book');
		}

		//search the item to delete
		if ( !$this->return_book_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/return_book');
		}
 
		//delete the item
		                     if ( $this->return_book_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/return_book/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'return_date',
                 'label' => 'Return Date',
                 'rules' =>'xss_clean'),

                 array(
		 'field' =>'book',
                 'label' => 'Book',
                 'rules' =>'xss_clean'),
				 array(
		 'field' =>'remarks',
                 'label' => 'Remarks',
                 'rules' =>'xss_clean'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/return_book/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 100;
            $config['total_rows'] = $this->return_book_m->count();
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