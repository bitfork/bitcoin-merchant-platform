<?php
class PayController extends WobController
{
	public function init()
	{
		parent::init();
		$this->layout = Wob::module()->payLayout;
	}

	/**
	 * форма оплаты сгенерированного заказа
	 * @param $id
	 */
	public function actionIndex($hash)
	{
		$this->h1 = 'Pay';
		$order = $this->loadOrderByHash($hash);
		if (empty($order->id_currency_1)) {
			$this->redirect(array('currency','hash'=>$hash));
		}
		$this->render('index',array('order'=>$order));
	}

	public function actionCurrency($hash, $id_currency = null)
	{
		$this->h1 = 'Pay';
		$order = $this->loadOrderByHash($hash);
		if ($id_currency!==null) {
			if ($order->setPayCurrency((int)$id_currency)===false) {
				$this->render('error', array('errors'=>$order->getErrors()));
			}
			$this->redirect(array('index','hash'=>$hash));
		}
		$pairs = $order->getPairsPay();
		$this->render('currency',array('order'=>$order,'pairs'=>$pairs));
	}

	public function actionNew()
	{
		$this->h1 = 'Pay';
		$param = array();
		if (isset($_GET) and isset($_POST)) {
			$param = $_GET + $_POST;
		} elseif (isset($_GET) and !isset($_POST)) {
			$param = $_GET;
		} elseif (!isset($_GET) and isset($_POST)) {
			$param = $_POST;
		}

		$shop = null;
		if (isset($param['merchant_id']))
			$shop=WobShops::model()->findByPk($param['merchant_id']);

		// если у мерчанта включен тестовый режим
		if ($shop!==null and $shop->is_test_mode!=1) {
			$this->h1 = 'Test mode';
			$model=new WobButtonForm;
			$model->attributes = $param;
			$this->render('test', array('model'=>$model));
		} else {
			$order = new WobOrders();
			if ($order->addOrder($param)===true) {
				if (empty($order->id_currency_1))
					$this->redirect(array('currency', 'hash'=>$order->hash));
				else
					$this->redirect(array('index', 'hash'=>$order->hash));
			}

			$this->render('error', array('errors'=>$order->getErrors()));
		}
	}

	/**
	 * отправка запроса о успешной оплате в тестовом режиме
	 */
	public function actionTestSuccess()
	{
		$model=new WobButtonForm;
		$model->scenario = WobButtonForm::ON_IS_TEST;
		if (isset($_POST['ajax']))
		{
			$error = CActiveForm::validate($model);
			if ($error != '[]') {
				echo $error;
			} else {
				$shop = null;
				if (isset($_POST['WobButtonForm']['merchant_id']))
					$shop=WobShops::model()->findByPk($_POST['WobButtonForm']['merchant_id']);
				if ($shop!==null) {
					if ($shop->is_test_mode!=1) {
						$return = "В настройках магазина включен рабочий режим.\nДля тестирования включите тестовый режим.";
					} else {
						$return = Wob::sendShopTest($_POST['WobButtonForm'], $shop);
						if ($return===false) {
							$return = 'Проверьте настройки магазина в личном кабинете.';
						}
					}
				} else {
					$return = 'Не найден указанный магазин';
				}
				echo CJSON::encode(array('content'=>CHtml::encode($return)));
			}
		}
		Yii::app()->end();
	}

	public function loadOrderByHash($hash)
	{
		$model=WobOrders::model()->find('hash=:hash', array(':hash'=>$hash));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}