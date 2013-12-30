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
 * The followings are the available model relations:
 */
class Device extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('settings_id', 'numerical', 'integerOnly'=>true),
			array('soft_version', 'numerical'),
			array('IMEI', 'length', 'max'=>20),
			array('type_id, object_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, IMEI, type_id, soft_version, object_id, settings_id', 'safe', 'on'=>'search'),
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
                        'object' => array(self::BELONGS_TO, 'Object', 'object_id'),
                        'deviceType' => array(self::BELONGS_TO, 'DeviceType', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Ид',
			'IMEI' => 'Сериейный номер (IMEI)',
			'type_id' => 'Тип устройства',
                        'type' => 'Тип устройства',
                        'type_name' => 'Тип устройства',
			'soft_version' => 'Версия ПО',
			'object_id' => 'Объект',
                        'object_val' => 'Объект',
			'settings_id' => 'ИД настроек',
                        'settings_tmpl_id'=>'Шаблон настроек',
                        'comment'=>'Комментарий',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('IMEI',$this->IMEI,true);
		$criteria->compare('type_val',$this->type_id,true);
		$criteria->compare('soft_version',$this->soft_version);
		$criteria->compare('object',$this->object,true);
		$criteria->compare('settings_id',$this->settings_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
       
        /* @var $tmpl_var SettingsTmplDetail */
        public function saveWithSetttings() {
            if($this->isNewRecord) {
                $this->settings_id = 1;
            } else {
                $this->settings_id++;
            }
            $this->save();
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
                    $data .= pack('C',ord('#'));
                    $data .= pack('C',$setings_var->var_id);
                    if ($setings_var->var->size_type_id == 0) {
                        $data .= pack('N',$setings_var->value);
                    } else {
                        $data .= pack('C',  strlen($setings_var->value));
                        $data .= pack('A*',$setings_var->value);
                    }
                }
                $size  = pack('n', strlen($data));
                $crc16 = pack('n', CRC16::calculate($data));
                
                $data = $size . $crc16 . $data;
                file_put_contents($fileName, $data, FILE_BINARY );
            }
            $command = new CommandExecuting();
            $command->device_id = $this->id;
            $command->dt = new CDbExpression('NOW()');
            $command->save();
            return TRUE;
        }
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Device the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
