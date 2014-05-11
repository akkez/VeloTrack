<?php

class RideController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'checkAccess + update, delete'
		);
	}

	public function filterCheckAccess($filterChain)
	{
		$id = Yii::app()->request->getParam('id');
		if (empty($id))
		{
			throw new CHttpException(404, 'omg empty id');
		}
		$ride = $this->loadModel($id);
		if (Yii::app()->user->isAdmin)
		{
			$filterChain->run();

			return;
		}
		/* @var $ride Ride */
		if ($ride->user_id != Yii::app()->user->getId())
		{
			throw new CHttpException(403, 'You cant have access to this ride, sorry');
		}

		$filterChain->run();
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
				'actions' => array('create', 'update', 'my', 'delete', 'csv'),
				'users'   => array('@'),
			),
			array(
				'deny',
				'users' => array('*'),
			),
		);
	}

	public function actionMy()
	{
		$dataProvider = new CActiveDataProvider('Ride', array(
			'criteria' => array(
				'condition' => 'user_id = :uid',
				'with'      => array('user'),
				'params'    => array(
					':uid' => Yii::app()->user->getId()
				)
			),
			'sort'     => array(
				'defaultOrder' => 't.created DESC, t.id DESC',
			)
		));

		$this->render('my', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Ride;

		if (isset($_POST['Ride']))
		{
			$model->attributes = $_POST['Ride'];

			$model->user_id = Yii::app()->user->getId();

			if ($model->save())
			{
				Yii::app()->user->setFlash('success', 'Поездка была успешно создана');
				$this->redirect(array('my'));
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if (isset($_POST['Ride']))
		{
			$model->attributes = $_POST['Ride'];
			if ($model->save())
			{
				Yii::app()->user->setFlash('success', 'Поездка была успешно изменена');
				$this->redirect('/ride/my');
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 * @throws CHttpException
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();
			$this->redirect(array('/ride/my'));
		}
		else
		{
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	public function actionCsv()
	{
		$dataProvider = new CActiveDataProvider('Ride', array(
			'criteria' => array(
				'condition' => 'user_id = :uid',
				'params'    => array(
					':uid' => Yii::app()->user->getId()
				)
			),
		));

		$this->layout = false;
		$this->render('csv', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param $id
	 * @throws CHttpException
	 * @internal param \the $integer ID of the model to be loaded
	 * @return Ride
	 */
	public function loadModel($id)
	{
		$model = Ride::model()->findByPk($id);
		if ($model === null)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}
}
