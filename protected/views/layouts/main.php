<?php /* @var $this Controller */

if ($this->pageTitle === '')
{
	$title = Yii::app()->name;
}
else
{
	$title = Yii::app()->name . " - " . CHtml::encode($this->pageTitle);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en"/>

	<link rel="stylesheet" type="text/css" href="/css/styles.css"/>

	<title><?php echo $title; ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<div id="wrap">

	<?php

	$guestMenu = array(
		array('label' => 'Главная', 'url' => array('/site/index')),
		array('label' => 'Регистрация', 'url' => array('/site/register')),
	);

	$userMenu = array(
		array('label' => 'Главная', 'url' => array('/site/index')),
		array('label' => 'Мои поездки', 'url' => array('/ride/my')),
		array('label' => 'Новая поездка', 'url' => array('/ride/create')),
		array('label' => 'Статистика', 'url' => array('/stats/index')),
		array('label' => 'Точка дома', 'url' => array('/user/home')),
	);

	$guestDropdownMenu = array(
		array('label' => 'Вход', 'url' => array('/site/login')),
	);

	$userDropdownMenu = array(
		array(
			'label' => Yii::app()->user->name, 'url' => '#', 'items' =>
			array(
				array(
					'label' => 'Выход', 'url' => array('/site/logout'),
				)
			)
		)
	);

	$this->widget('bootstrap.widgets.TbNavbar', array(
			'items' => array(
				array(
					'class' => 'bootstrap.widgets.TbMenu',
					'items' => Yii::app()->user->isGuest ? $guestMenu : $userMenu,
				),
				array(
					'class'       => 'bootstrap.widgets.TbMenu',
					'htmlOptions' => array('class' => 'pull-right'),
					'items'       => Yii::app()->user->isGuest ? $guestDropdownMenu : $userDropdownMenu,
				),
			),
		)
	); ?>

	<div class="container" id="page">

		<?php if (isset($this->breadcrumbs)): ?>
			<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
				'links'    => $this->pageTitle == '' ? array() : array($this->pageTitle),
				'homeLink' => Chtml::tag('a', array('href' => '/'), 'Главная'),
			)); ?><!-- breadcrumbs -->
		<?php endif ?>

		<?php $this->widget('bootstrap.widgets.TbAlert', array(
			'block'     => true,
			'closeText' => '&times;',
			'alerts'    => array(
				'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'),
			),
		)); ?>

		<?php echo $content; ?>
		<div class="clear"></div>
	</div>
	<div id="push"></div>
</div>

<div id="footer">
	<div class="container">
		<div class="span4" style="padding-top: 10px">&copy; 2014<br/>
			Работает на Yii и чьей-то матери <br/></div>
		<div class="span4" style="padding-top: 20px"><a href="https://github.com/akkez/VeloTrack" target="_blank">Форкни плиз</a></div>
	</div>
</div>
<!-- footer -->

</body>
</html>
