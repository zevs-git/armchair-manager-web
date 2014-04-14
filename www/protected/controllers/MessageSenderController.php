<?php

class MessageSenderController extends Controller {

    public function actionIndex() {
        ;
    }

    public function actionCheckAndSend() {

        $messages = UserMessages::model()->findAll("state_id = 1 and `read` = 0");

        foreach ($messages as $mes) {
            $usres = User::model()->findAll("departament_id = " . $mes->device->object->departament_id);
            foreach ($usres as $user) {
                $SMStext = "" . $mes->device->object->obj .
                        "/" . (!empty($mes->device->comment) ? $mes->device->comment : $mes->device->id) .
                        ":" . $mes->message->descr;

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

    private function SendSMS() {
        /* $sUrl  = 'http://letsads.com/api';
          $sXML  = '<?xml version="1.0" encoding="UTF-8"?>
          <request>
          <auth>
          <login>+380995190195</login>
          <password>chair</password>
          </auth>
          <message>
          <from>MagicRest</from>
          <text>Тестовое сообщение.</text>
          <recipient>380995190195</recipient>
          </message>
          </request>';

          $rCurl = curl_init($sUrl);
          curl_setopt($rCurl, CURLOPT_HEADER, 0);
          curl_setopt($rCurl, CURLOPT_POSTFIELDS, $sXML);
          curl_setopt($rCurl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($rCurl, CURLOPT_POST, 1);
          $sAnswer = curl_exec($rCurl);
          curl_close($rCurl); */

        //echo "<textarea>" . $sAnswer . "</textarea>";
        //$this->beginWidget('application.extensions.email.debug');
        $email = Yii::app()->email;
        $email->to = 'zevs-mail@ya.ru';
        $email->subject = 'Hello';
        $email->message = 'Hello brother';
        $s = $email->send();
        //$this->endWidget();
        print_r($s);

        echo "err";
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
