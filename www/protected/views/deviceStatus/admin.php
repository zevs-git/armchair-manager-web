<?php
/* @var $this DeviceStatusController */
/* @var $model DeviceStatus */

$updateTimeout = 10000;

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
");
?>
<?php
//$model->dbCriteria->order='dt DESC';
$this->beginWidget('zii.widgets.CPortlet', array(
    'htmlOptions' => array('style' => 'min-width: 1000px;', 'class' => 'portlet')
));
?>
<div id="grid-container">
    <img id="loader" style="display: none; width: 100px; height: 100px; position: absolute; left: 50%; margin-left: -50px; top:50%;"
         src='/images/loading.gif' />

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'device-status-grid',
        'dataProvider' => $model->search(),
        //'filter' => $model,
        'itemsCssClass' => 'table table-bordered grad-head table-fixed-header',
        'htmlOptions' => array('class'=>'no-summay','style' => 'text-align: center;min-width: 900px;table-layout:fixed'),
        'rowCssClassExpression'=>'$data->rowClass',
        'columns' => array(
            array('name' => 'object.obj',
                'htmlOptions' => array('style' => 'min-width: 220px;'),
                'type' => 'raw',
                'value' => '"<b  rel=\'tooltip\' title=\'" . $data->device->comment . "\'>г." . $data->device->object->city . " \"" . $data->device->object->obj . "\"</b>"'),
            array('name' => 'dt',
                'htmlOptions' => array('style' => 'width: 130px;font-size:12px'),
                'value' => 'date_format(date_create($data->dt), "d.m.Y H:i")'),
            array('name' => 'cash_string',
                'header' => 'Купюры',
                'htmlOptions' => array('style' => 'align: center; width: 200px;'),
                'type' => 'raw'),
            array('name' => 'coin_string',
                'header' => 'Монеты',
                'htmlOptions' => array('style' => 'align: center; width: 200px;'),
                'type' => 'raw'),
            array('name' => 'all_summ',
                'htmlOptions' => array('style' => 'min-width: 70px; text-align: center;font-size:12px'),
                'type' => 'raw',
                'value'=>'"<b style=\'color:green\'>" . (($data->deviceCashReport->summ)?$data->deviceCashReport->summ:0) . " руб.</b>"'
                ),
            array('name' => 'cashbox_state',
                'htmlOptions' => array('style' => 'min-width: 200px; text-align: center;'),
                'header' => 'Состояние',
                'type' => 'raw',
                'value' => '$data->state'),
            'balance',
            array('class' => 'myButtonColumn',
                'updateButtonVisible' => 'FALSE',
                'deleteButtonVisible' => 'FALSE',
                'buttons' => array('view' =>
                    array(
                        'label' => 'Статус устройства',
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

<?php
$countAll = Device::model()->count();
$countTrue = $model->count("unix_timestamp(now()) - unix_timestamp(dt) <= 60*5");
$countFalse = $countAll - $countTrue;

$Balance = 0;


$sql = "SELECT SUM(summ_coin)+SUM(summ_cash) AS res
FROM device_cash_report c, `device_status` s
WHERE c.`device_id` = s.`device_id`";

$res = Yii::app()->db->createCommand($sql)
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
<div class="row-fluid fixed-summ">
    
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <!-- <li class="stat-graph inlinebar" id="weekly-visit">8,4,6,5,9,10</li> -->
                <li class="stat-count" ><span id="device_count"><?php echo $countAll; ?></span><span>Устройств в базе</span></li>
                <li class="stat-percent" ><span id="device_count_p" class="text-success stat-percent"></span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count" ><span id="device_connected"><?php echo $countTrue; ?></span><span>Подключено</span></li>
                <li class="stat-percent" ><span id="device_connected_p" class="text-success stat-percent"><?php echo number_format($countTrue / $countAll * 100, 2, '.', ''); ?>%</span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count" ><span id="device_not_connected"><?php echo $countFalse; ?></span><span>Не на связи</span></li>
                <li class="stat-percent" ><span id="device_not_connected_p" class="text-error stat-percent"><?php echo number_format($countFalse / $countAll * 100, 2, '.', ''); ?>%</span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count" ><span id="cash_summ"><?php echo $Balance; ?> RUB</span><span>В купюрониках</span></li>
                <li class="stat-percent"><span id="cash_summ_p" class="text-success stat-percent"><?php echo number_format($cash_count / ($countAll * 400), 2, '.', '') * 100; ?>%</span></li>
            </ul>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        updateSummary();
        $('[rel=tooltip]').tooltip();
        $('img').tooltip();
        setInterval(function() {
            /*$('[rel=tooltip]').tooltip('destroy');
             $('img').tooltip('destroy');*/
            $.fn.yiiGridView.update('device-status-grid', {
                complete: function() {
                    $('[rel=tooltip]').tooltip();
                    $('img').tooltip();
                }});
            updateSummary();
        }, <?=$updateTimeout?>);
        $('#grid-container').load('/index.php/DeviceStatus/grid');
    });

    function updateSummary() {
        $.ajax({
            url: "<?php echo $this->createAbsoluteUrl('DeviceStatus/Summary') ?>",
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('#device_count').html(data.device_count);
                $('#device_count_p').html(data.device_count_p);
                $('#device_connected').html(data.device_connected);
                $('#device_connected_p').html(data.device_connected_p);
                $('#device_not_connected').html(data.device_not_connected);
                $('#device_not_connected_p').html(data.device_not_connected_p);
                $('#cash_summ').html(data.cash_summ);
                $('#cash_summ_p').html(data.cash_summ_p);
            }
        });
    }
</script>