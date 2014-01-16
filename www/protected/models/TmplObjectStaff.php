<?php

/**
 * This is the model class for table "tmpl_object_staff".
 *
 * The followings are the available columns in table 'tmpl_object_staff':
 * @property integer $object_id
 * @property integer $incasator1
 * @property integer $incasator2
 * @property integer $tehnik1
 * @property integer $tehnik2
 */
class TmplObjectStaff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tmpl_object_staff';
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
			array('object_id, incasator1, incasator2, tehnik1, tehnik2', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('object_id, incasator1, incasator2, tehnik1, tehnik2', 'safe', 'on'=>'search'),
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
			'incasator1' => 'Инкасатор1',
			'incasator2' => 'Инкасатор2',
			'tehnik1' => 'Техник1',
			'tehnik2' => 'Техник2',
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
		$criteria->compare('incasator1',$this->incasator1);
		$criteria->compare('incasator2',$this->incasator2);
		$criteria->compare('tehnik1',$this->tehnik1);
		$criteria->compare('tehnik2',$this->tehnik2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TmplObjectStaff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
