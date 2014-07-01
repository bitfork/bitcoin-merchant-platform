<?php

Yii::app()->attachbehavior('viewRenderer', 'wob.components.behaviors.CAViewRendererBehavior');
Yii::import("wob.components.*");

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

	public function actionPayoff()
	{
		Wob::startSetStatusPayoff();
		return 0;
	}
}