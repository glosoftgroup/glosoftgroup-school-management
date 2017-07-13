<style>
    @media print{

        .navigation{
            display:none;
        }
        .widget{
            width:420px;

        }
        .head{
            display:none;
        }
        .print{
            display:none;
        }

        .tip{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; }
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
<div class=" right">
    <a class="print" href="" onclick="window.print();
        return false"><button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print  </button></a>
   
</div>
<div class="col-md-3">
</div>
<div class="col-md-5">

    <div class="widget">
        <div class="profile clearfix">
            <div class="image">

                <?php if (!empty($passport)): ?>	
                    <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="90" height="90" class="img-polaroid" style="align:left">

                <?php else: ?>   
                    <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:90px; height:90px; align:left")); ?>

                <?php endif; ?>   
 
            </div>                        
            <div class="info" >
                <p style="text-align:center; font-size:1.7em; font-weight:bold;">
                    <?php echo strtoupper($this->school->school); ?><br>
                    <span style="font-size:.5em;"><?php echo $this->school->postal_addr; ?></span><br>

                    <span style="font-size:.5em; text-decoration:underline"><?php echo $this->school->email; ?></span>
                </p>
              
                <p><strong>Name: </strong> <?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></p>                          
                <p><strong>Gender: </strong> <?php if ($u->gender == 1) echo 'Male';
                else echo 'Female'; ?> <strong>DOB:</strong> <?php echo $u->dob > 1000 ? date('d M Y', $u->dob) : ''; ?></p>
				<p><strong> <span class="date">Admission Date:</strong> <?php echo date('d M Y', $u->admission_date); ?></span></p>
                <p><strong>Expiry Date: </strong><?php echo date('d M Y', time()); ?></p>
				
                <div class="status" style="width:100%; ">ADM NO. <?php if (!empty($u->old_adm_no)) echo $u->old_adm_no;
                else echo $u->admission_number; ?></div>
            </div>
            <div class="stats">
                <img src="<?php echo base_url('assets/themes/admin/img/barcode.png'); ?>" class="">                              

            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
</div>

