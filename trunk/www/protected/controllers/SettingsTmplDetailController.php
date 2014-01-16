<?php

class SettingsTmplDetailController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/settings';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'ServiceSettings', 'CashBox', 'CoinBox', 'Tariff'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'deleteAll'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('view', array('model' => $this->loadModel($id)));
        else
            $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = NULL) {
        $model = new SettingsTmplDetail;
        $model->tmpl_id = $id;
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);
        if (isset($_POST['SettingsTmplDetail'])) {
            $model->attributes = $_POST['SettingsTmplDetail'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo 'success';
                    Yii::app()->end();
                } else {
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('_form', array('model' => $model), false, true);
        else
            $this->render('create', array('model' => $model));
    }

    public function actionDeleteAll($id) {
        SettingsTmplDetail::model()->deleteAll("tmpl_id = $id");
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SettingsTmplDetail'])) {
            $model->attributes = $_POST['SettingsTmplDetail'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo 'success';
                    Yii::app()->end();
                } else {
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('_form', array('model' => $model), false, true);
        else
            $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        elseif (Yii::app()->request->isAjaxRequest) {
            if ($this->loadModel($id)->delete())
                echo "success";
            else
                echo "error";
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SettingsTmplDetail');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin($id) {
        $model = new SettingsTmplDetail();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SettingsTmplDetail']))
            $model->attributes = $_GET['SettingsTmplDetail'];

        $this->render('admin', array(
            'model' => $model,
            'tmpl_id' => $id
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SettingsTmplDetail::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'settings-tmpl-detail-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionServiceSettings($id) {
        $model = TmplServiceSettings::model()->findByPk($id);
        if (!$model) {
            $model = new TmplServiceSettings();
            $model->tmpl_id = $id;
        }

        if (isset($_POST['TmplServiceSettings'])) {
            $model->attributes = $_POST['TmplServiceSettings'];
            $this->render('service_settings', array(
                'is_save' => $model->save(),
                'model' => $model,
                'tmpl_name' => SettingsTemplate::model()->findByPk($id)->descr,
            ));
            return;
        }

        $this->render('service_settings', array(
            'model' => $model,
            'tmpl_name' => SettingsTemplate::model()->findByPk($id)->descr,
        ));
    }

    public function actionCashBox($id) {
        $model = TmplCashboxSettings::model()->findByPk($id);
        if (!$model) {
            $model = new TmplCashboxSettings();
            $model->tmpl_id = $id;
        }

        if (isset($_POST['TmplCashboxSettings'])) {
            $model->attributes = $_POST['TmplCashboxSettings'];
            $this->render('cashbox', array(
                'is_save' => $model->save(),
                'model' => $model,
                'tmpl_name' => SettingsTemplate::model()->findByPk($id)->descr,
            ));
            return;
        }

        $this->render('cashbox', array(
            'model' => $model,
            'tmpl_name' => SettingsTemplate::model()->findByPk($id)->descr,
        ));
    }

    public function actionCoinBox($id) {
        $model = TmplCoinboxSettings::model()->findByPk($id);
        if (!$model) {
            $model = new TmplCoinboxSettings();
            $model->tmpl_id = $id;
        }

        if (isset($_POST['TmplCoinboxSettings'])) {
            $model->attributes = $_POST['TmplCoinboxSettings'];
            $this->render('coinbox', array(
                'is_save' => $model->save(),
                'model' => $model,
                'tmpl_name' => SettingsTemplate::model()->findByPk($id)->descr,
            ));
            return;
        }

        $this->render('coinbox', array(
            'model' => $model,
            'tmpl_name' => SettingsTemplate::model()->findByPk($id)->descr,
        ));
    }

}
