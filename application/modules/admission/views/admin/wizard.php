<div class="col-md-12">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Admission  </h2>
        <div class="right"> 
            <?php echo anchor('admin/admission/create', '<i class="glyphicon glyphicon-plus">
                </i> New Admission ', 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Admission')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/admission/inactive/', '<i class="glyphicon glyphicon-question-sign"></i> Inactive Students', 'class="btn btn-warning"'); ?>
        </div>
    </div>
    <!--javascript:notify('Wizard','Form #wizard_validate submited')-->
    <div class="block-fluid">
        <form action="javascript:function(){}" method="POST" id="wizard_validate">
           
            <fieldset title="Student Details">                            
                <legend>Biodata</legend>
                <div class="form-group">
                    <div class="col-md-3">First Name:</div>
                    <div class="col-md-4">
                        <?php echo form_input('first_name', $result->first_name, 'class="validate[required,minSize[2]]"'); ?>
                        <span class="bottom">Required, minSize = 2</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">Last Name:</div>
                    <div class="col-md-4">
                        <?php echo form_input('last_name', $result->last_name, 'class="validate[required,minSize[2]]"'); ?>
                        <span class="bottom">Required, minSize = 2</span>
                    </div>
                </div>                                
                <div class="form-group">
                    <div class="col-md-3">Date of Birth:</div>
                    <div class="col-md-4">
                        <div id="datetimepicker1" class="input-group date form_datetime">
                            <?php echo form_input('dob', $result->dob > 0 ? date('d M Y', $result->dob) : $result->dob, 'class=" form-control datepicker col-md-4"'); ?>
                            <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                            <span class="bottom">Required, date</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">Gender:</div>
                    <div class="col-md-4"> 
                        <?php
                        $st = '';
                        if ($result->gender == 1)
                        {
                            $st = 'checked="checked"';
                        }
                        $sf = '';
                        if ($result->gender == 2)
                        {
                            $sf = 'checked="checked"';
                        }
                        ?>
                        <div class = "radio"> <input type = "radio"  <?php echo $st; ?> name = "gender" class = "validate[required]" value = "1"> </div>Male
                        <div class = "radio"> <input type = "radio" <?php echo $sf; ?> name = "gender" value = "2" class = "validate[required]"> </div>Female
                    </div>
                </div>
				 

                <div class = "form-group">
                    <div class = "col-md-3">Passport Photo</div>
                    <div class = "col-md-4">
                        <?php
                        echo form_upload('userfile', '', 'id="userfile" ');
                        echo form_input('photo', $result->photo, ' readonly="readonly" style="display:none" class="col-md-4" id="sphoto" ');
                        ?>
                    </div>
                </div>

                <div class = "form-group">
                    <div class = "col-md-3">Student's E-mail: (Optional)</div>
                    <div class = "col-md-4"> 
                        <?php 
                       $addi =  $updType=='edit'? '' : ',ajax[ajaxUserCallPhp]';
                        echo form_input('email', $result->email, 'class="validate[custom[email] '.$addi.']" id="smail" placeholder="Optional"');
                        ?>
                        <span class="bottom">Valid email - Will be used to Login</span>
                    </div>
                </div>
				
				<div class="form-group">
                    <div class="col-md-3">Former school:</div>
                    <div class="col-md-4">
                        <?php echo form_input('former_school', $result->former_school, 'class=""'); ?>
                        <span class="bottom">Optional</span>
                    </div>
                </div> 
				<div class="form-group">
                    <div class="col-md-3">Entry marks:</div>
                    <div class="col-md-4">
                        <?php echo form_input('entry_marks', $result->entry_marks, 'class=""'); ?>
                        <span class="bottom">Optional</span>
                    </div>
                </div> 
				<div class="form-group">
                    <div class="col-md-3">Allergies:</div>
                    <div class="col-md-4">
						 <textarea name="allergies" class=""><?php echo isset($result) && !empty($result) ? $result->allergies : $this->input->post('allergies'); ?></textarea>
                            <span class="bottom">Optional</span>
                       
                    </div>
                </div>
				<div class="form-group">
                    <div class="col-md-3">Doctor's Name:</div>
                    <div class="col-md-4">
                        <?php echo form_input('doctor_name', $result->doctor_name, ''); ?>
                        <span class="bottom">Optional</span>
                    </div>
                </div> 
				<div class="form-group">
                    <div class="col-md-3">Doctor's Phone:</div>
                    <div class="col-md-4">
                        <?php echo form_input('doctor_phone', $result->doctor_phone, ''); ?>
                        <span class="bottom">Optional</span>
                    </div>
                </div>  
<div class="form-group">
                    <div class="col-md-3">Prefered Hospital:</div>
                    <div class="col-md-4">
                        <?php echo form_input('hospital', $result->hospital, 'class=""'); ?>
                        <span class="bottom">Optional</span>
                    </div>
                </div> 				

            </fieldset>

            <fieldset title="Parent Details">
                <legend>Address & Contact </legend>
                <div class="form-group" id="swtch">
                    <div class="col-md-3">Parent:</div>
                    <div class="col-md-6"> 
                        <div class = "radio"> <input type = "radio" id="pnew"  name = "ptype" class = "validate[required] " <?php echo $updType == 'edit' ? 'disabled="disabled" ' : ''; ?> value = "1"> </div>New Parent
                        <div class = "radio"> <input type = "radio" id="pexists" name = "ptype" value = "2" class = "validate[required]" <?php echo $updType == 'edit' ? 'disabled="disabled" ' : ''; ?>> </div>Existing Parent
                    </div>
                </div>

                <div id="pdrop" style="display: none;">
                    <div class='form-group'>
                        <div class="col-md-3" for='parent_id'>Select Parent <span class='required'>*</span></div>
                        <div class="col-md-4">

                            <?php echo form_dropdown('parent_id', $parents, (isset($result->parent_id)) ? $result->parent_id : '', ' class="select" ');
                            ?><span class="bottom">Required</span>		
                        </div>
                    </div>
                </div>
				
				 <div class="col-md-12">
				 <div class="col-md-6">
                       <h3 style="text-align:center"> 1st Parent's Details (Father)</h3>
                        <div class="form-group">
                            <div class="col-md-3"> First Name: <span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php echo form_input('parent_fname', isset($pero) && !empty($pero) ? $pero->first_name : $this->input->post('parent_fname'), 'class="validate[required,minSize[2]]"'); ?>
                                <span class="bottom">required</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3"> Last Name: <span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php echo form_input('parent_lname', isset($pero) && !empty($pero) ? $pero->last_name : $this->input->post('parent_lname'), 'class="validate[required,minSize[4]]"'); ?>
                                <span class="bottom">required</span>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="col-md-3" for='parent_email'> Email  <span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php echo form_input('parent_email', isset($pero) && !empty($pero) ? $pero->email : $this->input->post('parent_email'), 'id="parent_email"  class="form-control" '); ?>
                                <span class="bottom">Required - Will be used to Login(No Spaces)</span> 
                            </div>
                        </div>
                        <input style="display:none" class="mask_mobile" >    
                        <div class='form-group'>
                            <div class="col-md-3" for='phone'> Phone <span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php echo form_input('phone', isset($pero) && !empty($pero) ? $pero->phone : $this->input->post('phone'), 'id="phone"  class="form-control validate[required,minSize[10]] mask_mobile" '); ?>
                                <span class="bottom">Example: 0720-002-002 </span>

                            </div>
                        </div>
						
						 <div class="form-group">
                            <div class="col-md-3"> Occupation:</div>
                            <div class="col-md-8">
                                <?php echo form_input('occupation', isset($pero) && !empty($pero) ? $pero->occupation : $this->input->post('occupation'), 'class=""'); ?>
                                <span class="bottom">optional</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3"> Address:</div>
                            <div class="col-md-8">
                                <textarea name="address" class=""><?php echo isset($pero) && !empty($pero) ? $pero->address : $this->input->post('address'); ?></textarea>
                                <span class="bottom">Optional</span>
                            </div>
                        </div>  
                   
                    </div>
					  <div class="col-md-6">
					    <h3> 2nd Parent/Guardian (Mother)</h3>
					    <div class="form-group">
                            <div class="col-md-3"> First Name: </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_fname', isset($pero) && !empty($pero) ? $pero->mother_fname : $this->input->post('mother_fname'), 'class=""'); ?>
                                <span class="bottom"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3"> Last Name: </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_lname', isset($pero) && !empty($pero) ? $pero->mother_lname : $this->input->post('mother_lname'), 'class=""'); ?>
                                <span class="bottom"></span>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="col-md-3" for='parent_email'> Email  </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_email', isset($pero) && !empty($pero) ? $pero->mother_email : $this->input->post('mother_email'), 'id="mother_email"  class=" form-control" '); ?>
                                <span class="bottom"></span> 
                            </div>
                        </div>
                        <input style="display:none" class="mask_mobile" >    
                        <div class='form-group'>
                            <div class="col-md-3" for='phone'> Phone </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_phone', isset($pero) && !empty($pero) ? $pero->mother_phone : $this->input->post('mother_phone'), 'id="mother_phone"  class="form-control  mask_mobile" '); ?>
                                <span class="bottom">Example: 0720-002-002 </span>

                            </div>
                        </div>
						
						 <div class="form-group">
                            <div class="col-md-3"> Occupation:</div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_occupation', isset($pero) && !empty($pero) ? $pero->mother_occupation : $this->input->post('mother_occupation'), 'class=""'); ?>
                                <span class="bottom">optional</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3"> Address:</div>
                            <div class="col-md-8">
                                <textarea name="mother_address" class=""><?php echo isset($pero) && !empty($pero) ? $pero->mother_address : $this->input->post('mother_address'); ?></textarea>
                                <span class="bottom"> Optionals</span>
                            </div>
                        </div> 
                    </div>
				
				</div>
				
				
				
				
                <div id="newp" <?php echo $updType == 'edit' ? '' : ' style="display: none;"'; ?>>
                  
                    
                  
					 <input style="display:none" class="mask_mobile" >    
                    <div class='form-group'>
                        <div class="col-md-3" for='phone'></div>
                        <div class="col-md-4">
                           
                        </div>
                    </div>

                    
                </div>
            </fieldset>
			
			
            <fieldset title="Registration Details">
                <legend>Admission Details</legend>
             
                <div class="form-group">
                    <div class="col-md-3">Date of Admission:</div>
                    <div class="col-md-4">
                        <div id="datetimepicker1" class="input-group date form_datetime">
                            <?php echo form_input('admission_date', $result->admission_date > 0 ? date('d M Y', $result->admission_date) : $result->admission_date, 'class="validate[required] datepicker"'); ?>
                            <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span></div>
                        <span class="bottom">Required, date</span>
                    </div>
                </div>

                <div class='form-group'>
                    <div class="col-md-3" for='class'>Class <span class='required'>*</span></div>
                    <div class="col-md-4">
                        <?php
                        $classes = $this->ion_auth->fetch_classes();
                         echo form_dropdown('class', array(''=>'Select Class')+$classes, (isset($result->class)) ? $result->class : '', ' class="select" data-placeholder="Select  Options..." ');
                        ?>		
                    </div>
                </div>

                <div class='form-group' style="">
                    <div class="col-md-3" for='stream'>Current Admission No.</div>
                    <div class="col-md-4">
                        <?php echo form_input('old_adm_no', $result->old_adm_no, 'class="validate[minSize[2]]"'); ?>
                    </div>
                </div>
                <div class='form-group' style="">
                    <div class="col-md-3" for='stream'>Student House</div>
                    <div class="col-md-4">
                        <?php
                         echo form_dropdown('house', $house, (isset($result->house)) ? $result->house : '', ' class="select" ');
                        ?>	
                    </div>
                </div>

            </fieldset>
            
            
            <?php
            if ($updType == 'edit')
            {
                ?>
                <span id='opr' title="<?php echo $rec; ?>"> </span>
            <?php } ?>
            <input type="submit" title="<?php echo $updType; ?>" id="ad_finish" class="btn btn-primary finish" value="Submit" />
            <?php if ($updType == 'edit'): ?>
                <?php echo form_hidden('pid', $pid); ?>
            <?php endif ?>
            <?php echo form_close(); ?>

            <div class="clearfix"></div>
    </div>
</div>


<script>
    $(document).ready(
            function()
            {
                $('#swtch input[type="radio"]').on('click', function()
                {
                    var pt = $(this).attr('value');
                    if (pt == 1)
                    {
                        $('#pdrop').hide();
                        $('#newp').show();
                    }
                    if (pt == 2)
                    {
                        $('#newp').hide();
                        $('#pdrop').show();
                    }

                });
                $('#trswtch input[type="radio"]').on('click', function()
                {
                    var pt = $(this).attr('value');
                    if (pt == 1)
                    {
                        if ($("#tram_val").length > 0)
                        {
                            $('#tram_val').remove();
                        }
                        $('#trswtch span[class="bottom"]').after('<input name="tramount" type="text" class="validate[required]" id="tram_val" style="opacity:100; float:left; width:140px; height:32px; display:block; placeholder="amount"  />')
                    }
                    if (pt == 0)
                    {
                        if ($("#tram_val").length > 0)
                        {
                            $('#tram_val').remove();
                        }
                    }

                });

                $('#smswtch input[type="radio"]').on('click', function()
                {
                    var pt = $(this).attr('value');
                    if (pt == 1)
                    {
                        if ($("#sm_val").length > 0)
                        {
                            $('#sm_val').remove();
                        }
                        $('#smswtch span[class="bottom"]').after('<input name="smamount" type="text" class="validate[required]" id="sm_val" style="opacity:100; float:left; width:140px; height:32px; display:block; placeholder="amount"  />')
                    }
                    if (pt == 0)
                    {
                        if ($("#sm_val").length > 0)
                        {
                            $('#sm_val').remove();
                        }
                    }

                });

                $('#bdswtch input[type="radio"]').on('click', function()
                {
                    var pt = $(this).attr('value');
                    if (pt == 1)
                    {
                        if ($("#bd_val").length > 0)
                        {
                            $('#bd_val').remove();
                        }
                        $('#bdswtch span[class="bottom"]').after('<input name="bdamount" type="text" class="validate[required]" id="bd_val" style="opacity:100; float:left; width:140px; height:32px; display:block; placeholder="amount"  />')
                    }
                    if (pt == 0)
                    {
                        if ($("#bd_val").length > 0)
                        {
                            $('#bd_val').remove();
                        }
                    }

                });

                $('#mlswtch input[type="radio"]').on('click', function()
                {
                    var pt = $(this).attr('value');
                    if (pt == 1)
                    {
                        if ($("#ml_val").length > 0)
                        {
                            $('#ml_val').remove();
                        }
                        $('#mlswtch span[class="bottom"]').after('<input name="mlamount" type="text" class="validate[required]" id="ml_val" style="opacity:100; float:left; width:140px; height:32px; display:block; placeholder="amount" />')
                    }
                    if (pt == 0)
                    {
                        if ($("#ml_val").length > 0)
                        {
                            $('#ml_val').remove();
                        }
                    }

                });

                $('input#userfile').ajaxfileupload({
                    'action': BASE_URL + 'admin/admission/save_photo/',
                    'params': {
                        'extra': 'info'
                    },
                    'onComplete': function(response) {
                        console.log(response);
                        if (response.status !== 'error')
                        {
                            //alert(response.status);
                            $('#files').html('<p>' + response.status + '.</p>');
                            $('#sphoto').val(response.pid);
                        }
                        //alert(JSON.stringify(response));
                    },
                    'onStart': function() {
                        //   if (weWantedTo)
                        //    return false; // cancels upload
                    },
                    'onCancel': function() {
                        console.log('no file selected');
                    }
                });

            });


</script>