<?php
$settings = $this->ion_auth->settings();
?>
<!-- Main navbar -->
    <div class="navbar navbar-inverse bg-indigo">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?=base_url();?>">

            </a>

            <ul class="nav navbar-nav pull-right visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            </ul>
        </div>

        <div class="navbar-collapse collapse" id="navbar-mobile">
            <ul class="nav navbar-nav navbar-right">           
            </ul>
        </div>
    </div>
    <!-- /main navbar -->


    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">

                    <!-- Simple login form -->
                    <?php
          echo form_open("admin/login", ' class="form-login" ');  ?>
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <div class="icon-object border-slate-300 text-slate-300">
                                <?php if (!empty($settings)): ?>
                                  <img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />
                          <?php else: ?>
                                  <img src="<?php echo base_url('assets/themes/default/img/logo.png/'); ?>" width="80" height="80" />
                          <?php endif; ?>
                                </div>
                                <?php
                $str = is_array($message) ? $message['text'] : $message;
                echo (isset($message) && !empty($message)) ? '
                                <div class="error alert alert-danger ">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="glyphicon glyphicon-remove"></i>
                        </button>' . $str . '
                       </div>' : '';
                ?>
                                <h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input name='email' type="email" class="form-control" placeholder="Email">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" name='password' class="form-control" placeholder="Password">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>
                            <div class="form-group login-options">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="styled" checked="checked"
                                            name="rem">
                                            Remember
                                        </label>
                                    </div>

                                    <div class="col-sm-6 text-right">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn bg-pink-400 btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
                            </div>

                            <div class="text-center">
                                <a href="login_password_recover.html">Forgot password?</a>
                            </div>
                        </div>
                    </form>
                    <!-- /simple login form -->


                    <!-- Footer -->
                    <div class="footer text-muted text-center">
                        <?php echo date('Y');?> &copy; Glosoft Group.</a>
                    </div>
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->
