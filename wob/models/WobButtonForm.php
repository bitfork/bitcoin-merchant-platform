<?php

class WobButtonForm extends CFormModel
{
	const ON_IS_TEST = 'test';
	public $merchant_id;
	public $id_order_shop;
	public $amount;
	public $note;
	public $currency_code;
	public $currency_code_pay;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('merchant_id, amount, currency_code', 'required'),
			array('id_order_shop', 'required', 'on'=>self::ON_IS_TEST),
			array('merchant_id, id_order_shop', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('currency_code, currency_code_pay', 'length', 'max'=>3),
			array('note', 'length', 'max'=>2048),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'merchant_id'=>'Мерчант id',
			'id_order_shop'=>'Номер заказа в магазине',
			'amount'=>'Сумма к оплате',
			'note'=>'Описание услуги для пользователя',
			'currency_code'=>'Валюта в которой ваставленна сумма',
			'currency_code_pay'=>'Валюта в которой будет оплачивать',
		);
	}
}