<?php

class WalletController extends WobController
{
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','update','activation','payoff','payoffCreate'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCreate()
	{
		$model=new WobUsersWallet;
		$model->scenario = WobUsersWallet::ON_ADDRESS;
		$model->id_user = Yii::app()->user->getId();
		$model->volume = 0;

		if(isset($_POST['WobUsersWallet']))
		{
			$model->attributes=$_POST['WobUsersWallet'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->scenario = WobUsersWallet::ON_ADDRESS;

		if(isset($_POST['WobUsersWallet']))
		{
			$model->attributes=$_POST['WobUsersWallet'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=WobUsersWallet::model()->getListMy();
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * активация адреса кошелька
	 * @param $id
	 * @param $key
	 */
	public function actionActivation($id, $key)
	{
		$model=$this->loadModel($id);
		if ($model->activate_key==$key) {
			$model->is_address_activate = 1;
			$model->save();
		}
		$this->redirect(array('index'));
	}

	public function actionPayoff($id)
	{
		$model=$this->loadModel($id);
		$this->render('payoff',array(
			'model'=>$model,
			'list'=>WobOrdersPayoff::getListByWallet($id),
		));
	}

	public function actionPayoffCreate($id)
	{
		$model=$this->loadModel($id);
		$modelPayoff = new WobOrdersPayoff;
		$modelPayoff->scenario = WobOrdersPayoff::ON_CREATE;
		$modelPayoff->id_wallet = $model->id;
		$modelPayoff->amount = $model->volume;
		$modelPayoff->id_status = WobOrders::STATUS_NEW;

		if(isset($_POST['WobOrdersPayoff']))
		{
			$modelPayoff->attributes=$_POST['WobOrdersPayoff'];
			if($modelPayoff->save())
				$this->redirect(array('index'));
		}

		$this->render('payoff_create',array(
			'model'=>$modelPayoff,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return WobShops the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=WobUsersWallet::model()->my()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
