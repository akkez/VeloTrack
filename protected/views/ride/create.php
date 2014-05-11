<?php
/* @var $this RideController */
/* @var $model Ride */

$this->pageTitle = 'Новая поездка';

Yii::app()->getClientScript()->registerPackage('yandexmap');

echo HeaderHelper::page($this->pageTitle);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'                   => 'ride-form',
	'enableAjaxValidation' => false,
));

/* @var $form TbActiveForm */

echo $form->errorSummary($model);

echo $form->hiddenField($model, 'track');

?>
<div class="row-fluid">
	<div class="span4"><?php
		echo $form->label($model, 'created');
		$this->widget('application.components.was.WasDatepicker', array(
			'model'       => $model,
			'attribute'   => 'created',
			'options'     => array(
				'language'           => 'ru',
				'format'             => 'yyyy.mm.dd',
				'autoclose'          => 'true',
				'weekStart'          => 1,
				'startView'          => 0,
				'keyboardNavigation' => true
			),
			'htmlOptions' => array(
				'value' => date("Y.m.d"),
			),
		));
		?></div>
	<div class="span8"><?php
		echo $form->textFieldRow($model, 'comment', array('rows' => 1, 'class' => 'span6'));
	?></div>
</div>

<div id="map" style="width:800px; height:600px"></div>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'  => 'submit',
		'type'        => 'primary',
		'label'       => 'Сохранить',
		'htmlOptions' => array('id' => 'saveTrack'),
	)); ?>
</div>

<?php $this->endWidget();

$user = User::model()->findByPk(Yii::app()->user->getId());
/* @var $user User */
$defaultLat = $user->default_lat;
$defaultLng = $user->default_lng;
$defaultZoom = $user->default_zoom;

$script = <<<JS
        ymaps.ready(init);

        function init () {
            var myMap = new ymaps.Map('map', {
                    center: [$defaultLng, $defaultLat],
                    zoom: $defaultZoom
                });

				var polyline = new ymaps.Polyline([], {}, {
					strokeColor: '#ff0000',
                    strokeWidth: 3
                });

			myMap.geoObjects.add(polyline);
			polyline.editor.startEditing();
			polyline.editor.startDrawing();

            $('#saveTrack').click(
                function () {
                    polyline.editor.stopEditing();
					dumpGeometry(polyline.geometry.getCoordinates());
            });
        }

        function dumpGeometry (coords) {
            $('#Ride_track').val(stringify(coords));

            function stringify (coords) {
                var res = '';
                if ($.isArray(coords)) {
                    res = '[';
                    for (var i = 0, l = coords.length; i < l; i++) {
                        if (i > 0) {
                            res += ',';
                        }
                        res += stringify(coords[i]);
                    }
                    res += ']';
                } else if (typeof coords == 'number') {
                    res = coords.toPrecision(6);
                } else if (coords.toString) {
                    res = coords.toString();
                }

                return res;
            }
        }
JS;

Yii::app()->getClientScript()->registerScript('yamap', $script);

?>
