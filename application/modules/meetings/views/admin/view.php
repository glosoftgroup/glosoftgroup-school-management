<div class="col-md-6">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title"> Meeting Details </h4>
        <div class="heading-elements">
        
        </div>
    </div>
    
    <div class="panel-body">           
                        
            <div class="col-md-12">
                
                <div class="timeline">
                    
                    <div class="event">
                      
                        <div class="icon"><span class="icos-comments3"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#"> Meeting Title</a> </div>
                             <div class="text"><?php echo $p->title;?></div>
                        </div>
                    </div>    
                    <div class="event">
                        <div class="icon"><span class="icos-calendar"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#"> Date From</a> </div>
                             <div class="text"><?php echo date('d M Y',$p->start_date);?></div>
                        </div>
                    </div>  
                    <div class="event">
                        <div class="icon"><span class="icos-calendar"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#"> Date To</a> </div>
                             <div class="text"><?php echo date('d M Y',$p->end_date);?></div>
                        </div>
                    </div>  
                    <div class="event">
                        <div class="icon"><span class="icos-power"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#"> Venue</a> </div>
                             <div class="text"><?php echo $p->venue;?></div>
                        </div>
                    </div>  
                    <div class="event">
                        <div class="icon"><span class="icos-user3"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#"> Guest(s) Invited</a> </div>
                             <div class="text">
                                <?php 
                                    if($p->type==1){ $u=$this->ion_auth->get_user($p->guests);}
                                    if($p->type==2){ $pr=$this->ion_auth->get_single_parent($p->guests);}
                                        if($p->type==1){
                                          echo $u->first_name.' '.$u->last_name;
                                        }
                                        elseif($p->type==2){
                                         echo $pr->first_name.' '.$pr->last_name;
                                        }
                                        else{
                                        echo $p->guests;
                                        }
                                    ?>
                             </div>
                        </div>
                    </div>  
                       
                    
                    <div class="event">
                       
                        <div class="icon"><span class="icos-meter-fast"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#"> Importance</a></div>
                         
                               <div class="text"><?php echo $p->importance;?></div>
                          
                        </div>
                    </div> 
                    <div class="event">
                       
                        <div class="icon"><span class="icos-clipboard1"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#"> Meeting Description</a></div>
                         
                               <div class="text"><?php echo $p->description;?></div>
                          
                        </div>
                    </div> 
                   <div class="event">                        
                        <div class="icon"><span class="icos-locked"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="head">
                            <a href="#">Created By: </a> <?php  $u=$this->ion_auth->get_user($p->created_by); echo $u->first_name.' '.$u->last_name;?> 
                            <a href="#">Created on: </a> <?php echo date('d M Y',$p->created_on);?></div>                            
                        </div>
                    </div>
                </div>
             </div>
           </div>
    </div>
    </div>
    <div class="col-md-6">
    
    <!-- Pager -->
    <div class="panel panel-white animated fadeIn">
        <div class="panel-heading">
            <h4 class="panel-title"> Meetings</h4>
            <div class="heading-elements">
                <?php echo anchor( 'admin/meetings/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Meetings')), 'class="btn btn-primary"');?>
 <?php echo anchor( 'admin/meetings/calendar' , '<i class="glyphicon glyphicon-calendar"></i> Calendar View', 'class="btn btn-primary"');?> 
<?php echo anchor( 'admin/meetings' , '<i class="glyphicon glyphicon-list"></i> List View', 'class="btn btn-primary"');?>
            </div>
        </div>
        
      
           
                                
              
                 <?php if ($meetings): ?>
               <div class="panel-body">
                <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
     <thead>
                <th>#</th>
                <th>Title</th>
                
                <th>Date</th>
                <th>Guests</th>
            
                <th ><?php echo lang('web_options');?></th>
        </thead>
        <tbody>
        <?php 
                             $i = 0;
                             
            foreach ($meetings as $p ):
                if($p->type==1){ $u=$this->ion_auth->get_user($p->guests);}
                     if($p->type==2){ $pr=$this->ion_auth->get_single_parent($p->guests);}
                                
                 $i++;
                     ?>
     <tr>
                <td><?php echo $i . '.'; ?></td>                    
                <td><?php echo $p->title;?></td>
                    
                    <td>From: <?php echo date('d M Y',$p->start_date);?><br> To: <?php echo date('d M Y',$p->end_date);?></td>
                    <td><?php 
                    if($p->type==1){
                      echo $u->first_name.' '.$u->last_name;
                    }
                    elseif($p->type==2){
                     echo $pr->first_name.' '.$pr->last_name;
                    }
                    else{
                    echo $p->guests;
                    }
                    ?></td>
                    

             <td width='125'>
                     <a class="" href='<?php echo site_url('admin/meetings/view/'.$p->id);?>'><i class='glyphicon glyphicon-chevron-right'></i> Full Details</a>
                        
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>

    
</div>

<?php else: ?>
    <p class='text-center'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
    </div>
    </div>