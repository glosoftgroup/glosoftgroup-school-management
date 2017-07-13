<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Parents  </h2>
    <div class="right">  
        <?php //echo anchor( 'admin/parents/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Parents')), 'class="btn btn-primary"');?>
        <?php echo anchor('admin/parents', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Parents')), 'class="btn btn-primary"'); ?> 

    </div>
</div>
<div class="block-fluid">
    <div class="col-md-8">
        <div class="widget">
            <div class="profile clearfix">
                <div class="image">
                    <img src="<?php echo base_url('assets/themes/admin/img/2.png'); ?>" width="100" height="100"class="img-polaroid"/>
                </div>                        
                <div class="info-s">
                    <h2><?php echo $p->first_name . ' ' . $p->last_name ?></h2>
                    <table border="0" width="450">
                        <tr> <td><strong>Email:</strong></td><td> <?php echo $p->email ?></td></tr>
                        <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $p->phone ?></td></tr>
                        <tr> <td><strong>Other Phone:</strong></td><td> <?php echo $p->phone2 ?></td></tr>
                        <tr> <td><strong>Occupation:</strong></td><td><?php echo $p->occupation ?></td></tr>
                        <tr> <td><strong>Address:</strong></td><td><?php echo $p->address ?></td></tr>
                    </table>
                    <div class="status">Father Details</div>
                </div>

            </div>
        </div>

        <div class="widget">
            <div class="profile clearfix">
                <div class="image">
                    <img src="<?php echo base_url('assets/themes/admin/img/3.png'); ?>" width="100" height="100"class="img-polaroid"/>
                </div>                        
                <div class="info-s">
                    <h2><?php echo $p->mother_fname . ' ' . $p->mother_lname ?></h2>
                    <table border="0" width="450">
                        <tr> <td><strong>Email:</strong></td><td> <?php echo $p->mother_email ?></td></tr>
                        <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $p->mother_phone ?></td></tr>
                        <tr> <td><strong>Other Phone:</strong></td><td> <?php echo $p->mother_phone2 ?></td></tr>
                        <tr> <td><strong>Occupation:</strong></td><td><?php echo ''; ?></td></tr>
                        <tr> <td><strong>Address:</strong></td><td><?php echo $p->address ?></td></tr>
                    </table>

                    <div class="status">Mother Details</div>
                </div>

            </div>
        </div>
    </div>
</div>