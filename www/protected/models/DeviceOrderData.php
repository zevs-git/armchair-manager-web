<?php

/**
 * This is the model class for table "device_order_data".
 *
 * The followings are the available columns in table 'device_order_data':
 * @property integer $device_id
 * @property string $dt
 * @property integer $settings_id
 * @property integer $firmware_id
 * @property string $ICCID
 * @property integer $device_id_in
 */
class DeviceOrderData extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device_order_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, dt', 'required'),
			array('device_id, settings_id, firmware_id, device_id_in', 'numerical', 'integerOnly'=>true),
			array('ICCID', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('device_id, dt, settings_id, firmware_id, ICCID, device_id_in', 'safe', 'on'=>'search'),
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
			'device_id' => 'Device',
			'dt' => 'Dt',
			'settings_id' => 'Ид настроек',
			'firmware_id' => 'Версия ПО',
			'ICCID' => 'Номер SIM',
			'device_id_in' => 'Внутренний ИД',
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

		$criteria->compare('device_id',$this->device_id);
		$criteria->compare('dt',$this->dt,true);
		$criteria->compare('settings_id',$this->settings_id);
		$criteria->compare('firmware_id',$this->firmware_id);
		$criteria->compare('ICCID',$this->ICCID,true);
		$criteria->compare('device_id_in',$this->device_id_in);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DeviceOrderData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
