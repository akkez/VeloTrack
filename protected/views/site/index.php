<?php
/* @var $this SiteController */

$this->pageTitle = '';
echo HeaderHelper::page('VeloTrack');
?>
	<p>Я катаюсь на велосипеде, gps-навигатора у меня нет, но хочется хранить и использовать данные о поездках, чтобы
		смотреть по ним статистику и видеть прогресс.</p>
	<p>Цель этой штуки - ввод и ведение статистики по велотрекам.</p>
	<p>Используется Yii и API Яндекс.Карт. И ещё Chart.js для графиков.</p>

<p>&nbsp;</p>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType' => 'link',
	'url' => 'register',
	'label' => 'Регистрация без смс',
	'type'  => 'primary',
	'size'  => 'large',

));

?><p>&nbsp;</p>	<h3>Что внутри:</h3><?php

echo CHtml::tag('p', array(), CHtml::image('/images/screen1.png'));
echo CHtml::tag('p', array(), CHtml::image('/images/screen2.png'));
echo CHtml::tag('p', array(), CHtml::image('/images/screen3.png'));