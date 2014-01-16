<?php

/**
 * This is the model class for table "tmpl_servise_settings".
 *
 * The followings are the available columns in table 'tmpl_servise_settings':
 * @property integer $tmpl_id
 * @property string $IP_monitoring
 * @property integer $port_monitoring
 * @property string $IP_config
 * @property integer $port_config
 * @property string $USSD
 */
class TmplServiceSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tmpl_service_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tmpl_id, IP_monitoring, port_monitoring, IP_config, port_config', 'required'),
			array('tmpl_id, port_monitoring, port_config', 'numerical', 'integerOnly'=>true),
			array('IP_monitoring, IP_config, USSD', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tmpl_id, IP_monitoring, port_monitoring, IP_config, port_config, USSD', 'safe', 'on'=>'search'),
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
			'tmpl_id' => 'ID шаблолна',
			'IP_monitoring' => 'IP/DNS мониторинг',
			'port_monitoring' => 'Порт мониторинг',
			'IP_config' => 'IP/DNS конфигуратор',
			'port_config' => 'Порт конфигуратор',
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

		$criteria->compare('tmpl_id',$this->tmpl_id);
		$criteria->compare('IP_monitoring',$this->IP_monitoring,true);
		$criteria->compare('port_monitoring',$this->port_monitoring);
		$criteria->compare('IP_config',$this->IP_config,true);
		$criteria->compare('port_config',$this->port_config);
		$criteria->compare('USSD',$this->USSD,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TmplServiceSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
