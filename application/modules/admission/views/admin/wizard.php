<?=core_js('core/js/plugins/forms/wizards/stepy.min.js'); ?>
<?=core_js('core/js/pages/wizard_stepy.js');?> 
<div class="col-md-12">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h6 class="panel-title">Admission</h6>
        <div class="heading-elements">
             <?php echo anchor('admin/admission/create', '<i class="glyphicon glyphicon-plus">
                </i> New Admission ', 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Admission')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/admission/inactive/', '<i class="glyphicon glyphicon-question-sign"></i> Inactive Students', 'class="btn btn-warning"'); ?>        
        </div>
    </div>
    
    <div class="panel-body">
    <form action="javascript:function(){}" method="POST" id="wizard_validate">

            <fieldset title="Student Details">
                <legend>Biodata</legend>
            <div class="row">
             <div class='col-md-6'>
                <div class="form-group">
                    <label>First Name: </label>                   
                        <?php echo form_input('first_name', $result->first_name, 'class="form-control validate[required,minSize[2]]"'); ?>
                        <span class="bottom">Required, minSize = 2</span>
                   
                </div>
                <div class="form-group">
                   <label>Last Name:</label>
                   
                        <?php echo form_input('last_name', $result->last_name, 'class="form-control validate[required,minSize[2]]"'); ?>
                        <span class="bottom">Required, minSize = 2</span>
                  
                </div>
                <div class="form-group">
                   <label>Date of Birth:</label>
                    
                        <div id="datetimepicker1" class="input-group date form_datetime">
                            <?php echo form_input('dob', $result->dob > 0 ? date('d M Y', $result->dob) : $result->dob, 'class=" form-control datepicker col-md-4"'); ?>
                            <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                            <span class="bottom">Required, date</span>
                        </div>
                   
                </div>
                <div class="form-group">
                   <label>Gender:</label>
                    
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
                        <div class = "radio">
                            <label>
                             <input type = "radio" style="position: static;"  <?php echo $st; ?> name = "gender" class = "styled validate[required]" value = "1">
                                    Male
                            </label>
                         </div>
                        <div class = "radio">
                         <label>
                             <input type = "radio" style="position: static;" <?php echo $sf; ?> name = "gender" value = "2" class = "styled validate[required]"> 
                             Female 
                         </label>                        
                        </div>

                    
                </div>


                <div class = "form-group">
                    <label>Passport Photo</label>
                    
                        <?php
                        echo form_upload('userfile', '', 'id="userfile" class="file-styled-primary" ');
                        echo form_input('photo', $result->photo, ' readonly="readonly" style="display:none" class="col-md-4" id="sphoto" ');
                        ?>
                    
                </div>

                <div class = "form-group">
                   <label>Student's E-mail: (Optional)</label>
                    
                        <?php
                       $addi =  $updType=='edit'? '' : ',ajax[ajaxUserCallPhp]';
                        echo form_input('email', $result->email, 'class="form-control validate[custom[email] '.$addi.']" id="smail" placeholder="Optional"');
                        ?>
                        <span class="bottom">Valid email - Will be used to Login</span>
                  
                </div>
            </div>
            <div class='col-md-6'>

                <div class="form-group">
                    <label>Former school:</label>
                    
                        <?php echo form_input('former_school', $result->former_school, 'class="form-control"'); ?>
                        <span class="bottom">Optional</span>
                   
                </div>
                <div class="form-group">
                   <label>Entry marks:</label>
                    
                        <?php echo form_input('entry_marks', $result->entry_marks, 'class="form-control"'); ?>
                        <span class="bottom">Optional</span>
                   
                </div>
                <div class="form-group">
                   <label>Allergies:</label>
                   
                         <textarea name="allergies" class="form-control"><?php echo isset($result) && !empty($result) ? $result->allergies : $this->input->post('allergies'); ?></textarea>
                            <span class="bottom">Optional</span>

                  
                </div>
                <div class="form-group">
                    <label>Doctor's Name:</label>
                   
                        <?php echo form_input('doctor_name', $result->doctor_name, 'class="form-control"'); ?>
                        <span class="bottom">Optional</span>
                   
                </div>
                <div class="form-group">
                    <label>Doctor's Phone:</label>
                    
                        <?php echo form_input('doctor_phone', $result->doctor_phone, 'class="form-control"'); ?>
                        <span class="bottom">Optional</span>
                    
                </div>
              <div class="form-group">
                    <label>Prefered Hospital:</label>
                    
                        <?php echo form_input('hospital', $result->hospital, 'class="form-control"'); ?>
                        <span class="bottom">Optional</span>
                   
                </div>
            </div>
            </div>
            </fieldset>

            <fieldset title="Parent Details">
                <legend>Address & Contact </legend>
            
                <div class="form-group" id="swtch">
                    <label>Parent:</label>
                   
                        <div class = "radio"> <input type = "radio" id="pnew"  name = "ptype" class = "validate[required] " <?php echo $updType == 'edit' ? 'disabled="disabled" ' : ''; ?> value = "1"> </div>New Parent
                        <div class = "radio"> <input type = "radio" id="pexists" name = "ptype" value = "2" class = "validate[required]" <?php echo $updType == 'edit' ? 'disabled="disabled" ' : ''; ?>> </div>Existing Parent
                   
                </div>

                <div id="pdrop" style="display: none;">
                    <div class='form-group'>
                        <label>Select Parent <span class='required'>*</span></label>
                       
                            <?php echo form_dropdown('parent_id', $parents, (isset($result->parent_id)) ? $result->parent_id : '', ' class="select" ');
                            ?><span class="bottom">Required</span>
                     
                    </div>
                </div>

                 <div class="col-md-12">
                 <div class="col-md-6">
                       <h3 style="text-align:center"> 1st Parent's Details (Father)</h3>
                        <div class="form-group">
                            <div class="col-md-3"> First Name: <span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php echo form_input('parent_fname', isset($pero) && !empty($pero) ? $pero->first_name : $this->input->post('parent_fname'), 'class="form-control validate[required,minSize[2]]"'); ?>
                                <span class="bottom">required</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3"> Last Name: <span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php echo form_input('parent_lname', isset($pero) && !empty($pero) ? $pero->last_name : $this->input->post('parent_lname'), 'class="form-control validate[required,minSize[4]]"'); ?>
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
                                <?php echo form_input('occupation', isset($pero) && !empty($pero) ? $pero->occupation : $this->input->post('occupation'), 'class="form-control"'); ?>
                                <span class="bottom">optional</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3"> Address:</div>
                            <div class="col-md-8">
                                <textarea name="address" class="form-control"><?php echo isset($pero) && !empty($pero) ? $pero->address : $this->input->post('address'); ?></textarea>
                                <span class="bottom">Optional</span>
                            </div>
                        </div>

                    </div>
                      <div class="col-md-6">
                        <h3> 2nd Parent/Guardian (Mother)</h3>
                        <div class="form-group">
                            <div class="col-md-3"> First Name: </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_fname', isset($pero) && !empty($pero) ? $pero->mother_fname : $this->input->post('mother_fname'), 'class="form-control"'); ?>
                                <span class="bottom"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3"> Last Name: </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_lname', isset($pero) && !empty($pero) ? $pero->mother_lname : $this->input->post('mother_lname'), 'class="form-control"'); ?>
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
                                <?php echo form_input('mother_occupation', isset($pero) && !empty($pero) ? $pero->mother_occupation : $this->input->post('mother_occupation'), 'class="form-control"'); ?>
                                <span class="bottom">optional</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3"> Address:</div>
                            <div class="col-md-8">
                                <textarea name="mother_address" class="form-control"><?php echo isset($pero) && !empty($pero) ? $pero->mother_address : $this->input->post('mother_address'); ?></textarea>
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
            <div class="row">
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
                        <?php echo form_input('old_adm_no', $result->old_adm_no, 'class="form-control validate[minSize[2]]"'); ?>
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
<style type="text/css">
    .stepwizard-step p {
        margin-top: 10px;
    }
    .stepwizard-row {
        display: table-row;
    }
    .stepwizard {
        display: table;
        width: 50%;
        position: relative;
    }
    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }
    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }
    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 3px;
        font-size: 12px;
        border-radius: 50%;
    }
    h4 {
        font-size: 17.5px;
        margin: 10px 0;
        font-family: inherit;
        font-weight: bold;
        line-height: 3px;
        color: inherit;
    }

.formError {
    z-index: 990;
}
.formError .formErrorContent {
    z-index: 991;
}
.formError .formErrorArrow {
    z-index: 996;
}
.ui-dialog .formError {
    z-index: 5000;
}
.ui-dialog .formError .formErrorContent {
    z-index: 5001;
}
.ui-dialog .formError .formErrorArrow {
    z-index: 5006;
}
.inputContainer {
    float: left;
    position: relative;
}
.formError {
    cursor: pointer;
    display: block;
    left: 300px;
    position: absolute;
    text-align: left;
    top: 300px;
}
.formError.inline {
    display: inline-block;
    left: 0;
    position: relative;
    top: 0;
}
.ajaxSubmit {
    background: #55ea55 none repeat scroll 0 0;
    border: 1px solid #999;
    display: none;
    padding: 20px;
}
.formError .formErrorContent {
    background: #ee0101 none repeat scroll 0 0;
    border: 2px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 0 6px #000;
    color: #fff;
    font-size: 11px;
    min-width: 120px;
    padding: 4px 10px;
    position: relative;
    width: 100%;
}
.formError.inline .formErrorContent {
    border: medium none;
    border-radius: 0;
    box-shadow: none;
}
.greenPopup .formErrorContent {
    background: #33be40 none repeat scroll 0 0;
}
.blackPopup .formErrorContent {
    background: #393939 none repeat scroll 0 0;
    color: #fff;
}
.formError .formErrorArrow {
    margin: -2px 0 0 13px;
    position: relative;
    width: 15px;
}
body[dir="rtl"] .formError .formErrorArrow, body.rtl .formError .formErrorArrow {
    margin: -2px 13px 0 0;
}
.formError .formErrorArrowBottom {
    box-shadow: none;
    margin: 0 0 0 12px;
    top: 2px;
}
.formError .formErrorArrow div {
    background: #ee0101 none repeat scroll 0 0;
    border-left: 2px solid #ddd;
    border-right: 2px solid #ddd;
    box-shadow: 0 2px 3px #444;
    display: block;
    font-size: 0;
    height: 1px;
    line-height: 0;
    margin: 0 auto;
}
.formError .formErrorArrowBottom div {
    box-shadow: none;
}
.greenPopup .formErrorArrow div {
    background: #33be40 none repeat scroll 0 0;
}
.blackPopup .formErrorArrow div {
    background: #393939 none repeat scroll 0 0;
    color: #fff;
}
.formError .formErrorArrow .line10 {
    border: medium none;
    width: 13px;
}
.formError .formErrorArrow .line9 {
    border: medium none;
    width: 11px;
}
.formError .formErrorArrow .line8 {
    width: 11px;
}
.formError .formErrorArrow .line7 {
    width: 9px;
}
.formError .formErrorArrow .line6 {
    width: 7px;
}
.formError .formErrorArrow .line5 {
    width: 5px;
}
.formError .formErrorArrow .line4 {
    width: 3px;
}
.formError .formErrorArrow .line3 {
    border-bottom: 0 solid #ddd;
    border-left: 2px solid #ddd;
    border-right: 2px solid #ddd;
    width: 1px;
}
.formError .formErrorArrow .line2 {
    background: #ddd none repeat scroll 0 0;
    border: medium none;
    width: 3px;
}
.formError .formErrorArrow .line1 {
    background: #ddd none repeat scroll 0 0;
    border: medium none;
    width: 1px;
}

</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('.button-next').addClass('btn btn-primary');
    });
</script>