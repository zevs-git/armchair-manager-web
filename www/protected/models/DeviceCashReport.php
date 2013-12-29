<?php

/**
 * This is the model class for table "device_cash_report".
 *
 * The followings are the available columns in table 'device_cash_report':
 * @property integer $device_id
 * @property double $summ
 * @property double $summ_coin
 * @property double $summ_cash
 * @property integer $count_cash
 * @property integer $count_coin
 * @property string $update_date
 * @property integer $last_cash
 * @property integer $last_coin
 */
class DeviceCashReport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device_cash_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id', 'required'),
			array('device_id, count_cash, count_coin, last_cash, last_coin', 'numerical', 'integerOnly'=>true),
			array('summ', 'numerical'),
			array('update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('device_id, summ, count_cash, count_coin, update_date, last_cash, last_coin', 'safe', 'on'=>'search'),
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
			'summ' => 'Summ',
                        'summ_cash' => 'Сумма купюр',
                        'summ_coin' => 'Сумма монет',
			'count_cash' => 'Count Cash',
			'count_coin' => 'Count Coin',
			'update_date' => 'Update Date',
			'last_cash' => 'Last Cash',
			'last_coin' => 'Last Coin',
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
		$criteria->compare('summ',$this->summ);
		$criteria->compare('count_cash',$this->count_cash);
		$criteria->compare('count_coin',$this->count_coin);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('last_cash',$this->last_cash);
		$criteria->compare('last_coin',$this->last_coin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DeviceCashReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
