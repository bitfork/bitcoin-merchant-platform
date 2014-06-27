<?php

Yii::setPathOfAlias('wob' , dirname(__FILE__));

class WobModule extends CWebModule
{
	public $isLocal = YII_DEBUG;
	public $baseLayout = 'wob.views.layouts.main';
	public $payLayout = 'wob.views.layouts.pay';
	public $enableLogging = false;
	public $wallets = array(
		'btc'=>array(
			'name'=>'btc',
			'count_confirm'=>6,
			'user'=>'admin',
			'pass'=>'password',
			'host'=>'yandex.ru',
			'port'=>'8990',
		),
	);
	public $walletDefault = 'btc';
	public $defaultController='shop';
	public $initCss = true;
	public $fileCss = 'bootstrap';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'wob.models.*',
			'wob.components.*',
			'wob.components.helpers.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	public static function t($category, $message, $params=array(), $source=null, $language=null)
	{
		return Yii::t('WobModule.'.$category, $message, $params, $source, $language);
	}

	public function registerScripts()
	{
		if ($this->initCss===false)
			return;
		$assetsUrl = $this->getAssetsUrl();
		$cs = Yii::app()->getClientScript();
		if ($this->fileCss=='bootstrap') {
			$cs->registerCssFile($assetsUrl.'/bootstrap-3.2.0/css/bootstrap.min.css');
			$cs->registerCssFile($assetsUrl.'/css/wob.css');
		} else {
			$cs->registerCssFile($assetsUrl.'/css/default.css');
		}
	}

	public function getAssetsUrl()
	{
		return Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('wob.assets'));
	}
}
