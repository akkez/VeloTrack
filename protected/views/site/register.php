<?php
/**
 * Created by PhpStorm.
 * Date: 09.05.14
 * Time: 18:56
 */

/* @var $this SiteController */
/* @var $model RegisterForm */

$this->pageTitle = 'Регистрация';
echo HeaderHelper::page($this->pageTitle);
?>

<div class="form">
	<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'          => 'verticalForm',
		'htmlOptions' => array('class' => 'well'),
	));

	echo CHtml::errorSummary($model);

	echo $form->textFieldRow($model, 'username', array('class' => 'span3'));
	echo $form->textFieldRow($model, 'email', array('class' => 'span3'));
	echo $form->passwordFieldRow($model, 'password', array('class' => 'span3'));

	?>
	<div class="row-fluid"><?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit', 'label' => 'Зарегистрироваться', 'type' => 'primary'
		));
		?></div><?php

	$this->endWidget(); ?>
</div><!-- form -->
