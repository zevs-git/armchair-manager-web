<?php

/**
 * @var UserMessages $model
 */
class UserMessagesController extends RController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'rights',
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
     * Lists all models.
     */
    public function actionIndex() {
        $model = new UserMessages('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserMessages']))
            $model->attributes = $_GET['UserMessages'];

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
        $model = UserMessages::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    //Задача отработана
    public function actionSuccess($id) {
        $model = $this->loadModel($id);
        $model->state_id = 3;
        $model->user_id = Yii::app()->user->id;
        if ($model->save()) {
            $this->SendMessages($model);
            echo "succes";
        }
    }

    //Задача в рабте
    public function actionAccept($id) {
        $model = $this->loadModel($id);
        $model->state_id = 2;
        $model->user_id = Yii::app()->user->id;
        if ($model->save()) {
            $this->SendMessages($model);
            echo "succes";
        }
    }
    //передать задачу пользователю
    public function actionAcceptToUser($id) {
        $task_id = $_REQUEST['task_id'];
        $model = $this->loadModel($task_id);
        $model->state_id = 2;
        $model->user_id = $id;
        if ($model->save()) {
            $this->SendMessages($model);
            echo "succes";
        }
    }
    
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->delete()) {
            echo "succes";
        }
    }

    public function actionUsers($id) {
        $users = new User('searchByDepId', $id);
        $users->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $users->attributes = $_GET['User'];
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('user_select', array(
                'users' => $users,
                'task_id' => $id), false, true);
            Yii::app()->end();
        } else
            $this->render('detail', array(
                'users' => $this->loadModel($id),
                'task_id' => $id
            ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-messages-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    /**
     * 
     * @param int $id
     * @var UserMessages $message
     */
    private function SendMessages($model) {
        //Сформировать тексты сообщений
        if ($model->state_id == 2) {
            $SMStext = "Задание.\r\nОбъект: " . $model->device->object->obj .
                    "\r\nКресло: " . (!empty($model->device->comment)?$model->device->comment:$model->device->id) .
                    "\r\nСобытие:" . $model->message->descr;
            
            $EmailText = 'Получено новое задание. MagicRest'
                . '<br>Город: ' . $model->device->object->city
                . "<br>Объект: " . $model->device->object->obj
                . "<br>Кресло: [" . $model->device_id . "] " . $model->device->comment
                . "<br>Событие: " . $model->message->descr
                . "<br>http://chair.teletracking.ru/";
            
            $subject = 'Получено новое задание.'
                . ' Город: ' . $model->device->object->city
                . ". Объект: " . $model->device->object->obj
                . ". Кресло: [" . $model->device_id . "] " . $model->device->comment;
            
            $sender = new MsgSender();
            $prifile = Profile::model()->findByPk($model->user_id);
            if ($prifile && $prifile->getAttribute('sendMail')) $sender->SendEmail($model->user_id, $subject, $EmailText);
            if ($prifile && $prifile->getAttribute('sendSMS'))  $sender->SendSms($model->user_id, $SMStext);
        }
        
    }

}
