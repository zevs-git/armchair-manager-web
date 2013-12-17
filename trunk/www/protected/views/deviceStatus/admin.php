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
$('[rel=tooltip]').tooltip();
$('img').tooltip();
setInterval(function() { 
    //$('[rel=tooltip]').tooltip('destroy');
    //$('img').tooltip('destroy');
    $.fn.yiiGridView.update('device-status-grid',{
    complete: function() {
        $('[rel=tooltip]').tooltip();
        $('img').tooltip();
    }}); 
    },10000);

 //$('#grid-container').load('/index.php/DeviceStatus/grid');
");
?>
<?php
//$model->dbCriteria->order='dt DESC';
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Монториг системы",
));
?>
<div id="grid-container">
    <img id="loader" style="display: none; width: 100px; height: 100px; position: absolute; left: 50%; margin-left: -50px; top:50%;"
         src='/images/loading.gif' />

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'device-status-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'itemsCssClass' => 'table table-striped table-bordered',
    'htmlOptions' => array('style' => 'text-align: center;'),
    'columns' => array(
        array('name' => 'device_id',
            'type' => 'raw',
            'value' => '$data->name_val'),
        array('name' => 'dt',
            'htmlOptions' => array('style' => 'width: 130px;'),
            'value' => 'date_format(date_create($data->dt), "Y-m-d H:i:s")'),
        array('name' => 'cash',
            'htmlOptions' => array('style' => 'width: 70px; text-align: center;'),
            'header' => 'Сумма',
            'type' => 'raw',
            'value' => '(($data->cash->summ > 0)?\'<b style="color: green">\' . $data->cash->summ . " руб.</b>":"-")'),
        array('name' => 'cash',
            'header' => 'Купюры',
            'htmlOptions' => array('style' => 'align: center; width: 120px;'),
            'type' => 'raw',
            'value' => '($data->cash->count_cash)?"<b style=\'color: green\' rel=\'tooltip\' title=\'Последняя купюра\'>" . $data->cash->last_cash . "</b>&nbsp;&nbsp;<div style=\'float:right;\' rel=\'tooltip\' title=\'Наполнение купюрника\'>" .$data->cash->count_cash . "/" . "400 - " . ($data->cash->count_cash/400)*100 . "%</div>":"-" '),
        array('name' => 'cash',
            'header' => 'Монеты',
            'htmlOptions' => array('style' => 'align: center; width: 120px;'),
            'type' => 'raw',
            'value' => '($data->cash->count_coin)?"<b style=\'color: green\' rel=\'tooltip\' title=\'Последняя купюра\'>" . $data->cash->last_coin . "</b>&nbsp;&nbsp;<div style=\'float:right;\' rel=\'tooltip\' title=\'Наполнение купюрника\'>" .$data->cash->count_coin . "/" . "400 - " . ($data->cash->count_coin/400)*100 . "%</div>":"-" '),
        array('name' => 'cashbox_state',
            'header' => 'Состояние',
            'type' => 'raw',
            'value' => '$data->state'),
        array('class' => 'myButtonColumn',
            'updateButtonVisible' => 'FALSE',
            'deleteButtonVisible' => 'FALSE',
            'buttons' => array('view' =>
                array(
                    'url' => 'Yii::app()->createUrl("DeviceStatus/view", array("id"=>$data->device_id,"asDialog"=>1))',
                    'options' => array(
                        'ajax' => array(
                            'type' => 'POST',
                            // ajax post will use 'url' specified above 
                            'url' => "js:$(this).attr('href')",
                            'update' => '#id_view',
                            'beforeSend' => 'function() { $("#loader").show(); }',
                            'complete' => 'function() { $("#loader").hide(); $("#modal").dialog("open");}',
                        ),
                    ),
                ),
            ),
        ),
    ),
));
?>
</div>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'modal',
        'options' => array(
            'title' => 'Статус устройтсва',
            'autoOpen' => FALSE,
            'modal' => false,
            'width' => 600,
            'height' => 500,
            'show' => array(
                'effect' => 'fade',
                'duration' => 250,
            ),
            'hide' => array(
                'effect' => 'fade',
                'duration' => 500,
            ),
        ),
    ));
    ?>
<div id="id_view"></div>

<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
<?php
$countAll = $model->count();
$countTrue = $model->count("unix_timestamp(now()) - unix_timestamp(dt) <= 60*5");
$countFalse = $countAll - $countTrue;

$Balance = 0;



$res = Yii::app()->db->createCommand()
        ->select('sum(summ) as res')
        ->from('device_cash_report')
        ->queryRow();

if (isset($res['res'])) {
    $Balance = $res['res'];
}

$res = Yii::app()->db->createCommand()
        ->select('sum(count_cash + count_coin) as res')
        ->from('device_cash_report')
        ->queryRow();


if (isset($res['res'])) {
    $cash_count = $res['res'];
}
?>
<div class="row-fluid">
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <!-- <li class="stat-graph inlinebar" id="weekly-visit">8,4,6,5,9,10</li> -->
                <li class="stat-count"><span><?php echo $countAll; ?></span><span>Устройств в базе</span></li>
                <li class="stat-percent"><span class="text-success stat-percent"></span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count"><span><?php echo $countTrue; ?></span><span>Подключено</span></li>
                <li class="stat-percent"><span class="text-success stat-percent"><?php echo $countTrue / $countAll * 100; ?>%</span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count"><span><?php echo $countFalse; ?></span><span>Не на связи</span></li>
                <li class="stat-percent"><span class="text-error stat-percent"><?php echo $countFalse / $countAll * 100; ?>%</span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count"><span><?php echo $Balance; ?> RUB</span><span>В купюрониках</span></li>
                <li class="stat-percent"><span><span class="text-success stat-percent"><?php echo number_format($cash_count / ($countAll * 400), 2, '.', ''); ?>%</span></li>
            </ul>
        </div>
    </div>
</div>
