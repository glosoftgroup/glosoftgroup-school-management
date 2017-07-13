<?php
$settings = $this->ion_auth->settings();
?>
<!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
              <?php if (!empty($settings)): ?>
                      <img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />
              <?php else: ?>
                      <img src="<?php echo base_url('assets/themes/default/img/logo.png/'); ?>" width="80" height="80" />
              <?php endif; ?>
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
          <?php
          echo form_open("admin/login", ' class="form-login" ');
          ?>
                <h3 class="form-title">Login to your account</h3>
                <style>
                .error p{color:red;}
                </style>
                <?php
                $str = is_array($message) ? $message['text'] : $message;
                echo (isset($message) && !empty($message)) ? '
                                <div class="error alert alert-danger ">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="glyphicon glyphicon-remove"></i>
                        </button>' . $str . '
                       </div>' : '';
                ?>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
                </div>
                <div class="form-actions">
                    <label class="rememberme mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="rem"  /> Remember me
                        <span></span>
                    </label>
                    <button type="submit" class="btn green pull-right"> Login </button>
                </div>


            <?php
                echo form_close(); ?>
            <!-- END LOGIN FORM -->


        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright"> <?php echo date('Y');?> &copy; Glosoft Group. </div>
        <!-- END COPYRIGHT -->
