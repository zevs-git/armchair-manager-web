<?php

/**
 * This is the model class for table "v_device_status_report".
 *
 * The followings are the available columns in table 'v_device_status_report':
 * @property integer $device_id
 * @property string $object_id
 * @property string $day
 * @property integer $mp
 * @property integer $pp
 * @property integer $cp
 * @property integer $ep
 */
class VDeviceStatusReport extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'v_device_status_report';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('device_id, m, p, c, e', 'numerical', 'integerOnly' => true),
            array('object_id', 'length', 'max' => 11),
            array('day', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('device_id, object_id, day, mp, pp, cp, ep', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    public $mp;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'device_id' => 'Ид',
            'object_id' => 'Объект',
            'day' => 'Day',
            'mp' => 'M',
            'p' => 'P',
            'c' => 'C',
            'e' => 'E',
        );
    }

    protected function afterFind() {
        parent::afterFind();
        $names = array('m', 'p', 'c', 'e');
        $res = array();
        foreach ($names as $key=>$name) {
            if ($this->{$name} == 0) {
                $res[$name] = 0;
            } elseif (!$this->m && !$this->p && !$this->c && !$this->e) {
                $res[$name] = ($name == 'c') ? 100 : 0;
            } else {
                $res[$name] = round($this->{$name} / ($this->m + $this->p + $this->c + $this->e),2) * 100;
            }
        }
        foreach ($res as $key=>$value) {
            $this->{$key} = $value;
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('device_id', $this->device_id);
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('day', $this->day, true);
        $criteria->compare('mp', $this->mp);
        $criteria->compare('pp', $this->pp);
        $criteria->compare('cp', $this->cp);
        $criteria->compare('ep', $this->ep);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VDeviceStatusReport the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
