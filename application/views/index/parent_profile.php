<div class="col-md-12 whitebg">
    <?php
    $u = $this->ion_auth->get_user();
    $user = $this->ion_auth->parent_profile($u->id);
	
    ?> 
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">

            <div class="widget1">
                <div class="profile clearfix">
                    <div class="image sps center">
                        <img src="<?php echo base_url('assets/themes/admin/img/2.png'); ?>" width="100" height="100"class="img-polaroid"/>
                    </div>                        
                    <div class="info-s">
                        <h3><?php echo trim($user->first_name . ' ' . $user->last_name); ?></h3>
                    
                        <p><strong>Email:</strong> <?php echo $user->email; ?></p>
                        <p><strong>Phone:</strong> <?php echo $user->phone; ?></p>
                        <p><strong>Occupation:</strong> <?php echo $user->occupation; ?></p>
                        <p><strong>Registration Date:</strong> <?php echo $user->created_on > 0 ? date('d M Y H:i', $user->created_on) : ' - '; ?></p>
						<p><strong>Address:</strong> <?php echo $user->address; ?></p>
                       
                    </div>

                </div>
            </div>
        </div>
		<div class="col-md-4 col-sm-4 col-xs-12">

            <div class="widget1">
                <div class="profile clearfix">
                    <div class="image sps center">
                        <img src="<?php echo base_url('assets/themes/admin/img/3.png'); ?>" width="100" height="100"class="img-polaroid"/>
                    </div>                        
                    <div class="info-s">
                        <h3><?php echo trim($user->mother_fname . ' ' . $user->mother_lname); ?></h3>
                    
                        <p><strong>Email:</strong> <?php echo $user->mother_email; ?></p>
                        <p><strong>Phone:</strong> <?php echo $user->mother_phone; ?></p>
                        <p><strong>Occupation:</strong> <?php echo $user->mother_occupation; ?></p>
                        <p><strong>Registration Date:</strong> <?php echo $user->created_on > 0 ? date('d M Y H:i', $user->created_on) : ' - '; ?></p>
						
                        <p><strong>Address:</strong> <?php echo $user->mother_address; ?></p>
                       
                    </div>

                </div>
            </div>
        </div>
		
		<div class="col-md-8 col-sm-8 col-xs-8">
		<hr>
		</div>

		 <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo form_open_multipart('index/update_parent', $attributes);
    ?>
		<div class="col-md-4 col-sm-4 col-xs-4">
		<hr>
		<h3>Parent/Guardian 1</h3>
		<hr>
		<div class="block-fluid">

   
 
    <div class='form-group'>
        <div class='col-md-3' for='email'>Email <span class='required'>*</span></div>
        <div class="col-md-4">
           <?php echo form_input('email' ,$user->email, 'id="email"  class="form-control" ' );?>
            <?php echo form_error('email', '<p class="required">', '</p>'); ?>
        </div>
    </div>
	
       <div class='form-group'>
	<div class="col-md-3" for='phone'>Phone </div><div class="col-md-4">
	<?php echo form_input('phone' ,$user->phone, 'id="phone"  class="form-control" ' );?>
 	<?php echo form_error('phone'); ?>
</div>
</div>
  <div class='form-group'>
	<div class="col-md-3" for='phone'>Occupation </div><div class="col-md-4">
	<?php echo form_input('occupation' ,$user->occupation, 'id="occupation_"  class="form-control" ' );?>
 	<?php echo form_error('occupation'); ?>
</div>
</div>	 

<div class="clearfix"></div>
<div class=' col-md-9'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	Address and other important details</div>
	 <div class="block-fluid editor">
	<textarea id="address"   style="height: 150px;"  class=" form-control "  name="address"  /><?php echo $user->address; ?></textarea>
	<?php echo form_error('address'); ?>
</div>
</div>
<br>

</div>

        </div>
		
		<div class="col-md-4 col-sm-4 col-xs-4">
		<hr>
		<h3>Parent/Guardian 2</h3>
		<hr>
		
		<div class="block-fluid">

   
 
    <div class='form-group'>
        <div class='col-md-3' for='email'>Email <span class='required'>*</span></div>
        <div class="col-md-4">
           <?php echo form_input('mother_email' ,$user->mother_email , 'id="email"  class="form-control" ' );?>
            <?php echo form_error('email', '<p class="required">', '</p>'); ?>
        </div>
    </div>
	
       <div class='form-group'>
	<div class="col-md-3" for='phone'>Phone </div><div class="col-md-4">
	<?php echo form_input('mother_phone' ,$user->mother_phone , 'id="phone"  class="form-control" ' );?>
 	<?php echo form_error('phone'); ?>
</div>
</div>
  <div class='form-group'>
	<div class="col-md-3" for='phone'>Occupation </div><div class="col-md-4">
	<?php echo form_input('mother_occupation' ,$user->mother_occupation , 'id="mother_occupation"  class="form-control" ' );?>
 	<?php echo form_error('mother_occupation'); ?>
</div>
</div>	 

<div class="clearfix"></div>
<div class=' col-md-9'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	Address and other important details</div>
	 <div class="block-fluid editor">
	<textarea id="address"   style="height: 150px;" class=" form-control "  name="mother_address"  /><?php echo $user->mother_address; ?></textarea>
	<?php echo form_error('mother_address'); ?>
</div>
</div>
<br>
<div class="clearfix"></div>
    <div class='form-group'><div class="control-div"></div><div class="col-md-4">
             <?php echo form_submit('submit', 'Update Profile Details', "id='submit' class='btn btn-primary'"); ?> 
            <?php echo anchor('account', 'Cancel', 'class="btn  btn-default"'); ?>
        </div></div>


    <?php echo form_close(); ?>
    <div class="clearfix"></div>
</div>

        </div>
		

      

    </div>
</div>
<?php /* <div class="col-md-6">

  <div class="timeline">

  <div class="event">
  <div class="date red">15<span>min ago</span></div>
  <div class="icon"><span class="icos-comments3"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head">Leave comment on <a href="img/examples/photo/example_3.jpg" class="fb">image</a>:</div>
  <div class="text">Really great!!! I like it! What kind of lens do you use???</div>
  </div>
  </div>


  <div class="event">
  <div class="date">18<span>April</span></div>
  <div class="icon"><span class="icos-user3"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head">Change image to:</div>
  <div class="text">
  <?php echo theme_image('member.png', array('class' => "img-polaroid")); ?>
  </div>
  </div>
  </div>
  <div class="event">
  <div class="date">16<span>April</span></div>
  <div class="icon"><span class="icos-clipboard1"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head">Add new article in <a href="#">category</a>:</div>
  <div class="text typography">
  <h5>Lorem ipsum dolor, sit amet</h5>
  <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure.</p>
  <?php echo theme_image('examples/photo/example_7s.jpg', array('class' => "img-polaroid")); ?>
  </div>
  </div>
  </div>

  <div class="event">
  <div class="date">12<span>April</span></div>
  <div class="icon"><span class="icos-power"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head">Request technical support:</div>
  <div class="text">
  I need MySQL dump! Quickly!!! Cause customers will kill me, if i don't give it...
  </div>
  </div>
  </div>

  <div class="event">
  <div class="icon"><span class="icos-arrow-down4"></span></div>
  <div class="body">
  <div class="arrow"></div>
  <div class="head"><a href="#">Older</a></div>
  </div>
  </div>

  </div>

  </div> */ ?>
 