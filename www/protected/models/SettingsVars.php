<?php

/**
 * This is the model class for table "settings_vars".
 *
 * The followings are the available columns in table 'settings_vars':
 * @property integer $id
 * @property string $descr
 * @property integer $size_type_id
 *
 * The followings are the available model relations:
 * @property SettingsDeviceDetail[] $settingsDeviceDetails
 * @property SettingsTmplDetail[] $settingsTmplDetails
 * @property SizeTypeSpr $sizeType
 */
class SettingsVars extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings_vars';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('size_type_id', 'numerical', 'integerOnly'=>true),
			array('descr', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descr, size_type_id', 'safe', 'on'=>'search'),
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
			'settingsDeviceDetails' => array(self::HAS_MANY, 'SettingsDeviceDetail', 'var_id'),
			'settingsTmplDetails' => array(self::HAS_MANY, 'SettingsTmplDetail', 'var_id'),
			'sizeType' => array(self::BELONGS_TO, 'SizeTypeSpr', 'size_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descr' => 'Descr',
			'size_type_id' => 'Size Type',
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
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('size_type_id',$this->size_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SettingsVars the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
