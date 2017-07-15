<?php
if ($this->session->flashdata('warning'))
{
		?>
		<div class="alert">
			<button type="button" class="close" data-dismiss="alert">
				<i class="glyphicon glyphglyphicon glyphicon-remove"></i> </button>
			<strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
		</div>
<?php } ?>
<?php
if ($this->session->flashdata('success'))
{
		?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">  <i class="glyphicon glyphglyphicon glyphicon-remove-circle"></i>  </button>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
<?php } ?>
<?php
if ($this->session->flashdata('info'))
{
		?>
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert">
				<i class="glyphicon glyphglyphicon glyphicon-remove-circle"></i> </button>
			<?php echo $this->session->flashdata('info'); ?>
		</div>
<?php } ?>
<?php
if ($this->session->flashdata('message'))
{
		$message = $this->session->flashdata('message');
		$str = is_array($message) ? $message['text'] : $message;
		?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">
				<i class="glyphicon glyphglyphicon glyphicon-remove-circle"></i>                                </button>
			<?php echo $str; //$this->session->flashdata('message');  ?>
		</div>
<?php } ?>
<?php
if ($this->session->flashdata('error'))
{
		?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">
				<i class="glyphicon glyphicon-remove"></i>      </button>
			<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
		</div>
<?php } ?>
