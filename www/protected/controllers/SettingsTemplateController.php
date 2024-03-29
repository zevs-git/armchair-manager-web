<?php

class SettingsTemplateController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/settings';

	/**
	 * @return array action filters
	 */
	public function filters() {
            return array(
                'rights', 
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
			array('deny',  // deny all users
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
		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial('view',array('model'=>$this->loadModel($id)));
		else
			$this->render('view',array('model'=>$this->loadModel($id)));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model= new SettingsTemplate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['SettingsTemplate'])){
			$model->attributes=$_POST['SettingsTemplate'];
			if($model->save()){
                            
                                $serviceBase = TmplServiceSettings::model()->findByPk(0);
                                $newService = new TmplServiceSettings();
                                $newService->attributes = $serviceBase->attributes;
                                $newService->tmpl_id = $model->id;
                                $newService->save();
                                
                                $cashBase = TmplCashboxSettings::model()->findByPk(0);
                                $newCash = new TmplCashboxSettings();
                                $newCash->attributes = $cashBase->attributes;
                                $newCash->tmpl_id = $model->id;
                                $newCash->save();
                                
                                $coinBase = TmplCoinboxSettings::model()->findByPk(0);
                                $newCoin = new TmplCoinboxSettings();
                                $newCoin->attributes = $coinBase->attributes;
                                $newCoin->tmpl_id = $model->id;
                                $newCoin->save();
                                
				if(Yii::app()->request->isAjaxRequest){
                                        echo $model->id;
					Yii::app()->end();
				}
				else {
					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}
		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial('_form',array('model'=>$model), false, true);
		else
			$this->render('create',array('model'=>$model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
            $url = $this->createUrl("/settingsTmplDetail/ServiseSettings/$id");
            $this->redirect($url);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
                        if ($id == 0) {  throw new CHttpException(400,'Invalid request. Please do not repeat this request again.'); }
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
                elseif(Yii::app()->request->isAjaxRequest) {
                    if ($id == 0) {  echo "error"; return;}
                    if ($this->loadModel($id)->delete())
                        echo "success";
                    else 
                        echo "error";
                }
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SettingsTemplate');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SettingsTemplate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SettingsTemplate']))
			$model->attributes=$_GET['SettingsTemplate'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SettingsTemplate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='settings-template-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
