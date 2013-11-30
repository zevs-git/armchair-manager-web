<?php

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property integer $id
 * @property string $IMEI
 * @property string $type_id
 * @property integer $group_id
 * @property double $soft_version
 * @property string $SIM
 * @property string $object_id
 * @property string $create_user_id
 * @property string $create_date
 * @property string $update_user_id
 * @property string $update_date
 */
class Device extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('IMEI, group_id, type_id', 'required'),
			array('group_id', 'numerical', 'integerOnly'=>true),
			array('soft_version', 'numerical'),
			array('IMEI, SIM', 'length', 'max'=>20),
			array('type_id, object_id, create_user_id, update_user_id', 'length', 'max'=>11),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, IMEI, type_id, group_id, soft_version, SIM, object_id, create_user_id, create_date, update_user_id, update_date', 'safe', 'on'=>'search'),
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
			'id' => 'Ид',
			'IMEI' => 'Сериейный номер (IMEI)',
			'type_id' => 'Тип устройства',
			'group_id' => 'Группа устройств',
			'soft_version' => 'Версия ПО',
			'SIM' => 'номер SIM карты',
			'object_id' => 'Объект',
			'create_user_id' => 'Владелец',
			'create_date' => 'Дата создания',
			'update_user_id' => 'Редактор',
			'update_date' => 'Дата редактирования',
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
		$criteria->compare('IMEI',$this->IMEI,true);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('soft_version',$this->soft_version);
		$criteria->compare('SIM',$this->SIM,true);
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_user_id',$this->update_user_id,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Device the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
