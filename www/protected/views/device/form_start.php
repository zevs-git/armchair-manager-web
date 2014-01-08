<?php
/* @var $this ObjectController */
/* @var $model Object */
?>


<?php
$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Общая информация', 'url'=>$this->createUrl("/$this->id/view/$model->id"),'active'=>(in_array($this->action->id,array('view','update')))),
        array('label'=>'Сервисные настройки', 'url'=>$this->createUrl("/$this->id/DeviceServiceSettings/$model->id"),'active'=>($this->action->id == 'DeviceServiceSettings')),
        array('label'=>'Купюроприемник', 'url'=>$this->createUrl("/$this->id/Cashbox/$model->id"),'active'=>($this->action->id == 'Cashbox')),
        array('label'=>'Монетоприемник', 'url'=>$this->createUrl("/$this->id/Coinbox/$model->id"),'active'=>($this->action->id == 'Coinbox')),
    ),
)); 
?>