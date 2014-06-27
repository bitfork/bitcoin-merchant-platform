<?php

class OrdersController extends WobController
{
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex($id)
	{
		$dataProvider=WobOrders::model()->getListByShop($id);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
}
