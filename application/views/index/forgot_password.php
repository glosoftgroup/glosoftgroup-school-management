 
<div class="login-form">
    <div class="login-content"><?php
            $str = is_array($message) ? $message['text'] : $message;
            echo (isset($message) && !empty($message)) ? '
                        <div class="alert alert-danger "> 
                <button type="button" class="close" data-dismiss="alert">
                    <i class="glyphicon glyphicon-remove"></i>
                </button>
                <strong>   <i class="glyphicon glyphicon-comment"></i>
                  </strong>' . $str . '   
            </div>' : '';
        ?> 
        <?php echo form_open("admin/forgot_password", 'role="form" id="form_login" '); ?> 
        <p class="description">Please Enter Your Email Address to Receive Instructions on how to reset your Password</p>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="entypo-mail"></i>
                </div>

                <input type="text" class="form-control" name="email" id="password"   placeholder="Email" autocomplete="off" />
            </div>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-login">
                Send Me
                <i class="entypo-login"></i>
            </button>
        </div>

        <?php echo form_close(); ?> 

        <div class="login-bottom-links">
            <a href="<?php echo base_url('admin/login'); ?>" class="link">Back To Login</a>
            <br />

        </div>

    </div>

</div>
