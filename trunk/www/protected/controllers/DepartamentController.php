<?php

class DepartamentController extends RController {

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
                'actions' => array('index', 'view', 'store'),
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

    public function actionStore($id) {
        $obj = Object::model()->find("departament_id = $id and type_id = 14");
        if ($obj) {
            $this->redirect(yii::app()->createUrl("object/devices/$obj->id"));
        } else {
            throw new ExceptionClass('Не удалось найти склад данного департамента');
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new Departament;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Departament'])) {
            $model->attributes = $_POST['Departament'];
            $model->country = "Россия";
            if ($model->validate()) {
                $obj = new Object();
                $obj->departament_id = $model->id;
                $obj->obj = "Склад '" . $model->name . "'";
                $obj->country = "Россия";
                $obj->city = $model->city;
                $obj->face = $model->lname . " " . $model->fname;
                $obj->phone = $model->phone;
                $obj->region = $model->region;
                $obj->type_id = 14;
                /* if ($obj->validate()) {
                  foreach ($obj->errors as $er) {
                  echo $er[0];
                  }
                  } */


                $baseTarif = ObjectTariff::model()->findByPk(0);
                $newTarif = new ObjectTariff();
                $newTarif->attributes = $baseTarif->attributes;

                $user = new User();
                $user->email = $model->email;

                $user->username = $model->username;
                $pass = $user->GeneretePass();
                $user->status = 1;

                $profile = new Profile;
                $profile->user_id = 0;

                $profile->firstname = $model->fname;
                $profile->lastname = $model->lname;
                $profile->phone = $model->phone;

                $obj_s = $obj->validate();
                $user_s = $user->validate();
                $prof_s = $profile->validate();

                if (!$obj_s) {
                    $model->addErrors($obj->errors);
                }
                if (!$user_s) {
                    $model->addErrors($user->errors);
                }
                if (!$prof_s) {
                    $model->addErrors($profile->errors);
                }

                if ($obj_s && $user_s && $prof_s && $model->save()) {
                    $obj->departament_id = $model->id;
                    $obj->save();
                    $newTarif->object_id = $obj->id;
                    $newTarif->save();
                    $user->departament_id = $model->id;
                    $user->role = "Company_admin";
                    if (!$user->save()) {
                        throw new Exception("fail user");
                    }
                    $profile->user_id = $user->id;
                    $profile->sendMail = 1;
                    $profile->sendSMS  = 1;
                    $profile->save();
                    $authorizer = Yii::app()->getModule("rights")->authorizer;
                    $authorizer->authManager->assign($user->role, $user->id);

                    $sender = new MsgSender();
                    $sender->SendEmail($user->id, "Uchetnaya zapis na MagicRest", "Username: '$user->username'; password: '$pass'; http://chair.teletracking.ru/");
                    if (Yii::app()->request->isAjaxRequest) {
                        echo 'success';
                        Yii::app()->end();
                    } else {
                        $this->render('view', array('model' => $model,'is_save'=>true,'username'=>$user->username,'pass'=>$pass));
                        Yii::app()->end();
                    }
                }
            }
        }
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('create', array('model' => $model), false, true);
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Departament'])) {
            $model->attributes = $_POST['Departament'];
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
            $this->renderPartial('update', array('model' => $model), false, true);
        else
            $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if ($id == 0) {
            return false;
        }
        //При удалении департамета все устройства помещаем на склад главного департамента
        $objs = Object::model()->findAll("departament_id = $id");
        foreach ($objs as $obj) {
            $obj->departament_id = 0;
            $tarif = ObjectTariff::model()->find("object_id = $obj->id");
            if ($tarif)
                $tarif->delete();
            $devices = Device::model()->findAll("object_id = $obj->id");
            foreach ($devices as $device) {
                $device->object_id = 0;
                $device->saveSettings();
            }
            $obj->delete();
        }

        $users = User::model()->findAll("departament_id = $id");
        foreach ($users as $user) {
            $pofile = Profile::model()->findByPk($user->id);
            $pofile->delete();
            $user->delete();
        }
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
    public function actionIndex() {
        $this->actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Departament('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Departament']))
            $model->attributes = $_GET['Departament'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionDevices($id) {
        $device = new Device('searchByDepId', $id);
        $device->unsetAttributes();  // clear any default values
        if (isset($_GET['Device']))
            $device->attributes = $_GET['Device'];

        $this->render('devices', array(
            'model' => $this->loadModel($id),
            'devices' => $device
        ));
    }

    public function actionStaff($id) {
        $staff = new Staff('searchByDepId', $id);
        $staff->unsetAttributes();  // clear any default values
        if (isset($_GET['Staff']))
            $staff->attributes = $_GET['Staff'];

        $this->render('staff', array(
            'model' => $this->loadModel($id),
            'staff' => $staff
        ));
    }

    public function actionUser($id) {
        $users = new User('searchByDepId', $id);
        $users->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $users->attributes = $_GET['User'];

        $this->render('users', array(
            'model' => $this->loadModel($id),
            'users' => $users
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Departament::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'departament-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function get_in_translate_to_en($string, $gost = false) {
        if ($gost) {
            $replace = array("А" => "A", "а" => "a", "Б" => "B", "б" => "b", "В" => "V", "в" => "v", "Г" => "G", "г" => "g", "Д" => "D", "д" => "d",
                "Е" => "E", "е" => "e", "Ё" => "E", "ё" => "e", "Ж" => "Zh", "ж" => "zh", "З" => "Z", "з" => "z", "И" => "I", "и" => "i",
                "Й" => "I", "й" => "i", "К" => "K", "к" => "k", "Л" => "L", "л" => "l", "М" => "M", "м" => "m", "Н" => "N", "н" => "n", "О" => "O", "о" => "o",
                "П" => "P", "п" => "p", "Р" => "R", "р" => "r", "С" => "S", "с" => "s", "Т" => "T", "т" => "t", "У" => "U", "у" => "u", "Ф" => "F", "ф" => "f",
                "Х" => "Kh", "х" => "kh", "Ц" => "Tc", "ц" => "tc", "Ч" => "Ch", "ч" => "ch", "Ш" => "Sh", "ш" => "sh", "Щ" => "Shch", "щ" => "shch",
                "Ы" => "Y", "ы" => "y", "Э" => "E", "э" => "e", "Ю" => "Iu", "ю" => "iu", "Я" => "Ia", "я" => "ia", "ъ" => "", "ь" => "",
                " " => "_", '"' => "", "'" => "");
        } else {
            $arStrES = array("ае", "уе", "ое", "ые", "ие", "эе", "яе", "юе", "ёе", "ее", "ье", "ъе", "ый", "ий");
            $arStrOS = array("аё", "уё", "оё", "ыё", "иё", "эё", "яё", "юё", "ёё", "её", "ьё", "ъё", "ый", "ий");
            $arStrRS = array("а$", "у$", "о$", "ы$", "и$", "э$", "я$", "ю$", "ё$", "е$", "ь$", "ъ$", "@", "@");

            $replace = array("А" => "A", "а" => "a", "Б" => "B", "б" => "b", "В" => "V", "в" => "v", "Г" => "G", "г" => "g", "Д" => "D", "д" => "d",
                "Е" => "Ye", "е" => "e", "Ё" => "Ye", "ё" => "e", "Ж" => "Zh", "ж" => "zh", "З" => "Z", "з" => "z", "И" => "I", "и" => "i",
                "Й" => "Y", "й" => "y", "К" => "K", "к" => "k", "Л" => "L", "л" => "l", "М" => "M", "м" => "m", "Н" => "N", "н" => "n",
                "О" => "O", "о" => "o", "П" => "P", "п" => "p", "Р" => "R", "р" => "r", "С" => "S", "с" => "s", "Т" => "T", "т" => "t",
                "У" => "U", "у" => "u", "Ф" => "F", "ф" => "f", "Х" => "Kh", "х" => "kh", "Ц" => "Ts", "ц" => "ts", "Ч" => "Ch", "ч" => "ch",
                "Ш" => "Sh", "ш" => "sh", "Щ" => "Shch", "щ" => "shch", "Ъ" => "", "ъ" => "", "Ы" => "Y", "ы" => "y", "Ь" => "", "ь" => "",
                "Э" => "E", "э" => "e", "Ю" => "Yu", "ю" => "yu", "Я" => "Ya", "я" => "ya", "@" => "y", "$" => "ye",
                " " => "_", '"' => "", "'" => "");

            $string = str_replace($arStrES, $arStrRS, $string);
            $string = str_replace($arStrOS, $arStrRS, $string);
        }

        return iconv("UTF-8", "UTF-8//IGNORE", strtr($string, $replace));
    }

}
