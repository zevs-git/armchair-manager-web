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
    public function ActionSuccess($id) {
        $model = $this->loadModel($id);
        $model->state_id = 3;
        $model->user_id = Yii::app()->user->id;
        if ($model->save()) {
            echo "succes";
        }
    }

    //Задача в рабте
    public function ActionAccept($id) {
        $model = $this->loadModel($id);
        $model->state_id = 2;
        $model->user_id = Yii::app()->user->id;
        if ($model->save()) {
            echo "succes";
        }
    }
    
    public function ActionAcceptToUser($id) {
        $model = $this->loadModel($_REQUEST['task_id']);
        $model->state_id = 2;
        $model->user_id = $id;
        if ($model->save()) {
            echo "succes";
        }
    }
    
    public function ActionDelete($id) {
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

}
