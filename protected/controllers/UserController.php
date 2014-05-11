<?php

class UserController extends Controller
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
				'actions' => array('home'),
				'users'   => array('@'),
			),
			array(
				'deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * @param $id
	 * @return User
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = User::model()->findByPk($id);
		if ($model === null)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	public function actionHome()
	{
		$model = $this->loadModel(Yii::app()->user->getId());

		if (isset($_POST['User']))
		{
			$model->setScenario('home');
			$model->setAttributes($_POST['User']);
			if ($model->save())
			{
				Yii::app()->user->setFlash('success', 'Точка дома изменена');
				$this->redirect('/user/home');
			}
		}

		$this->render('home', array(
			'model' => $model,
		));
	}
}
