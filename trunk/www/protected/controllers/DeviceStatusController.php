<?php

class DeviceStatusController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            /* array('allow',  // allow all users to perform 'index' and 'view' actions
              'actions'=>array('index','view'),
              'users'=>array('*'),
              ),
              array('allow', // allow authenticated user to perform 'create' and 'update' actions
              'actions'=>array('create','update'),
              'users'=>array('@'),
              ), */
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'index', 'view', 'grid', 'Summary'),
                'users' => array('admin','pulkovo'),
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
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('view', array(
                'model' => $this->loadModel($id),
                'asDialog' => !empty($_GET['asDialog']),
                    ), false, true);
            Yii::app()->end();
        } else
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new DeviceStatus;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DeviceStatus'])) {
            $model->attributes = $_POST['DeviceStatus'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->device_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
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

        if (isset($_POST['DeviceStatus'])) {
            $model->attributes = $_POST['DeviceStatus'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->device_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('DeviceStatus');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionGrid() {
        if (!Yii::app()->request->isAjaxRequest)
            throw new CHttpException('Url should be requested via ajax only');
        $model = new DeviceStatus('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DeviceStatus']))
            $model->attributes = $_GET['DeviceStatus'];

        $this->renderPartial('_grid', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {        
        $model = new DeviceStatus('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DeviceStatus']))
            $model->attributes = $_GET['DeviceStatus'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DeviceStatus the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DeviceStatus::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DeviceStatus $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'device-status-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSummary() {
        if (Yii::app()->request->isAjaxRequest) {
            

            $result = array();
            $result['device_count'] = Device::model()->count();
            $result['device_connected'] = DeviceStatus::model()->count("unix_timestamp(now()) - unix_timestamp(dt) <= 60*5");
            $result['device_connected_p'] = number_format($result['device_connected'] / $result['device_count'] * 100 , 2, '.', '') . "%";
            $result['device_not_connected'] = $result['device_count'] - $result['device_connected'];
            $result['device_not_connected_p'] = number_format($result['device_not_connected'] / $result['device_count'] * 100, 2, '.', '') . "%";

            $result['cash_summ'] = 0;

            $sql = "SELECT SUM(summ_coin)+SUM(summ_cash) AS res
            FROM device_cash_report c, `device_status` s
            WHERE c.`device_id` = s.`device_id` and unix_timestamp(now()) - unix_timestamp(s.dt) <= 60*5";

            $res = Yii::app()->db->createCommand($sql)
                    ->queryRow();

            if (isset($res['res'])) {
                $result['cash_summ'] = $res['res'];
            }
            $result['cash_summ'] .= ' RUR';
            $res = Yii::app()->db->createCommand()
                    ->select('sum(count_cash + count_coin) as res')
                    ->from('device_cash_report')
                    ->queryRow();

            $sql = "SELECT SUM(a.volume + b.volume) AS res
            FROM device_cashbox_settings a, device_coinbox_settings b, `device_status` s
            WHERE a.`device_id` = b.`device_id` and a.`device_id` = s.`device_id` and unix_timestamp(now()) - unix_timestamp(s.dt) <= 60*5";

            $res1 = Yii::app()->db->createCommand($sql)
                    ->queryRow();
            if (isset($res1['res'])) {
                $volume = $res1['res'];
            } else {
                $volume = 400 * $res['res'];
            }
            

            $sql = "SELECT SUM(count_coin)+SUM(count_cash) AS res
            FROM device_cash_report c, `device_status` s
            WHERE c.`device_id` = s.`device_id` and unix_timestamp(now()) - unix_timestamp(s.dt) <= 60*5";

            $res2 = Yii::app()->db->createCommand($sql)
                    ->queryRow();
            
            if (isset($res['res'])) {
                $result['cash_summ_p'] = number_format($res2['res'] / $volume *100, 2, '.', '') . "%";
            } else {
                $result['cash_summ_p'] = "-";
            }

            echo json_encode($result);
        }
    }

}
