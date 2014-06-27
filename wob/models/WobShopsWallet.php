<?php

/**
 * This is the model class for table "shops_wallet".
 *
 * The followings are the available columns in table 'shops_wallet':
 * @property integer $id
 * @property integer $id_shop
 * @property integer $id_currency
 * @property double $volume
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class WobShopsWallet extends WobActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shops_wallet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_shop, id_currency, volume, create_date, mod_date', 'required'),
			array('id_shop, id_currency, is_active', 'numerical', 'integerOnly'=>true),
			array('volume', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_shop, id_currency, volume, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
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
			'currency' => array(self::BELONGS_TO, 'WobCurrency', 'id_currency'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_shop' => 'Id Shop',
			'id_currency' => 'Id Currency',
			'volume' => 'Volume',
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
		$criteria->compare('id_shop',$this->id_shop);
		$criteria->compare('id_currency',$this->id_currency);
		$criteria->compare('volume',$this->volume);
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
	 * @return WobShopsWallet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * добавить в кошелек средства
	 * @param $id_shop
	 * @param $volume
	 * @param $id_currency
	 * @return bool
	 */
	public static function up($id_shop, $volume, $id_currency)
	{
		$wallet = self::model()->find('id_shop=:id_shop AND id_currency=:id_currency',
			array (
				':id_user'=>$id_shop,
				':id_currency'=>$id_currency,
			));
		if ($wallet===null) {
			$wallet = new WobShopsWallet();
			$wallet->id_shop = $id_shop;
			$wallet->id_currency = $id_currency;
		}

		$wallet->volume = $wallet->volume + $volume;

		if ($wallet->save()) {
			return true;
		}
		Wob::log(__CLASS__ . "errors save wallet: " . $wallet->id . var_export(func_get_args(), true), __METHOD__);
		return false;
	}
}
