<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Expenses</h4>
        <div class="heading-elements">
          <?php echo anchor('admin/expenses/create/' . $page, '<i class="glyphicon glyphicon-plus">                </i>' . lang('web_add_t', array(':name' => 'Expenses')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/expenses/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/expenses/voided', '<i class="glyphicon glyphicon-list">
                </i> Voided Expenses', 'class="btn btn-warning"'); ?>
        </div>
    </div>
    
  
    
<?php if ($expenses): ?>    
  <div class="panel-body">
        <div class="information">
            <div class="item">
                <div class="rates">
                    <div class="title"><?php
                        if (empty($total_exp_day->total))
                            echo '0.00';
                        else
                            echo number_format($total_exp_day->total, 2);
                        ?> </div>
                    <div class="description">Total Expenses Today (<?php echo $this->currency;?>)</div>
                </div>
            </div>
            <div class="item">
                <div class="rates">
                    <div class="title"><?php if (empty($total_exp_month->total)) echo '0.00';
                        else echo number_format($total_exp_month->total, 2); ?></div>
                    <div class="description">Total Expenses This Month (<?php echo $this->currency;?>)</div>
                </div>
            </div>


            <div class="item">
                <div class="rates">
                    <div class="title"><?php
                        if (empty($total_exp_year->total))
                            echo '0.00';
                        else
                            echo number_format($total_exp_year->total, 2);
                        ?></div>
                    <div class="description">Total Expenses This Year (<?php echo $this->currency;?>)</div>
                </div>
            </div> 
            <div class="item">
                <div class="rates">
                    <div class="title"><?php if (empty($total_expenses->total)) echo '0.00';
                        else echo number_format($total_expenses->total, 2); ?></div>
                    <div class="description">Full Total Expenses (<?php echo $this->currency;?>)</div>
                </div>
            </div>								
        </div>
    </div>

    <div class="block-fluid">
        <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">

            <thead>
            <th>#</th>
            <th>Date</th>
            <th>Title</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Person <br>Responsible</th>
            <th>Receipt</th>
            <th>Description</th>
            <th width="20%">Action</th>

            </thead>
            <tbody>
                <?php
                $i = 0;
                $j = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                }

                foreach ($expenses as $p):
                    $user = $this->ion_auth->get_user($p->person_responsible);
                    $u = $this->ion_auth->get_user($p->modified_by);

                    $i++;
                    $j++;
                    ?>
                    <tr>
                        <td><?php echo $j . '.'; ?></td>					
                        <td><?php echo date('d/m/Y', $p->expense_date); ?></td>
                        <td><?php echo isset($items[$p->title]) ? $items[$p->title] : ' '; ?></td>
                        <td><?php echo $cats[$p->category]; ?></td>
                        <td><?php echo number_format($p->amount, 2); ?></td>
                        <td><?php $resp = $user->first_name . ' ' . $user->last_name;
                    echo isset($resp) ? $resp : ' '; ?></td>
                        <td>
        <?php if (!empty($p->receipt)): ?>
                                <a href='<?php echo base_url(); ?>uploads/files/<?php echo $p->receipt ?>' />Download receipt</a>
        <?php else: ?>
                                ................
                    <?php endif ?>
                        </td>
                        <td><?php echo $p->description; ?></td>
                        <td>
                            <div class='btn-group'> <a class='btn btn-primary' href ='<?php echo base_url('admin/expenses/edit/' . $p->id); ?>' >Edit</a> 
                                <a onClick='return confirm(\"Are you sure?\")' class='kftt btn btn-danger' href ='<?php echo base_url('admin/expenses/void/' . $p->id); ?>' >Void</a>" + '</div>
                        </td>

                    </tr>
    <?php endforeach ?>
            </tbody>

        </table>
    </div>


<?php else: ?>
    <p class='text-center'><?php echo lang('web_no_elements'); ?></p>
     <?php endif ?>