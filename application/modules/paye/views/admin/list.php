<!-- Pager -->
<div class="panel panel-white animated fadeIn">
  <div class="panel-heading">
    <h4 class="panel-title">PAYE</h4>
    <div class="heading-elements">
      <?php echo anchor('admin/paye/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'PAYE')), 'class="btn btn-primary"'); ?>
         <?php echo anchor('admin/paye', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'PAYE')), 'class="btn btn-primary"'); ?> 
    </div>
  </div>
  
  
 
<?php if ($paye): ?>
      <div class="panel-body">
             <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 <th>#</th>
                 <th>Range From (<?php echo $this->currency; ?>)</th>
                 <th>Range To (<?php echo $this->currency; ?>)</th>
                 <th>Tax</th>
                 <th>Amount (<?php echo $this->currency; ?>)</th>
                 <th ><?php echo lang('web_options'); ?></th>
                 </thead>
                 <tbody>
                      <?php
                      $i = 0;
                      if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                      {
                           $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                      }
                      foreach ($paye as $p):
                           $i++;
                           ?>
                          <tr>
                              <td><?php echo $i . '.'; ?></td>					
                              <td><?php
                                   if (is_numeric($p->range_from))
                                   {
                                        echo number_format($p->range_from, 2);
                                   }
                                   else
                                   {
                                        echo '<i style="color:green">' . $p->range_from . '</i>';
                                   }
                                   ?></td>
                              <td><?php
                                   if (is_numeric($p->range_to))
                                   {
                                        echo number_format($p->range_to, 2);
                                   }
                                   else
                                   {
                                        echo '<i style="color:green">' . $p->range_to . '</i>';
                                   }
                                   ?></td>
                              <td><?php echo $p->tax; ?>%</td>
                              <td><?php
                                   if (is_numeric($p->amount))
                                   {
                                        echo number_format($p->amount, 2);
                                   }
                                   else
                                   {
                                        echo $p->amount;
                                   }
                                   ?></td>
                              <td width='20%'>
                                  <div class='btn-group'>
                                      <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                      <ul class='dropdown-menu pull-right'>
                                          <li><a href='<?php echo site_url('admin/paye/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                                          <li><a  href='<?php echo site_url('admin/paye/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
                                          <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/paye/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
                                      </ul>
                                  </div>
                              </td>
                          </tr>
                     <?php endforeach ?>
                 </tbody>
             </table>
         </div>
    <?php else: ?>
         <p class='text-center text-muted p-10'><?php echo lang('web_no_elements'); ?></p>
                   <?php endif ?>