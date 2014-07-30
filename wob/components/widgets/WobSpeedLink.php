<?php
class WobSpeedLink extends WobWidget
{
	public $view = 'speed_link';

	public function run()
	{
		if (Yii::app()->user->getState('wob_select_shop')===null) {
			return;
		}
		$this->render($this->getViewPathTheme().$this->view, array(
			'id_shop'=>Yii::app()->user->getState('wob_select_shop'),
		));
	}
}