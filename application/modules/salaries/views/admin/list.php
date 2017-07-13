<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Salaried Employees  </h2>
    <div class="right">  
         <?php echo anchor('admin/salaries/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Employee to Salary')), 'class="btn btn-primary"'); ?>
         <?php echo anchor('admin/salaries', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Salaried Employees')), 'class="btn btn-primary"'); ?> 
    </div>
</div>
<?php if ($salaries): ?>
         <div class="block-fluid">
             <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 <th>#</th>
                 <th>Employee</th>
                 <th>Basic Salary (<?php echo $this->currency; ?>)</th>
                 <th>Bank Details</th>
                 <th>Deductions (<?php echo $this->currency; ?>)</th>
                 <th>Allowances (<?php echo $this->currency; ?>)</th>
                 <th>Method</th>
                 <th>NHIF/NSSF</th>
                 <th ><?php echo lang('web_options'); ?></th>
                 </thead>
                 <tbody>
                      <?php
                      $i = 0;
                      if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                      {
                           $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                      }
                      foreach ($salaries as $p):
                           $i++;
                           $u = $this->ion_auth->get_user($p->employee);
                           ?>
                          <tr>
                              <td><?php echo $i . '.'; ?></td>					
                              <td><?php
                                   $emp = $u->first_name . ' ' . $u->last_name;
                                   echo isset($emp) ? $emp : ' ';
                                   ?></td>					
                              <td> <?php echo number_format($p->basic_salary, 2); ?></td>
                              <td><?php
                                   echo $p->bank_name . '<br>ACC-';
                                   echo $p->bank_account_no;
                                   ?></td>
                              <td>
                                   <?php
                                   $decs = $this->salaries_m->get_deductions($p->id);
                                   echo 'NHIF - ' . number_format($p->nhif, 2) . '<br>';
                                   foreach ($decs as $d)
                                   {
                                        echo $deductions[$d->deduction_id] . '<br>';
                                   }
                                   if (isset($p->staff_deduction) && !empty($p->staff_deduction))
                                   {
                                        echo 'Staff Ded: ' . number_format($p->staff_deduction);
                                   }
                                   ?>
                              </td>
                              <td>
                                   <?php
                                   $allws = $this->salaries_m->get_allowance($p->id);
                                   foreach ($allws as $d)
                                   {
                                        echo $allowances[$d->allowance_id] . '<br>';
                                   }
                                   ?>
                              </td>
                              <td><?php echo $p->salary_method; ?></td>
                              <td><?php echo 'NHIF #- ' . $p->nhif_no . '<br> NSSF #- ' . $p->nssf_no; ?></td>
                              <td width='20%'>
                                  <div class='btn-group'>
                                      <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                      <ul class='dropdown-menu pull-right'>
                                          <li><a  href='<?php echo site_url('admin/salaries/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
                                          <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/salaries/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
                                      </ul>
                                  </div>
                              </td>
                          </tr>
                     <?php endforeach ?>
                 </tbody>
             </table>
         </div>
    <?php else: ?>
         <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                     <?php endif ?>