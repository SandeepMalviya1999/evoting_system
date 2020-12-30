<?php if(!empty($_SESSION["messages"])): ?>
	<div class="alert alert-success alert-dismissible">
		<?php foreach($_SESSION["messages"] as $message): ?>
			<p><?php echo $message; ?></p>
		<?php endforeach; ?>
	</div>
	<?php unset($_SESSION["messages"]); ?>
<?php elseif(!empty($_SESSION["errors"])):  ?>
	<div class="alert alert-danger alert-dismissible">
		<?php foreach($_SESSION["errors"] as $error): ?>
			<p><?php echo $error; ?></p>
		<?php endforeach; ?>
	</div>
	<?php unset($_SESSION["errors"]); ?>
<?php endif; ?>