<?php

/**
 * This is the model class for table "command_executing".
 *
 * The followings are the available columns in table 'command_executing':
 * @property integer $id
 * @property integer $device_id
 * @property string $dt
 * @property char $state
 * @property integer $command_id
 * @property integer $value1
 * @property integer $value2
 */
class CommandExecuting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'command_executing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, command_id', 'numerical', 'integerOnly'=>true),
			array('dt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, device_id, dt, state, command_id', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'device_id' => 'Device',
			'dt' => 'Dt',
			'state' => 'State',
			'command_id' => 'Command',
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
		$criteria->compare('dt',$this->dt,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('command_id',$this->command_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CommandExecuting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        const MASSAGE = 9;
        const SETTINGS = 8;
        const RESTART = 11;
}
