<?php

class MessageSenderController extends Controller {

    public function actionIndex() {
        ;
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
}
