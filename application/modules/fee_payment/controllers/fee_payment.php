<?php

    if (!defined('BASEPATH'))
         exit('No direct script access allowed');

    class Fee_payment extends Public_Controller
    {

         public function __construct()
         {
              parent::__construct();
              $this->load->model('fee_payment_m');
              $this->template
                           ->set_layout('default.php')
                           ->set_partial('meta', 'partials/meta.php')
                           ->set_partial('header', 'partials/header.php')
                           ->set_partial('sidebar', 'partials/sidebar.php')
                           ->set_partial('footer', 'partials/footer.php');
         }

         public function process_fee()
         {
              $res = $this->worker->do_invoice();
              echo ' <hr>Made <strong>' . $res . '</strong> New Invoices';
              echo '<hr>Updated All Student Balances <br> <br> ';
              echo anchor('admin/fee_payment/paid', '<i class="glyphicon glyphicon-list">
                </i>Go Back to fee Payment Status', 'class="btn btn-primary"');
         }

         function calc($id = FALSE)
         {
              if ($id)
              {
                   $this->worker->calc_balance($id);
                   echo 'done...';
              }
              else
              {
                   $this->worker->sync_bals(1);
              }
         }

         /**
          * Show Fee Details to Parent
          * 
          */
         function fee()
         {
              if (!$this->parent)
              {
                   redirect('account');
              }
              $data[''] = '';
              $this->template->title(' Fee Payment Summary ')->build('index/summary', $data);
         }

         /**
          * Student Fee Statement
          * 
          * @param type $id
          */
         function statement($id)
         {
              if (!$this->parent)
              {
                   redirect('account');
              }
              $valid = array();
              foreach ($this->parent->kids as $pk)
              {
                   $valid[] = $pk->student_id;
              }
              if (!in_array($id, $valid))
              {
                   $id = $valid[0];
              }
              if (!$this->fee_payment_m->student_exists($id))
              {
                   redirect('admin/fee_payment');
              }

              $post = $this->fee_payment_m->get_student($id);
              $data['banks'] = $this->fee_payment_m->banks();
              $data['post'] = $post;
              $data['class'] = $this->portal_m->fetch_class($post->class);
              $data['cl'] = $this->portal_m->get_class_options();
              $data['arrs'] = $this->fee_payment_m->fetch_total_arrears($id);
              $data['extras'] = $this->fee_payment_m->all_fee_extras();
              $payload = $this->worker->process_statement($id);

              $data['payload'] = $payload;
              $this->template->title(' Fee Statement')->build('index/statement', $data);
         }

    }
    