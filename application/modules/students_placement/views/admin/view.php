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
						<?php
						$user=$this->ion_auth->list_student($post->student);
						$passport = $this->ion_auth->passport($user->photo);
						if(!empty($user->photo)):?>	
						<image src="<?php echo base_url('uploads/'.$passport->fpath.'/'.$passport->filename);?>" width="80" height="80" class="img-circle" >

						 <?php else:?>   
						   <?php echo theme_image("thumb.png", array('class'=>"img-polaroid",'style'=>"width:100px; height:100px; align:left"));?>
											 
						<?php endif;?>
					</a>
				</div>

				<div class="media-body">
				   <div class="col-md-6">
					<h6 class="media-heading"><?php  $class=$this->ion_auth->list_classes();   echo $user->first_name.' '.$user->last_name; ?></h6>
					<p class="text-muted"><?php echo strtoupper($position[$post->position]);?></p>
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
						<h6 class="text-semibold no-margin-top"><?php echo strtoupper($position[$post->position]);?></h6>
						<ul class="list list-unstyled">
							<li><strong>Representing: &nbsp;</strong><?php if($post->student_class=="Others") echo 'Others'; else echo $class[$post->student_class];?></li>
							<li> <strong>Description :</strong><br> <?php  echo $post->description;?> </li>
						</ul>
					</div>					
				</div>
			</div>

			<div class="panel-footer panel-footer-condensed">
				<div class="heading-elements">
					<span class="heading-text">
						<span class="status-mark border-danger position-left"></span> From: <span class="text-semibold"><?php  echo date('d M Y',$post->start_date);?></span>
					</span>

					<ul class="list-inline list-inline-condensed heading-text pull-right">
						<li>
							<span class="status-mark border-danger position-left"></span> To: <span class="text-semibold"><?php  echo date('d M Y',$post->duration);?></span>
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
		<h5 class="panel-title"> Placement</h5>
		<div class="heading-elements">
			  <?php echo anchor( 'admin/students_placement/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => ' New Students Placement')), 'class="btn btn-primary"');?>
              <?php echo anchor( 'admin/students_placement/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
		</div>
	</div>
	
	<div class="panel-body">
	 <?php if ($students_placement): ?>              
               <div class="block-fluid">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">

 
	 <thead>
	    <tr class="bg-primary">
                <th>#</th>
				<th>Student</th>	
				<th>Position</th>	
				<th>Class</th>	
				<th><?php echo lang('web_options');?></th>
		</tr>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                       
                
            foreach ($students_placement as $p ): 
                 $i++;
				  $user=$this->ion_auth->list_student($p->student);
				  $class=$this->ion_auth->list_classes();
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $user->first_name.' '.$user->last_name;?></td>
				<td><?php echo $position[$p->position];?></td>
				<td><?php if($post->student_class=="Others") echo 'Others'; else echo $class[$post->student_class];?></td>
				
					  <td width="20%">
	                  <a href="<?php echo site_url('admin/students_placement/view/'.$p->id);?>"><i class="glyphicon glyphicon-eye-open"></i> View</a>
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



