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
    <h3 align="center">Отчет по персоналу</h3>
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
    
    if (!empty($_REQUEST['staff_id'])) {
        $showFIO = false;
    } else {
        $showFIO = true;
    }

$this->widget('ext.groupgridview.GroupGridView', array(
    'id' => 'device-grid',
    'itemsCssClass' => 'table table-striped table-bordered',
    'dataProvider' => $data,
    'mergeColumns' => array('obj','type','FIO'),
    'columns' => array(
        array('name'=>'obj',
            'header'=>'Объект'),
        array('name'=>'type',
            'header'=>'Тип',
            'visible'=>$showFIO),
        array('name'=>'FIO',
            'header'=>'ФИО',
            'visible'=>$showFIO),
        array('name'=>'dt',
            'header'=>'Дата'),
    ),
));
?>
</div>
<?php $this->endWidget() ?>
<?php endif;?>