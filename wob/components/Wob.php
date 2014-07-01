<?php
class Wob
{
	const STATUS_SHOP_OK		= 'ok';
	const STATUS_SHOP_ERR		= 'err';

	protected static $_instanceWallet = array();
	protected static $_instanceCurrency = null;
	protected static $_instanceMail = null;

	/**
	 * модуль
	 * @return mixed
	 */
	public static function module()
	{
		return Yii::app()->getModule('wob');
	}

	/**
	 * кошелек
	 * @param null $currency
	 * @return mixed
	 * @throws CException
	 */
	public static function wallet($currency = null)
	{
		if (null === $currency) {
			$currency = self::module()->walletDefault;
		}
		$currency = mb_strtolower($currency, 'utf-8');
		if (!isset(self::$_instanceWallet[$currency])) {
			$wallets = self::module()->wallets;
			if (!isset($wallets[$currency])) {
				throw new CException('Кошелек для валюты '. $currency .' не настроен');
			}
			$wallet = $wallets[$currency];
			self::$_instanceWallet[$currency] = new WobWallet($wallet, self::module()->isLocal);
		}
		return self::$_instanceWallet[$currency];
	}

	/**
	 * валюта
	 * @return null|WobCurrency
	 */
	public static function currency()
	{
		if (null === self::$_instanceCurrency) {
			self::$_instanceCurrency = new WobCurrencyCourse();
		}
		return self::$_instanceCurrency;
	}

	/**
	 * почта
	 * @return null|WobCurrency
	 */
	public static function mail()
	{
		if (null === self::$_instanceMail) {
			self::$_instanceMail = new WobMail(self::module()->admin_email, self::module()->admin_name, self::module()->mail_view_path);
		}
		return self::$_instanceMail;
	}

	/**
	 * для не оплаченных заказов запускается процесс проверки статуса
	 */
	public static function startSetStatusPayOrders()
	{
		self::module();
		// получаем все неоплаченные заказы
		$orders = WobOrders::model()->findAll('id_status!=:id_status_1 and id_status!=:id_status_2', array(
			':id_status_1'=>WobOrders::STATUS_READY,
			':id_status_2'=>WobOrders::STATUS_FINISH,
		));
		foreach ($orders as $order) {
			$order->setStatusPay();
		}
	}

	/**
	 * для заявок на вывод запустить отправку средств
	 */
	public static function startSetStatusPayoff()
	{
		if (self::module()->is_activate_address) {
			$orders = WobOrdersPayoff::model()->with('wallet')->findAll('id_status!=:id_status_1 and wallet.is_address_activate = 1', array(
				':id_status_1'=>WobOrders::STATUS_FINISH,
			));
		} else {
			$orders = WobOrdersPayoff::model()->with('wallet')->findAll('id_status!=:id_status_1', array(
				':id_status_1'=>WobOrders::STATUS_FINISH,
			));
		}
		// получаем все неоплаченные заказы
		foreach ($orders as $order) {
			$order->setStatusPay();
		}
	}

	/**
	 * для заказов у которых еще не было выплат запускается процесс выплаты на счет магазина
	 */
	public static function startSetStatusFinishOrders()
	{
		self::module();
		// получаем все завершенные заказы, но по которым не выплачивались средства
		$orders = WobOrders::model()->findAll('id_status=:id_status', array(
			':id_status'=>WobOrders::STATUS_READY
		));
		foreach ($orders as $order) {
			$order->setStatusFinish();
		}
	}

	/**
	 * зупуск обновления курса для пар валют
	 */
	public static function startCourseCurrency()
	{
		self::module();
		$pairs = WobPair::model()->findAll(array('condition'=>'id_currency_1!=id_currency_2', 'order'=>'id_currency_3'));
		foreach ($pairs as $pair) {
			$pair->updateCourse();
		}
	}

	/**
	 * отправит в магазин данные о статусе оплаты
	 * @param $id_order
	 * @param string $status
	 * @return bool
	 */
	public static function sendShop($id_order, $status = self::STATUS_SHOP_OK)
	{
		$order = WobOrders::model()->findByPk($id_order);

		if($order===null)
			return false;

		if (empty($order->shop->password_api) or empty($order->shop->url_result_api) or empty($order->id_order_shop))
			return false;

		$data['status'] = $status;
		$data['merchant_id'] = $order->id_shop;
		$data['id_order_shop'] = $order->id_order_shop;
		$data['amount_shop'] = $order->amount_2;
		$data['amount_pay'] = $order->amount_1;
		$data['currency_code_pay'] = $order->amount_1;
		$data['signature'] = md5(implode('|', array($order->id_order_shop, $order->amount_2, $order->shop->password_api)));

		$result = self::sendResponse($order->shop->url_result_api, $data);
		if ($result===false) {
			return false;
		}
		return $result;
	}

	/**
	 * отправит в магазин данные о статусе оплаты в тестовом режиме
	 * @param $order
	 * @param $shop
	 * @param string $status
	 * @return bool
	 */
	public static function sendShopTest($order, $shop, $status = self::STATUS_SHOP_OK)
	{
		if (empty($shop->password_api) or empty($shop->url_result_api) or empty($order['id_order_shop']))
			return false;

		$data = $order;
		$data['status'] = $status;
		$data['signature'] = md5(implode('|', array($order['id_order_shop'], $order['amount_2'], $shop->password_api)));

		$result = self::sendResponse($shop->url_result_api, $data);
		if ($result===false) {
			return false;
		}
		return $result;
	}

	/**
	 * отправить ответ
	 * @param $url
	 * @param $data
	 * @return bool|string
	 */
	private static function sendResponse($url, $data)
	{
		$_curl = curl_init();
		curl_setopt($_curl, CURLOPT_URL, $url);
		curl_setopt($_curl, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($this->_curl, CURLOPT_FOLLOWLOCATION, $this->options['fallow']);
		curl_setopt($_curl, CURLOPT_HEADER, 0);
		curl_setopt($_curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($_curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($_curl, CURLOPT_POST, true);
		curl_setopt($_curl, CURLOPT_POSTFIELDS, $data);
		$contents = trim(curl_exec($_curl));
		$error_code = curl_errno($_curl);
		if ($contents === false or $error_code != 0) {
			$_error_code = curl_errno($_curl);
			$_error_string = curl_error($_curl);
			curl_close($_curl);
			self::log(__CLASS__ . "Error code: ". $_error_code ." - Error string: ". $_error_string, __METHOD__);
			return false;
		}
		return $contents;
	}

	/**
	 * хеш для строки
	 * @param string $string
	 * @return string
	 */
	public static function encrypting($string="")
	{
		return md5($string);
	}

	/**
	 * запись в лог
	 * @param $message
	 * @param string $name
	 * @param $level
	 */
	public static function log($message, $name = 'empty', $level = CLogger::LEVEL_INFO)
	{
		if (self::module()->enableLogging) {
			Yii::log($message, $level, $name);
		}
	}
}