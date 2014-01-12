<?php

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property integer $id
 * @property string $IMEI
 * @property string $type_id
 * @property double $soft_version
 * @property string $object_id
 * @property integer $settings_tmpl_id
 * @property integer $settings_id
 * @property string $comment
 * @property string $ICCID
 * The followings are the available model relations:
 */
class Device extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'device';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('settings_id', 'numerical', 'integerOnly' => true),
            array('soft_version', 'numerical'),
            array('IMEI', 'length', 'max' => 20),
            array('IMEI', 'required'),
            array('type_id, object_id', 'length', 'max' => 11),
            array('comment', 'length', 'max' => 255),
            array('ICCID, phone, interval, zapros,', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, IMEI, type_id, soft_version, object_id, settings_id,comment, ICCID,object_obj', 'safe', 'on' => 'search'),
            array('id, IMEI, type_id, soft_version, object_id, settings_id,comment, ICCID,object_obj', 'safe', 'on' => 'searchByObjectId'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'object' => array(self::BELONGS_TO, 'Object', 'object_id'),
            'deviceType' => array(self::BELONGS_TO, 'DeviceType', 'type_id')
        );
    }

    public $object_obj;
    
    /*public function afterFind() {
                $this->object_obj = $this->object->obj;
                parent::afterFind();
                return true;
    }*/

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Ид',
            'IMEI' => 'Сериейный номер(IMEI)',
            'type_id' => 'Тип устройства',
            'type' => 'Тип устройства',
            'type_name' => 'Тип устройства',
            'soft_version' => 'Версия ПО',
            'object_id' => 'Объект',
            'object_val' => 'Объект',
            'settings_id' => 'ИД настроек',
            'settings_tmpl_id' => 'Шаблон настроек',
            'comment' => 'Место установки',
            'ICCID' => 'Номер SIM',
            'object_obj' => 'Объект',
            'phone'=>'Номер телефона',
            'interval'=>'Интевал передачяи данных',
            'zapros'=>'Запрос баланса'
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
        $criteria->with = array('object','deviceType');
        $criteria->compare('id', $this->id);
        $criteria->compare('IMEI', $this->IMEI, true);
        $criteria->compare('type_val', $this->type_id, true);
        
        $criteria->compare('soft_version', $this->soft_version);
        //$criteria->compare('object', $this->object, true);
        $criteria->compare('settings_id', $this->settings_id);
        $criteria->compare('t.comment', $this->comment,true);
        $criteria->compare('object.obj', $this->object_obj,true);
        //$criteria->addSearchCondition('object_obj', $this->object->obj,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                'sort' => array(
                    'attributes' => array(
                        'object_obj' => array(
                            'asc' => 'object.obj',
                            'desc' => 'object.obj DESC',
                        ),
                        '*',
                    ),
                ),
        ));
    }

    public function searchByObjectId($object_id) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('IMEI', $this->IMEI, true);
        $criteria->compare('type_val', $this->type_id, true);
        $criteria->compare('soft_version', $this->soft_version);
        $criteria->compare('object_id', $object_id, true);
        $criteria->compare('settings_id', $this->settings_id);
        $criteria->compare('comment', $this->comment);
        //$criteria->compare('object.obj', $this->object->obj);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /* @var $tmpl_var SettingsTmplDetail */

    public function saveFromTamplate() {
        if (!$this->save())
            return false;
        if (!is_null($this->settings_tmpl_id)) {
            $tmpl = SettingsTmplDetail::model()->findAll("tmpl_id = $this->settings_tmpl_id");
            SettingsDeviceDetail::model()->deleteAll("device_id = $this->id");

            $fileName = "settings/$this->IMEI.bin";
            $data = '';
            foreach ($tmpl as $tmpl_var) {
                $setings_var = new SettingsDeviceDetail;
                $setings_var->device_id = $this->id;
                $setings_var->sett_id = 1;
                $setings_var->var_id = $tmpl_var->var_id;
                $setings_var->value = $tmpl_var->default;
                $setings_var->save();
                $data .= pack('C', ord('#'));
                $data .= pack('C', $setings_var->var_id);
                if ($setings_var->var->size_type_id == 0) {
                    $data .= pack('N', $setings_var->value);
                } else {
                    $data .= pack('C', strlen($setings_var->value));
                    $data .= pack('A*', $setings_var->value);
                }
            }

            $crc16 = CRC16::calc($data);
            $size = strlen($data);
            $size_b = pack('n', $size);
            $crc16_b = pack('n', $crc16);

            $data = $size_b . $crc16_b . $data;
            file_put_contents($fileName, $data, FILE_BINARY);
        }
        $state = DeviceStatus::model()->findBYPk($this->id);
        if ($state) {
            $state->u_settings = 1;
            $state->save();
        }

        $tmp = unpack("Nid", $size_b . $crc16_b);
        if (isset($tmp['id'])) {
            $this->settings_id = $tmp['id'];
        } else {
            $this->settings_id = 0;
        }
        $this->save();
        return TRUE;
    }

    /* @var $set_var SettingsDeviceDetail */

    public function saveSettings() {
        $this->getServiceSettings();
        $this->getObjectSettings();
        $set = SettingsDeviceDetail::model()->findAll("device_id = $this->id");
        $fileName = "settings/$this->IMEI.bin";
        $data = '';
        foreach ($set as $set_var) {
            $data .= pack('C', ord('#'));
            $data .= pack('C', $set_var->var_id);
            if ($set_var->var->size_type_id == 0) {
                $data .= pack('N', $set_var->value);
            } else {
                $data .= pack('C', strlen($set_var->value));
                $data .= pack('A*', $set_var->value);
            }
        }
        $crc16 = $this->calcCRC($data);
        $size = strlen($data);
        $size_b = pack('n', $size);
        $crc16_b = pack('n', $crc16);

        $data = $size_b . $crc16_b . $data;
        file_put_contents($fileName, $data, FILE_BINARY);
        $command = new CommandExecuting();
        $command->device_id = $this->id;
        $command->dt = new CDbExpression('NOW()');
        $command->save();
        $tmp = unpack("Nid", $size_b . $crc16_b);
        if (isset($tmp['id'])) {
            $this->settings_id = $tmp['id'];
        } else {
            $this->settings_id = 0;
        }
        $this->save();

        $state = DeviceStatus::model()->findBYPk($this->id);
        $state->u_settings = 1;
        $state->save();

        return TRUE;
    }
    public function getObjectSettings() {
        $objectStaff = ObjectStaff::model()->findByPk($this->object_id);
        
        //Ключи персонала
        if ($objectStaff) {
            if ($objectStaff->incasator1) {
                $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 22");
                $set->value = $objectStaff->incasator1_staff->key;
                $set->save();
            }
            if ($objectStaff->incasator2) {
                $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 23");
                $set->value = $objectStaff->incasator1_staff->key;
                $set->save();
            }
            if ($objectStaff->tehnik1) {
                $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 26");
                $set->value = $objectStaff->tehnik2_staff->key;
                $set->save();
            }
            if ($objectStaff->tehnik2) {
                $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 27");
                $set->value = $objectStaff->tehnik2_staff->key;
                $set->save();
            }
        }
        
        //Настройки тарифа
        $objectTariff = ObjectTariff::model()->findByPk($this->object_id);
        if ($objectTariff) {
            $var = 12;
            for ($k = 1; $k <= 10; $k++) {
                $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = $var");
                $a = unpack("i",pack('v', $objectTariff->{"lk" . $k . "_r"}) . pack('v', $objectTariff->{"lk" . $k . "_l"}));
                $set->value = $a[1];
                $var++;
                $set->save();
            }
        }
    }
    
    public function getServiceSettings() {
        $servSettings = DeviceServiceSettings::model()->findByPk($this->id);        
        if ($servSettings->IP_monitoring) {
            $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 193");
            $set->value = $servSettings->IP_monitoring;
            $set->save();
        }
        if ($servSettings->port_monitoring) {
            $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 1");
            $set->value = $servSettings->IP_monitoring;
            $set->save();
        }
        
        if ($servSettings->IP_config) {
            $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 192");
            $set->value = $servSettings->IP_monitoring;
            $set->save();
        }
        if ($servSettings->port_config) {
            $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 0");
            $set->value = $servSettings->IP_monitoring;
            $set->save();
        }
        
        $deviceCashboxSettings = DeviceCashboxSettings::model()->findByPk($this->id);
        
        $secondBit = 0x00;
        if ($deviceCashboxSettings->nominal0) {
            $secondBit ^= 0x01;
        }
        if ($deviceCashboxSettings->nominal1) {
            $secondBit ^= 0x02;
        }
        if ($deviceCashboxSettings->nominal2) {
            $secondBit ^= 0x04;
        }
        if ($deviceCashboxSettings->nominal3) {
            $secondBit ^= 0x08;
        }
        if ($deviceCashboxSettings->nominal4) {
            $secondBit ^= 0x10;
        }
        if ($deviceCashboxSettings->nominal5) {
            $secondBit ^= 0x20;
        }
        if ($deviceCashboxSettings->nominal6) {
            $secondBit ^= 0x40;
        }
        if ($deviceCashboxSettings->nominal7) {
            $secondBit ^= 0x80;
        }
        $a = unpack("i",pack('v', $deviceCashboxSettings->coeficient) . pack('C', $secondBit) .  pack('C', $deviceCashboxSettings->model_id));
        $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 32");
        $deviceCashboxSettings->save();
        $set->value = $a[1];
        $set->save(); 
        
        
        $deviceCoinboxSettings = DeviceCoinboxSettings::model()->findByPk($this->id);
        
        $secondBit = 0x00;
        if ($deviceCoinboxSettings->nominal0) {
            $secondBit ^= 0x01;
        }
        if ($deviceCoinboxSettings->nominal1) {
            $secondBit ^= 0x02;
        }
        if ($deviceCoinboxSettings->nominal2) {
            $secondBit ^= 0x04;
        }
        if ($deviceCoinboxSettings->nominal3) {
            $secondBit ^= 0x08;
        }
        if ($deviceCoinboxSettings->nominal4) {
            $secondBit ^= 0x10;
        }
        if ($deviceCoinboxSettings->nominal5) {
            $secondBit ^= 0x20;
        }
        if ($deviceCoinboxSettings->nominal6) {
            $secondBit ^= 0x40;
        }
        if ($deviceCoinboxSettings->nominal7) {
            $secondBit ^= 0x80;
        }
        $a = unpack("i",pack('v', $deviceCoinboxSettings->coeficient) . pack('C', $secondBit) .  pack('C', $deviceCoinboxSettings->model_id));
        $set = SettingsDeviceDetail::model()->find("device_id = $this->id and var_id = 33");
        $deviceCoinboxSettings->save();
        $set->value = $a[1];
        $set->save();   
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Device the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
   public function calcCRC($buffer) {
        $crc = 0xFFFF;
        $j = 0;
        
        $len = strlen($buffer);
        
        while ($len--) {
            $crc ^= (ord($buffer[$j++]) << 8) & 0xFFFF;

            for ($i = 0; $i < 8; $i++) {
                $crc = $crc & 0x8000 ? (($crc << 1) & 0xFFFF ) ^ 0x1021 : ($crc << 1) & 0xFFFF;
            }
        }

        return $crc;
    }

}
