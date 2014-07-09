<?php

/**
 * This is the model class for table "orders_payoff".
 *
 * The followings are the available columns in table 'orders_payoff':
 * @property integer $id
 * @property integer $id_wallet
 * @property integer $id_status
 * @property double $amount
 * @property double $fee
 * @property integer $count_confirm
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class WobOrdersPayoff extends WobActiveRecord
{
	const ON_CREATE = 'create';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orders_payoff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_wallet, amount, create_date, mod_date', 'required'),
			array('id_wallet, id_status, count_confirm, is_active', 'numerical', 'integerOnly'=>true),
			array('amount, fee', 'numerical'),
			array('amount', 'minCurrency', 'on'=>self::ON_CREATE),
			array('amount', 'maxCurrency', 'on'=>self::ON_CREATE),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_wallet, id_status, amount, fee, count_confirm, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * валидация на мииимальное значенние
	 * @param $attribute
	 * @param $params
	 */
	public function minCurrency($attribute, $params)
	{
		if($this->$attribute < 0.1)
			$this->addError($attribute, 'указана слишком маленькая сумма');
	}

	/**
	 * валидация на максимальное значенние доступное на кошельке
	 * @param $attribute
	 * @param $params
	 */
	public function maxCurrency($attribute, $params)
	{
		$limit = WobUsersWallet::model()->findByPk($this->id_wallet);
		if($this->$attribute > $limit->volume)
			$this->addError($attribute, 'указана слишком большая сумма, доступно '. $limit->volume);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'wallet'=>array(self::BELONGS_TO, 'WobUsersWallet', 'id_wallet'),
			'status'=>array(self::BELONGS_TO, 'WobOrdersStatus', 'id_status'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_wallet' => 'Id Wallet',
			'id_status' => 'Id Status',
			'amount' => 'Amount',
			'fee' => 'Fee',
			'count_confirm' => 'Count Confirm',
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
		$criteria->compare('id_wallet',$this->id_wallet);
		$criteria->compare('id_status',$this->id_status);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('count_confirm',$this->count_confirm);
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
	 * @return WobOrdersPayoff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterSave()
	{
		parent::afterSave();
		if ($this->isNewRecord) {
			WobUsersWallet::down($this->wallet->id_user, $this->amount, $this->wallet->id_currency);
		}
	}

	/**
	 * список заявок для кошелька
	 * @param $id_wallet
	 * @return CActiveDataProvider
	 */
	public static function getListByWallet($id_wallet)
	{
		$criteria=new CDbCriteria;
		$criteria->with = array('wallet:my');
		$criteria->condition = 'wallet.id=:id_wallet';
		$criteria->params = array(
			':id_wallet'=>$id_wallet
		);
		if (!isset($_GET['WobOrdersPayoff_sort']))
			$criteria->order='t.id desc';
		return new CActiveDataProvider('WobOrdersPayoff', array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * проверяет новый статус и выставляет его
	 * @return bool
	 */
	public function setStatusPay()
	{
		// если статус уже завершен
		if ($this->id_status == WobOrders::STATUS_FINISH or (Wob::module()->is_activate_address and $this->wallet->is_address_activate == 0)) {
			return true;
		}

		$wallet = Wob::wallet($this->wallet->currency->code);

		$return = $wallet->sendFrom((string)$this->wallet->id_user, (string)$this->wallet->address, (float)$this->amount);
		if ($return!==false) {
			$this->id_status = WobOrders::STATUS_FINISH;
			if ($this->save()) {
				return true;
			}
		}
		Wob::log(__CLASS__ . ' not save: '. $this->id, __METHOD__);
		return false;
	}
}
