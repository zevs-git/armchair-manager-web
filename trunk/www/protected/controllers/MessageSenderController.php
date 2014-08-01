<?php

class MessageSenderController extends Controller {

    public function actionIndex() {
        $this->checkCashBox();
    }

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
    
    public function CheckCashBox() {
        $sql = "SELECT device_id FROM device_status ds
                WHERE NOT EXISTS 
                (SELECT 1 FROM device_cash_report dcr WHERE dcr.device_id = ds.device_id
                AND (DATE(dcr.update_cash) = CURRENT_DATE() OR  DATE(dcr.update_coin) = CURRENT_DATE()))";
        
       $res = Yii::app()->db->createCommand($sql)->queryAll();
       
       foreach($res as $row) {
           $dev = Device::model()->findByPk($row['device_id']);
           if ($dev) {
                $SMStext = "Уведомление.\r\n Объект: " . $dev->object->obj .
                    "\r\nКресло: " . (!empty($dev->comment)?$dev->comment:$dev->id) .
                    "\r\nСобытие: В течении дня не посупало данных с купюрника";
                
                $EmailText = 'Получено новое уведолмление. MagicRest'
                        . '<br>Город: ' . $dev->object->city
                        . "<br>Объект: " . $dev->object->obj
                        . "<br>Кресло: [" . $dev->id . "] " . $dev->comment
                        . "<br>Текст ошибки: В течении дня не посупало данных с купюрника"
                        . "<br>http://chair.teletracking.ru/";
                
                $subject = 'Новое уведомление.'
                        . ' Город: ' . $dev->object->city
                        . ". Объект: " . $dev->object->obj
                        . ". Кресло: [" . $dev->id . "] " . $dev->comment;
                
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
}
