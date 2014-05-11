<?php
/* @var $this StatsController */

$this->pageTitle = 'Статистика';
echo HeaderHelper::page($this->pageTitle);
?>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
	'type'    => 'pills',
	'stacked' => false, // whether this is a stacked menu
	'items'   => array(
		array('label' => 'По дням', 'url' => '#', 'active' => true),
		array('label' => 'По неделям', 'url' => '#', 'active' => true),
		array('label' => 'По месяцам', 'url' => '#'),
	),
)); ?>

<h1><?php echo $length; ?></h1>