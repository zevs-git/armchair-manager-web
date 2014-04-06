<?php

class DeviceStatusController extends RController {
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
            'rights', 
          );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    /*public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'index', 'view', 'grid', 'Summary'),
                'users' => array('admin', 'pulkovo'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }*/

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('view', array(
                'id' =>$id,
                'asDialog' => !empty($_GET['asDialog']),
                    ), false, true);
            Yii::app()->end();
        } else
            $this->render('view', array(
                 'id' =>$id,
            ));
    }
    
    public function actionDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('detail', array(
                'model' => $this->loadModel($id),
                'asDialog' => !empty($_GET['asDialog']),
                    ), false, true);
            Yii::app()->end();
        } else
            $this->render('detail', array(
                'model' => $this->loadModel($id),
            ));
    }
    
    public function actionDeviceLog($id) {
        $model = new CommandLog('search');
        if (isset($_GET['CommandLog'])) {// чтобы работали функции поиска нужно передать параметры в модель
            $model->attributes = $_GET['CommandLog'];
            echo "tut";
            exit();
        }
            $this->renderPartial('device_log', array(
                    'model' => $model,
                    'id' => $id), false, true);
    }
    
    public function actionDeviceConfig($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('device_config', array(
                'model' => $this->loadModel($id),
                'asDialog' => !empty($_GET['asDialog']),
                    ), false, true);
            Yii::app()->end();
        } else
            $this->render('device_config', array(
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
    
    public function loadLogModel($id) {
        $model = CommandLog::model()->search($id);
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
            
            $sql = "SELECT COUNT(*) AS res
            FROM `device` d, `object` obj
            WHERE d.object_id = obj.id ";
            if(!Yii::app()->getModule('user')->user()->role != 'Admin' || !Yii::app()->getModule('user')->user()->role != 'Superadmin') {
                $sql .= ' and obj.departament_id = ' . Yii::app()->getModule('user')->user()->departament_id . ';';
            }
            
            $res = Yii::app()->db->createCommand($sql)
                    ->queryRow();

            $result['device_count'] = $res['res'];
            
            
            $sql = "SELECT COUNT(*) AS res
            FROM `device_status` s, `device` d, `object` obj
            WHERE d.`id` = s.`device_id` and unix_timestamp(now()) - unix_timestamp(s.dt) <= 60*5 
            and d.id = s.device_id
            and d.object_id = obj.id";
            if(!Yii::app()->getModule('user')->user()->role != 'Admin' || !Yii::app()->getModule('user')->user()->role != 'Superadmin') {
                $sql .= ' and obj.departament_id = ' . Yii::app()->getModule('user')->user()->departament_id . ';';
            }

            $res = Yii::app()->db->createCommand($sql)
                    ->queryRow();

            if (isset($res['res'])) {
               $result['device_connected'] = $res['res'];
            }
            
            $result['device_connected_p'] = number_format($result['device_connected'] / $result['device_count'] * 100, 2, '.', '') . "%";

            $result['cash_summ'] = 0;

            $sql = "SELECT SUM(summ_coin)+SUM(summ_cash) AS res
            FROM device_cash_report c, `device_status` s, `device` d, `object` obj
            WHERE c.`device_id` = s.`device_id` and unix_timestamp(now()) - unix_timestamp(s.dt) <= 60*5 
            and d.id = s.device_id
            and d.object_id = obj.id";

            if(!Yii::app()->getModule('user')->user()->role != 'Admin' || !Yii::app()->getModule('user')->user()->role != 'Superadmin') {
                $sql .= ' and obj.departament_id = ' . Yii::app()->getModule('user')->user()->departament_id . ';';
            }

            $res = Yii::app()->db->createCommand($sql)
                    ->queryRow();

            if (isset($res['res'])) {
                $result['cash_summ'] = $res['res'];
            }
            $result['cash_summ'] .= ' RUR';

            $sql = "SELECT SUM(a.volume + b.volume) AS res
            FROM device_cashbox_settings a, device_coinbox_settings b, `device_status` s, `device` d, `object` obj
            WHERE a.`device_id` = b.`device_id` and a.`device_id` = s.`device_id` and unix_timestamp(now()) - unix_timestamp(s.dt) <= 60*5 
            and d.id = s.device_id
            and d.object_id = obj.id";

            if(!Yii::app()->getModule('user')->user()->role != 'Admin' || !Yii::app()->getModule('user')->user()->role != 'Superadmin') {
                $sql .= ' and obj.departament_id = ' . Yii::app()->getModule('user')->user()->departament_id . ';';
            }

            $res1 = Yii::app()->db->createCommand($sql)
                    ->queryRow();
            if (isset($res1['res'])) {
                $volume = $res1['res'];
            } else {
                $volume = 400 * $res['res'];
            }


            $sql = "SELECT SUM(count_coin)+SUM(count_cash) AS res
            FROM device_cash_report c, `device_status` s, `device` d, `object` obj
            WHERE c.`device_id` = s.`device_id` and unix_timestamp(now()) - unix_timestamp(s.dt) <= 60*5 
            and d.id = s.device_id
            and d.object_id = obj.id";

            if(!Yii::app()->getModule('user')->user()->role != 'Admin' || !Yii::app()->getModule('user')->user()->role != 'Superadmin') {
                $sql .= ' and obj.departament_id = ' . Yii::app()->getModule('user')->user()->departament_id . ';';
            }

            $res2 = Yii::app()->db->createCommand($sql)
                    ->queryRow();

            if (isset($res['res'])) {
                $result['cash_summ_p'] = number_format($res2['res'] / $volume * 100, 2, '.', '') . "%";
            } else {
                $result['cash_summ_p'] = "-";
            }
            
            $sql = "SELECT SEC_TO_TIME(SUM(time)) as time,SUM(time)/(TIME_TO_SEC(TIMEDIFF(NOW(),CAST(CURRENT_DATE() AS DATETIME))) * " . $result['device_connected'] . ")*100 as perc "
                    . "FROM massage m, `object` obj, `device` d "
                    . "WHERE m.dt BETWEEN CURRENT_DATE() AND NOW() "
                    . "and m.device_id = d.id "
                    . "and d.object_id = obj.id ";
            
            if(!Yii::app()->getModule('user')->user()->role != 'Admin' || !Yii::app()->getModule('user')->user()->role != 'Superadmin') {
                $sql .= ' and obj.departament_id = ' . Yii::app()->getModule('user')->user()->departament_id;
            }
            
            $res = Yii::app()->db->createCommand($sql)->queryRow();
             
            if (isset($res['time'])) {
                 $result['mass_time'] = $res['time'];
                 $result['mass_perc'] = number_format($res['perc'], 2, '.', '') . "%";
            } else {
                 $result['mass_time'] = '00:00';
                 $result['mass_perc'] = 0;
            }          
            
            $sql = 'SELECT COUNT(*) as res '
                    . 'FROM user_messages um, `object` obj, `device` d '
                    . 'WHERE um.`read` = 0 '
                    . "and um.device_id = d.id "
                    . "and d.object_id = obj.id ";
            
            if(!Yii::app()->getModule('user')->user()->role != 'Admin' || !Yii::app()->getModule('user')->user()->role != 'Superadmin') {
                $sql .= ' and obj.departament_id = ' . Yii::app()->getModule('user')->user()->departament_id;
            }
            
            $res = Yii::app()->db->createCommand($sql)->queryRow();
            
            if (isset($res['res'])) {
                 $result['messages_count'] = $res['res'];
            } else {
                 $result['messages_count'] = 0;
            }
            
            $last_mes = new UserMessages();
            $last_mes = UserMessages::model()->find('`user_id` = 1 AND `read` = 0 ORDER BY `dt` DESC');
            
            if ($last_mes) {
                $result['last_message'] = "<font color=red>" . date('H:i:s',strtotime($last_mes->dt)) . " [" . $last_mes->device_id . "] " . $last_mes->message->descr . "</font>";
            } else {
                $result['last_message'] = 'Нет новых уведомлений';
            }
            

            echo json_encode($result);
        }
    }
    
    public function actionUpdateSettings($id) {
        Device::UpdateSettingsCommand($id);
    }
    
    public function actionExecMassage($id,$min,$sec) {
        $command = new CommandExecuting();
        $command->device_id = $id;
        $command->value1 = $min;
        $command->value2 = $sec;
        $command->command_id = CommandExecuting::MASSAGE;
        $command->save();
        
        $text = " $min мин $sec секунд";
        
        Yii::app()->db->createCommand("CALL p_comand_log($id,9,'$text');")->execute();
    }
    
    public function actionDeviceRestart($id) {
        $command = new CommandExecuting();
        $command->device_id = $id;
        $command->command_id = CommandExecuting::RESTART;
        $command->save();
        
        $text = "";
        Yii::app()->db->createCommand("CALL p_comand_log($id,11,'$text');")->execute();
    }
    
    public function actionMessages() {
                $model=new UserMessages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserMessages']))
			$model->attributes=$_GET['UserMessages'];

		$this->render('messages',array(
			'model'=>$model,
		));
    }
    public function actionReadMessages() {
                $sql = 'UPDATE user_messages um SET um.`read` = 1 WHERE um.user_id = 1 AND um.`read` = 0';
                Yii::app()->db->createCommand($sql)->execute();
                
    }

}
