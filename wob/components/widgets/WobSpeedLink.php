<?php
class WobSpeedLink extends CWidget
{
	public function run()
	{
		if (Yii::app()->user->getState('wob_select_shop')===null) {
			return;
		}
		$this->render('speed_link', array(
			'id_shop'=>Yii::app()->user->getState('wob_select_shop'),
		));
	}
}