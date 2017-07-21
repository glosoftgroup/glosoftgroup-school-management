<div class="col-md-6">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h4 class="panel-title">Student Details</h4>
		<div class="heading-elements">
		
		</div>
	</div>
	
	<div class="panel-body">
	<!-- horizontal icon-github -->

<div class="row animated fadeIn">
	<div class="col-md-12">
		<div class="panel panel-body">
			<div class="media">
				<div class="media-left">
					<a href="#" data-popup="lightbox">
						<img src="<?php echo base_url('assets/themes/admin/img/examples/users/dmitry_b.jpg'); ?>" class="img-polaroid ">
					</a>
				</div>

				<div class="media-body">
				   <div class="col-md-6">
					<h6 class="media-heading"><?php  
							$class=$this->ion_auth->list_classes();  
							$user=$this->ion_auth->list_student($post->culprit);							
							echo $user->first_name.' '.$user->last_name; 
							?></h6>
					
					<p><i class="icon-envelop5"></i>&nbsp;<?php  echo $user->email;?></p>
					<p><strong>Gender: </strong> <?php  if($user->gender==1) echo 'Male'; else echo 'Female';?></p>
				     </div>
				     <div class="col-md-6">

						<p><strong>ADM No.: </strong> <?php  echo $user->admission_number;?></p>
						<p><strong>ADM Date.:</strong> <?php  echo date('d M Y',$user->admission_date);?></p>	
						
						<p><strong>Class: </strong> <?php  echo $class[$user->class];?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 animated zoomIn">
		<div class="panel border-left-lg border-left-danger invoice-grid timeline-content">
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
						<h6 class="text-semibold no-margin-top">Reported for: </h6>
						<ul class="list list-unstyled">
						    <li><strong>Date Reported:</strong><?php  echo date('d M Y',$post->date_reported);?></li>
							<li> <strong>Reported By :</strong><br> 
							<?php 
									$user=$this->ion_auth->get_user($post->created_by);
									
									if($post->reported_by==''){
									echo $post->others;
									}
									else{
									echo $user->first_name.' '.$user->last_name;
									}
									
									?>
							</li>
							<li><strong>Reason : &nbsp;</strong><br><?php  echo $post->description;?></li>
							<li><strong>ACTION TAKEN :</strong> <?php echo strtoupper($post->action_taken);?></li>
							<li>NO ACTION HAS BEEN TAKEN</li>
							<li><strong>Comment :</strong><br> <?php  echo $post->comment;?>  </li>
							<li><strong>Recorded By: </strong><?php $user=$this->ion_auth->get_user($post->modified_by);   echo $user->first_name.' '.$user->last_name;?></li>
						</ul>
					</div>					
				</div>
			</div>

			<div class="panel-footer panel-footer-condensed">
				<div class="heading-elements">
					<span class="heading-text">
						<strong>Created By: </strong>
									<?php $user=$this->ion_auth->get_user($post->created_by);   echo $user->first_name.' '.$user->last_name;?>
					</span>

					<ul class="list-inline list-inline-condensed heading-text pull-right">
						<li>
							<span class="status-mark border-danger position-left"></span> Date Punished:  <span class="text-semibold"><?php  echo date('d M Y',$post->date_reported);?></span>
						</li>						
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

	</div>
</div>

</div>
<!-- right -->
<div class="col-md-6 animated fadeIn">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
	<div class="panel-heading">
		<h5 class="panel-title"> Disciplinary</h5>
		<div class="heading-elements">
			   <?php echo anchor( 'admin/disciplinary/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => ' New Disciplinary')), 'class="btn btn-primary"');?>
                <?php echo anchor( 'admin/disciplinary/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
		</div>
	</div>
	
	<div class="panel-body">
	 <?php if ($disciplinary): ?>              
               <div class="block-fluid">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">


 
	 <thead>
	 <tr class="bg-primary">
                <th>#</th>
				<th>Repored on</th>
				<th>Culprit</th>
				
				<th>Status</th>
				
				<th><?php echo lang('web_options');?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                              
                
            foreach ($disciplinary as $p ): 
                 $i++;
				 $user=$this->ion_auth->students_full_details();
                     ?>
	 <tr>
					<td><?php echo $i . '.'; ?></td>					
					<td><?php echo date('d/m/Y',$p->date_reported);?></td>
					<td><?php echo $user[$p->culprit];?></td>
					
					<td width="20%">
					<?php  
					if(!empty($p->action_taken)){
					echo '<span class="label label-success">Action Taken</span>';
					}
					else{ echo '<span class="label label-warning">Pending </span>';}
					?>
					</td>
	             <td width="20%">
							<a href="<?php echo site_url('admin/disciplinary/view/'.$p->id);?>"><i class="glyphicon glyphicon-eye-open"></i> View</a>
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



</div>



