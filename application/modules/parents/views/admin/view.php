<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Parents</h4>
        <div class="heading-elements">
          <?php echo anchor('admin/parents', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Parents')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    
    <div class="panel-body">
    
    <div class="col-md-12">
     <div class="col-md-6">
        <div class="panel panel-body">
            <div class="media">
                <div class="media-left">
                    <a href="assets/images/demo/images/3.png" data-popup="lightbox">
                    <img src="<?php echo base_url('assets/themes/admin/img/2.png'); ?>" width="100" height="100"class="img-polaroid"/>               
                    </a>
                </div>

                <div class="media-body">
                     <div class="info-s">
                    <h2><?php echo $p->first_name . ' ' . $p->last_name ?></h2>
                    <table class='table table-borderd' border="0" width="450">
                        <tr> <td><strong>Email:</strong></td><td> <?php echo $p->email ?></td></tr>
                        <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $p->phone ?></td></tr>
                        <tr> <td><strong>Other Phone:</strong></td><td> <?php echo $p->phone2 ?></td></tr>
                        <tr> <td><strong>Occupation:</strong></td><td><?php echo $p->occupation ?></td></tr>
                        <tr> <td><strong>Address:</strong></td><td><?php echo $p->address ?></td></tr>
                    </table>
                   
                </div>
                </div>
            </div>
             <div class="panel-footer">Father Details</div>
        </div>
        </div>
         <div class="col-md-6">

        <div class="panel panel-body">
            <div class="media">
                <div class="media-left">
                    <a href="" data-popup="lightbox">
                    <img src="<?php echo base_url('assets/themes/admin/img/3.png'); ?>" width="100" height="100"class="img-polaroid"/>               
                    </a>
                </div>

                <div class="media-body">
                  <div class="info-s">
                    <h2><?php echo $p->mother_fname . ' ' . $p->mother_lname ?></h2>
                    <table class="table table-hover" border="0" width="450">
                        <tr> <td><strong>Email:</strong></td><td> <?php echo $p->mother_email ?></td></tr>
                        <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $p->mother_phone ?></td></tr>
                        <tr> <td><strong>Other Phone:</strong></td><td> <?php echo $p->mother_phone2 ?></td></tr>
                        <tr> <td><strong>Occupation:</strong></td><td><?php echo ''; ?></td></tr>
                        <tr> <td><strong>Address:</strong></td><td><?php echo $p->address ?></td></tr>
                    </table>

                    
                  </div>
                </div>
            </div>
            <div class="panel-footer">Mother Details</div>
        </div>
        </div >
    </div>
</div>