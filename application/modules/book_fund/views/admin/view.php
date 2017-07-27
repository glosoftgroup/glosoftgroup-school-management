<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Book Details </h4>
        <div class="heading-elements">
         <button onClick="return false;" id="printBtn" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
                      <?php echo anchor( 'admin/book_fund/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
        </div>
    </div>
    
    <div class="panel-body">
                    
      <div class="widget">
                    
                    <div class="block invoice1" id="printme">
					
						<div class="clearfix"></div>
                            <div class="col-md-11 view-title text-center">
                                <h1><img src="<?php echo base_url('assets/themes/admin/img/logo-sm.png'); ?>" width="80" height="80"/>
								<h5><?php $settings=$this->ion_auth->settings(); echo ucwords($settings->motto);?>
								  <br>
								  <span style="font-size:0.6em !important"><?php echo $settings->postal_addr.'<br> Tel:'.$settings->tel.' Cell:'.$settings->cell?></span>
								</h5>
								</h1>
								
                            </div>
			 <div class="clearfix"></div>
			 
			 <div class="col-md-2 dates">
			 <div class="widget">
                    <div class="panel-heading dark">
                        
                                                                       
                    </div>                    
                    <div class="events">
                                        
                        
                        <div class="item" style="min-height:80px;">
                            <div class="date" >
                               
								
                            </div>
                           
                        </div>                         
                        
                    </div>
                </div>
                </div>
				<div class="col-md-8">
					   <div class="panel">
                    <div class="panel-heading dark">
                        <div class="icon"><i class="icos-user3"></i></div>
                        <h2>Books Details</h2>
                        <div class="heading-elements">
                            <div class="caption red"><span class="glyphicon glyphicon-info-sign glyphicon glyphicon-calendar"></span></div>
                                <span class="day"><?php echo date('d',$post->created_on);?></span>
                                <span class="month"><?php echo date('M, Y',$post->created_on);?></span>
                        </div>                                              
                    </div>                    
                    <div class="panel-body events">
                        
                        <table class="text-left table table-hover " id="sort_1">
                            <td><b>Category:</b> <span ><?php echo $category[$post->category];?></span></td>
                            <td><b>Title:</b> <span ><?php echo $post->title;?></span></td>
                            <td><b>Author</b> <span ><?php echo $post->author;?></span></td>
                            <td><b>Edition:</b> <span ><?php echo $post->edition;?></span></td>
                            <td><b>Pages:</b> <span ><?php echo $post->pages;?></span></td>
                            <td><b>Memo:</b>
							<span ><?php echo $post->description;?></span>
							</td>
                            
                        </table>                       
                        
                    </div>
                </div>
                   </div>
				   
                   </div>
                    
                </div>

<style>
    @media print{

        .navigation{
            display:none;
        }
 .head{
            display:none;
        }

        .tip{
            display:none !important;
        }
        .dates{
             display:none;
        } 
		.date{
             display:none;
        }
		.item{
             display:none;
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