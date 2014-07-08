<?php
class WobShopsList extends CWidget
{
	public function run()
	{
		$shops = WobShops::model()->my()->findAll();
		$this->render('shops_list', array(
			'shops'=>$shops,
			'id_shop'=>Yii::app()->user->getState('wob_select_shop'),
		));
	}
}