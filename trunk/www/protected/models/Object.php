<?php

/**
 * This is the model class for table "object".
 *
 * The followings are the available columns in table 'object':
 * @property string $id
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $type_id
 * @property string $obj
 * @property string $face
 * @property string $phone
 * @property string $comment
 * @property int    $departament_id
 */
class Object extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country, region, city, street, house, type_id, obj, face, phone, comment,departament_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
                        array('city, obj', 'required'),
			array('id, country, region, city, street, house, type.descr, obj, face, phone, comment,object_type,departament_id,departament_name', 'safe', 'on'=>'search'),
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
                    'type' => array(self::BELONGS_TO, 'ObjectType', 'type_id'),
                    'departament' => array(self::BELONGS_TO, 'Departament', 'departament_id'),
                    
		);
	}
        public $object_type;
        public $departament_name;

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Ид',
			'country' => 'Страна',
			'region' => 'Регион',
			'city' => 'Город',
			'street' => 'Улица',
			'house' => 'Дом',
			'object_type' => 'Тип',
			'obj' => 'Название объекта',
			'face' => 'Контактное лицо',
			'phone' => 'Телефон',
			'comment' => 'Примечание',
                        'departament_id'=>'Департамент',
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
                
		$criteria->compare('t.id',$this->id);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('house',$this->house,true);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('obj',$this->obj,true);
		$criteria->compare('face',$this->face,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('comment',$this->comment,true);
                $criteria->compare('departament_id',$this->departament_id,true);
                
                $criteria->with = array('type','departament');
                $criteria->compare('type.id',$this->object_type,false);
                $criteria->compare('departament.id',$this->departament_name,false);
                
               
                if (!Yii::app()->user->checkAccess('Superadmin')) {
                    $criteria->addCondition('departament_id = ' . Yii::app()->getModule('user')->user()->departament_id);
                }

		return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'attributes' => array(
                            'object_type' => array(
                                'asc' => 'type.descr ASC',
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
	 * @return Object the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
