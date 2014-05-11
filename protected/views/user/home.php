<?php
/**
 * Created by PhpStorm.
 * Date: 10.05.14
 * Time: 0:03
 */

/* @var $this UserController */
/* @var $model User */

Yii::app()->getClientScript()->registerPackage('yandexmap');

$this->pageTitle = 'Точка дома';
echo HeaderHelper::page($this->pageTitle);
?>
<p>Чтобы вбивать маршруты было удобнее, стоит задать здесь точку, от которой вы обычно начинаете путь. Хотя бы
	примерно.</p>
<p>Просто наведите карту куда нужно и нажмите *Сохранить*</p>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'                   => 'user-form',
	'enableAjaxValidation' => false,
));

/* @var $form TbActiveForm */

echo $form->errorSummary($model);

echo $form->hiddenField($model, 'default_lat');
echo $form->hiddenField($model, 'default_lng');
echo $form->hiddenField($model, 'default_zoom');

?>
<div id="map" style="width:800px; height:600px"></div>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'  => 'submit',
		'type'        => 'primary',
		'label'       => 'Сохранить',
		'htmlOptions' => array('id' => 'save'),
	)); ?>
</div>

<?php $this->endWidget();

$defaultLat = $model->default_lat;
$defaultLng = $model->default_lng;
$defaultZoom = $model->default_zoom;

$script = <<<JS
        ymaps.ready(init);

        function init () {
            var myMap = new ymaps.Map('map', {
                    center: [$defaultLng, $defaultLat],
                    zoom: $defaultZoom
                });

            $('#save').click(
                function () {
               		var data = myMap.getCenter();
                	$("#User_default_lng").val(data[0]);
                	$("#User_default_lat").val(data[1]);
                	$("#User_default_zoom").val(myMap.getZoom());
            });
        }
JS;
Yii::app()->getClientScript()->registerScript('yamap', $script);

?>
