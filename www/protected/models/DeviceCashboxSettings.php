<?php

/**
 * This is the model class for table "device_cashbox_settings".
 *
 * The followings are the available columns in table 'device_cashbox_settings':
 * @property integer $device_id
 * @property integer $model_id
 * @property integer $valuta_id
 * @property integer $volume
 * @property integer $nominal0
 * @property integer $nominal1
 * @property integer $nominal2
 * @property integer $nominal3
 * @property integer $nominal4
 * @property integer $nominal5
 * @property integer $nominal6
 * @property integer $nominal7
 * @property double $coeficient
 */
class DeviceCashboxSettings extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'device_cashbox_settings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('device_id', 'required'),
            array('device_id, model_id, valuta_id, volume, nominal0, nominal1, nominal2, nominal3, nominal4, nominal5, nominal6, nominal7', 'numerical', 'integerOnly' => true),
            array('coeficient', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('device_id, model_id, valuta_id, volume, nominal0, nominal1, nominal2, nominal3, nominal4, nominal5, nominal6, nominal7, coeficient', 'safe', 'on' => 'search'),
        );
    }

    public $models = array(
        '1' => 'Импульсный',
        '2' => 'Цифровой ICT002',
    );
    public $valutes = array(
        0 => 'Рубли'
    );
    public $coeficients = array(
        //0 => '0.05',
        1 => '0.1',
        2 => '0.2',
        5 => '0.5',
        50 => '5',
        100 => '10',
    );

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'device_id' => 'Device',
            'model_id' => 'Модель',
            'valuta_id' => 'Валюта',
            'volume' => 'Емкость',
            'nominal0' => '10',
            'nominal1' => '50',
            'nominal2' => '100',
            'nominal3' => '500',
            'nominal4' => '1000',
            'nominal5' => '5000',
            'nominal6' => '10000',
            'nominal7' => '20000',
            'coeficient' => 'Коэф. перевода импульса в номинал',
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

        $criteria->compare('device_id', $this->device_id);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('valuta_id', $this->valuta_id);
        $criteria->compare('volume', $this->volume);
        $criteria->compare('nominal0', $this->nominal0);
        $criteria->compare('nominal1', $this->nominal1);
        $criteria->compare('nominal2', $this->nominal2);
        $criteria->compare('nominal3', $this->nominal3);
        $criteria->compare('nominal4', $this->nominal4);
        $criteria->compare('nominal5', $this->nominal5);
        $criteria->compare('nominal6', $this->nominal6);
        $criteria->compare('nominal7', $this->nominal7);
        $criteria->compare('coeficient', $this->coeficient);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DeviceCashboxSettings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
