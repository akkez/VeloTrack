<?php
/**
 * Created by PhpStorm.
 * Date: 09.05.14
 * Time: 21:41
 */

/* @var $this RideController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Мои поездки';
echo HeaderHelper::page($this->pageTitle);

$this->widget('bootstrap.widgets.TbGridView', array(
	'type'         => 'striped bordered condensed',
	'dataProvider' => $dataProvider,
	'template'     => "{items}{pager}",
	'columns'      => array(
		array('name' => 'id', 'header' => '#'),
		array('name' => 'created', 'value' => 'date("d.m.Y", strtotime($data->created))'),
		'comment',
		array('name' => 'length', 'value' => 'GeoHelper::getTitleOfLength($data->length)'),
		array(
			'class'         => 'bootstrap.widgets.TbButtonColumn',
			'header'        => 'Действия',
			'template'      => '{view} {delete}',
			'htmlOptions'   => array('style' => 'text-align: center'),
			'viewButtonUrl' => 'Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey))',
		),
	),
));

?><p>CSV</p>