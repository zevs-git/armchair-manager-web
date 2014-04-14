<?php

/**
 * This is the model class for table "user_messages".
 *
 * The followings are the available columns in table 'user_messages':
 * @property integer $id
 * @property integer $user_id
 * @property string $dt
 * @property integer $device_id
 * @property integer $msg_code
 * @property integer $read
 * @property integer $email
 * @property integer $sms
 * @property integer $state_id
 */
class UserMessages extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_messages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, device_id, msg_code, read, email, sms', 'numerical', 'integerOnly' => true),
            array('dt', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, dt, device_id, msg_code, read, email, sms', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'message' => array(self::BELONGS_TO, 'logCommandMsg', 'msg_code'),
            'device' => array(self::BELONGS_TO, 'Device', 'device_id'),
            'state' => array(self::BELONGS_TO, 'UserMassageState', 'state_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'dt' => 'Дата/время',
            'device_id' => 'Место установки',
            'msg_code' => 'Сообщение',
            'read' => 'Read',
            'email' => 'Email',
            'sms' => 'Sms',
            'device.object.obj' => 'Объект',
            'state.descr' => 'Статус',
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
        $criteria->with = array('device');
        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('dt', $this->dt, true);
        $criteria->compare('device_id', $this->device_id);
        $criteria->compare('msg_code', $this->msg_code);
        $criteria->compare('read', $this->read);
        $criteria->compare('email', $this->email);
        $criteria->compare('sms', $this->sms);

        if (!Yii::app()->user->checkAccess('Superadmin')) {
            $criteria->addCondition('device.id ' . Device::getAccessIDSQLStr());
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'dt DESC'),
            'pagination' => array(
                'pageSize' => 15,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserMessages the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function getrowState() {
        $profile = Profile::model()->findByPk($this->user_id);
        if ($this->state_id == 2 && $profile)
            $tooltip = "В работе у пользователя "
                    . $profile->getAttribute('firstname')
                    . ' '
                    . $profile->getAttribute('lastname');
        elseif ($this->state_id == 3 && $profile) {
            $tooltip = "Отработано пользователем "
                    . $profile->getAttribute('firstname')
                    . ' '
                    . $profile->getAttribute('lastname');
        } else {
            $tooltip = $this->state->descr;
        }
        return "<span rel='tooltip' title='$tooltip'>" . $this->state->descr . "</span>";
    }

    public function getrowClass() {
        switch ($this->state_id) {
            case 1: $class = 'warning';
                break;
            case 2: $class = 'info';
                break;
            case 3: $class = 'success';
                break;
            default : $class = '';
        }
        return $class;
    }

}
