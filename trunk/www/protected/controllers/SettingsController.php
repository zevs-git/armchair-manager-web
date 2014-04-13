<?php

/* @var $model Device */

class SettingsController extends RController {

    public $device;
    public $data;

    /*public function filters() {
        return array(
            'rights', 
          );
    }*/
    
    public function actionIndex() {
        echo "Для запроса файла настроек укажите IMEI устройтва";
    }

    public function actionDevice($device_imei) {
        $this->layout = 'NULL';
        if ($this->setDevice($device_imei)) {
            $this->SettingsFile();
        } else {
            header('HTTP/1.0 404 Not Found');
            header('HTTP/1.1 404 Not Found');
            header('Status: 404 Not Found');
            exit();
        }
        //$this->render('device',  array('device_imei'=>$device_imei));
    }

    private function setHeaders() {
        header('Content-Type: application/octet-stream');
        //header( 'Content-Disposition: attachment; filename="example.zip"' );
        header('Content-Transfer-Encoding: binary');
    }

    private function setDevice($device_imei) {
        $this->device = Device::model()->find("IMEI = '$device_imei'");
        if (!$this->device) {
            return false;
        }
        return true;
    }

    private function SettingsFile() {
        $this->data = '';
        $this->getServiceSettings();
        $this->getObjectSettings();
        
        $crc16 = $this->calcCRC($this->data);
        $size = strlen($this->data);
        $size_b = pack('n', $size);
        $crc16_b = pack('n', $crc16);

        $this->data = $size_b . $crc16_b . $this->data;
        
        $tmp = unpack("Nid", $size_b . $crc16_b);
        if (isset($tmp['id'])) {
            $this->device->settings_id = $tmp['id'];
        } else {
            $this->device->settings_id = 0;
        }
        
        $this->device->save();
        
        $this->setHeaders();
        print $this->data;
    }

    public function putValue32($id, $value, $dinamic = false) {
        $this->data .= pack('C', ord('#'));
        $this->data .= pack('C', $id);
        if (!$dinamic) {
            $this->data .= pack('N', $value);
        } else {
            $this->data .= pack('C', strlen($value));
            $this->data .= pack('A*', $value);
        }
    }

    public function getObjectSettings() {
        $objectStaff = ObjectStaff::model()->findByPk($this->device->object_id);

        //Ключи персонала
        if ($objectStaff) {
            if ($objectStaff->incasator1) {
                $this->putValue32(SetVarId::INCASSATOR1, hexdec($objectStaff->incasator1_staff->key));
            }
            if ($objectStaff->incasator2) {
                $this->putValue32(SetVarId::INCASSATOR2, hexdec($objectStaff->incasator2_staff->key));
            }
            if ($objectStaff->tehnik1) {
                $this->putValue32(SetVarId::TEHNIK1, hexdec($objectStaff->tehnik1_staff->key));
            }
            if ($objectStaff->tehnik2) {
                $this->putValue32(SetVarId::TEHNIK2, hexdec($objectStaff->tehnik2_staff->key));
            }
        }

        //Настройки тарифа
        $objectTariff = ObjectTariff::model()->findByPk($this->device->object_id);
        if (!$objectTariff) {
            $objectTariff = ObjectTariff::model()->findByPk(0);
        }
        if ($objectTariff) {
            $var = 12;
            for ($k = 1; $k <= 10; $k++) {
                $a = unpack("i", pack('v', $objectTariff->{"lk" . $k . "_r"}) . pack('v', $objectTariff->{"lk" . $k . "_l"}));
                $this->putValue32($var, $a[1]);
                $var++;
            }
        }
    }
    
    public function getServiceSettings() {
        $servSettings = DeviceServiceSettings::model()->findByPk($this->device->id);        
        if ($servSettings->IP_monitoring) {
            $this->putValue32(SetVarId::IP_MONITORING, $servSettings->IP_monitoring,true);
        }
        if ($servSettings->port_monitoring) {
            $this->putValue32(SetVarId::PORT_MONITORING, $servSettings->port_monitoring);
        }
        if ($servSettings->IP_config) {
            $this->putValue32(SetVarId::IP_CONF, $servSettings->IP_config,true);
        }
        if ($servSettings->port_config) {
            $this->putValue32(SetVarId::PORT_CONFIG, $servSettings->port_config);
        }
        if ($servSettings->USSD) {
            $this->putValue32(SetVarId::USSD, $servSettings->USSD,true);
        }
        $this->putValue32(SetVarId::INTERVAL, $this->device->interval);
        
        $deviceCashboxSettings = DeviceCashboxSettings::model()->findByPk($this->device->id);
        if (!$deviceCashboxSettings) {
            $deviceCashboxSettings = TmplCashboxSettings::model()->findByPk(0);
        }
        if ($deviceCashboxSettings) {
            $secondBit = 0x00;
            if ($deviceCashboxSettings->nominal0) {
                $secondBit ^= 0x01;
            }
            if ($deviceCashboxSettings->nominal1) {
                $secondBit ^= 0x02;
            }
            if ($deviceCashboxSettings->nominal2) {
                $secondBit ^= 0x04;
            }
            if ($deviceCashboxSettings->nominal3) {
                $secondBit ^= 0x08;
            }
            if ($deviceCashboxSettings->nominal4) {
                $secondBit ^= 0x10;
            }
            if ($deviceCashboxSettings->nominal5) {
                $secondBit ^= 0x20;
            }
            if ($deviceCashboxSettings->nominal6) {
                $secondBit ^= 0x40;
            }
            if ($deviceCashboxSettings->nominal7) {
                $secondBit ^= 0x80;
            }
            $a = unpack("i",pack('v', $deviceCashboxSettings->coeficient) . pack('C', $secondBit) .  pack('C', $deviceCashboxSettings->model_id));
            $this->putValue32(SetVarId::CASH_BOX, $a[1]);
        }
        
        $deviceCoinboxSettings = DeviceCoinboxSettings::model()->findByPk($this->device->id);
        if (!$deviceCoinboxSettings) {
            $deviceCoinboxSettings = TmplCoinboxSettings::model()->findByPk($this->device->id);
        }
        if ($deviceCoinboxSettings) {
            $secondBit = 0x00;
            if ($deviceCoinboxSettings->nominal0) {
                $secondBit ^= 0x01;
            }
            if ($deviceCoinboxSettings->nominal1) {
                $secondBit ^= 0x02;
            }
            if ($deviceCoinboxSettings->nominal2) {
                $secondBit ^= 0x04;
            }
            if ($deviceCoinboxSettings->nominal3) {
                $secondBit ^= 0x08;
            }
            if ($deviceCoinboxSettings->nominal4) {
                $secondBit ^= 0x10;
            }
            if ($deviceCoinboxSettings->nominal5) {
                $secondBit ^= 0x20;
            }
            if ($deviceCoinboxSettings->nominal6) {
                $secondBit ^= 0x40;
            }
            if ($deviceCoinboxSettings->nominal7) {
                $secondBit ^= 0x80;
            }
            $a = unpack("i",pack('v', $deviceCoinboxSettings->coeficient) . pack('C', $secondBit) .  pack('C', $deviceCoinboxSettings->model_id));
            $this->putValue32(SetVarId::COIN_BOX, $a[1]);
        }
    }
    
    public function calcCRC($buffer) {
        $crc = 0xFFFF;
        $j = 0;
        
        $len = strlen($buffer);
        
        while ($len--) {
            $crc ^= (ord($buffer[$j++]) << 8) & 0xFFFF;

            for ($i = 0; $i < 8; $i++) {
                $crc = $crc & 0x8000 ? (($crc << 1) & 0xFFFF ) ^ 0x1021 : ($crc << 1) & 0xFFFF;
            }
        }

        return $crc;
    }
}

class SetVarId {

    const PORT_CONFIG = 0;
    const PORT_MONITORING = 1;
    const INTERVAL = 4;
    const LK1 = 12;
    const LK2 = 13;
    const LK3 = 14;
    const LK4 = 15;
    const LK5 = 16;
    const LK6 = 17;
    const LK7 = 18;
    const LK8 = 19;
    const LK9 = 20;
    const LK10 = 21;
    const INCASSATOR1 = 22;
    const INCASSATOR2 = 23;
    const TEHNIK1 = 26;
    const TEHNIK2 = 27;
    const CASH_BOX = 32;
    const COIN_BOX = 33;
    const IP_CONF = 192;
    const IP_MONITORING = 193;
    const USSD = 202;

}
