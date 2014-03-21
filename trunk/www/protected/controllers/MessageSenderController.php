<?php

class MessageSenderController extends Controller
{
	public function actionIndex()
	{
		;
	}
        
        public function actionCheckAndSend()
	{
            $this->SendSMS();
	}
        
        private function SendSMS() {
            /*$sUrl  = 'http://letsads.com/api';
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
            curl_close($rCurl);*/
            
            //echo "<textarea>" . $sAnswer . "</textarea>";
            //$this->beginWidget('application.extensions.email.debug');
            $email  = Yii::app()->email;
            $email->to = 'zevs-mail@ya.ru';
            $email->subject = 'Hello';
            $email->message = 'Hello brother';
            $s= $email->send();
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