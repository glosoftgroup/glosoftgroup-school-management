 <!-----------------------------ADD MODAL------------------------->
<div class="modal fade" id="Upload" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<form action="<?php echo base_url('admin/uploads/upload_students_only');?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Upload Students</h4>
				<div class="clearfix"></div>
			</div>
		

			<div class='form-group'>
				<div class='col-md-1 ' for='survey_date'> 
				</div>
				<label class='col-md-9 control-label' for='survey_date'> 
				Choose CSV File <br>
				Click <a href="<?php echo base_url('uploads/Sample_Students_Upload_File.xlsx')?>">here</a> to download Sample file
				<span class='error'>*</span>
				</label>
				<div class="col-md-12">
				 <hr class="col-md-11">
				<div class="col-md-8">
							
                                <?php echo form_dropdown('campus_id', array(''=>'Select Campus/School')+$campus, (isset($result->campus_id)) ? $result->campus_id : '', ' class="select" ');
                                ?>	
                            </div>
				 <div class="col-md-8">
				 <hr>
                                <?php

                                $classes = $this->ion_auth->fetch_classes();
                                echo form_dropdown('class',array(''=>'Select Class')+ $classes, (isset($result->class)) ? $result->class : '', ' class="select" data-placeholder="Select  Options..." ');

                                ?>
								<hr>		
                            </div>
							
							 
							
							 <div class="col-md-8">
							 <hr>
							 Choose the CSV File to upload
				 <input name="csv" type="file" id="csv" /> <br>
				 </div>
				
			</div>
			</div> 

<div class="modal-footer">

				<button type="submit" class="btn btn-primary">
					Save Changes
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">
					Close
				</button>
				</div>
			</form> 
			</div>
			</div>
			</div>
			
			<div class="modal fade" id="Upload_paro" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog7">
			<form action="<?php echo base_url('admin/uploads/upload_pp');?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Upload Parents</h4>
				<div class="clearfix"></div>
			</div>
		

			<div class='form-group'>
				<div class='col-md-1 ' for='survey_date'> 
				</div>
				<label class='col-md-9 control-label' for='survey_date'> 
				Choose CSV File <br>
				Click <a href="#">here</a> to download Sample file
				<span class='error'>*</span>
				</label>
				<div class="col-md-12">
				 <input name="csv" type="file" id="csv" /> <br>
			</div>
			</div>
			
<div class="modal-footer">
				<button type="submit" class="btn btn-primary">
					Save Changes
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">
					Close
				</button>
				</div>
			</form> 
			</div>
			</div>
			</div>


<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Uploads  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/uploads/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Uploads')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/uploads' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Uploads')), 'class="btn btn-primary"');?> 
				
             <a data-toggle="modal" style='' class="btn btn-success" role="button" href="#Upload">
				<i class='glyphicon glyphicon-share'></i> Upload Students
			  </a>
			  <a data-toggle="modal" style='' class="btn btn-success" role="button" href="#Upload_paro">
				<i class='glyphicon glyphicon-share'></i> Upload Parents
			  </a>
                </div>
                </div>
         	                    
              
                 <?php if ($uploads): ?>
                 <div class="block-fluid">
				<table class="table table-hover fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th><th>Name</th><th>Description</th>	<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($uploads as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					<td><?php echo $p->name;?></td>
					<td><?php echo $p->description;?></td>

			 <td width='20%'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/uploads/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/uploads/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/uploads/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
							</ul>
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text-center'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>