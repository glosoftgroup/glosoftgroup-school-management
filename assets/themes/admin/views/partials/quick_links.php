<!-- quicklinks -->
<div class='quicklinks'>
<!-- student -->
<div class="col-lg-2 text-center">
  <?php if ($this->acl->is_allowed(array('admission', 'create'), 1)) { ?>
	<a href="<?php echo base_url('admin/admission/create'); ?>">
	<div class="panel bg-pink-400">
	  <div class="panel-body">
		<h1 class="no-margin">
		  <i class='icon-user'></i>
		</h1>
		New Student
	  </div>
	</div>
  </a>
  <?php } ?>
</div>
<!-- /student -->
<!-- fee payment -->
<div class="col-lg-2 text-center">
  <?php if ($this->acl->is_allowed(array('fee_payment', 'create'), 1)) { ?>
	<a href="<?php echo base_url('admin/fee_payment/create'); ?>">

	<div class="panel bg-indigo-400">
	  <div class="panel-body">
		<h1 class="no-margin">
		  <i class='icon-database'></i>
		</h1>
	  New Payment
	  </div>
	</div>
  </a>
  <?php } ?>
</div>
<!-- /fee payment -->
<!-- classes -->
<div class="col-lg-2 text-center">
	<a href="<?php echo base_url('admin/class_groups/classes'); ?>">
	<div class="panel  bg-blue-400">
	  <div class="panel-body">
		<h1 class="no-margin">
		  <i class='icon-list-numbered'></i>
		</h1>
	  Classes
	  </div>
	</div>
	</a>
</div>
<!-- /classes -->
<!-- send sms -->
<div class="col-lg-2 text-center">
	<a href="<?php echo base_url('admin/sms/create'); ?>">
	<div class="panel panel-default">
	  <div class="panel-body">

		<h1 class="no-margin">
		  <i class='icon-comment-discussion'></i>
		</h1>
	  Send SMS
	  </div>
	</div>
  </a>
</div>
<!-- /send sms -->
<!-- payroll -->
<div class="col-lg-2 text-center">
	<?php if ($this->acl->is_allowed(array('record_salaries'), 1)) { ?>
	  <a href="<?php echo base_url('admin/record_salaries/'); ?>">

	  <div class="panel bg-pink-400">
		<div class="panel-body">

		  <h1 class="no-margin">
			<i class='icon-cash'></i>
		  </h1>
		  Payroll
		</div>
	  </div>
	</a>
	<?php } ?>
</div>
<!-- /payroll -->
<!-- Expenses -->
<div class="col-lg-2 text-center">
<?php if ($this->acl->is_allowed(array('expenses'), 1)) { ?>
  <a href="<?php echo base_url('admin/expenses/'); ?>">

  <div class="panel bg-dark-400">
	<div class="panel-body">

	  <h1 class="no-margin">
		<i class='icon-libreoffice'></i>
	  </h1>
	  Expenses
	</div>
  </div>
</a>
<?php } ?>
		  </div>
<!-- /expenses -->
<!-- rollcall -->
<div class="col-lg-2 text-center">
	  <a href="<?php echo base_url('admin/class_attendance'); ?>">
	  <div class="panel panel-default">
		<div class="panel-body">

		  <h1 class="no-margin">
			<i class='icon-file-spreadsheet2'></i>
		  </h1>
		 RollCall
		</div>
	  </div>
			  </div>
	<!-- /roll call -->
<!-- rollcall -->
<div class="col-lg-2 text-center">
	<a href="<?php echo base_url('admin/exams'); ?>">
	<div class="panel panel-default">
	  <div class="panel-body">

		<h1 class="no-margin">
		  <i class='icon-copy4'></i>
		</h1>
	   Exam
	  </div>
	</div>
</div>
<!-- /send sms -->
<!-- fee arrears -->
<div class="col-lg-2 text-center">
  <?php if ($this->acl->is_allowed(array('fee_arrears'), 1)) { ?>
	<a href="<?php echo base_url('admin/fee_arrears'); ?>">

	<div class="panel bg-dark-400">
	  <div class="panel-body">

		<h1 class="no-margin">
		  <i class='icon-paste2'></i>
		</h1>
		Fee Arrears
	  </div>
	</div>
  <?php } ?>
</div>
<!-- /Fee Arrears  -->
<!-- Transport -->
<div class="col-lg-2 text-center">
	<a href="<?php echo base_url('admin/transport'); ?>">
	<div class="panel panel-default">
	  <div class="panel-body">
		<h1 class="no-margin">
		  <i class='icon-bus'></i>
		</h1>
	   Transport
	  </div>
	</div>
   </a>
</div>
<!-- /Transport -->
  <!-- Boarding -->
  <div class="col-lg-2 text-center">
	<?php if ($this->acl->is_allowed(array('hostels'), 1)) { ?>
	  <a href="<?php echo base_url('admin/hostels'); ?>">
	  <div class="panel bg-dark-400">
		<div class="panel-body">
		  <h1 class="no-margin">
			<i class='icon-home9'></i>
		  </h1>
		Boarding
		</div>
	  </div>
	 </a>
	<?php } ?>
  </div>
  <!-- /Boarding  -->
  <!-- Inventory -->
  <div class="col-lg-2 text-center">
	<?php if ($this->acl->is_allowed(array('inventory'), 1)) { ?>
	  <a href="<?php echo base_url('admin/inventory'); ?>">
	  <div class="panel bg-dark-400">
		<div class="panel-body">

		  <h1 class="no-margin">
			<i class='icon-books'></i>
		  </h1>
		  Inventory
		</div>
	  </div>
	  </a>
	<?php } ?>
  </div>
  <!-- /inventory  -->
  <!-- Settings -->
  <div class="col-lg-2 text-center">
	<a href="<?php echo base_url('admin/settings'); ?>">
	<div class="panel panel-default">
	  <div class="panel-body">

		<h1 class="no-margin">
		  <i class='icon-cogs'></i>
		</h1>
	   Settings
	  </div>
	</div>
   </a>
  </div>
  <!-- /settings -->
  <!-- Data Backup -->
  <div class="col-lg-2 text-center">
	<a href="<?php echo base_url('admin/settings/backup'); ?>">
	<div class="panel panel-default">
	  <div class="panel-body">

		<h1 class="no-margin">
		  <i class='icon-file-download'></i>
		</h1>
	   Data Backup
	  </div>
	</div>
   </a>
  </div>
  <!-- /Data Backup -->

<!-- ./quicklinks -->
</div>
