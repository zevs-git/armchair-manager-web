<?php
/* @var $this ObjectController */
/* @var $model Object */
?>


<?php
$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Сервисные настройки', 'url'=>$this->createUrl("/$this->id/ServiceSettings/$model->tmpl_id"),'active'=>($this->action->id == 'ServiceSettings')),
        array('label'=>'Купюроприемник', 'url'=>$this->createUrl("/$this->id/Cashbox/$model->tmpl_id"),'active'=>($this->action->id == 'Cashbox')),
        array('label'=>'Монетоприемник', 'url'=>$this->createUrl("/$this->id/Coinbox/$model->tmpl_id"),'active'=>($this->action->id == 'Coinbox')),
    ),
)); 
?>