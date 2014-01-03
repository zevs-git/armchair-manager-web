<?php

/**
 * This is the model class for table "settings_device_detail".
 *
 * The followings are the available columns in table 'settings_device_detail':
 * @property integer $id
 * @property integer $sett_id
 * @property integer $var_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property SettingsVars $var
 * @property SettingsDevice $sett
 */
class SettingsDeviceDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings_device_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sett_id, var_id', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sett_id, var_id, value, var_descr', 'safe', 'on'=>'search'),
		);
	}

        public $var_descr;
        
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'var' => array(self::BELONGS_TO, 'SettingsVars', 'var_id'),
			'sett' => array(self::BELONGS_TO, 'SettingsDevice', 'sett_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sett_id' => 'Sett',
			'var_id' => 'Ид',
                        'var_descr' => 'Название',
			'value' => 'Значение',
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
		$criteria->compare('sett_id',$this->sett_id);
		$criteria->compare('var_id',$this->var_id);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                ));
	}
        public function search_sett($device_id) {
            $criteria=new CDbCriteria;
            $criteria->with = array('var');
            $criteria->compare('id',$this->id);
            $criteria->compare('device_id',$device_id);
            $criteria->compare('var_id',$this->var_id);
            $criteria->compare('value',$this->value,true);
            $criteria->compare('var.descr',$this->var_descr,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort' => array(
                    'attributes' => array(
                        'var_descr' => array(
                            'asc' => 'var.descr',
                            'desc' => 'var.descr DESC',
                        ),
                        '*',
                    ),
                ),
            ));
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SettingsDeviceDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
