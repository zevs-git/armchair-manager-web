<?php

/**
 * This is the model class for table "object_tariff".
 *
 * The followings are the available columns in table 'object_tariff':
 * @property integer $object_id
 * @property integer $lk1_l
 * @property integer $lk1_r
 * @property integer $lk2_l
 * @property integer $lk2_r
 * @property integer $lk3_l
 * @property integer $lk3_r
 * @property integer $lk4_l
 * @property integer $lk4_r
 * @property integer $lk5_l
 * @property integer $lk5_r
 * @property integer $lk6_l
 * @property integer $lk6_r
 * @property integer $lk7_l
 * @property integer $lk7_r
 * @property integer $lk8_l
 * @property integer $lk8_r
 * @property integer $lk9_l
 * @property integer $lk9_r
 * @property integer $lk10_l
 * @property integer $lk10_r
 */
class ObjectTariff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'object_tariff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_id', 'required'),
			array('object_id, lk1_l, lk1_r, lk2_l, lk2_r, lk3_l, lk3_r, lk4_l, lk4_r, lk5_l, lk5_r, lk6_l, lk6_r, lk7_l, lk7_r, lk8_l, lk8_r, lk9_l, lk9_r, lk10_l, lk10_r', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('object_id, lk1_l, lk1_r, lk2_l, lk2_r, lk3_l, lk3_r, lk4_l, lk4_r, lk5_l, lk5_r, lk6_l, lk6_r, lk7_l, lk7_r, lk8_l, lk8_r, lk9_l, lk9_r, lk10_l, lk10_r', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'object_id' => 'Object',
			'lk1_l' => 'Lk1 L',
			'lk1_r' => 'Lk1 R',
			'lk2_l' => 'Lk2 L',
			'lk2_r' => 'Lk2 R',
			'lk3_l' => 'Lk3 L',
			'lk3_r' => 'Lk3 R',
			'lk4_l' => 'Lk4 L',
			'lk4_r' => 'Lk4 R',
			'lk5_l' => 'Lk5 L',
			'lk5_r' => 'Lk5 R',
			'lk6_l' => 'Lk6 L',
			'lk6_r' => 'Lk6 R',
			'lk7_l' => 'Lk7 L',
			'lk7_r' => 'Lk7 R',
			'lk8_l' => 'Lk8 L',
			'lk8_r' => 'Lk8 R',
			'lk9_l' => 'Lk9 L',
			'lk9_r' => 'Lk9 R',
			'lk10_l' => 'Lk10 L',
			'lk10_r' => 'Lk10 R',
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

		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('lk1_l',$this->lk1_l);
		$criteria->compare('lk1_r',$this->lk1_r);
		$criteria->compare('lk2_l',$this->lk2_l);
		$criteria->compare('lk2_r',$this->lk2_r);
		$criteria->compare('lk3_l',$this->lk3_l);
		$criteria->compare('lk3_r',$this->lk3_r);
		$criteria->compare('lk4_l',$this->lk4_l);
		$criteria->compare('lk4_r',$this->lk4_r);
		$criteria->compare('lk5_l',$this->lk5_l);
		$criteria->compare('lk5_r',$this->lk5_r);
		$criteria->compare('lk6_l',$this->lk6_l);
		$criteria->compare('lk6_r',$this->lk6_r);
		$criteria->compare('lk7_l',$this->lk7_l);
		$criteria->compare('lk7_r',$this->lk7_r);
		$criteria->compare('lk8_l',$this->lk8_l);
		$criteria->compare('lk8_r',$this->lk8_r);
		$criteria->compare('lk9_l',$this->lk9_l);
		$criteria->compare('lk9_r',$this->lk9_r);
		$criteria->compare('lk10_l',$this->lk10_l);
		$criteria->compare('lk10_r',$this->lk10_r);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ObjectTariff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
