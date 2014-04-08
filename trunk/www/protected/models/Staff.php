<?php

/**
 * This is the model class for table "staff".
 *
 * The followings are the available columns in table 'staff':
 * @property integer $id
 * @property string $FIO
 * @property integer $staff_type_id
 * @property string $key
 * @property string $phone
 * @property string $comment
 * @property integer $object_id
 * @property int    $departament_id
 */
class Staff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'staff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staff_type_id, object_id, departament_id', 'numerical', 'integerOnly'=>true),
			array('FIO, comment', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>20),
                        array('key', 'length', 'max'=>8,'min'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, FIO, staff_type_id, key, phone, comment, object_id, type_descr, departament_id', 'safe', 'on'=>'search'),
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
                    'type' => array(self::BELONGS_TO, 'StaffType', 'staff_type_id'),
                    'departament' => array(self::BELONGS_TO, 'Departament', 'departament_id'),
		);
	}
        public $type_descr;
        public $departament_name;

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'FIO' => 'ФИО',
			'staff_type_id' => 'Тип',
			'key' => 'Номер ключа',
			'phone' => 'Телефон',
			'comment' => 'Примечание',
			'object_id' => 'Объект',
                        'type_descr'=>'Тип персонала',
                        'departament_id'=>'Деапртамент',
                        'departament_name'=>'Департамент'
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
                $criteria->with = array('type','departament');
		$criteria->compare('t.id',$this->id);
		$criteria->compare('FIO',$this->FIO,true);
		$criteria->compare('staff_type_id',$this->staff_type_id);
		$criteria->compare('t.key',$this->key,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('object_id',$this->object_id);
                $criteria->compare('type.descr', $this->type_descr,true);
                $criteria->compare('departament_id',$this->departament_id,true);
                
                if (!Yii::app()->user->checkAccess('Superadmin')) {
                    $criteria->addCondition('departament_id = ' . Yii::app()->getModule('user')->user()->departament_id);
                }

                
		return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                    'sort' => array(
                        'attributes' => array(
                            'type_descr' => array(
                                'asc' => 'type.descr',
                                'desc' => 'type.descr DESC',
                            ),
                            'departament_name' => array(
                                'asc' => 'departament.name ASC',
                                'desc' => 'departament.name DESC',
                            ),
                            '*',
                        ),
                    ),
            ));
	}
        
        public function searchByDepId($dep_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('type','departament');
		$criteria->compare('t.id',$this->id);
		$criteria->compare('FIO',$this->FIO,true);
		$criteria->compare('staff_type_id',$this->staff_type_id);
		$criteria->compare('t.key',$this->key,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('object_id',$this->object_id);
                $criteria->compare('type.descr', $this->type_descr,true);
                $criteria->compare('departament_id',$dep_id,true);
                
                if (!Yii::app()->user->checkAccess('Superadmin')) {
                    $criteria->addCondition('departament_id = ' . Yii::app()->getModule('user')->user()->departament_id);
                }

                
		return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                    'sort' => array(
                        'attributes' => array(
                            'type_descr' => array(
                                'asc' => 'type.descr',
                                'desc' => 'type.descr DESC',
                            ),
                            'departament_name' => array(
                                'asc' => 'departament.name ASC',
                                'desc' => 'departament.name DESC',
                            ),
                            '*',
                        ),
                    ),
            ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Staff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
