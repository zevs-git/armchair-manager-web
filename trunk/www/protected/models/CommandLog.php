<?php

/**
 * This is the model class for table "command_log".
 *
 * The followings are the available columns in table 'command_log':
 * @property integer $id
 * @property integer $device_id
 * @property string $dt
 * @property integer $command_id
 * @property string $text
 */
class CommandLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'command_log';
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
			array('id, device_id, dt, command_id', 'safe', 'on'=>'search'),
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
                    'message' => array(self::BELONGS_TO, 'logCommandMsg', 'command_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'device_id' => 'Устройство',
			'dt' => 'Дата',
			'command_id' => 'Событие',
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
	public function search($device_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->condition = "device_id = $device_id and dt > CURRENT_DATE()";
		$criteria->compare('id',$this->id);
		$criteria->compare('device_id',$this->device_id);
		$criteria->compare('dt',$this->dt,true);
		$criteria->compare('command_id',$this->command_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array('defaultOrder' => 'dt DESC'),
                        'pagination' => array(
                        'pageSize' => 15,
                        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CommandLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function gettype() {
            switch ($this->message->type) {
                case 'e': $class = 'icon-remove-sign';
                    break;
                case 'w': $class = 'icon-warning-sign';
                    break;
                    default : $class = 'icon-info-sign icon-red';
                    break;
            }
            return "<img class='$class' />";
        }
        
     public function getrowClass() {
            switch ($this->message->type) {
                case 'e': $class = 'error';
                    break;
                case 'w': $class = 'warning';
                    break;
                    default : $class = '';
                    break;
            }
        
        return $class;
    }
}
