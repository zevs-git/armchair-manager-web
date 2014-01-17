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
 * @property integer $is_conneted
 * @property integer $u_settings
 */
class DeviceStatus extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'device_status';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('device_id, dt', 'required'),
            array('cashbox_state, cash_in_state, error_number, door_state, alarm_state, mas_state, gsm_level, sim_in, pwr_in_id, pwr_ext', 'numerical', 'integerOnly' => true),
            array('device_id, gsm_state_id', 'length', 'max' => 10),
            array('update_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('device_id, dt, cashbox_state, cash_in_state, update_date, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'deviceCashReport' => array(self::HAS_ONE, 'DeviceCashReport', 'device_id'),
            'device' => array(self::BELONGS_TO, 'Device', 'device_id'),
            'deviceCashboxSettings' => array(self::BELONGS_TO, 'DeviceCashboxSettings', 'device_id'),
            'deviceCoinboxSettings' => array(self::BELONGS_TO, 'DeviceCoinboxSettings', 'device_id'),
        );
    }

    public function getstate() {
        return $this->gprs_state_icon . " " .
                $this->gsm_state_icon . " " .
                $this->power_state_icon . " " .
                $this->akb_proc_icon . " " .
                $this->cashbox_state_icon . " " .
                $this->massage_state_icon . " " .
                $this->door_state_icon . " " .
                $this->alarm_state_icon . " " .
                (($this->u_settings) ? "[Обновление настроек]" : "");
    }

    public function getpwr_ext_val() {
        return $this->pwr_ext * 150 . " мВ";
    }

    public function getpwr_in_id_val() {
        $res = "Отключено";

        switch ($this->pwr_in_id) {
            case 0: $res = "Отключено";
                break;
            case 1: $res = "от 3В до 3.8 В";
                break;
            case 2: $res = "10 - от 3.8В до 4.1В";
                break;
            case 3: $res = "более 4.1В";
                break;
        }

        return $res;
    }

    public function getname_val() {
        $val = "Кресло";
        if ($this->device_id == 1) {
            $val = '<b>861785002417983</b>';
        } elseif ($this->device_id == 2) {
            $val = '<b>861785002394348</b>';
        } else {
            $val = "Кресло " . $this->device_id;
        }
        return $val;
    }

    public function getcash_string() {

        return ($this->deviceCashReport->count_cash) ?
                "<table style='width:100%;font-size:12px'><tr>"
                . "<td width=25% style='padding:0;font-weight:700; text-align: center;color: green' rel='tooltip' title='" . $this->deviceCashReport->update_cash . "'>"
                . $this->deviceCashReport->last_cash
                . "</td>"
                . "<td style='padding:0;text-align: center;' width=25% rel='tooltip' title='Наполнение купюрника'>"
                . $this->deviceCashReport->count_cash
                . "/"
                . $this->deviceCashboxSettings->volume
                . "</td>"
                . "<td width=50% style='padding:0;text-align: center; color: green;font-weight:700' rel='tooltip' title='Сумма купюр'>"
                . $this->deviceCashReport->summ_cash
                . " руб.</td>"
                . "</tr></table>" : "-";
    }

    public function getcoin_string() {

        return ($this->deviceCashReport->count_coin) ?
                "<table style='width:100%;font-size:12px'><tr>"
                . "<td width=25% style='padding:0;font-weight:700; text-align: center;color: green' rel='tooltip' title='" . $this->deviceCashReport->update_coin . "'>"
                . $this->deviceCashReport->last_coin
                . "</td>"
                . "<td width=25% style='padding:0;text-align: center;' rel='tooltip' title='Наполнение монетника'>"
                . $this->deviceCashReport->count_coin
                . "/"
                . $this->deviceCoinboxSettings->volume
                . "</td>"
                . "<td width=50% style='padding:0;text-align: center; color: green;font-weight:700' rel='tooltip' title='Сумма монет'>"
                . $this->deviceCashReport->summ_coin
                . " руб.</td>"
                . "</tr></table>" : "-";
    }

    public function getsumm() {
        return ($this->deviceCashReport->summ)?
                "<b style='color:green'>"
                . $this->deviceCashReport->summ
                . " руб.</b>":
                "-";
    }

    public $is_conneted_r = null;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
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
            'power_state_icon' => 'Питание',
            'update_date' => 'Дата сохранения',
            'balance' => 'Баланс',
            'city' => 'Город',
            'object.obj' => 'Объект',
            'summ' => 'Сумма'
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('device.object');
        $criteria->compare('device_id', $this->device->id, true);
        $criteria->compare('dt', $this->dt, true);
        $criteria->compare('cashbox_state', $this->cashbox_state);
        $criteria->compare('cash_in_state', $this->cash_in_state);
        $criteria->compare('error_number', $this->error_number);
        $criteria->compare('door_state', $this->door_state);
        $criteria->compare('alarm_state', $this->alarm_state);
        $criteria->compare('mas_state', $this->mas_state);
        $criteria->compare('gsm_state_id', $this->gsm_state_id, true);
        $criteria->compare('gsm_level', $this->gsm_level);
        $criteria->compare('sim_in', $this->sim_in);
        $criteria->compare('pwr_in_id', $this->pwr_in_id);
        $criteria->compare('pwr_ext', $this->pwr_ext);
        $criteria->compare('update_date', $this->update_date, true);
        $criteria->compare('object.obj', $this->device->object->obj, true);

        $criteria->condition = 'device.id > 0';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'dt DESC',
                'attributes' => array(
                    'object.obj' => array(
                        'asc' => 'object.obj',
                        'desc' => 'object.obj DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function getis_conneted() {
        date_default_timezone_set('Europe/Moscow');
        if ($this->is_conneted_r != null) {
            return $this->is_conneted_r;
        }
        $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($this->update_date);
        if ($diff < (5 * 60)) {
            $this->is_conneted_r = true;
            return true;
        } else {
            $this->is_conneted_r = false;
            return false;
        }
    }

    /*     * *****************device staus icons******************************* */

    private function state_img($file_name, $title) {
        return "<img width='20px' src='/images/state_icons/$file_name' title='$title'>";
    }

    public function getdoor_state_icon() {
        if (!$this->is_conneted) {
            return $this->state_img("door_null.png", "Статус двери неопределен");
        }
        if ($this->door_state) {
            return $this->state_img("door_true.png", "Дверь открыта");
        } else {
            return $this->state_img("door_false.png", "Дверь закрыта");
        }
    }

    public function getcashbox_state_icon() {
        if (!$this->is_conneted) {
            return $this->state_img("cashbox_false.png", "Статус связи с купюрником неопределен");
        }
        if ($this->cashbox_state) {
            return $this->state_img("cashbox_true.png", "Есть связь с купюрником");
        } else {
            return $this->state_img("cashbox_false.png", "Нет связи с купюрником");
        }
    }

    public function getalarm_state_icon() {
        if (!$this->is_conneted) {
            return $this->state_img("alarm_false.png", "Статус тревоги неопределен");
        }
        if ($this->alarm_state) {
            return $this->state_img("alarm_true.png", "Тревога включена");
        } else {
            return $this->state_img("alarm_false.png", "Тревога отключена");
        }
    }

    public function getgsm_level_icon() {

        if (!$this->is_conneted) {
            return $this->state_img("gsm_level_0.png", "Уровень сигнала GSM неопределен");
        } elseif ($this->gsm_level >= 1 && $this->gsm_level < 10) {
            return $this->state_img("gsm_level_1.png", "Уровень сигнала GSM - $this->gsm_level");
        } elseif ($this->gsm_level < 18) {
            return $this->state_img("gsm_level_2.png", "Уровень сигнала GSM - $this->gsm_level");
        } elseif ($this->gsm_level < 25) {
            return $this->state_img("gsm_level_3.png", "Уровень сигнала GSM - $this->gsm_level");
        } elseif ($this->gsm_level >= 25) {
            return $this->state_img("gsm_level_4.png", "Уровень сигнала GSM - $this->gsm_level");
        } else {
            return $this->state_img("gsm_level_0.png", "Уровень сигнала GSM - $this->gsm_level");
        }
    }

    public function getgsm_state_icon() {

        if (!$this->is_conneted) {
            return $this->state_img("gsm_false.png", "Уровень сигнала GSM неопределен");
        } elseif ($this->gsm_level >= 0 && $this->gsm_level < 10) {
            return $this->state_img("gsm_low.png", "Низкий уровень сигнала GSM");
        } elseif ($this->gsm_level < 18) {
            return $this->state_img("gsm_medium.png", "Средний уровень сигнала GSM");
        } else {
            return $this->state_img("gsm_high.png", "Высокий уровень сигнала GSM");
        }
    }

    public function getgprs_state_icon() {
        if ($this->is_conneted) {
            return $this->state_img("gprs_true.png", "объект подключен");
        } else {
            return $this->state_img("gprs_false.png", "объект не подключен");
        }
    }

    public function getmassage_state_icon() {
        if (!$this->is_conneted) {
            return $this->state_img("massage_false.png", "Статус массажа неопределен");
        } elseif ($this->mas_state) {
            return $this->state_img("massage_true.png", "Массаж включен");
        } else {
            return $this->state_img("massage_false.png", "Массаж выключен");
        }
    }

    public function getpower_state_icon() {
        if (!$this->is_conneted) {
            return $this->state_img("power_null.png", "Состояние неопределено");
        } elseif ($this->pwr_ext) {
            return $this->state_img("power_true.png", "Есть питание");
        } else {
            return $this->state_img("power_false.png", "Нет питания");
        }
    }

    public function getakb_state_icon() {
        if (!$this->is_conneted) {
            return $this->state_img("akb_null.png", "Заряд резервного аккумулятора неопределен");
        } elseif ($this->pwr_in_id == 0) {
            return $this->state_img("power_0.png", "Заряд резервного аккумулятора $this->pwr_in_id_val");
        } elseif ($this->pwr_in_id == 1) {
            return $this->state_img("power_1.png", "Заряд резервного аккумулятора $this->pwr_in_id_val");
        } elseif ($this->pwr_in_id == 2) {
            return $this->state_img("power_2.png", "Заряд резервного аккумулятора $this->pwr_in_id_val");
        } elseif ($this->pwr_in_id == 3) {
            return $this->state_img("power_4.png", "Заряд резервного аккумулятора $this->pwr_in_id_val");
        }
    }

    public function getakb_proc_icon() {
        if (!$this->is_conneted) {
            return $this->state_img("akb_null.png", "Заряд аккумулятора неопределен");
        } elseif ($this->pwr_in_id == 0) {
            return $this->state_img("power_0.png", "Аккумулятор требует подзарядки");
        } elseif ($this->pwr_in_id == 1) {
            return $this->state_img("power_1.png", "Низкий заряд аккумулятора");
        } elseif ($this->pwr_in_id == 2) {
            return $this->state_img("power_2.png", "Средний заряд аккумулятора");
        } elseif ($this->pwr_in_id == 3) {
            return $this->state_img("power_4.png", "Высокий заряд аккумулятора");
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DeviceStatus the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
