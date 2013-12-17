<?php

/**
 * This is the model class for table "settings_device".
 *
 * The followings are the available columns in table 'settings_device':
 * @property integer $id
 * @property integer $device_id
 * @property string $comment
 * @property integer $tmpl_id
 *
 * The followings are the available model relations:
 * @property SettingsTemplate $tmpl
 * @property Device $device
 * @property SettingsDeviceDetail[] $settingsDeviceDetails
 */
class SettingsDevice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings_device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, tmpl_id', 'numerical', 'integerOnly'=>true),
			array('comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, device_id, comment, tmpl_id', 'safe', 'on'=>'search'),
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
			'tmpl' => array(self::BELONGS_TO, 'SettingsTemplate', 'tmpl_id'),
			'device' => array(self::BELONGS_TO, 'Device', 'device_id'),
			'settingsDeviceDetails' => array(self::HAS_MANY, 'SettingsDeviceDetail', 'sett_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'device_id' => 'Device',
			'comment' => 'Комментарий',
			'tmpl_id' => 'Шаблон',
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
		$criteria->compare('device_id',$this->device_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('tmpl_id',$this->tmpl_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SettingsDevice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
