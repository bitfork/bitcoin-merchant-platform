<?php

/**
 * This is the model class for table "shops".
 *
 * The followings are the available columns in table 'shops':
 * @property integer $id
 * @property integer $id_user
 * @property string $url
 * @property string $name
 * @property string $email_admin
 * @property string $password_api
 * @property string $url_result_api
 * @property integer $id_currency_2
 * @property string $id_currency_1
 * @property integer $is_test_mode
 * @property integer $is_commission_shop
 * @property double $commission
 * @property integer $is_enable
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class WobShops extends WobActiveRecord
{
	public function scopes()
	{
		return array(
			'my'=>array(
				'condition'=>'id_user=:id_user',
				'params'=>array(
					':id_user'=>Yii::app()->user->getId()
				),
			),
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shops';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, url, name, create_date, mod_date', 'required'),
			array('id_user, id_currency_2, is_test_mode, is_commission_shop, is_enable, is_active', 'numerical', 'integerOnly'=>true),
			array('commission', 'numerical'),
			array('url, url_result_api', 'length', 'max'=>2048),
			array('name, email_admin, password_api', 'length', 'max'=>1024),
			array('email_admin', 'email'),
			array('url, url_result_api', 'url',	'pattern'=>'/^({schemes}:\/\/)?(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i'),
			array('url, url_result_api', 'length', 'max'=>2048),
			array('id_currency_1', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, url, name, email_admin, password_api, url_result_api, id_currency_2, is_test_mode, is_commission_shop, commission, id_currency_1, is_enable, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'orders'=>array(self::HAS_MANY, 'WobOrders', 'id_shop'),
			'wallets'=>array(self::HAS_MANY, 'WobUsersWallet', 'id_user'),
			'currency_2'=>array(self::BELONGS_TO, 'WobCurrency', 'id_currency_2'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => WobModule::t('main', 'ID'),
			'id_user' => WobModule::t('main', 'Id User'),
			'url' => WobModule::t('main', 'Url'),
			'name' => WobModule::t('main', 'Name'),
			'email_admin' => WobModule::t('main', 'Email Admin'),
			'password_api' => WobModule::t('main', 'Password Api'),
			'url_result_api' => WobModule::t('main', 'Url Result Api'),
			'id_currency_2' => WobModule::t('main', 'Currency order'),
			'id_currency_1' => WobModule::t('main', 'Payment Methods'),
			'is_test_mode' => WobModule::t('main', 'Mode'),
			'is_commission_shop' => WobModule::t('main', 'Is Commission Shop'),
			'commission' => WobModule::t('main', 'Commission'),
			'is_enable' => WobModule::t('main', 'Is Enable'),
			'is_active' => WobModule::t('main', 'Is Active'),
			'create_date' => WobModule::t('main', 'Create Date'),
			'mod_date' => WobModule::t('main', 'Mod Date'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email_admin',$this->email_admin,true);
		$criteria->compare('password_api',$this->password_api,true);
		$criteria->compare('url_result_api',$this->url_result_api,true);
		$criteria->compare('id_currency_2',$this->id_currency_2);
		$criteria->compare('id_currency_1',$this->id_currency_1,true);
		$criteria->compare('is_test_mode',$this->is_test_mode);
		$criteria->compare('is_commission_shop',$this->is_commission_shop);
		$criteria->compare('commission',$this->commission);
		$criteria->compare('is_enable',$this->is_enable);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('mod_date',$this->mod_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WobShops the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeValidate()
	{
		if (is_array($this->id_currency_1)) {
			if (empty($this->id_currency_1[0])) {
				$this->id_currency_1 = null;
			} else {
				$this->id_currency_1 = implode(',', $this->id_currency_1);
				if (empty($this->id_currency_1)) {
					$this->id_currency_1 = null;
				}
			}
		}
		if ($this->isNewRecord) {
			$this->id_user = Yii::app()->user->getId();
			$this->commission = Wob::module()->commissionDefault;
			if ($this->is_commission_shop===null) {
				$this->is_commission_shop = Wob::module()->isCommissionShopDefault;
			}
		}
		return parent::beforeValidate();
	}

	protected function afterSave()
	{
		parent::afterSave();

		if (!is_array($this->id_currency_1) and !empty($this->id_currency_1)) {
			$this->id_currency_1 = explode(',', $this->id_currency_1);
		}
		if (!empty($this->id_currency_1)) {
			foreach ($this->id_currency_1 as $id_currency) {
				$wallet = WobUsersWallet::model()->find('id_user=:id_user and id_currency=:id_currency', array(
					':id_user'=>$this->id_user,
					':id_currency'=>$id_currency,
				));
				if ($wallet===null) {
					$wallet = new WobUsersWallet();
					$wallet->id_currency = $id_currency;
					$wallet->id_user = $this->id_user;
					$wallet->volume = 0;
					$wallet->save();
				}
			}
		}
	}

	/**
	 * список магазинов пользователя
	 * @return CActiveDataProvider
	 */
	public function getListMy()
	{
		$criteria=new CDbCriteria;
		$criteria->scopes = 'my';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * список доступных валют для оплаты в магазине
	 * @return array
	 */
	public function getCurrencyPay()
	{
		return (empty($this->id_currency_1)) ? array() : explode(',', (string)$this->id_currency_1);
	}

	/**
	 * список доступных валют для оплаты в магазине
	 * @return array
	 */
	public function getStrCurrencyPay()
	{
		$in = $this->getCurrencyPay();
		if (count($in)>0) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id', $in);
			$currencies = CHtml::listData(WobCurrency::model()->findAll($criteria), 'id', 'name');
			return implode(', ', $currencies);
		}
		return '';
	}

	/**
	 * режим магазина
	 * @return string
	 */
	public function getStrIsTestMode()
	{
		if ($this->is_test_mode!=1)
			return WobModule::t('main', 'test');
		return WobModule::t('main', 'worker');
	}
}
