<?php
class WobUserInfo extends WobWidget
{
	public $view = 'user_info';

	public function run()
	{
		$this->render($this->getViewPathTheme().$this->view, array(
			'user'=>Yii::app()->user->user(),
		));
	}
}