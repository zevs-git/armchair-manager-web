<?php

class ObjectController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_navigator';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('allow',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
        
        public function actionStaff($id)
	{
            if(isset($_POST['ObjectStaff']))
		{
                        $objectStaff = ObjectStaff::model()->findByPk($id);
                        if (is_null($objectStaff)) {
                            $objectStaff = new ObjectStaff();
                            $objectStaff->object_id = $id;
                        }
			$objectStaff->attributes=$_POST['ObjectStaff'];
			if($objectStaff->save()) {
				$this->redirect(array('staff','id'=>$objectStaff->object_id,'is_save'=>'true'));
                        } else {
                                $this->redirect(array('staff','id'=>$objectStaff->object_id,'is_save'=>'true'));
                        }
		}
		$this->render('staff',array(
			'model'=>$this->loadModel($id),
		));
	}
        
        public function actionTariff($id) {
            if(isset($_POST['ObjectTariff']))
		{
                        $objectTariff = ObjectTariff::model()->findByPk($id);
                        if (is_null($objectTariff)) {
                            $objectTariff = new ObjectTariff();
                            $objectTariff->object_id = $id;
                        }
			$objectTariff->attributes=$_POST['ObjectTariff'];
			if($objectTariff->save()) {
				$this->redirect(array('tariff','id'=>$objectTariff->object_id,'is_save'=>'true'));
                        } else {
                            $this->render('tariff',array(
                        	'model'=>$this->loadModel($id),
                                'objectTariff'=>$objectTariff,
                                'is_save'=>false
                                ));
                            return;
                               // $this->redirect(array('tariff','id'=>$objectTariff->object_id,'is_save'=>'false'));
                        }
		}
                
		$this->render('tariff',array(
			'model'=>$this->loadModel($id)
		));
        }
        
        public function actionDevices($id) {
            $device = new Device('searchByObjectId',$id);
		$device->unsetAttributes();  // clear any default values
		if(isset($_GET['Device']))
			$device->attributes=$_GET['Device'];
                
                $this->render('devices',array(
			'model'=>$this->loadModel($id),
                        'devices'=>$device
		));
        }
        
        public function actionDeviceSelect($id) {
            $model = new Device('search');
            if(isset($_GET['Device'])) // чтобы работали функции поиска нужно передать параметры в модель
            $model->attributes=$_GET['Device'];
            $this->renderPartial('deviceSelect',array(
			'model'=>$model),
                false,true);
        }
        public function actionAddDevice($object_id,$device_id) {
            $device = Device::model()->findByPk($device_id);
            $device->object_id = $object_id;
            if ($device->save()) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
        public function actionDeleteDevice($object_id,$device_id) {
            $device = Device::model()->findByPk($device_id);
            $device->object_id = 0;
            if ($device->save()) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
        
        
        public function actionGetStaffList($field) {
            $model = new Staff('search');
            if(isset($_GET['Staff'])) // чтобы работали функции поиска нужно передать параметры в модель
            $model->attributes=$_GET['Staff'];
            $this->renderPartial('staffSelect',array(
			'model'=>$model,
                        'field'=>$field),
                false,true);
        }
        

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Object;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Object']))
		{
			$model->attributes=$_POST['Object'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Object']))
		{
			$model->attributes=$_POST['Object'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Object('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Object']))
			$model->attributes=$_GET['Object'];

		$this->render('admin',array(
			'model'=>$model
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('Object');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Object the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Object::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Object $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='object-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
