<?php

class MessageSenderController extends Controller {

    public function actionCheckAndSend() {
        ini_set('max_execution_time', 60000);

        $messages = UserMessages::model()->findAll("state_id = 1 and `read` = 0");
        

        foreach ($messages as $mes) {
            $usres = User::model()->findAll("departament_id = " . $mes->device->object->departament_id);
            foreach ($usres as $user) {
                $SMStext = "Уведомление.\r\n Объект: " . $mes->device->object->obj .
                    "\r\nКресло: " . (!empty($mes->device->comment)?$mes->device->comment:$mes->device->id) .
                    "\r\nСобытие:" . $mes->message->descr;

                $EmailText = 'Получено новое уведолмление. MagicRest'
                        . '<br>Город: ' . $mes->device->object->city
                        . "<br>Объект: " . $mes->device->object->obj
                        . "<br>Кресло: [" . $mes->device_id . "] " . $mes->device->comment
                        . "<br>Текст ошибки: " . $mes->message->descr
                        . "<br>http://chair.teletracking.ru/";
                
                $subject = 'Новое уведомление.'
                        . ' Город: ' . $mes->device->object->city
                        . ". Объект: " . $mes->device->object->obj
                        . ". Кресло: [" . $mes->device_id . "] " . $model->device->comment;

                $sender = new MsgSender();
                $prifile = Profile::model()->findByPk($user->id);
                if ($prifile && $prifile->getAttribute('sendMail'))
                    $sender->SendEmail($user->id, $subject, $EmailText);
                if ($prifile && $prifile->getAttribute('sendSMS'))
                    $sender->SendSms($user->id, $SMStext);
                
                $mes->read = 1;
                $mes->save();
            }
        }
    }
    
    public function actionCheckCashBox() {
        ini_set('max_execution_time', 60000);
        $sql = "SELECT ds.device_id FROM device_status ds WHERE
                EXISTS (SELECT 1 FROM command_log cl USE INDEX (IDX_command_log) WHERE cl.device_id = ds.device_id AND cl.dt  BETWEEN DATE_SUB(CURRENT_DATE(),INTERVAL 1 DAY)  AND CURRENT_DATE() LIMIT 1)
                AND NOT EXISTS 
                (SELECT 1 FROM cash c WHERE c.device_id = ds.device_id
                AND (DATE(c.dt) = DATE_SUB(CURRENT_DATE(),INTERVAL 1 DAY) ) LIMIT 1)";
        
       $res = Yii::app()->db->createCommand($sql)->queryAll();
       
       foreach($res as $row) {
           $dev = Device::model()->findByPk($row['device_id']);
           if ($dev) {
               
               $mess = new UserMessages();
               
               $mess->device_id = $dev->id;
               $mess->msg_code = 113;
               $mess->dt = date(DATE_ATOM);
               
               $mess->save();
           }
       }
    }
}
