  <?php $settings = $this->ion_auth->settings(); ?>
<div class="row">
    <div class="col-md-12">
      
        <div class="xs-margin"></div><!-- space -->
       <?php echo form_open(current_url(), 'id="register-form" '); ?> 
            <div class="row">

                <div class="col-md-6 col-sm-6 col-xs-12">
				
				  <div class="center">
                         <img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" class="center lg" align="center" width="150" height="100" />
						 <h2 class=""><?php echo $settings->school; ?></h2>
						 <br>
						   <?php
                              if (!empty($settings->tel))
                              {
                                   echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' ' . $settings->cell;
                              }
                              else
                              {
                                   echo $settings->postal_addr . ' Cell:' . $settings->cell;
                              }
                              ?>
							  <br>
							   <?php echo $settings->email; ?>
							  </span>
							 <br> 
							 <br> 
                       <h2 class="sub-title">SCHOOl MOTTO</h2>
                        <?php echo $settings->motto; ?>
                  
                    </div>
				 
                       
                      
                   
					
					
                    
					 
				</div>
				
				
                <div class="col-md-6 col-sm-6 col-xs-12">
				  <header class="content-title">
            <h1 class="title">Account Login</h1>
            <p class="title-desc">Please Login to your Account. </p>
        </header>
		
                     <?php
        $str = is_array($message) ? $message['text'] : $message;
        echo (isset($message) && !empty($message)) ? '
                        <div class="alert alert-danger "> 
                <button type="button" class="close" data-dismiss="alert">
                    <i class="glyphicon glyphicon-remove"></i>
                </button> ' . $str . '   
            </div>' : '';
        ?> 
                    <fieldset>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="input-icon input-glyphicon glyphicon-email"></span>
                                <span class="input-text">Email&#42;</span></span>
                            <input type="text" name='email' class="form-control input-lg" placeholder="Your Email">
                        </div><!-- End .input-group -->
                        <div class="input-group">
                            <span class="input-group-addon"><span class="input-icon input-glyphicon glyphicon-password"></span>
                                <span class="input-text">Password&#42;</span></span>
                            <input type="password"  name='password' class="form-control input-lg" placeholder="Your Password">
                        </div><!-- End .input-group -->
                        <div class="input-group">
                            <input type="submit" value="Login" class="btn btn-custom-2 btn-lg md-margin">
                        </div><!-- End .input-group -->
                    </fieldset>

                </div><!-- End .col-md-6 -->

            </div><!-- End .row -->
             <?php echo form_close(); ?>
    </div><!-- End .col-md-12 -->
</div><!-- End .row -->
