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
 * @property string $object_id
 * @property integer $settings_id
 *
 * The followings are the available model relations:
 * @property SettingsDevice[] $settingsDevices
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
			array('group_id, settings_id', 'numerical', 'integerOnly'=>true),
			array('soft_version', 'numerical'),
			array('IMEI', 'length', 'max'=>20),
			array('type_id, object_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, IMEI, type_id, group_id, soft_version, object_id, settings_id', 'safe', 'on'=>'search'),
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
			'settingsDevices' => array(self::HAS_MANY, 'SettingsDevice', 'device_id'),
                        'object' => array(self::BELONGS_TO, 'Object', 'object_id'),
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
                        'type' => 'Тип устройства',
			'group_id' => 'Группа устройств',
			'soft_version' => 'Версия ПО',
			'object_id' => 'Объект',
                        'object' => 'Объект',
			'settings_id' => 'ИД настроек',
		);
	}
        
        public function gettype() {
            if ($this->type_id == 0) {
            return "Тип устройтва1";  
            } else {
                return NULL;
            }
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
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('settings_id',$this->settings_id);

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
