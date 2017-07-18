<!-- Pager -->
<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"><?php
        $cc = isset($classes[$class->class]) ? $classes[$class->class] : ' -';
        $ss = isset($streams[$class->stream]) ? $streams[$class->stream] : ' -';
        echo $cc . ' ' . $ss;
        ?></h4>
		<div class="heading-elements">
			<div class="heading-btn">
				 <button onClick="window.print();
                      return false" class="btn heading-btn btn-primary" type="button">
	     <span class="glyphicon glyphicon-print"></span> Print Class List</button>
        <a href="<?php echo base_url('admin/class_groups/classes'); ?>" class="btn heading-btn btn-info">
		<i class="glyphicon glyphicon-list"> </i> List All</a>

			</div>
		</div>
	</div>

	<div class="panel-body">
		<div class="col-sm-6 content-group">
		  <h5 class="text-uppercase text-semibold">Number of Registered Students <span style="color:red"><?php echo count($post); ?></h5>
		  <span class="text-right text-muted">Class Profile as at : <?php echo date('jS M Y'); ?></span>
		</div>
		<div class="col-sm-6 content-group">
      <div class='invoice-details'>
			<h5 class="text-uppercase position-right text-semibold">
			 Class Teacher :
			 <?php
			 $u = $this->ion_auth->get_user($class->class_teacher);
					$tr = ' ';
					if($class->class_teacher>0){

						$tr = $u->first_name.' '.$u->last_name;
					}
					echo '<span style="color:red">'.$tr.'</span>';
					?></span>
			</h5>
    </div>
		</div>
		<!-- end topline -->
		<table class='table table-striped table-hover'>
        <thead>
            <tr class="bg-primary">
                <th>#</th>
                <th>Name</th>
                <th>Admission Number</th>
                <th>Gender</th>
                <th>Admission Date</th>
                <th class="option">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $gender = array(1 => 'Male', 0 => 'Female',2 => 'Female');
            $i = 0;
            foreach ($post as $s)
            {
                $i++;
                ?>

                <tr>
                    <td><?php echo $i . '. '; ?></td>
                    <td><?php echo $s->first_name . ' ' . $s->last_name; ?></td>
                    <td><?php
                        if (!empty($s->old_adm_no))
                        {
                            echo $s->old_adm_no;
                        }
                        else
                        {
                            echo $s->admission_number;
                        }
                        ?></td>
                    <td><?php echo isset($gender[$s->gender]) ? $gender[$s->gender] : ' '; ?></td>
                    <td><?php echo $s->admission_date > 0 ? date('d M Y', $s->admission_date) : ' '; ?></td>
                    <td class="option">
                        <div class="btn-group">
                            <a class='btn btn-success'  href="<?php echo site_url('admin/admission/view/' . $s->id); ?>"><i class="glyphicon glyphicon-edit"></i> View Profile</a>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
	</div>

</div>
<!-- /pager -->



<style>
    @media print{

         .buttons-hide{
              display:none !important;
         }

		 .option{
              display:none !important;
         }
         .col-md-4 {
              width: 200px !important;
              float: left !important;
              margin:0px !important;
         }

		  table tr{
			  border:1px solid #666 !important;
		  }
		  table th{
			  border:1px solid #666 !important;
			   padding:5px;
		  }
 table td{
			  border:1px solid #666 !important;
			   padding:5px;
		  }

         .col-md-4 {
              width: 200px !important;
              float: left !important;
         }
         .right{
              float:right;

         }
         .bold{
              font-weight:bold;
              font-size:1.5em;
              color:#000;
         }
         .kes{
              color:#000;
              font-weight:bold;
         }
         .item{
              padding:3px;
         }
         .col-md-3 {
              width: 200px !important;
              float: left !important;
         }
         .col-md-6 {
              width: 300px !important;
              float: left !important;
         }
         .col-md-2 {
              width: 150px !important;
              float: left !important;
         }

         .navigation{
              display:none;
         }
         .alert{
              display:none;
         }
         .alert-success{
              display:none;
         }

         .img{
              align:center !important;
         }
         .print{
              display:none !important;
         }
         .bank{
              float:right;
         }
         .view-title h1{border:none !important; text-align:center }
         .view-title h3{border:none !important; }

         .split{

              float:left;
         }
         .header{display:none}
         .invoice {
              width:100%;
              margin: auto !important;
              padding: 0px !important;
         }
         .invoice table{padding-left: 0; margin-left: 0; }

         .smf .content {
              margin-left: 0px;
         }
         .content {
              margin-left: 0px;
              padding: 0px;
         }
    }
</style>
