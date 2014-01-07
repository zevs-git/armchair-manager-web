<?php
/* @var $this ObjectController */
/* @var $model Object */
?>


<?php
$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Общая информация', 'url'=>$this->createUrl("/$this->id/view/$model->id"),'active'=>($this->action->id == 'view')),
        array('label'=>'Тарифный план', 'url'=>$this->createUrl("/$this->id/tariff/$model->id"),'active'=>($this->action->id == 'tariff')),
        array('label'=>'Персонал', 'url'=>$this->createUrl("/$this->id/staff/$model->id"),'active'=>($this->action->id == 'staff')),
        array('label'=>'Устройства', 'url'=>$this->createUrl("/$this->id/devices/$model->id"),'active'=>($this->action->id == 'devices')),
        array('label'=>'Пользователи', 'url'=>'#','active'=>($this->action->id == 'users')),
        array('label'=>'Дополнительно', 'url'=>'#','active'=>($this->action->id == 'other')),
    ),
)); 
?>