
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title">Book Details</h4>
        <div class="heading-elements">
           <button onClick="return false;" id="printBtn" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
                      <?php echo anchor( 'admin/books/list_view/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
        </div>
    </div>
    
    <div class="panel-body">
                   
                    
                    <div class="block invoice1" id='printme'>
					
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
                    <div class="head dark">
                        <div class="icon"><i class="icos-user3"></i></div>
                        
                                                                        
                    </div>                    
                    <div class="block-fluid events">                     
                        
                        <div class="item" style="min-height:80px;">
                            <div class="date" >
                                <div class="caption red"></div>
                                
								
                            </div>
                           
                        </div>                         
                        
                    </div>
                </div>
                </div>
				<div class="col-md-8">
					   <div class="widget">
                    <div class="panel-heading">
                        <div class="icon"><i class="icos-user3"></i></div>
                        <h2>Books Details</h2>
                        <div class="heading-elements">
                        <strong>Added on :<span class="glyphicon glyphicon-info-sign glyphicon glyphicon-calendar"></span></strong>
                        <span class="day"><?php echo date('d',$post->created_on);?></span>
                                <span class="month"><?php echo date('M, Y',$post->created_on);?></span>
                        </div>
                                                                      
                    </div>                    
                    <div class="block-fluid events">
                        
                        <table class="table table-hover table-bordered" id="sort_1">
                          <tbody>
                             <tr>
                              <td><b>Category:</b></td>
                              <td><?php echo $category[$post->category];?></td>
                             </tr>
                             <tr>
                              <td><b>Title:</b></td>
                              <td><?php echo $post->title;?></td>
                             </tr>
                             <tr>
                              <td><b>Author:</b></td>
                              <td><?php echo $post->author;?></td>
                             </tr>
                             <tr>
                              <td><b>Publisher:</b></td>
                              <td><?php echo $post->author;?></td>
                             </tr>
                             <tr>
                              <td><b>Year Published:</b></td>
                              <td><?php echo $post->year_published;?></td>
                             </tr>
                             <tr>
                              <td><b>ISBN No.:</b></td>
                              <td><?php echo $post->isbn_number;?></td>
                             </tr>
                              <tr>
                              <td><b>Edition:</b></td>
                              <td><?php echo $post->edition;?></td>
                             </tr>
                             <tr>
                              <td><b>Pages:</b></td>
                              <td><?php echo $post->pages;?></td>
                             </tr>
                             <tr>
                              <td><b>Copyright:</b></td>
                              <td><?php echo $post->copyright;?></td>
                             </tr>
                             <tr>
                              <td><b>Shelf:</b></td>
                              <td><?php echo $post->shelf;?></td>
                             </tr>
                             <tr>
                              <td><b>Memo:</b></td>
                              <td><?php echo $post->memo;?></td>
                             </tr>


                          </tbody>
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