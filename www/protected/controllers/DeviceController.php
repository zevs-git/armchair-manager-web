<?php

class DeviceController extends RController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/admin_navigator';

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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'Cashbox','Coinbox'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'DeviceServiceSettings'),
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
    public function actionCreate() {
        $model = new Device;
        
        $model->object_id = 0; // объект по умолч. - склад

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Device'])) {
            $model->attributes = $_POST['Device'];
            $model->settings_tmpl_id = $_POST['Device']['settings_tmpl_id'];
            if ($model->saveFromTamplate()) {
                    $serviceBase = TmplServiceSettings::model()->findByPk(0);
                    $newService = new DeviceServiceSettings();
                    $newService->attributes = $serviceBase->attributes;
                    $newService->device_id = $model->id;
                    $newService->save();

                    $cashBase = TmplCashboxSettings::model()->findByPk(0);
                    $newCash = new DeviceCashboxSettings();
                    $newCash->attributes = $cashBase->attributes;
                    $newCash->device_id = $model->id;
                    $newCash->save();

                    $coinBase = TmplCoinboxSettings::model()->findByPk(0);
                    $newCoin = new DeviceCoinboxSettings();
                    $newCoin->attributes = $coinBase->attributes;
                    $newCoin->device_id = $model->id;
                    $newCoin->save();
                if (Yii::app()->request->isAjaxRequest) {
                    print 'success';
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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Device'])) {
            $model->attributes = $_POST['Device'];
            if ($model->saveSettings()) {
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

    public function actionSettings($id) {
        $this->redirect("/index.php/SettingsDeviceDetail/admin/$id");
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
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionList() {
        $dataProvider = new CActiveDataProvider('Device');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $this->actionAdmin();
    }

    public function actionAdmin() {
        $model = new Device('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Device']))
            $model->attributes = $_GET['Device'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Device::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($model->object->departament_id != Yii::app()->getModule('user')->user()->departament_id && !Yii::app()->user->checkAccess('Superadmin'))
            throw new CHttpException(404, 'У Вас нет прав на доступ к этому устройтву.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'device-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDeviceServiceSettings($id) {
        if (isset($_POST['DeviceServiceSettings'])) {
            $deviceServiceSettings = DeviceServiceSettings::model()->findByPk($id);
            if (is_null($deviceServiceSettings)) {
                $deviceServiceSettings = new DeviceServiceSettings();
                $deviceServiceSettings->device_id = $id;
            }
            $deviceServiceSettings->attributes = $_POST['DeviceServiceSettings'];
            if ($deviceServiceSettings->save()) {
                $device = Device::model()->findByPk($id);
                $device->saveSettings();
                $this->redirect(array('DeviceServiceSettings', 'id' => $deviceServiceSettings->device_id, 'is_save' => 'true'));
                return;
            } else {
                $this->render('service_settings', array(
                    'model' => $this->loadModel($id),
                    'deviceServiceSettings' => $deviceServiceSettings,
                    'is_save' => 'false'
                ));
                return;
            }
        }
        $this->render('service_settings', array(
            'model' => $this->loadModel($id)
        ));
    }

    public function actionCashbox($id) {
        $cashbox = DeviceCashboxSettings::model()->findByPk($id);
        if (is_null($cashbox)) {
            $cashbox = new DeviceCashboxSettings();
        }

        $cashbox->device_id = $id;
        if (isset($_REQUEST['DeviceCashboxSettings'])) {
            $cashbox->attributes = $_REQUEST['DeviceCashboxSettings'];
            if ($cashbox->save()) {
                $device = Device::model()->findByPk($id);
                $device->saveSettings();
                $this->redirect(array('Cashbox', 'id' => $cashbox->device_id, 'is_save' => 'true'));
                return;
            } else {
                $this->render('cashbox', array(
                    'model' => $this->loadModel($id),
                    'cashbox' => $cashbox,
                    'is_save' => 'false'
                ));
            }
        }

        $this->render('cashbox', array(
            'model' => $this->loadModel($id),
            'cashbox' => $cashbox,
        ));
    }
    
    public function actionCoinbox($id) {
        $cashbox = DeviceCoinboxSettings::model()->findByPk($id);
        if (is_null($cashbox)) {
            $cashbox = new DeviceCoinboxSettings();
        }

        $cashbox->device_id = $id;
        if (isset($_REQUEST['DeviceCoinboxSettings'])) {
            $cashbox->attributes = $_REQUEST['DeviceCoinboxSettings'];
            if ($cashbox->save()) {
                $device = Device::model()->findByPk($id);
                $device->saveSettings();
                $this->redirect(array('Coinbox', 'id' => $cashbox->device_id, 'is_save' => 'true'));
                return;
            } else {
                $this->render('cashbox', array(
                    'model' => $this->loadModel($id),
                    'cashbox' => $cashbox,
                    'is_save' => 'false'
                ));
            }
        }

        $this->render('cashbox', array(
            'model' => $this->loadModel($id),
            'cashbox' => $cashbox,
        ));
    }

}
