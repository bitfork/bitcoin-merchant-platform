<?php
class WobCurrencyCourse
{
	public function __construct()
	{

	}

	/**
	 * вернет курс btc / usd
	 * @return float
	 */
	public function getBTCUSD()
	{
		$data = $this->query('http://www.bitfork-rate.com/api/index/index/from/BTC/to/USD');
		if ($data!==false and isset($data['success'], $data['data'], $data['data']['index'])) {
			return (float)$data['data']['index'];
		}
		$this->log('не наден нужный елемент', __METHOD__);
		return false;
	}

	/**
	 * вернет курс ltc / usd
	 * @return float
	 */
	public function getLTCUSD()
	{
		$data = $this->query('http://www.bitfork-rate.com/api/index/index/from/LTC/to/USD');
		if ($data!==false and isset($data['success'], $data['data'], $data['data']['index'])) {
			return (float)$data['data']['index'];
		}
		$this->log('не наден нужный елемент', __METHOD__);
		return false;
	}

	/**
	 * вернет курс drk / usd
	 * @return float
	 */
	public function getDRKUSD()
	{
		$data = $this->query('http://www.bitfork-rate.com/api/index/index/from/DRK/to/USD');
		if ($data!==false and isset($data['success'], $data['data'], $data['data']['index'])) {
			return (float)$data['data']['index'];
		}
		$this->log('не наден нужный елемент', __METHOD__);
		return false;
	}

	/**
	 * записать в лог
	 * @param $message
	 * @param string $method
	 */
	private function log($message, $method)
	{
		Wob::log(__CLASS__ . $message, $method);
	}

	/**
	 * запрос к сторонему сервису
	 * @param $url
	 * @param null $post_data
	 * @param null $headers
	 * @return bool|mixed
	 */
	private function query($url, $post_data = null, $headers = null)
	{
		$ch = null;
		if (is_null($ch)) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.0.1) Gecko');
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		if (is_array($post_data)) {
			$post_data = http_build_query($post_data, '', '&');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		}
		if (is_array($post_data)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		// run the query
		$res = curl_exec($ch);
		if ($res === false) {
			$this->log('Could not get reply: '.curl_error($ch) .' - '. $url, 'query');
			return false;
		}
		$dec = json_decode($res, true);
		if (!$dec) {
			$this->log('Invalid data received, please make sure connection is working and requested API exists - '. $url, 'query');
			return false;
		}
		if (isset($dec['error'])) {
			$this->log($dec['error'] .' - '. $url, 'query');
			return false;
		}
		return $dec;
	}
}