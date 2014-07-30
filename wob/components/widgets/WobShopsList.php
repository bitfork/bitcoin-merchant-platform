<?php
class WobShopsList extends WobWidget
{
	public $view = 'shops_list';

	public function run()
	{
		$shops = WobShops::model()->my()->findAll();
		$this->render($this->getViewPathTheme().$this->view, array(
			'shops'=>$shops,
			'id_shop'=>Yii::app()->user->getState('wob_select_shop'),
		));
	}
}