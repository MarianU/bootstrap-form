<html>
	<header>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="style.css">

		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<script src="script.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</header>
	<body>
		<div id="main-container">
			<div class="row">
				<div class="col-md-12 col-lg-12 col-md-12">
		<?php if($this->form->isSubmited()) : ?>
			<?php if($this->form->isValid()) : ?>
					<div class="alert alert-success" role="alert"><?php echo $this->succesMessage;?></div>
			<?php else: ?>
					<div class="alert alert-danger" role="alert"><?php echo $this->errorMessage;?></div>
			<?php endif?>
		<?php endif; ?>
					<form name="contact" action="" method="post" class="bs-example bs-example-form">

		<?php foreach($this->form as $formField) : ?>
			<?php if($formField->type == 'render') :?>
				<?php echo $formField->render(); ?>
			<?php elseif($formField->type == 'hidden') :?>
						<input name="<?php echo $formField->name ?>" type="hidden" value="<?php echo $formField->getValue()?>">
			<?php else: ?>
						<div class="input-group <?php echo ($this->form->isSubmited() && !$formField->isValid())? 'has-error' : ''?>">
							<span class="input-group-addon" id="basic-addon1"><?php echo $formField->label ?></span>
				<?php if($formField->type == 'textarea') :?>
								<textarea rows="3" class="form-control" name="<?php echo $formField->name ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $formField->tooltipMessage?>"><?php echo $formField->getValue()?></textarea>
				<?php else :?>
								<input class="form-control" name="<?php echo $formField->name ?>" type="text" value="<?php echo $formField->getValue()?>" data-toggle="tooltip" data-placement="top" title="<?php echo $formField->tooltipMessage?>">
				<?php endif; ?>
						</div>
				<?php if($this->form->isSubmited() && !$formField->isValid() && 0):?>
						<div class="alert alert-danger" role="alert"><?php echo $formField->name;?></div>
				<?php endif?>
			<?php endif; ?>
		<?php endforeach; ?>
						<input type="submit" value="Send" class="btn btn-default">
					</form>

		<?php include 'guestsList.php'; ?>
				</div>
			</div>
		</div>

	</body>
</html>