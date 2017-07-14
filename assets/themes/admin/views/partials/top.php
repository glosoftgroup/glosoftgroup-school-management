<!-- Main navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top bg-indigo">
		<div class="navbar-header">
			<a class="navbar-brand" href="">
        <?php echo $this->school ? $this->school->school : ' '; ?>
      </a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
            <img style="padding:1px;" src="<?php echo base_url('assets/themes/admin/img/us.jpg'); ?>" width="20" height="20" />
						<span>
              <?php
              echo trim($this->user->first_name . ' ' . $this->user->last_name);
              ?>
            </span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
            <?php
            if ($this->acl->is_allowed(array('settings'), 1))
              {
             ?>
						<li>
              <a href="<?php echo base_url('admin/settings'); ?>">
                <i class="icon-cog3"></i>
                 Settings</a>
            </li>
            <?php } ?>
            <li>
              <a href="<?php echo base_url('admin/change_password'); ?>">
                <i class="icon-pencil5"></i>
                 Change Password</a>
            </li>
            <!-- message -->
            <?php
            if ($this->acl->is_allowed(array('sms', 'create'), 1))
            { ?>
            <li>
              <a href="<?php echo base_url('admin/sms'); ?>">
                <i class="icon-comment-discussion"></i>
                 Messaging</a>
            </li>
           <?php } ?>
           <!-- permissions -->
           <?php
            if ($this->acl->is_allowed(array('users', 'create'), 1))
            {
            ?>
            <li>
              <a href="<?php echo base_url('admin/permissions'); ?>">
                <i class="icon-lock2"></i>
                 Permissions</a>
            </li>
            <?php } ?>
            <!-- process_fee -->
            <?php
             if  ($this->acl->is_allowed(array('users', 'create'), 1))
             {
             ?>
             <li>
               <a href="<?php echo base_url('fee_payment/process_fee'); ?>">
                 <i class="icon-cogs"></i>
                 Run Process Fee</a>
             </li>
             <?php } ?>
						<li class="divider"></li>
						<li><a href="<?php echo base_url('admin/logout'); ?>"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>

			</ul>
		</div>
	</div>
	<!-- /main navbar -->
