<?php

/**
 * This is the model class for table "object_staff".
 *
 * The followings are the available columns in table 'object_staff':
 * @property integer $object_id
 * @property integer $incasator1
 * @property integer $incasator2
 * @property integer $tehnik1
 * @property integer $tehnik2
 */
class ObjectStaff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'object_staff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_id', 'required'),
			array('object_id, incasator1, incasator2, tehnik1, tehnik2', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('object_id, incasator1, incasator2, tehnik1, tehnik2', 'safe', 'on'=>'search'),
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
                    'incasator1_staff' => array(self::BELONGS_TO, 'Staff', 'incasator1'),
                    'incasator2_staff' => array(self::BELONGS_TO, 'Staff', 'incasator2'),
                    'tehnik1_staff' => array(self::BELONGS_TO, 'Staff', 'tehnik1'),
                    'tehnik2_staff' => array(self::BELONGS_TO, 'Staff', 'tehnik2'),
		);
	}
        public function getincasator1_val() {
            return $this->getButton(incasator1,$this->incasator1_staff->FIO);
        }
        public function getincasator2_val() {
            return $this->getButton(incasator2,$this->incasator2_staff->FIO);
        }
        public function gettehnik1_val() {
            return $this->getButton(tehnik1,$this->tehnik1_staff->FIO);
        }
        public function gettehnik2_val() {
            return $this->getButton(tehnik2,$this->tehnik2_staff->FIO);
        }
        
        private function getButton($name,$value) {
            if (is_null($value)) {
                $value = 'Не задан';
            }
            return '<span id="' . $name. '_value" >' . $value .'</span><button class="btn select-btn btn-primary" style="float:right" id="' . $name .'" data-loading-text=" Загрузка ... " type="button" >Выбрать <i class="icon-list"></i></button>';
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'object_id' => 'Object',
			'incasator1' => 'Инкасатор1',
			'incasator2' => 'Инкасатор2',
			'tehnik1' => 'Техник1',
			'tehnik2' => 'Техник2',
                        'incasator1_val'=>'Первый инкасатор',
                        'incasator2_val'=>'Второй инкасатор',
                        'tehnik1_val'=>'Первый техник',
                        'tehnik2_val'=>'Второй техник',
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

		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('incasator1',$this->incasator1);
		$criteria->compare('incasator2',$this->incasator2);
		$criteria->compare('tehnik1',$this->tehnik1);
		$criteria->compare('tehnik2',$this->tehnik2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ObjectStaff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
