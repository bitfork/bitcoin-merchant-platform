<?php
class WobSettings extends WobWidget
{
	public $view = 'settings';

	public function run()
	{
		if (Yii::app()->user->getState('wob_select_shop')===null) {
			return;
		}
		$id_shop = (int)Yii::app()->user->getState('wob_select_shop');
		$shop = WobShops::model()->my()->findByPk($id_shop);
		$model = new WobShopCommissionForm;
		$model->is_commission_shop = $shop->is_commission_shop;
		if (isset($_POST['WobShopCommissionForm']))
		{
			$model->attributes=$_POST['WobShopCommissionForm'];
			$shop->is_commission_shop = $model->is_commission_shop;
			if ($shop->save()) {
				Yii::app()->user->setFlash('wob_settings', 'Сохранено');
			}
		}
		$this->render($this->getViewPathTheme().$this->view, array(
			'shop'=>$shop,
			'model'=>$model,
		));
	}
}