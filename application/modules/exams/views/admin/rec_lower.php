<div class="col-md-12">
   <!-- Pager -->
   <div class="panel panel-white animated fadeIn">
       <div class="panel-heading">
           <h4 class="panel-title">Exams Management</h4>
           <div class="heading-elements">
             <?php echo anchor('admin/exams/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
           </div>
       </div>
       
       <div class="panel-body">
        

        <table class="table table-striped table-bordered  " >
            <!-- BEGIN -->
            <thead>
                <tr> 
                    <th width="3%">#</th>
                    <th width="">Student</th>
                    <th width="" >Action</th>
                </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
                <?php
                $i = 1;
                foreach ($students as $post):
                    $std = $this->worker->get_student($post->id)
                    ?>  
                    <tr>
                        <td>
                            <span id="reference" name="reference" class="heading-reference"><?php echo $i . '. '; ?></span>
                        </td> 
                        <td>
                            <?php echo $std->first_name . ' ' . $std->last_name; ?>
                        </td>
                        <td colspan="2">
                            <?php
                            echo anchor('admin/exams/create_lower/' . $exm . '/' . $class . '/' . $post->id, 'Progress Report','class="btn btn-primary"');
                            ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                endforeach;
                ?>		
            </tbody>
        </table>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
