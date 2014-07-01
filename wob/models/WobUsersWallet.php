<?php

/**
 * This is the model class for table "users_wallet".
 *
 * The followings are the available columns in table 'users_wallet':
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_currency
 * @property double $volume
 * @property string $address
 * @property integer $is_address_activate
 * @property string $activate_key
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class WobUsersWallet extends WobActiveRecord
{
	const ON_ADDRESS = 'adress';

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
		return 'users_wallet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_currency, volume, create_date, mod_date', 'required'),
			array('address', 'required', 'on'=>self::ON_ADDRESS),
			array('id_user, id_currency, is_address_activate, is_active', 'numerical', 'integerOnly'=>true),
			array('volume', 'numerical'),
			array('address, activate_key', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, id_currency, volume, address, is_address_activate, activate_key, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
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
			'currency'=>array(self::BELONGS_TO, 'WobCurrency', 'id_currency'),
			'payoffs'=>array(self::HAS_MANY, 'WobOrdersPayoff', 'id_wallet'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'Id User',
			'id_currency' => 'Id Currency',
			'volume' => 'Volume',
			'address' => 'Address',
			'is_address_activate' => 'Is Address Activate',
			'activate_key' => 'Activate Key',
			'is_active' => 'Is Active',
			'create_date' => 'Create Date',
			'mod_date' => 'Mod Date',
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
		$criteria->compare('id_currency',$this->id_currency);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('is_address_activate',$this->is_address_activate);
		$criteria->compare('activate_key',$this->activate_key,true);
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
	 * @return WobUsersWallet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterValidate()
	{
		parent::afterValidate();
		$this->is_address_activate=1;
		if ($this->scenario == self::ON_ADDRESS and Wob::module()->is_activate_address) {
			$this->is_address_activate=0;
			$this->activate_key=Wob::encrypting(microtime());
		}
	}

	protected function afterSave()
	{
		parent::afterSave();
		if ($this->scenario == self::ON_ADDRESS and Wob::module()->is_activate_address) {
			$this->sendMail();
		}
	}

	/**
	 * отправляет email
	 */
	public function sendMail()
	{
		if (isset(Yii::app()->user->email) and !empty(Yii::app()->user->email)) {
			$subject = 'активация';
			$activation_url = Yii::app()->createAbsoluteUrl('/wob/wallet/activation',array("id" => $this->id, "key" => $this->activate_key));
			Wob::mail()->send(Yii::app()->user->email, $subject, $activation_url);
		}
	}

	/**
	 * добавить в кошелек средства
	 * @param $id_user
	 * @param $volume
	 * @param $id_currency
	 * @return bool
	 */
	public static function up($id_user, $volume, $id_currency)
	{
		$wallet = self::model()->find('id_user=:id_user AND id_currency=:id_currency',
			array (
				':id_user'=>$id_user,
				':id_currency'=>$id_currency,
			));
		if ($wallet===null) {
			$wallet = new WobUsersWallet();
			$wallet->id_user = $id_user;
			$wallet->id_currency = $id_currency;
		}

		$wallet->volume = $wallet->volume + $volume;

		if ($wallet->save()) {
			return true;
		}
		Wob::log(__CLASS__ . "errors save wallet: " . $wallet->id . var_export(func_get_args(), true), __METHOD__);
		return false;
	}

	/**
	 * снять с кошелека средства
	 * @param $id_user
	 * @param $volume
	 * @param $id_currency
	 * @return bool
	 */
	public static function down($id_user, $volume, $id_currency)
	{
		$wallet = self::model()->find('id_user=:id_user AND id_currency=:id_currency',
			array (
				':id_user'=>$id_user,
				':id_currency'=>$id_currency,
			));
		if ($wallet===null) {
			$wallet = new WobUsersWallet();
			$wallet->id_user = $id_user;
			$wallet->id_currency = $id_currency;
		}

		$wallet->volume = $wallet->volume - $volume;

		if ($wallet->save()) {
			return true;
		}
		Wob::log(__CLASS__ . "errors save down wallet: " . $wallet->id . var_export(func_get_args(), true), __METHOD__);
		return false;
	}

	/**
	 * список счетов пользователя
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
	 * список валют для которых не указаны адреса для вывода
	 * @param $not
	 * @return mixed
	 */
	public static function getCurrencyEmpty($not = null)
	{
		$criteria=new CDbCriteria;
    	$criteria->join = 'LEFT JOIN users_wallet AS pv ON (pv.id_currency=t.id and pv.id_user=:id_user)';
    	if ($not===null)
			$criteria->condition = 'pv.id is null';
		else
			$criteria->condition = 'pv.id is null or t.id = :not_id';
    	$criteria->params = array(
			':id_user'=>Yii::app()->user->getId(),
		);
		if ($not!==null) {
			$criteria->params = array(
				':id_user'=>Yii::app()->user->getId(),
				':not_id'=>$not
			);
		}
		return WobCurrency::model()->pay()->findAll($criteria);
	}
}
