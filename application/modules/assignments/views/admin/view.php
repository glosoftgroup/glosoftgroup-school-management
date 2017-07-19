<div class="col-md-4">
	<!-- Pager -->
	<div class="panel panel-white">
		<div class="panel-heading">
			<h6 class="panel-title">Assignment Details </h6>
			<div class="heading-elements">
				<?php echo anchor( 'admin/assignments/edit/'.$p->id , '<i class="glyphicon glyphicon-edit"></i> Edit Details', 'class="btn btn-primary"');?>

			</div>
		</div>

		<div class="panel-body">
            <div class="col-md-12">
                <div class="timeline">
				  <div class="timeline-container">
                   <div class="timeline-row post-even">
		<div class="timelineicon">

		</div>
		<div class="timeline-time">
			<a href="#"><?php  $u=$this->ion_auth->get_user($p->created_by); echo $u->first_name.' '.$u->last_name;?></a>
			<span class="text-muted"><?php echo date('d M Y',$p->created_on);?></span>
		</div>

		<div class="panel border-left-lg border-left-success timeline-content">
			<div class="panel-heading">
				<h6 class="panel-title"><div class="text"><?php echo $p->title;?></div></h6>
		    </div>

			<div class="panel-body">

				<div class="body">
					<div class="arrow"></div>
					<div class="user"><a href="#"> Date To</a> </div>
					 <div class="text"><?php echo date('d M Y',$p->end_date);?></div>
				</div>
			    <h6>Comment</56>
				<div class="text"><?php echo $p->comment;?></div>
				<div class="user"><a href="#"> Assignment To</a> </div>
                <div class="text">
					 <?php
					 $class_id=$this->assignments_m->get_classes($p->id);
					 $class=$this->ion_auth->classes_and_stream();
					 $i = 0;
					  foreach($class_id as $c){
					   $i++;
					  echo $i.'. '.$class[$c->class].'<br>';

					  }
					?>
				</div>
				 <div class="body">
					<div class="arrow"></div>
					<div class="user"><a href="#"> Attachment</a> </div>
					 <div class="text">
						<?php if(!empty($p->document)){?>
						<a href="<?php echo base_url('uploads/files/'.$p->document);?>"><i class="glyphicon glyphicon-download"></i> Download Attachment</a>
						<?php } else {?>
						<b >No Attachment</b>
						<?php } ?>

					 </div>
				</div>
			</div>
		</div>
</div>
                 </div>
				</div>
             </div>
           </div>
    </div>
	</div>
	<div class="col-md-8">

	<!-- Pager -->
		<div class="panel panel-white">
			<div class="panel-heading">
				<h6 class="panel-title">Assignment</h6>
				<div class="heading-elements">
				   <?php echo anchor( 'admin/assignments/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Assignment')), 'class="btn btn-primary"');?>

					<?php echo anchor( 'admin/assignments' , '<i class="glyphicon glyphicon-list"></i> List View', 'class="btn btn-primary"');?>
				</div>
			</div>

			<div class="panel-body">


				 <?php echo $p->assignment; ?>


			</div>
	     </div>
	</div>
