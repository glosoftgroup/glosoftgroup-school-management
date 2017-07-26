
<?php
 $settings=$this->ion_auth->settings();
?>
           
                <div class="widget">
			    <div class="col-md-12">
<div class="col-md-4"></div>
<div class="col-md-4">
<div class="right print">
			  <button id="printBtn" onClick="return false;" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
				 <?php echo anchor( 'admin/leaving_certificate' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Leaving Certificate')), 'class="btn btn-primary"');?> 
        
	</div>
</div>
<div class="col-md-4"></div>
</div>
				<div class="clear"></div>
   <div class="col-md-2"></div>
    <div class="slip panel col-md-8" id="printme">
	 <div class="panel-body slip-content">
                        <div class="row">
                           <div class="col-md-12 view-title">
							 <span class="text-center">
                              <h1><img src="<?php echo base_url('uploads/files/emblem.jpg'); ?>" width="100" height="100" />
								<h1> Republic of Kenya
								<br>
								<span class="border">________________________</span>
								  <br>
								
								  Ministry of Education, Science and technology
								  <br>
								  <span class="border">________________________</span>
								</h5>
						</h1></span>
							
                               
                              		  <h3 class="text-center">School Leaving Certificate</h3>			
                            </div>
							 <div class="col-md-12">
							 
							   <address class="uppercase"  style="margin-right:18px;">
							 This is to certify that <abbr title="Name"><?php echo $student->first_name . ' ' . $student->last_name; ?></abbr>
							   ADM NO. <abbr  title="ADM" > <?php
                            if (!empty($student->old_adm_no)){echo $student->old_adm_no; }
                            else
                            { if ($student->admission_number > 99){ echo $student->admission_number; }
                                else{ echo '0' . $student->admission_number;} }
                            ?>
							</abbr>
							<br>
							Date of Birth  <abbr  title="DOB" ><?php echo date('d M Y', $student->dob); ?></abbr>
							Entered <abbr  title="SCH"><?php echo $settings->school;?></abbr> school and was enrolled on   <abbr  title="ADM Date"><?php echo date('d M Y', $student->admission_date); ?></abbr>
							In  <abbr title="Class" > <?php   $class = $this->ion_auth->list_classes(); echo isset($class[$student->class]) ? $class[$student->class] : ' '; ?></abbr> 
							And Left on   <abbr title="LEFT" > <?php echo date('d M Y',$post->leaving_date);?></abbr> From   <abbr title="FROM" > Class 8</abbr> Having satisfactorily completed the approved course for  <abbr class="" title="" >Class 8</abbr>
							<br>
							Headteacher's report on pupil's ability,Industry and conduct: <br> <abbr title="Remark" ><?php echo $post->ht_remarks;?></abbr>
							<br>
							Pupil's Participation in co-curricular activities:<br> <abbr title="activities" ><?php echo $post->co_curricular;?></abbr>
							    </address> 
							 </div>
							 
						<div class="row">
		                  <div class="col-md-12">
							<div class="col-md-6">
							
							<br>
							 <strong style="border-top:1px solid #000"> Pupil's Signature </strong>
							
							</div>
							<div class="col-md-6">
							
							<br>
								<strong class="right" style="border-top:1px solid #000"> Headteacher's Signature </strong>
							</div>
						</div>
						</div>
						<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
							
							<br>
							<?php echo date('d M Ys',time());?><br>
							 <strong style="border-top:1px solid #000"> Date of Issue  </strong>
							
							</div>
							<div class="col-md-6">
							
							<br>
							<br>
								<strong class="right" style="border-top:1px solid #000"> Official Stamp </strong>
							</div>
						</div>
			
		
        </div>
		<div class="center" style="border-top:1px solid #ccc">		
	 <span class="center uppercase" style="font-size:0.8em !important;text-align:center !important;">
	 This Certificate was issued without any erasure or alteration whatsoever
	 </span>
	 </div>		 
					
                        </div>
						
						
						 
			</div>
			</div>
		 <div class="col-md-2"></div>    
		</div>
                


<style>
    @media print{

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
		.col-md-4{
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
		.right{
float:right;

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
		.slip{
		margin-top:0;}
    }
</style>     

