<div class="header hidden-print" >
    <h2 class="toplogo"> <?php echo $this->school ? $this->school->school : ' '; ?>  </h2>
    <div class="buttons">
        <div class="popup" id="subNavControll">
            <div class="label"><span class="icos-list"></span></div>
        </div>
        <div class="dropdown pull-left">
        </div>   
        <div class="dropdown">
            <div class="label">
                <img style="padding:1px;"src="<?php echo base_url('assets/themes/admin/img/us.jpg'); ?>" width="20" height="20" /> 
                <?php
                echo trim($this->user->first_name . ' ' . $this->user->last_name);
                ?> 
                <span class="glyphicon glyphicon-chevron-down glyphicon glyphicon-white"></span></div>
            <div class="body" style="width: 160px;">
                <div class="itemLink">
                    <?php
                    if ($this->acl->is_allowed(array('settings'), 1))
                    {
                            ?> 
                            <a href="<?php echo base_url('admin/settings'); ?>"><span class="glyphicon glyphicon-cog glyphicon glyphicon-white"></span> Settings</a>
                    <?php } ?>
                    <a href="<?php echo base_url('admin/change_password'); ?>"><span class="glyphicon glyphicon-edit glyphicon glyphicon-white"></span> Change Password</a>
                </div>
                <div class="itemLink">
                    <?php
                    if ($this->acl->is_allowed(array('sms', 'create'), 1))
                    {
                            ?>
                            <a href="<?php echo base_url('admin/sms'); ?>"><span class="glyphicon glyphicon-comment glyphicon glyphicon-white"></span> Messaging</a><?php } ?>
                    <?php
                    if ($this->acl->is_allowed(array('users', 'create'), 1))
                    {
                            ?>
                            <a href="<?php echo base_url('admin/permissions'); ?>"><span class="glyphicon glyphicon-lock glyphicon glyphicon-white"></span>Permissions</a>
                    <?php } ?>

                    <?php
                    if ($this->acl->is_allowed(array('users', 'create'), 1))
                    {
                            ?>
                            <a href="<?php echo base_url('fee_payment/process_fee'); ?>"><span class="glyphicon glyphicon-cog glyphicon glyphicon-white"></span>Run Process Fee</a>
                    <?php } ?>
                </div>                    
                <div class="itemLink">
                    <a href="<?php echo base_url('admin/logout'); ?>"><span class="glyphicon glyphicon-off glyphicon glyphicon-white"></span> Logout</a>
                </div>                                        
            </div>                
        </div>            

        <div class="popup">
            <div class="label"><span class="icos-cog"></span></div>
            <div class="body">
                <div class="arrow"></div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="top">Themes:</span>
                            <div class="themes">
                                <a href="#" data-theme="" id="one" class="tip" title="Default">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/default.jpg'); ?>" />

                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#one").click(function ()
                                                {
                                                    var themes = {'theme': 'default'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>                                    
                                <a href="#" data-theme="ssDaB" id="two" class="tip" title="DaB">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/dab.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#two").click(function ()
                                                {
                                                    var themes = {'theme': 'ssDaB'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssTq" id="three" class="tip" title="Tq">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/tq.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#three").click(function ()
                                                {
                                                    var themes = {'theme': 'ssTq'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssGy" id="four" class="tip" title="Gy">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/gy.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#four").click(function ()
                                                {
                                                    var themes = {'theme': 'ssGy'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssLight" id="five" class="tip" title="Light">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/light.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#five").click(function ()
                                                {
                                                    var themes = {'theme': 'ssLight'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssDark" id="six" class="tip" title="Dark">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/dark.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#six").click(function ()
                                                {
                                                    var themes = {'theme': 'ssDark'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssGreen" id="seven" class="tip" title="Green">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/green.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#seven").click(function ()
                                                {
                                                    var themes = {'theme': 'ssGreen'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                                <a href="#" data-theme="ssRed" id="eight" class="tip" title="Red">
                                    <img src="<?php echo base_url('assets/themes/admin/img/themes/red.jpg'); ?>" />
                                    <script type="text/javascript">
                                            $(document).ready(function ()
                                            {
                                                $("#eight").click(function ()
                                                {
                                                    var themes = {'theme': 'ssRed'}
                                                    var saveData = $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url('admin/settings/post_theme') ?>",
                                                        data: themes,
                                                        dataType: "text",
                                                        success: function (resultData)
                                                        {
                                                            alert("Theme was successfully saved")
                                                        }
                                                    });
                                                    saveData.error(function ()
                                                    {
                                                        alert("Something went wrong");
                                                    });
                                                });
                                            });

                                    </script>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="top">Backgrounds:</span>
                            <div class="backgrounds">
                                <a href="#" data-background="bg_default" class="bg_default" id="bg_default"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_default").click(function ()
                                            {
                                                var themes = {'bg': 'bg_default'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_mgrid" class="bg_mgrid" id="bg_mgrid"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_mgrid").click(function ()
                                            {
                                                var themes = {'bg': 'bg_mgrid'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_crosshatch" class="bg_crosshatch" id="bg_crosshatch"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_crosshatch").click(function ()
                                            {
                                                var themes = {'bg': 'bg_crosshatch'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_hatch" class="bg_hatch" id="bg_hatch"></a> 
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_hatch").click(function ()
                                            {
                                                var themes = {'bg': 'bg_hatch'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>								
                                <a href="#" data-background="bg_light_gray" class="bg_light_gray" id="bg_light_gray"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_light_gray").click(function ()
                                            {
                                                var themes = {'bg': 'bg_light_gray'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_dark_gray" class="bg_dark_gray" id="bg_dark_gray"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_dark_gray").click(function ()
                                            {
                                                var themes = {'bg': 'bg_dark_gray'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_texture" class="bg_texture" id="bg_texture"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_texture").click(function ()
                                            {
                                                var themes = {'bg': 'bg_texture'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_light_orange" class="bg_light_orange" id="bg_light_orange"></a>
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_light_orange").click(function ()
                                            {
                                                var themes = {'bg': 'bg_light_orange'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_yellow_hatch" class="bg_yellow_hatch" id="bg_yellow_hatch"></a> 
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_yellow_hatch").click(function ()
                                            {
                                                var themes = {'bg': 'bg_yellow_hatch'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>
                                <a href="#" data-background="bg_green_hatch" class="bg_green_hatch" id="bg_green_hatch"></a> 
                                <script type="text/javascript">
                                        $(document).ready(function ()
                                        {
                                            $("#bg_green_hatch").click(function ()
                                            {
                                                var themes = {'bg': 'bg_green_hatch'}
                                                var saveData = $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('admin/settings/post_bg') ?>",
                                                    data: themes,
                                                    dataType: "text",
                                                    success: function (resultData)
                                                    {
                                                        alert("Background was successfully saved")
                                                    }
                                                });
                                                saveData.error(function ()
                                                {
                                                    alert("Something went wrong");
                                                });
                                            });
                                        });

                                </script>								
                            </div>
                        </div>          
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="top">Navigation:</span>
                            <input type="radio" name="navigation" id="fixedNav"/> Fixed 
                            <input type="radio" name="navigation" id="collapsedNav"/> Collapsible
                            <input type="radio" name="navigation" id="hiddenNav"/> Hidden
                        </div>                                
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
