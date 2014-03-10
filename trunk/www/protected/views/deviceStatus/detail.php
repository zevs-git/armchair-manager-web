<?php

$this->widget('bootstrap.widgets.TbDetailView', array(
    'type' => 'striped bordered condensed',
    'data' => $model,
    'attributes' => array(
        'device_id',
        array('name' => 'name_val', 'type' => 'raw', 'label' => 'Устройство'),
        'device.object.city',
        'device.object.obj',
        array('name' => 'gprs_state_icon',
            'label' => 'Подключение к серверу',
            'type' => 'raw'),
        'dt',
        array('name' => 'power_state_icon',
            'type' => 'raw'),
        array('name' => 'pwr_ext_val',
            'label' => $model->getAttributeLabel("pwr_ext"),
            'type' => 'raw'),
        array('name' => 'gsm_level_icon',
            'label' => $model->getAttributeLabel("gsm_level"),
            'type' => 'raw'),
        array('name' => 'cashbox_state_icon',
            'label' => $model->getAttributeLabel("cashbox_state"),
            'type' => 'raw'),
        'cash_in_state',
        'error_number',
        array('name' => 'akb_state_icon',
            'label' => $model->getAttributeLabel("pwr_in_id"),
            'type' => 'raw'),
        array('name' => 'massage_state_icon',
            'label' => $model->getAttributeLabel("mas_state"),
            'type' => 'raw'),
        array('name' => 'door_state_icon',
            'label' => $model->getAttributeLabel("door_state"),
            'type' => 'raw'),
        array('name' => 'alarm_state_icon',
            'label' => $model->getAttributeLabel("alarm_state"),
            'type' => 'raw'),
        'update_date',
    /* 'name_val',
      'dt',
      'cashbox_state',
      'cash_in_state',
      'error_number',
      'door_state',
      'alarm_state',
      'mas_state',
      'gsm_state_id',
      'gsm_level',
      //'sim_in',
      'pwr_in_id',
      'pwr_ext_val',
      'update_date', */
    ),
));
?>

<?php

//----------------------- close the CJuiDialog widget ------------
//if (!empty($asDialog)) $this->endWidget();
?>
