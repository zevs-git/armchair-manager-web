<?php
/* @var $this DeviceStatusController */
/* @var $model DeviceStatus */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#device-status-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
 //$('#grid-container').load('/index.php/DeviceStatus/grid');
setInterval(function() { 
    $.fn.yiiGridView.update('device-status-grid'); 
    },10000);
");

?>
<?php

$model->dbCriteria->order='dt DESC';
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Монториг системы",
));
?>

<div id="grid-container">

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'device-status-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'itemsCssClass' => 'table table-striped ',
        'htmlOptions' => array('style' => 'text-align: center;'),
        'columns' => array(
            array('name' => 'device_id',
            'value' => '$data->name_val'),
            array('name' => 'dt',
            'htmlOptions' => array('style' => 'width: 130px;'),
            'value' => 'date_format(date_create($data->dt), "Y-m-d H:i:s")'),
            array('name' => 'cash',
            'header' => 'Сумма',
            'htmlOptions' => array('style' => 'width: 70px;'),
            'type' => 'raw',
            'value' => '(($data->cash->summ > 0)?\'<b style="color: green">\' . $data->cash->summ . " руб.</b>":"-")'),
            array('name' => 'cash',
            'header' => 'Купюры',
            'htmlOptions' => array('style' => 'align: center;'),
            'type' => 'raw',
            'value' => '($data->cash->count_cash)?"<b style=\'color: green\'>" . $data->cash->last_cash . "</b>&nbsp;&nbsp;" .$data->cash->count_cash . "/" . "400 - " . ($data->cash->count_cash/400)*100 . "%</div>":"-" '),
            array('name' => 'cash',
            'header' => 'Монеты',
            'type' => 'raw',
            'value' => '($data->cash->count_coin)?"<b style=\'color: green\'>" . $data->cash->last_coin . "</b>&nbsp;&nbsp;".$data->cash->count_coin . "/" . "400 - " . ($data->cash->count_coin/400)*100 . "%":"-" '),
            array('name' => 'cashbox_state',
            'header' => 'Состояние',
            'type' => 'raw',
            'value' => '$data->state'),
            array('class' => 'myButtonColumn',
            'updateButtonVisible' => 'FALSE',
            'deleteButtonVisible' => 'FALSE',
            )
        ),
    ));
    ?>
</div>

<?php $this->endWidget();?>

<div class="row-fluid">
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <!-- <li class="stat-graph inlinebar" id="weekly-visit">8,4,6,5,9,10</li> -->
                <li class="stat-count"><span>50</span><span>Устройств в базе</span></li>
                <li class="stat-percent"><span class="text-success stat-percent"></span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count"><span>46</span><span>Подключено</span></li>
                <li class="stat-percent"><span class="text-success stat-percent">92%</span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count"><span>4</span><span>Неисправно</span></li>
                <li class="stat-percent"><span class="text-error stat-percent">8%</span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count"><span>78 000 RUB</span><span>В купюрониках</span></li>
                <li class="stat-percent"><span><span class="text-success stat-percent">20%</span></li>
            </ul>
        </div>
    </div>
</div>
