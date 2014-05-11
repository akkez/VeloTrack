<?php
/**
 * Created by PhpStorm.
 * Date: 11.05.14
 * Time: 20:23
 */

/* @var $dataProvider CActiveDataProvider */

$data = array();
$dataProvider->setPagination(false);
foreach ($dataProvider->getData() as $record)
{
	/* @var $record Ride */
	$data[] = array($record->id, $record->created, $record->comment, $record->length, $record->track);
}

CsvHelper::download_send_headers("data_" . date("Y-m-d") . ".csv");
echo CsvHelper::array2csv($data);