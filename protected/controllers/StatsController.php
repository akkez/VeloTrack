<?php

class StatsController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions' => array('index'),
				'users'   => array('@'),
			),
			array(
				'deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$sum    = Ride::model()->find(
			array(
				'condition' => 't.user_id = :uid', 'select' => 'SUM(t.length) as length',
				'params'    => array(':uid' => Yii::app()->user->getId())
			)
		);
		$length = $sum->length;

		$this->render('index', array('length' => $length));
	}
}