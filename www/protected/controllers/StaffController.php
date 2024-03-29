<?php

class StaffController extends RController {

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
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Staff;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Staff'])) {
            $model->attributes = $_POST['Staff'];
            if ($model->validate()) {

                $user = new User();
                $user->email = $model->email;

                $user->username = $model->username;
                $pass = $user->GeneretePass();
                $user->status = 1;

                $profile = new Profile;
                $profile->user_id = 0;

                $fio_arr = explode(' ', $model->FIO);
                if (is_array($fio_arr) && isset($fio_arr[1])) {
                    $profile->firstname = $fio_arr[1];
                    $profile->lastname = $fio_arr[0];
                } else {
                    $profile->firstname = $model->FIO;
                    $profile->lastname = $model->FIO;
                }

                $profile->phone = $model->phone;
                $profile->staff_state = ($model->staff_type_id == 0)?2:1;

                $user_s = $user->validate();
                $prof_s = $profile->validate();

                if (!$user_s) {
                    $model->addErrors($user->errors);
                }
                if (!$prof_s) {
                    $model->addErrors($profile->errors);
                }

                if ($user_s && $prof_s && $model->save()) {
                    $user->departament_id = $model->id;
                    $user->role = "Tehnik";
                    if (!$user->save()) {
                        throw new Exception("fail user");
                    }
                    $profile->user_id = $user->id;
                    $profile->save();
                    $authorizer = Yii::app()->getModule("rights")->authorizer;
                    $authorizer->authManager->assign($user->role, $user->id);

                    $sender = new MsgSender();
                    $sender->SendEmail($user->id, "Uchetnaya zapis na MagicRest", "Username: '$user->username'; password: '$pass'; http://chair.teletracking.ru/");
                    $this->render('view', array('model' => $model, 'is_save' => true, 'username' => $user->username));
                    Yii::app()->end();
                }
            }
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

        if (isset($_POST['Staff'])) {
            $model->attributes = $_POST['Staff'];
            //$model->key = hexdec($model->key);
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $this->actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Staff('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Staff']))
            $model->attributes = $_GET['Staff'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Staff the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Staff::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($model->departament_id != Yii::app()->getModule('user')->user()->departament_id && !Yii::app()->user->checkAccess('Superadmin'))
            throw new CHttpException(404, 'У Вас нет прав на доступ к этому объекту.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Staff $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'staff-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
