<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'device-status-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
	//'itemsCssClass' => 'table table-striped ',
    'htmlOptions' => array('style' => 'text-align: center;'),
    'columns' => array(
         array('name' => 'device_id',
          'value' => '$data->name_val'),
        array('name' => 'dt',
            'htmlOptions' => array('style' => 'width: 130px;'),
            'value' => 'date_format(date_create($data->dt), "Y-m-d H:i:s")'),
        array('name'=>'cash',
              'header'=>'Сумма',
              'value'=>'(($data->cash->summ > 0)?$data->cash->summ:0) . " руб."'),
        array('name'=>'cash',
              'header'=>'Купюры',
              'type'=>'raw',
              'value'=>'$data->cash->last_cash . "<br/>" . (($data->cash->count_cash)?$data->cash->count_cash:0) . "/" . "400 " . ($data->cash->count_cash/400)*100 . "%" '),
        array('name'=>'cash',
              'header'=>'Монеты',
              'type'=>'raw',
              'value'=>'$data->cash->last_coin . "<br/>" . (($data->cash->count_coin)?$data->cash->count_coin:0) . "/" . "400 " . ($data->cash->count_coin/400)*100 . "%" '),
        array('name'=>'cashbox_state',
              'header'=>'Состояние',
              'type'=>'raw',
              'value'=>'$data->state'),
        array('name'=>'pwr_ext',
              'header'=>'Напряжение',
              'type'=>'raw',
              'value'=>'$data->pwr_ext_val'),
        array('name'=>'pwr_in_id',
              'header'=>'Зарад',
              'type'=>'raw',
              'value'=>'$data->pwr_in_id_val'),
        
        /*'cashbox_state',
        'cash_in_state',
        'error_number',
        'door_state',
        'alarm_state',
        'mas_state',
        'gsm_state_id',
        'gsm_level',
        'sim_in',
        'pwr_in_id',
        'pwr_ext',*/
        //'update_date',
        array('class'=>'myButtonColumn',
            'updateButtonVisible'=>'FALSE',
            'deleteButtonVisible'=>'FALSE',
        )
    ),
));

?>

