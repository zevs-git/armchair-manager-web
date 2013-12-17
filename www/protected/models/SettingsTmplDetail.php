<?php

/**
 * This is the model class for table "settings_tmpl_detail".
 *
 * The followings are the available columns in table 'settings_tmpl_detail':
 * @property integer $id
 * @property integer $tmpl_id
 * @property integer $var_id
 * @property integer $acc_lvl
 * @property string $default
 *
 * The followings are the available model relations:
 * @property SettingsTemplate $tmpl
 * @property SettingsVars $var
 */
class SettingsTmplDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings_tmpl_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tmpl_id, var_id, acc_lvl', 'numerical', 'integerOnly'=>true),
			array('default', 'length', 'max'=>100),
                        array('var_id,acc_lvl', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tmpl_id, var_id, acc_lvl, default', 'safe', 'on'=>'search'),
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
			'tmpl' => array(self::BELONGS_TO, 'SettingsTemplate', 'tmpl_id'),
			'var' => array(self::BELONGS_TO, 'SettingsVars', 'var_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tmpl_id' => 'Идентификатор шаблона',
			'var_id' => 'Переменная',
			'acc_lvl' => 'ИД уровеня доступа',
                        'acc_lvl_val'=>'Уровень доступа',
			'default' => 'Значение по умолчанию',
		);
	}
        
        public function getacc_lvl_val() {
            if ($this->acc_lvl == 0) {
                return "Администратор";
            } else {
                return "Суперадминистратор";
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
	public function search_tmpl($tmpl_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tmpl_id',$tmpl_id);
		$criteria->compare('var_id',$this->var_id);
		$criteria->compare('acc_lvl',$this->acc_lvl);
		$criteria->compare('default',$this->default,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tmpl_id',$this->tmpl_id);
		$criteria->compare('var_id',$this->var_id);
		$criteria->compare('acc_lvl',$this->acc_lvl);
		$criteria->compare('default',$this->default,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SettingsTmplDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
