<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string = $model->id;
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
         * @var string $role
         * @var timestamp $create_at
         * @var timestamp $lastvisit_at
         * @var int  $departament_id
         * @var strimg $sort_by
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && (Yii::app()->user->checkAccess('Company_admin'))))?array(
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
                        array('role', 'length', 'max'=>20),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1)),
                        array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
                        array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('username, email, superuser, status', 'required'),
			array('superuser, status,departament_id', 'numerical', 'integerOnly'=>true),
			array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, role,departament_id,sort_by', 'safe', 'on'=>'search'),
		):((Yii::app()->user->id==$this->id)?array(
			array('username, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
        
        $relations['departament'] = array(self::BELONGS_TO, 'Departament', 'departament_id');
        return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username'=>UserModule::t("username"),
			'password'=>UserModule::t("password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			'email'=>UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => UserModule::t("Registration date"),
			'role' => 'Роль пользователя',
			'lastvisit_at' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
                        'departament' => 'Дилер',
                        'departament_id' => 'Дилер',
                        'departament.name' => 'Дилер',
                        'profile.staff_state'=>'Статус персонала'
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status,role,departament_id, `departament`.`id`',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'with'=>array("departament" => array(
                    'on'=>"departament.id = user.departament_id")),
            'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.role, user.departament_id,user.sort_by',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_ACTIVE => UserModule::t('Active'),
                                //self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
                        'StaffState'=>array(
                                '0' => 'Нет',
                                '1' => 'Техник',
                                '2' => 'Инкассатор',
                        )
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
        /**
         * Метод возвращает список ролей, которые может создать пользователь
         */
        public static function getRolesList() {
            $_items = array(
                'Admin' => array(
                    array('name'=>'Admin','descr'=>'Supervisor'),
                    array('name'=>'Superadmin','descr'=>'Супер администратор'),
                    array('name'=>'Company_admin','descr'=>'Администратор'),
                    array('name'=>'Operator','descr'=>'Оператор'),
                    array('name'=>'Tehnik','descr'=>'Техник'),
                    array('name'=>'Watcher','descr'=>'Наблюдатель'),
                 ),
                 'Superadmin' => array(
                    array('name'=>'Company_admin','descr'=>'Администратор'),
                    array('name'=>'Operator','descr'=>'Оператор'),
                    array('name'=>'Tehnik','descr'=>'Техник'),
                    array('name'=>'Watcher','descr'=>'Наблюдатель'),
                 ),
                'Company_admin' => array(
                    array('name'=>'Operator','descr'=>'Оператор'),
                    array('name'=>'Tehnik','descr'=>'Техник'),
                    array('name'=>'Watcher','descr'=>'Наблюдатель'),
                 ),
            );
            
            $roles=Rights::getAssignedRoles(Yii::app()->user->Id); // check for single role
                foreach($roles as $role) {
                    if($role->name == 'Admin')
                    {
                        return $_items['Admin'];
                    } elseif ($role->name == 'Superadmin') {
                        return $_items['Superadmin'];
                    } elseif ($role->name == 'Company_admin') {
                        return $_items['Company_admin'];
                    }
                }
                
                return array();
        }
        
        public static function getRolesListSQLStr() {
            $res = array();
            $roles = self::getRolesList();
            foreach($roles as $role) {
                $res[] =  "'" . $role['name'] . "'";
            }
            return " in (" . implode(",", $res) . ") ";
        }
        public function gerRoleDescr() {
            $roles = self::getRolesList();
            foreach ($roles as $role) {
                if ($role['name'] == $this->role) {
                    return $role['descr'];
                }
            }
            return NULL;
        }
	
/**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
         $criteria->with = array('departament');
        $criteria->compare('user.id',$this->id);
        $criteria->compare('user.username',$this->username,true);
        $criteria->compare('user.password',$this->password);
        $criteria->compare('user.email',$this->email,true);
        $criteria->compare('user.activkey',$this->activkey);
        $criteria->compare('user.create_at',$this->create_at);
        $criteria->compare('user.lastvisit_at',$this->lastvisit_at);
        $criteria->compare('user.superuser',$this->superuser);
        $criteria->compare('user.status',$this->status);
        $criteria->compare('user.role',$this->role);
        $criteria->compare('user.departamnet_id',$this->departament_id);
        
        
        if (!Yii::app()->user->checkAccess('Superadmin')) {
            $criteria->addCondition('departament_id = ' . Yii::app()->getModule('user')->user()->departament_id);
        }
        
        
        $criteria->addCondition('role ' . User::getRolesListSQLStr());

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }
    
    public function searchByDepId($dep_id)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->compare('user.id',$this->id);
        $criteria->compare('user.username',$this->username,true);
        $criteria->compare('user.password',$this->password);
        $criteria->compare('user.email',$this->email,true);
        $criteria->compare('user.activkey',$this->activkey);
        $criteria->compare('user.create_at',$this->create_at);
        $criteria->compare('user.lastvisit_at',$this->lastvisit_at);
        $criteria->compare('user.superuser',$this->superuser);
        $criteria->compare('user.status',$this->status);
        $criteria->compare('user.role',$this->role);
        $criteria->compare('user.departament_id',$dep_id);
        
        
       

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }

    public function afterSave() {
        if (get_class(Yii::app())=='CWebApplication'&&Profile::$regMode==false) {
            Yii::app()->user->updateSession();
        }
        return parent::afterSave();
    }
    
    public function GeneretePass() {
       $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $this->password = implode($pass);
        
        return $this->password;
                
    }
}