<?php

/**
 * This is the model class for table "departament".
 *
 * The followings are the available columns in table 'departament':
 * @property integer $id
 * @property string $name
 * @property string $comment
 * @property string $city
 * @property string $country
 * @property string $region
 * @property string $username
 * @property string $fname
 * @property string $lanme
 * @property string $email
 * @property string $phone
 */
class Departament extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'departament';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>50),
			array('comment', 'length', 'max'=>255),
                        array('name', 'unique'),
                        array('name, city,region,country,username,fname,lname,email,phone', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, comment,city,region,country,username,fname,lname,email,phone', 'safe', 'on'=>'search'),
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
			'id' => 'Ид',
			'name' => 'Название',
			'comment' => 'Комментарий',
                        'city' => 'Город',
                        'country' => 'Страна',
                        'region' => 'Регион',
                        'fname' => 'Имя',
                        'lname' => 'Фамилия',
                        'phone' => 'Телефон',
                        'username'=>'Логин пользователя',
                        'devicees_count'=>'Количество устройcтв'
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('comment',$this->comment,true);
                $criteria->compare('city',$this->city,true);
                $criteria->compare('country',$this->country,true);
                $criteria->compare('region',$this->region,true);
                $criteria->compare('fname',$this->fname,true);
                $criteria->compare('lname',$this->lname,true);
                $criteria->compare('phone',$this->phone,true);
                $criteria->compare('email',$this->email,true);
                $criteria->compare('username',$this->username,true);
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Departament the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public $devicees_count;
        public function getdeviceesCount() {
            return Device::model()->with('object')->count("`object`.departament_id = " . $this->id);
        }
}
