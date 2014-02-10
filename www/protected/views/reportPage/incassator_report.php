<?php if (isset($data)):?>
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Отчет \"Инкассация\""
));
?>

<div class="btn-toolbar">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Печать',
        'icon' => 'print',
        'type' => 'primary',
        'buttonType' => 'link',
        'url' => "javaScript:window.print();",
    ));
    ?>
</div>

<div class="to-print">
    <h3 align="center">Инкассация</h3>
    <h4 align="center"><?=$this->searchBy?></h4>
    <h4 align="center">за период с <?=$_REQUEST['date_from']?> по <?=$_REQUEST['date_to']?></h4>
<?php
/* echo $dataProvider->getId();
  $chart_id = $dataProvider->getId();
  $refresh_button = $this->widget('zii.widgets.jui.CJuiButton', array(
  'buttonType' => 'button',
  'name' => 'refresh',
  'caption' => 'Refresh',
  'options' => array(
  ),
  'onclick' => 'js:function(){
  url = window.location.href+"?";
  $.fn.highchartsview.update("' . $chart_id . '", url);
  }'
  )); */
?>
    <style>
        .summary {
            display: none;
        }
    </style>
    
    <?php
$this->widget('ext.groupgridview.GroupGridView', array(
    'id' => 'device-grid',
    'itemsCssClass' => 'table table-striped table-bordered',
    'dataProvider' => $data,
    'mergeColumns' => array('device_id','name'),
    'columns' => array(
        array('name'=>'device_id',
            'header'=>'ID'),
        array('name'=>'name',
            'header'=>'Место установки'),
        array('name'=>'dt',
            'header'=>'Дата'),
        array('name'=>'FIO',
            'header'=>'ФИО инкассатора'),
        array('name'=>'count_cash',
            'header'=>'Количество купюр'),
        array('name'=>'summ_cash',
            'header'=>'Сумма купюр'),
        array('name'=>'count_coin',
            'header'=>'Количество монет'),
        array('name'=>'summ_coin',
            'header'=>'Сумма монет'),
        array('name'=>'summ_cash',
            'header'=>'Общая сумма',
            'name'=>'all_summ'),
    ),
));
?>
</div>
<?php $this->endWidget() ?>
<?php endif;?>