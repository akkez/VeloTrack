<?php
/* @var $this StatsController */
/* @var $length int */
/* @var $interval int */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Статистика';
echo HeaderHelper::page($this->pageTitle);
?>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
	'type'    => 'pills',
	'stacked' => false,
	'items'   => array(
		array(
			'label'  => 'По дням',
			'url'    => array('/stats/index', 'interval' => 'day'),
			'active' => ($interval == 'day')
		),
		array(
			'label'  => 'По неделям',
			'url'    => array('/stats/index', 'interval' => 'week'),
			'active' => ($interval == 'week')
		),
		array(
			'label'  => 'По месяцам',
			'url'    => array('/stats/index', 'interval' => 'month'),
			'active' => ($interval == 'month')
		),
	),
));

$data = array();
$time = time();
$secondsInDay = 86400;
for ($i = 0; $i < 30; $i++)
{
	$key        = DateHelper::getDateRepresentation($time, $interval);
	$data[$key] = 0;
	if ($interval == 'day')
	{
		$time -= $secondsInDay;
	}
	elseif ($interval == 'week')
	{
		$time -= $secondsInDay * 7;
	}
	else
	{
		$currentMonth = date('m', $time);
		while (date('m', $time) == $currentMonth)
		{
			$time -= $secondsInDay * 7;
		}
	}
}

$dataProvider->setPagination(false);
foreach ($dataProvider->getData() as $record)
{
	/* @var $record Ride */
	$key = DateHelper::getDateRepresentation($record->created, $interval);
	if (!isset($data[$key]))
	{
		continue;
	}
	$data[$key] += (double)$record->length;
}

?>

<div class="row-fluid">
	<div class="span12">
		<canvas id="myChart" width="1000" height="600"></canvas>
	</div>
</div>

<?php

$keys = json_encode(array_reverse(array_keys($data)));
$values = json_encode(array_reverse(array_values($data)));

$script = <<<JS
	var ctx = document.getElementById("myChart").getContext("2d");
	var data = {
		labels : $keys,
		datasets : [
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : $values
			}
		]
	};
	new Chart(ctx).Line(data);
JS;

Yii::app()->getClientScript()->registerPackage('chart');
Yii::app()->getClientScript()->registerScript('chart', $script);

?><h3>Общая длина пути: <b><?php echo round($length, 3); ?> км.</b></h3>