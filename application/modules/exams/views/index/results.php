<div class="row " id="x-acts">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <h6>Filter to View Exam Results</h6>

        <?php echo form_open(current_url()); ?>
        Student:
        <?php echo form_dropdown('student', array('' => 'Select Student') + $kids, $this->input->post('student'), 'class="tsel"'); ?>

        Exam:
        <?php echo form_dropdown('exam', array('' => '') + $exams, $this->input->post('exam'), 'class="tsel"'); ?>

        &nbsp;
        <button type="submit" class="btn btn-custom">Submit</button>
        <?php
            if (!empty($report))
            {
                 ?>
                 <button onClick="window.print();
                           return false" class="btn btn-custom" type="button" style="margin-left:5%;"> Print </button>
                         <?php
                    }
                    echo form_close();
                ?>
    </div><!-- End .col-md-12 -->
    <?php
        if (!$this->input->post('exam'))
        {
             ?>
             <h1 class="title">   &nbsp;</h1>
             <h1 class="title">   &nbsp;</h1>
             <h1 class="title">   &nbsp;</h1>
        <?php } ?>

</div>

<?php
    if (!$proc)
    {
         if ($this->input->post('exam'))
         {
              ?>
              <h1 class="title">   &nbsp;</h1>
              <div class="alert alert-danger alert-dismissable col-md-8">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong>Error!</strong> Exams Results  Not Found.
              </div><?php
         }
    }
    else
    {
         $settings = $this->ion_auth->settings();
         if (!empty($report))
         {
              ?>
              <div class="col-md-12 col-sm-12 col-xs-12 ">

                  <div class="clearfix"></div>
                  <div class="xlg-margin  xs-margin"></div>
                  <div class="span"> 
                      <img  src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="left" align="left" style="margin-right:10px;" width="80" height="80" />
                  </div>
                  <div>
                      <b>Student: </b>
                      <span ><?php echo ucwords($student->first_name . ' ' . $student->last_name); ?> </span>
                      <span class="right">
                          <b>Reg. No. : </b>
                          <span><?php echo (!empty($student->old_adm_no)) ? $student->old_adm_no : $student->admission_number; ?>
                          </span>
                      </span>	
                      <br>
                      <b>Class : </b>
                      <span><?php
                           $crr = isset($this->classes[$cls->class]) ? $this->classes[$cls->class] : '';
                           $ctr = isset($streams[$cls->stream]) ? $streams[$cls->stream] : '';
                           echo $crr . ' ' . $ctr;
                           ?></span>
                      <br>
                      <b>Exam : </b>
                      <span><?php echo $exam->title . ' Term ' . $exam->term . ' ' . $exam->year; ?></span>
                  </div>

                  <div class="table-responsive col-md-9 col-sm-9 col-xs-9">
                      <div class=" xs-margin"></div>
                      <table class="table checkout-table interthin"  >
                          <thead>
                              <tr>
                                  <th width='3%'>#</th>
                                  <th>SUBJECT</th>
                                  <th colspan="2">MARKS</th>
                                  <th>  </th>
                              </tr>
                          </thead>
                          <tbody  id="sort_1">
                               <?php
                               $i = 0;
                               $total = 0;
                               if ($report && isset($report['marks']))
                               {
                                    $mks = $report['marks'];

                                    foreach ($mks as $ps):
                                         $p = (object) $ps;
                                         $total +=$p->marks;
                                         $i++;
                                         if (isset($p->units))
                                         {
                                              foreach ($p->units as $key => $value)
                                              {
                                                   ?>
                                                  <tr>
                                                      <td><?php echo $i . '.'; ?></td>
                                                      <td  ><?php echo isset($s_units[$key]) ? $s_units[$key] : ''; ?> </td>
                                                      <td class="right"><?php echo $value; ?></td>
                                                      <td> </td>
                                                      <td> </td>
                                                  </tr>    
                                                  <?php
                                                  $i++;
                                             }
                                        }
                                        ?>

                                        <tr class="new">
                                            <td><?php echo $i . '.'; ?></td>
                                            <td colspan="2"> 
                                                 <?php
                                                 echo isset($subjects[$p->subject]) ? $subjects[$p->subject] : '';
                                                 echo isset($p->units) ? ' TOTAL' : ''; //echo $p->subject;
                                                 ?>
                                            </td>
                                            <td class="right"><span class="strong" ><?php echo $p->marks; ?></span></td>
                                            <td> </td>
                                        </tr>
                                        <?php
                                   endforeach;
                              }
                              ?>        
                              <tr class="new">
                                  <td> </td>
                                  <td> </td>
                                  <td class="rightb">  <strong>Total:</strong></td>
                                  <td class="rightb"><strong><?php echo $total; ?></strong></td>
                                  <td> </td>
                              </tr>
                          </tbody>
                      </table>

                      <table class="lower" width="100%" border="0"  >
                          <tr><td class="nob" width="60%">
                                  <div>						 

                                      <div class="foo">
                                          <strong><span>Recommendation:</span></strong> 
                                          <br> <?php
                                          if (!empty($grading))
                                          {
                                               $pass_mark = $grading->pass_mark;
                                               $rem = $pass_mark - $total;
                                               if ($total > $pass_mark)
                                               {
                                                    //echo '<span class="green">PASS: Proceed to next level</span>';
                                               }
                                               else
                                               {
                                                    // echo '<span style="color:red">Failed by ' . $rem . ' Marks </span>';
                                               }
                                          }
                                          ?> 
                                      </div>
                                      <div class="foo">
                                          <strong><span style="text-decoration:underline">Teacher's Remarks:</span></strong>
                                          <br><span class="green"><?php echo isset($report['remarks']) && $report['remarks'] != '' ? $report['remarks'] : '<hr style="border-top: 2px dotted black"/>'; ?> </span>
                                      </div>
                                      <strong><span style="text-decoration:underline">Additional Remarks:</span></strong>
                                      <hr style="border-top: 2px dotted black"/>
                                  </div>
                              </td>
                              <td class="nob">
                                  <div class="right">  
                                      <br>
                                      <?php
                                      if (!empty($grading))
                                      {
                                           ?>
                                           <strong style="font-size:.8em"><?php echo $grading->title; ?> <br>
                                               Pass Mark: <?php echo $grading->pass_mark; ?> </strong>
                                      <?php } ?> </div>
                              </td></tr>
                      </table>

                      <div class="center" style="border-top:1px solid #ccc">		
                          <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                               <?php
                               if (!empty($settings->tel))
                               {
                                    echo $settings->postal_addr . ' Tel:' . $settings->tel . ' ' . $settings->cell;
                               }
                               else
                               {
                                    echo $settings->postal_addr . ' Cell:' . $settings->cell;
                               }
                               ?></span>
                      </div>

                  </div>
              </div>
              <?php
         }
         else
         {
              ?>
              <h1 class="title">   &nbsp;</h1>
              <div class="alert alert-danger alert-dismissable col-md-8">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong>Error!</strong> Exams Results for Selected Student not Found.
              </div>
              <?php
         }
    }
?>
<script>
     $(document).ready(function ()
     {
          $(".tsel").select2({'placeholder': 'Please Select', 'width': '270px'});

     });
</script>
<style>
    * { margin: 0; padding: 0; border: 0; }

    .strong{font-weight: bold;}
    .right{text-align: right;}
    .rightb{text-align: right; border-bottom: 3px double #000;}
    .center{text-align: center;}
    .green{color: green;}
    table td, table th {
         padding: 4px; font-size: 12px;
    }  .nob{border-right:0 !important;}
    @media print{
         body{background: #fff;font-family: OpenSans;}

         /**********/
         .ptable{ border: 1px solid #DDD;
                  border-collapse: collapse; }
         td, th {
              border: 1px solid #ccc;
         }
         th {
              background-color:  #ccc;
              border-color: #FFF;
              text-align: center;
         }
         td.nob{  border:none !important; background-color:#fff !important;}
         /**********/
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

         .right{
              float:right;
         }
         .header{display:none}

    }
</style>     