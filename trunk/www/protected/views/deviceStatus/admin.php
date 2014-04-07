<style>IMG {
    width: available;
    width: available;
    
    }</style>
<?php
/* @var $this DeviceStatusController */
/* @var $model DeviceStatus */

$updateTimeout = 100000000;
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
    'htmlOptions' => array('style' => 'min-width: 1000px; margin-top: 25px; margin-bottom: 50px; border: none;', 'class' => 'portlet')
));
?>
<div id="grid-container">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'device-status-grid',
        'dataProvider' => $model->search(),
        //'filter' => $model,
        'itemsCssClass' => 'table table-bordered grad-head table-fixed-header',
        'htmlOptions' => array('class'=>'no-summay','style' => 'text-align: center;min-width: 900px;table-layout:fixed'),
        'rowCssClassExpression'=>'$data->rowClass',
        'columns' => array(
            array('name' => 'object.city',
                'htmlOptions' => array('style' => 'width: 130px;'),
                'type' => 'raw',
                'value' => '"<span  rel=\'tooltip\' title=\'" . $data->device->comment . "\'>" . $data->device->object->city . "</span>"',
                'headerHtmlOptions'=> array('style' => 'width: 125px;')),
            array('name' => 'object.obj',
                'htmlOptions' => array('style' => 'width: 130px;'),
                'type' => 'raw',
                'value' => '"<span  rel=\'tooltip\' title=\'" . $data->device->comment . "\'>" . $data->device->object->obj . "</span>"',
                'headerHtmlOptions'=> array('style' => 'width: 125px;')),
            array('name' => 'dt',
                'htmlOptions' => array('style' => 'width: 130px; font-size:12px'),
                'value' => 'date_format(date_create($data->dt), "d.m.Y H:i")',
                'headerHtmlOptions'=> array('style' => 'width: 130px;')),
            array('name' => 'cash_string',
                'header' => 'Купюры',
                'htmlOptions' => array('style' => 'align: center; width: 200px;'),
                'type' => 'raw',
                'visible'=>Yii::app()->user->checkAccess('Watcher'),
                'headerHtmlOptions' => array('style' => 'align: center; width: 195px;')),
            array('name' => 'coin_string',
                'header' => 'Монеты',
                'htmlOptions' => array('style' => 'align: center; width: 200px;'),
                'type' => 'raw',
                'visible'=>Yii::app()->user->checkAccess('Watcher'),
                'headerHtmlOptions' => array('style' => 'align: center; width: 195px;')),
            array('name' => 'all_summ',
                'htmlOptions' => array('style' => 'width: 70px; text-align: center;font-size:12px'),
                'headerHtmlOptions' => array('style' => 'width: 65px; text-align: center;font-size:12px'),
                'type' => 'raw',
                'visible'=>Yii::app()->user->checkAccess('Watcher'),
                'value'=>'"<b style=\'color:green\'>" . (($data->deviceCashReport->summ)?$data->deviceCashReport->summ:0) . " руб.</b>"'
                ),
            array('name'=>'balance',
                  'htmlOptions' => array('style' => 'width: 50px;'),
                  'headerHtmlOptions' => array('style' => 'width: 45px;'),
                ), 
            array('name' => 'cashbox_state',
                'htmlOptions' => array('style' => 'width: 200px; text-align: center;'),
                'headerHtmlOptions' => array('style' => 'width: 200px; text-align: center;'),
                'header' => 'Состояние',
                'type' => 'raw',
                'value' => '$data->state'),
            array('class' => 'bootstrap.widgets.TbButtonColumn',
                'headerHtmlOptions' => array('style' => 'display: none; text-align: center;'),
                'template' => '{view}',
                'buttons' => array('view' =>
                    array(
                        'label' => 'Статус устройства',
                        'url' => '$data->device_id',
                        'icon'=> 'icon-zoom-in',
                        'options' => array(
                            'class' => 'btn btn-mini',
                            'onclick' => 'return openDetail(this);',
                            /*'ajax' => array(
                                'type' => 'POST',
                                // ajax post will use 'url' specified above 
                                'url' => "js:$(this).attr('href')",
                                'update' => '#id_view',
                                'beforeSend' => 'function() { $("#loader").show(); }',
                                'complete' => 'function() { $("#loader").hide(); $("#modal").dialog("open");}',
                            ),*/
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
        'title' => 'Статус устройства',
        'autoOpen' => FALSE,
        'modal' => false,
        'width' => 600,
        'height' => 550,
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
<div id="id_view"> 
    <?php   $id = -100; include 'view.php';   ?>    
    
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'modal-messages',
    'options' => array(
        'title' => 'Уведомления',
        'autoOpen' => FALSE,
        'modal' => false,
        'width' => 600,
        'height' => 550,
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
<div id="id_view-messages">
</div>

<?php $this->endWidget(); ?>

<div class="row-fluid fixed-summ">
    
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <!-- <li class="stat-graph inlinebar" id="weekly-visit">8,4,6,5,9,10</li> -->
                <li class="stat-count" ><span id="device_count"></span><span>Подключено устройств</span></li>
                <li class="stat-percent" ><span id="device_connected_p" class="text-success stat-percent"></span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <?php if(!(Yii::app()->getModule('user')->user()->role == 'Tehnik' || Yii::app()->getModule('user')->user()->role == 'Operator')): ?>
                <li class="stat-count" ><span id="cash_summ"><?php echo $Balance; ?> RUB</span><span style="width:500px">Сумма в купюрниках/наполненность</span></li>
                <li class="stat-percent"><span id="cash_summ_p" class="text-success stat-percent"></span></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <ul>
                <li class="stat-count" ><span id="mass_time"><?php echo $countFalse; ?></span><span style="width:500px">Время массажа за сегодня</span></li>
                <li class="stat-percent"><span id="mass_perc" class="text-success stat-percent"></span></li>
            </ul>
        </div>
    </div>
    <div class="span3 ">
        <div class="stat-block">
            <a href="#" onclick="openMessages();">
            <ul>
                <li class="stat-count" ><span>Уведомления</span><span id="last_message" style="width:500px"></span></li>
                <li class="stat-percent"><span id="messages_count" class="text-error stat-percent"></span></li>
            </ul>
            </a>
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
        //$('#grid-container').load('/index.php/DeviceStatus/grid');
    });
    
    function openMessages() {
        $("#modal-messages").dialog("open");
        $.ajax({
                url: '/DeviceStatus/ReadMessages',
                type: 'POST',
                dataType: 'html',
                cache: false,
        });
            
        $.ajax({
                url: '/DeviceStatus/Messages',
                type: 'POST',
                dataType: 'html',
                cache: false,
                success: function(html)
                {
                    jQuery('#id_view-messages').html(html);
                    //$("#loader").hide();
                },
                error: function() {
                    jQuery('#id_view-messages').html('Не удалось загрузить уведомления');
                }
            });
        return false;
    }

    function updateSummary() {
        $.ajax({
            url: "<?php echo $this->createAbsoluteUrl('DeviceStatus/Summary') ?>",
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('#device_count').html(data.device_connected + ' из ' + data.device_count);
                $('#device_connected').html(data.device_connected);
                $('#device_connected_p').html(data.device_connected_p);
                $('#mass_time').html(data.mass_time);
                $('#mass_perc').html(data.mass_perc);
                $('#cash_summ').html(data.cash_summ);
                $('#messages_count').html(data.messages_count);
                $('#last_message').html(data.last_message);
                
                $('#cash_summ_p').html(data.cash_summ_p);
            }
        });
    }
    function openDetail(but) {
        device_id = but.getAttribute("href"); 
        jQuery('#DetailTabs li.active').removeClass('active');
        $("#modal").dialog("open"); 
        jQuery('a[href="#Detail"]').tab('show');
        return false;
    }
</script>