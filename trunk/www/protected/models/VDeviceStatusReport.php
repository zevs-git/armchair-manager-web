<?php

/**
 * This is the model class for table "v_device_status_report".
 *
 * The followings are the available columns in table 'v_device_status_report':
 * @property integer $device_id
 * @property string $object_id
 * @property string $day
 * @property integer $m
 * @property integer $p
 * @property integer $c
 * @property integer $e
 */
class VDeviceStatusReport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_device_status_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, m, p, c, e', 'numerical', 'integerOnly'=>true),
			array('object_id', 'length', 'max'=>11),
			array('day', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('device_id, object_id, day, m, p, c, e', 'safe', 'on'=>'search'),
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
			'device_id' => 'Ид',
			'object_id' => 'Объект',
			'day' => 'Day',
			'm' => 'M',
			'p' => 'P',
			'c' => 'C',
			'e' => 'E',
		);
	}
        public function getmp() {
            if (($this->m == 0) || (!$this->m && !$this->p && !$this->c && !$this->e)) {
                return 0;
            } else {
                return $this->m / ($this->m + $this->p + $this->c + $this->e) * 100;
            }
        }
        public function getpp() {
            if (($this->p == 0) || (!$this->m && !$this->p && !$this->c && !$this->e)) {
                return 0;
            } else {
                return $this->p / ($this->m + $this->p + $this->c + $this->e) * 100;
            }
        }
        public function getcp() {
            if (!$this->m && !$this->p && !$this->c && !$this->e) {
                return 100;
            } else {
                return $this->c / ($this->m + $this->p + $this->c + $this->e) * 100;
            }
        }
        public function getep() {
            if (($this->e == 0) || (!$this->m && !$this->p && !$this->c && !$this->e)) {
                return 0;
            } else {
                return $this->e / ($this->m + $this->p + $this->c + $this->e) * 100;
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

		$criteria->compare('device_id',$this->device_id);
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('m',$this->m);
		$criteria->compare('p',$this->p);
		$criteria->compare('c',$this->c);
		$criteria->compare('e',$this->e);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VDeviceStatusReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
