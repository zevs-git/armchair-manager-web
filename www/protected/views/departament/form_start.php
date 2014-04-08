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
        array('label'=>'Устройства', 'url'=>$this->createUrl("/$this->id/devices/$model->id"),'active'=>($this->action->id == 'devices')),
        array('label'=>'Персонал', 'url'=>$this->createUrl("/$this->id/staff/$model->id"),'active'=>($this->action->id == 'staff')),
        array('label'=>'Пользователи',  'url'=>$this->createUrl("/$this->id/user/$model->id"),'active'=>($this->action->id == 'user')),
    ),
)); 
?>