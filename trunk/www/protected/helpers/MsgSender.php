<?php

class MsgSender {

    CONST SMS_URL = 'http://letsads.com/api';

    public static function SendSms($user_id, $text) {
        $user = Profile::model()->findByPk($user_id);
        if ($user) {
            $phone = $user->getAttribute('phone');
        } else {
            return false;
        }

        $sXML = '<?xml version="1.0" encoding="UTF-8"?>
                    <request>
                        <auth>
                            <login>+380995190195</login>
                            <password>chair</password>
                        </auth>
                        <message>
                            <from>MagicRest</from>
                            <text>' . $text . '</text>
                            <recipient>' . str_replace("+","",$phone) .'</recipient>
                        </message>
                    </request>';

        $rCurl = curl_init(self::SMS_URL);
        curl_setopt($rCurl, CURLOPT_HEADER, 0);
        curl_setopt($rCurl, CURLOPT_POSTFIELDS, $sXML);
        curl_setopt($rCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rCurl, CURLOPT_POST, 1);
        $sAnswer = curl_exec($rCurl);
        curl_close($rCurl);

        //echo "<textarea>" . $sAnswer . "</textarea>";
    }

    public function SendEmail($user_id, $subject, $text) {
        $user = User::model()->findByPk($user_id);
        if ($user) {
            $mail = $user->email;
        } else {
            return false;
        }
        $email =  Yii::app()->email;
        $email->from = 'MRmonitoring@mail.ru';
        $email->to = $mail;
        $email->subject = $subject;
        $email->message = $text . "<br/>" . date("d.m.Y H:i:s");
        
        $s = $email->send();
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
                " " => " ", '"' => "", "'" => "");

            $string = str_replace($arStrES, $arStrRS, $string);
            $string = str_replace($arStrOS, $arStrRS, $string);
        }

        return iconv("UTF-8", "UTF-8//IGNORE", strtr($string, $replace));
    }

}
?>

