<?php

Yii::import("application.modules.wob.components.*");

class OrdersCommand extends CConsoleCommand
{
	public function actionPay()
	{
		Wob::startSetStatusPayOrders();
		return 0;
	}

	public function actionFinish()
	{
		Wob::startSetStatusFinishOrders();
		return 0;
	}
}