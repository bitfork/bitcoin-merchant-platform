<?php
class WobShopInfo extends WobWidget
{
	public $view = 'shop_info';

	public function run()
	{
		if (Yii::app()->user->getState('wob_select_shop')===null) {
			return;
		}
		$id_shop = (int)Yii::app()->user->getState('wob_select_shop');
		$shop = WobShops::model()->my()->findByPk($id_shop);
		if ($shop===null) {
			return;
		}
		$this->render($this->getViewPathTheme().$this->view, array(
			'shop'=>$shop,
		));
	}
}