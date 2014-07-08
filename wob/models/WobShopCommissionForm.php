<?php
class WobShopCommissionForm extends CFormModel
{
	public $is_commission_shop;

	public function rules()
	{
		return array(
			array('is_commission_shop', 'numerical', 'integerOnly'=>true),
		);
	}

	public function attributeLabels()
	{
		return array(
			'is_commission_shop' => 'is_commission_shop',
		);
	}
}
