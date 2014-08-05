<?php
class WobWallet
{
	private $_wallet;
	private $_wallet_name;
	private $_prefix_account = 'wob_';
	private $_is_local = YII_DEBUG;
	private $_currency = null;
	private $_default_count_confirm = 6;

	public function __construct($currency, $is_local = null)
	{
		Yii::import("wob.lib.jsonrpcphp.jsonRPCClient");
		if ($is_local!==null)
			$this->_is_local = $is_local;
		$this->setWallet($currency);
	}

	/**
	 * указать сервис для кошелька
	 * @param string $currency
	 * @return bool
	 */
	public function setWallet($currency)
	{
		$this->_currency = $currency['name'];
		$this->_wallet_name = (isset($currency['name'])) ? $currency['name'] : 'bitcoind';
		$this->_wallet = new jsonRPCClient("http://". $currency['user'] .":". $currency['pass'] ."@". $currency['host'] .":". $currency['port'] ."/");
	}

	/**
	 * вернет имя аккаунта
	 * @param $account
	 * @return string
	 */
	private function getNameAccount($account)
	{
		return (string)($this->_prefix_account . $account);
	}

	/**
	 * признак локали
	 * @return bool|null
	 */
	private function isLocal()
	{
		return $this->_is_local;
	}

	/**
	 * количество необходимых подтверждений
	 * @return int
	 */
	public function getCountConfirm()
	{
		return (isset($this->_currency['count_confirm'])) ?
			$this->_currency['count_confirm'] :
			$this->_default_count_confirm;
	}

	/**
	 * Получение информации из wallet.
	 * @return mixed
	 */
	public function getInfo()
	{
		try {
			$this->_wallet->getinfo();
		} catch (Exception $e) {
			$this->log(var_export(func_get_args(), true) . $e->getMessage(), __METHOD__);
			return false;
		}
	}

	/**
	 * Возвращает число блоков в самой длинной цепочке блоков
	 * @return mixed
	 */
	public function getBlockCount()
	{
		return $this->_wallet->getblockcount();
	}

	/**
	 * @param $blocknum
	 * @return mixed
	 */
	public function getBlockHash($blocknum)
	{
		return $this->_wallet->getblockhash($blocknum);
	}

	/**
	 * Возвращает информацию об указанном хеше блоков
	 * @param $hash
	 * @return mixed
	 */
	public function getBlock($hash)
	{
		return $this->_wallet->getblock($hash);
	}

	/**
	 * Получить инфу о блоке
	 * @param $block
	 * @return mixed
	 */
	public function getBlockInfo($block)
	{
		$hash = $this->getBlockHash($block);
		$block_info = $this->getBlock($hash);
		return $block_info;
	}

	/*
	 * Работа с аккаунтами и адресами
	 */

	/**
	 * Показать все аккаунты
	 * @return mixed
	 */
	public function listAccounts()
	{
		return $this->_wallet->listaccounts();
	}

	/**
	 * Создание нового адреса
	 * @param $account
	 * @return string
	 */
	public function getNewAddress($account)
	{
		if ($this->isLocal()) {
			return 'local';
		}
		$account = $this->getNameAccount($account);
		try {
			return $this->_wallet->getnewaddress($account);
		} catch (Exception $e) {
			$this->log(var_export(func_get_args(), true) . $e->getMessage(), __METHOD__);
			return false;
		}
	}

	/**
	 * Проверка на существование адреса
	 * @param $address
	 * @return mixed
	 */
	public function validateAddress($address)
	{
		return $this->_wallet->validateaddress($address);
	}

	/**
	 * Привязка адреса к аккаунту
	 * @param $address
	 * @param string $account
	 * @return mixed
	 */
	public function setAccount($address, $account="")
	{
		$account = $this->getNameAccount($account);
		return $this->_wallet->setaccount($address, $account);
	}

	/**
	 * Возвращает аккаунт, к которому привязан указанный адресс
	 * @param $address
	 * @return mixed
	 */
	public function getAccount($address)
	{
		return $this->_wallet->getaccount($address);
	}

	/**
	 * Возвращает текущий адресс, на который приходят деньги, в указанном аккаунте
	 * @param $account
	 * @return mixed
	 */
	public function getCountAddress($account)
	{
		$account = $this->getNameAccount($account);
		return $this->_wallet->getaccountaddress($account);
	}

	/**
	 * Возвращает листинг адресов, указанного аккаунта
	 * @param $account
	 * @return mixed
	 */
	public function getAddressesByAccount($account)
	{
		$account = $this->getNameAccount($account);
		return $this->_wallet->getaddressesbyaccount($account);
	}

	/**
	 * Возвращает информацию о транзакции, чей ID указан в качестве параметра
	 * @param $t_id
	 * @return mixed
	 */
	public function getTransaction($t_id)
	{
		return $this->_wallet->gettransaction($t_id);
	}

	/**
	 * возвращает список транзакций аккаунта
	 * @param $account
	 * @param int $count
	 * @return array
	 */
	public function listTransactions($account, $count = 100)
	{
		if ($this->isLocal()) {
			return array();
		}
		$account = $this->getNameAccount($account);
		try {
			return $this->_wallet->listtransactions($account, $count);
		} catch (Exception $e) {
			$this->log(var_export(func_get_args(), true) . $e->getMessage(), __METHOD__);
			return array();
		}
	}

	/*
	 * Операции с биткоинами
	 */

	/**
	 * Получение баланса
	 * Если указан акк, то получаем его баланс, если не указан, то получаем общий баланс сервера
	 * @param string $account
	 * @return mixed
	 */
	public function getBalance($account = "")
	{
		$account = $this->getNameAccount($account);
		return $this->_wallet->getbalance($account);
	}

	/**
	 * Возвращает общее количество биткоинов, принятых указанным кошельком
	 * @param $address
	 * @return float
	 */
	public function getReceivedByAddress($address)
	{
		if ($this->isLocal()) {
			return 0;
		}
		try {
			return $this->_wallet->getreceivedbyaddress($address);
		} catch (Exception $e) {
			$this->log(var_export(func_get_args(), true) . $e->getMessage(), __METHOD__);
			return 0;
		}
	}

	/**
	 * Возвращает общее количество биткоинов, принятых указанным аккаунтом
	 * @param $account
	 * @return mixed
	 */
	public function getReceivedByAccount($account)
	{
		$account = $this->getNameAccount($account);
		return $this->_wallet->getreceivedbyaccount($account);
	}

	/**
	 * Передача биткоинов
	 * @param $account с какого аккаунта
	 * @param $toaddress на какой адресс
	 * @param $btc количество
	 * @param int $minconf
	 * @return mixed
	 */
	public function sendFrom($account, $toaddress, $btc, $minconf = 1)
	{
		if ($this->isLocal()) {
			return true;
		}
		$account = $this->getNameAccount($account);
		try {
			return $this->_wallet->sendfrom($account, (string)$toaddress, (float)$btc, (int)$minconf);
		} catch (Exception $e) {
			$this->log(var_export(func_get_args(), true) . $e->getMessage(), __METHOD__);
			return false;
		}
	}

	/**
	 * записать в лог
	 * @param $message
	 * @param string $method
	 */
	private function log($message, $method)
	{
		Wob::log(__CLASS__ . $message, $this->_wallet_name .'.'. $method);
	}
}