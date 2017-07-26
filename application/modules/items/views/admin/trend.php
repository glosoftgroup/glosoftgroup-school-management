<div class="col-md-12">	
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h4 class="panel-title">Trend for  <?php echo $item->item_name;?></h4>
		<div class="heading-elements">
			<div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Options</button>
					
					<ul class="dropdown-menu pull-right">
					  <li><a class=""  href="<?php echo base_url('admin/items'); ?>"><i class="glyphicon glyphicon-list-alt"></i> Manage Items</a></li>
					   <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/items_category'); ?>"><i class="glyphicon glyphicon-fullscreen"></i> Manage Items Category</a></li>
					  <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/add_stock/create'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Stock</a></li>
					    <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/stock_taking'); ?>"><i class="glyphicon glyphicon-edit"></i> Stock Taking</a></li>
					   <li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/inventory'); ?>"><i class="glyphicon glyphicon-folder-open"></i> Inventory Listing</a></li>
					</ul>
				</div>
		</div>
	</div>
	
	<div class="panel-body">
                    
	<div class="col-md-5 panel border-left-lg border-left-primary mr-5" style="border:1px solid #000">	
	
	<div class="row">	
	<div class="middle">	
 <div class="informer">
                    <a href="#">
                        <span class="icomg-cart"></span>
                        <span class="text-bold label label-success label-lg">Stock Addition</span>
                    </a>
                    <span class="caption purple">+</span>
                </div>	
                </div>	
                </div>	
  
     <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
<thead>
		    <th>No.</th>
		    <th>Date</th>
			<th>Quantity</th>
			<th>Unit Price</th>
			<th>Total</th>
			<th>Add by</th>

		</thead>
		<tbody>
		<?php $i=1;foreach ($add as $add_stock_m): $user=$this->ion_auth->get_user($add_stock_m->user_id);?>
		<tr class="gradeX">	
                    <td><?php echo $i;?></td>		
		          <td><?php echo date('d M Y',$add_stock_m->day);?></td>
		          
		          <td><?php echo $add_stock_m->quantity;?></td>
					<td><?php echo number_format($add_stock_m->unit_price,2);?></td>
					<td><?php echo number_format($add_stock_m->total,2);?></td>
					<td><?php echo $user->first_name.' '.$user->last_name;?></td>
					
				</tr>
 			<?php $i++; endforeach ?>
		</tbody>

	</table>
</div>

<div class="col-md-5 panel border-left-lg border-left-primary" style="border:1px solid #000">	
  <div class="row">	
	<div class="middle">	
 <div class="informer">
                    <a href="#">
                        <span class="icomg-stats-up"></span>
                        <span class="text text-bold label label-success label-lg">Stock Taking</span>
                    </a>
                    <span class="caption purple">+</span>
                </div>	
                </div>	
                </div>

     <table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
<thead>
		    <th>No.</th>
		    <th>Stock Date</th>
		  
		    <th>Closing Stock</th>
		    <th>Taken On</th>
		    <th>Taken by</th>
		</thead>
		<tbody>
		<?php $i=1;foreach ($take as $stock_taking_m):  $user=$this->ion_auth->get_user($stock_taking_m->created_by); ?>
		<tr class="gradeX">	
                    <td><?php echo $i;?></td>
					<td><?php echo date('d M Y',$stock_taking_m->stock_date);?></td>
                   					
		         <td><?php echo $stock_taking_m->closing_stock;?> Units</td>
					
				 <td><?php echo date('d M, Y',$stock_taking_m->created_on);?></td>
				 <td ><?php echo $user->first_name.' '.$user->last_name; ?></td>
					
				</tr>
 			<?php $i++; endforeach ?>
		</tbody>

	</table>
       
</div>

<div class="col-md-12">
<div class="row">	
	<div class="text-">	
 <div class="informer col-md-3">
    <a href="#">
     <div class="panel border-left-lg border-left-primary">
                      <span class="heading-text badge bg-teal-800">Units</span>
	  					<div class="panel-body">
        <span ><h2><?php echo $add_totals->quantity; ?> </h2></span>
        <span class="text">Total Added Stock</span>
    </a>
    </div>
    </div>
</div>	

                
                	
 <div class="informer col-md-3">
                    <a href="#">
                     <div class="panel border-left-lg border-left-danger">
                      <span class="heading-text badge bg-teal-800">Units</span>
	  					<div class="panel-body">
                         <span ><h2> <?php  
						   $rem = 0;
						  if(!empty($remove_totals->closing_totals)){ 
							$rem  = $remove_totals->closing_totals;
						  }
						  if($rem==0){
						    echo 0;
						  }
						  else{
							 $total_removed=$add_totals->quantity-$rem; 
							 echo $total_removed; 
						 }
						 ?></h2></span>
                        <span class="text">Total Removed Stock</span>
                        </div>
                        </div>
                    </a>
                  
                </div>	
				<div class="button col-md-3">
                        <a href="#">
						
						 <div class="panel border-left-lg border-left-primary">
                      <span class="heading-text badge bg-teal-800">Units</span>
	  					<div class="panel-body">
                           <span > <img src="<?php echo base_url('assets/themes/admin/img/loaders/1d_4.gif'); ?>"  /> </span><br>
                          <span > <img src="<?php echo base_url('assets/themes/admin/img/loaders/1d_4.gif'); ?>"  /> </span>

                          </div>
                          </div>
                        </a>
                       
                    </div>
	<div class="informer col-md-3">
                    <a href="#">
                      <div class="panel border-left-lg border-left-warning">
                      <span class="heading-text badge bg-teal-800">Units</span>
	  					<div class="panel-body">
                         <span ><h2>
						 <?php							
						 if($rem==0){
						    echo $add_totals->quantity;
						  }
						  else{
							 echo  $add_totals->quantity-$total_removed; 							
						 }
						 ?> 
						 </h2>
						 </span>

                        <span class="text">Total Remaining Stock</span>
                       </div>
                       </div>
                    </a>
                    
                </div>	
		</div>	
</div>

</div>
</div>
</div>
