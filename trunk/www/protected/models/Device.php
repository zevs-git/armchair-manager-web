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

    /* public function afterFind() {
      $this->object_obj = $this->object->obj;
      parent::afterFind();
      return true;
      } */

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Ид',
            'IMEI' => 'Серийный номер(IMEI)',
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
            'phone' => 'Номер телефона',
            'interval' => 'Интервал передачи данных',
            'zapros' => 'Запрос баланса'
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
        $criteria->with = array('object', 'deviceType');
        $criteria->compare('t.id', $this->id);
        $criteria->compare('IMEI', $this->IMEI, true);
        $criteria->compare('type_val', $this->type_id, true);

        $criteria->compare('soft_version', $this->soft_version);
        //$criteria->compare('object', $this->object, true);
        $criteria->compare('settings_id', $this->settings_id);
        $criteria->compare('t.comment', $this->comment, true);
        $criteria->compare('object.obj', $this->object_obj, true);
        //$criteria->addSearchCondition('object_obj', $this->object->obj,true);


        if (!Yii::app()->user->checkAccess('Superadmin')) {
            $criteria->addCondition('object.departament_id = ' . Yii::app()->getModule('user')->user()->departament_id);
        }

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

        $criteria->with = array('object');
        $criteria->compare('id', $this->id);
        $criteria->compare('IMEI', $this->IMEI, true);
        $criteria->compare('type_val', $this->type_id, true);
        $criteria->compare('soft_version', $this->soft_version);
        $criteria->compare('object_id', $object_id, false);
        $criteria->compare('settings_id', $this->settings_id);
        $criteria->compare('comment', $this->comment);
        //$criteria->compare('object.obj', $this->object->obj);

        if (!Yii::app()->user->checkAccess('Superadmin')) {
            $criteria->addCondition('object.departament_id = ' . Yii::app()->getModule('user')->user()->departament_id);
        }
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function searchByDepId($dep_id) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        
        $criteria = new CDbCriteria;
        $criteria->with = array('object', 'deviceType');
        $criteria->compare('t.id', $this->id);
        $criteria->compare('IMEI', $this->IMEI, true);
        $criteria->compare('type_val', $this->type_id, true);

        $criteria->compare('soft_version', $this->soft_version);
        //$criteria->compare('object', $this->object, true);
        $criteria->compare('settings_id', $this->settings_id);
        $criteria->compare('t.comment', $this->comment, true);
        $criteria->compare('object.obj', $this->object_obj, true);
        $criteria->compare('object.departament_id', $dep_id);
        
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
    

    /* @var $tmpl_var SettingsTmplDetail */

    public function saveFromTamplate() {
        $this->saveSettings();
        return TRUE;
    }

    /* @var $set_var SettingsDeviceDetail */

    public function saveSettings() {
        $this->settings_id = 0;
        $this->save();

        self::UpdateSettingsCommand($this->id);
        return TRUE;
    }
    public static function UpdateSettingsCommand($device_id) {
        $state = DeviceStatus::model()->findBYPk($device_id);
        if ($state) {
            $state->u_settings = 1;
            $state->save();
        }
        Yii::app()->db->createCommand("CALL p_comand_log($device_id,8,'');")->execute();
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
    public static function getAccessIDSQLStr() {
        $res = 'is NULL';
        
        $ids = self::getAccessIDArray();
        if (count($ids) > 0) {
            $res = 'in (' . implode(',', $ids) . ')';
        }
        return $res;
    }
    
    public static function getAccessIDArray() {
        $res = array();
        $rows = Yii::app()->db->createCommand()->select(array('d.id'))
                ->from('device d')
                ->join('object o', 'd.object_id=o.id')
                ->where('o.departament_id=:id', array(':id'=>Yii::app()->getModule('user')->user()->departament_id))
                ->queryAll();
        
        foreach ($rows as $row) {
            $res[] = $row['id'];
        }
        
        return $res;
    }

}
