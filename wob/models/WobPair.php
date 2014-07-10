<?php

/**
 * This is the model class for table "pair".
 *
 * The followings are the available columns in table 'pair':
 * @property integer $id
 * @property integer $id_currency_1
 * @property integer $id_currency_2
 * @property integer $id_currency_3
 * @property integer $is_pay
 * @property double $course
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class WobPair extends WobActiveRecord
{
	public function scopes()
	{
		return array(
			'pay'=>array(
				'condition'=>'is_pay=1',
			),
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pair';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_currency_1, id_currency_2, course, create_date, mod_date', 'required'),
			array('id_currency_1, id_currency_2, id_currency_3, is_pay, is_active', 'numerical', 'integerOnly'=>true),
			array('course', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_currency_1, id_currency_2, id_currency_3, is_pay, course, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
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
			'currency_1'=>array(self::BELONGS_TO, 'WobCurrency', 'id_currency_1'),
			'currency_2'=>array(self::BELONGS_TO, 'WobCurrency', 'id_currency_2'),
			'currency_3'=>array(self::BELONGS_TO, 'WobCurrency', 'id_currency_3'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => WobModule::t('main', 'ID'),
			'id_currency_1' => WobModule::t('main', 'Id Currency 1'),
			'id_currency_2' => WobModule::t('main', 'Id Currency 2'),
			'id_currency_3' => WobModule::t('main', 'Id Currency 3'),
			'is_pay' => WobModule::t('main', 'Is Pay'),
			'course' => WobModule::t('main', 'Course'),
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
		$criteria->compare('id_currency_1',$this->id_currency_1);
		$criteria->compare('id_currency_2',$this->id_currency_2);
		$criteria->compare('id_currency_3',$this->id_currency_3);
		$criteria->compare('is_pay',$this->is_pay);
		$criteria->compare('course',$this->course);
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
	 * @return WobPair the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * обновит курс для пары
	 * @return bool
	 */
	public function updateCourse()
	{
		if (($course = $this->getNewCourse())!==false) {
			$this->course = $course;
			if ($this->save()) {
				return true;
			}
		}
		return false;
	}

	/**
	 * вернет новый курс валюты
	 * @return float
	 */
	public function getNewCourse()
	{
		/*
		ищем метод которым получим курс для пары
		если метод не найден и нет третей валюты то получить ни как не получится
		иначе если есть промежуточная валюта, то попробуем получить через нее
		*/

		$methodGetCourse = 'get'. mb_strtoupper(($this->currency_1->code . $this->currency_2->code), 'utf-8');
		$course = Wob::currency();
		if (method_exists($course, $methodGetCourse)) {
			return $course->$methodGetCourse();
		} else {
			if (empty($this->id_currency_3)) {
				Wob::log(__CLASS__ . " not course: " . $this->id, __METHOD__);
			} else {
				//еще раз проверить правильно ли считается через 3 валюту
				//пробуем посчитать через промежуточную валюту
				$pair_1 = self::model()->find('(id_currency_1=:id_currency_1 and id_currency_2=:id_currency_2) or (id_currency_1=:id_currency_2 and id_currency_2=:id_currency_1)', array(
					':id_currency_1'=>$this->id_currency_3,
					':id_currency_2'=>$this->id_currency_2,
				));
				if ($pair_1!==null) {
					if ($pair_1->id_currency_1 == $this->id_currency_3) {
						$course_1 = $pair_1->course;
					} else {
						$course_1 = 1 / $pair_1->course;
					}

					$pair_2 = self::model()->find('(id_currency_1=:id_currency_1 and id_currency_2=:id_currency_2) or (id_currency_1=:id_currency_2 and id_currency_2=:id_currency_1)', array(
						':id_currency_1'=>$this->id_currency_1,
						':id_currency_2'=>$this->id_currency_3,
					));
					if ($pair_2!==null) {
						if ($pair_2->id_currency_1 == $this->id_currency_1) {
							$course_2 = $pair_2->course;
						} else {
							$course_2 = 1 / $pair_2->course;
						}

						return round($course_1 * $course_2, 8);
					}
				}

				Wob::log(__CLASS__ . " not course middle currency: " . $this->id, __METHOD__);
			}
		}

		return false;
	}
}
