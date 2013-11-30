<?php

/**
 * This is the model class for table "device_status".
 *
 * The followings are the available columns in table 'device_status':
 * @property string $device_id
 * @property string $dt
 * @property integer $cashbox_state
 * @property integer $cash_in_state
 * @property integer $error_number
 * @property integer $door_state
 * @property integer $alarm_state
 * @property integer $mas_state
 * @property string $gsm_state_id
 * @property integer $gsm_level
 * @property integer $sim_in
 * @property integer $pwr_in_id
 * @property integer $pwr_ext
 * @property string $update_date
 */
class DeviceStatus extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device_status';
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
			array('cashbox_state, cash_in_state, error_number, door_state, alarm_state, mas_state, gsm_level, sim_in, pwr_in_id, pwr_ext', 'numerical', 'integerOnly'=>true),
			array('device_id, gsm_state_id', 'length', 'max'=>10),
			array('update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('device_id, dt, cashbox_state, cash_in_state, error_number, door_state, alarm_state, mas_state, gsm_state_id, gsm_level, sim_in, pwr_in_id, pwr_ext, update_date', 'safe', 'on'=>'search'),
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
                    'cash'=>array(self::HAS_ONE,'DeviceCashReport','device_id')
		);
	}
        
        public function getstate() {
            return "[Дверь:" . (($this->door_state)?"Откр.":"Закр.") . "];" .
                   "[Купюрник:" . (($this->cashbox_state)?"Вкл.":"Откл.") . "];" .
                   "[Тревога:" . (($this->alarm_state)?"Вкл.":"Откл.") . "];" .
                   "[GSM:" . (($this->gsm_state_id)?"Вкл.":"Откл.") . "];" .
                   "[Масаж:" . (($this->mas_state)?"Вкл.":"Откл.") . "];" .
                    "";
        }
        
        public function getpwr_ext_val() {
            return $this->pwr_ext * 150 . " мВ";
        }
        
        public function getpwr_in_id_val() {
            $res = "Отключено";
            
            switch ($this->pwr_in_id) {
                case 0: $res = "Отключено"; break;
                case 1: $res = "от 3В до 3.8 В"; break;
                case 2: $res = "10 - от 3.8В до 4.1В"; break;
                case 3: $res = "более 4.1В"; break;
            }
            
            return $res;
        }
        public function getname_val() {
            $val = "Кресло";
            if ($this->device_id == 1) {
                $val = '861785002417983';
            } elseif ($this->device_id == 2) {
                $val = '861785002394348';
            }
            else {
                $val = "Кресло " . $this->device_id;
            }
            return $val;            
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'device_id' => 'Название',
			'dt' => 'Последний ответ',
			'cashbox_state' => 'Связь с купюрником',
			'cash_in_state' => 'Прием купюры',
			'error_number' => 'Ошибка',
			'door_state' => 'Дверь',
			'alarm_state' => 'Тревога',
			'mas_state' => 'Массаж',
			'gsm_state_id' => 'GSM модем',
			'gsm_level' => 'GSM Сигнал',
			'sim_in' => 'SIM-карта',
			'pwr_in_id' => 'Заряд',
			'pwr_ext' => 'Напряжение',
			'update_date' => 'Дата сохранения',
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

		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('dt',$this->dt,true);
		$criteria->compare('cashbox_state',$this->cashbox_state);
		$criteria->compare('cash_in_state',$this->cash_in_state);
		$criteria->compare('error_number',$this->error_number);
		$criteria->compare('door_state',$this->door_state);
		$criteria->compare('alarm_state',$this->alarm_state);
		$criteria->compare('mas_state',$this->mas_state);
		$criteria->compare('gsm_state_id',$this->gsm_state_id,true);
		$criteria->compare('gsm_level',$this->gsm_level);
		$criteria->compare('sim_in',$this->sim_in);
		$criteria->compare('pwr_in_id',$this->pwr_in_id);
		$criteria->compare('pwr_ext',$this->pwr_ext);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DeviceStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
