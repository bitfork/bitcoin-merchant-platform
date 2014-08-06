<?php

class ShopController extends WobController
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
				'actions'=>array('index','view','create','update','delete','button'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$payoffProvider = null;
		if (isset($_POST['id_wallet_payoff_select'])) {
			Yii::app()->user->setState('wob_select_wallet', (int)$_POST['id_wallet_payoff_select']);
			Yii::app()->end();
		}
		$wallets = WobUsersWallet::model()->my()->findAll();
		$wallet_select_id = false;
		if (Yii::app()->user->getState('wob_select_wallet')!==null) {
			$wallet_select_id = Yii::app()->user->getState('wob_select_wallet');
			$payoffProvider = WobOrdersPayoff::getListByWallet($wallet_select_id);
		} else {
			if (count($wallets)>0) {
				if (Yii::app()->user->getState('wob_select_wallet')===null) {
					Yii::app()->user->setState('wob_select_wallet', $wallets[0]->id);
					$wallet_select_id = Yii::app()->user->getState('wob_select_wallet');
					$payoffProvider = WobOrdersPayoff::getListByWallet($wallet_select_id);
				}
			}
		}
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'orderProvider'=>WobOrders::model()->getListByShop($id),
			'payoffProvider'=>$payoffProvider,
			'wallets'=>$wallets,
			'wallet_select_id'=>$wallet_select_id,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new WobShops;
		$model->is_commission_shop = Wob::module()->isCommissionShopDefault;
		$model->email_admin = (isset(Yii::app()->user->email)) ? Yii::app()->user->email : null;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WobShops']))
		{
			$model->attributes=$_POST['WobShops'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		Yii::app()->user->setState('wob_select_shop', null);

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionButton($id_shop)
	{
		$shop=$this->loadModel($id_shop);
		$model=new WobButtonForm;
		$model->merchant_id = $shop->id;

		if (isset($_POST['ajax']))
		{
			$error = CActiveForm::validate($model);
			if ($error != '[]') {
				echo $error;
			} else {
				$button = $this->renderPartial('button_template',array(
					'model'=>$model,
				), true);
				echo CJSON::encode(array('content'=>$button));
			}
			Yii::app()->end();
		}

		$model->currency_code = $shop->currency_2->code;

		$this->render('button',array(
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WobShops']))
		{
			$model->attributes=$_POST['WobShops'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$shops = WobShops::model()->my()->findAll();
		if (count($shops)>0) {
			$this->redirect(array('/wob/shop/view', 'id'=>$shops[0]->id));
		}
		$this->redirect(array('/wob/shop/create'));
		Yii::app()->user->setState('wob_select_shop', null);
		$dataProvider=WobShops::model()->getListMy();
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
		$model=WobShops::model()->my()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');

		Yii::app()->user->setState('wob_select_shop', $model->id);

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param WobShops $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shops-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
