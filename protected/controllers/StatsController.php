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

	public function getLengthOfAllRides($userId)
	{
		$criteria         = new CDbCriteria();
		$criteria->params = array(':uid' => $userId);
		$criteria->addCondition('t.user_id = :uid');
		$criteria->select = 'SUM(t.length) as length';
		$ride             = Ride::model()->find($criteria);

		return $ride->length;
	}

	public
	function actionIndex($interval = 'day')
	{
		$intervals = array('day', 'week', 'month');
		if (!in_array($interval, $intervals))
		{
			$interval = $intervals[0];
		}

		$criteria         = new CDbCriteria();
		$criteria->params = array(':uid' => Yii::app()->user->getId());
		$criteria->addCondition('t.user_id = :uid');
		$criteria->select = "SUM(t.length) as length, t.created";
		$criteria->group  = "DAY(t.created)";

		$dataProvider = new CActiveDataProvider('Ride', array('criteria' => $criteria));

		$length = $this->getLengthOfAllRides(Yii::app()->user->getId());
		$this->render('index', array('interval' => $interval, 'length' => $length, 'dataProvider' => $dataProvider));
	}
}