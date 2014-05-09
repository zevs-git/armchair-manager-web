<?php if (isset($data)):?>
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Отчет по выручке"
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
    <h3 align="center">Отчет по выручке</h3>
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
    <?php
$this->widget('ext.groupgridview.GroupGridView', array(
    'id' => 'device-grid',
    'itemsCssClass' => 'table table-striped table-bordered',
    'mergeColumns' => array('obj','name'),
    'dataProvider' => $data,
    'extraRowColumns' => array('obj'),
      'extraRowPos' => 'below',
      'extraRowTotals' => function($data, $row, &$totals) {
          if(!isset($totals['count'])) $totals['count'] = 0;
          if (empty($totals['name']) || $totals['name'] != $data['name']) {
            $totals['count']++;
          }
          $totals['name'] = $data['name'];
          
          if(!isset($totals['sum_all_summ'])) $totals['sum_all_summ'] = 0;
          $totals['sum_all_summ'] += $data['sum'];
      },
    'extraRowExpression' => '"<span class=\"subtotal\"><b>Количество кресел - ".$totals["count"].", Общая сумма - ".$totals["sum_all_summ"]." RUB</b></span>"',
    'columns' => array(
        array('name'=>'obj',
            'header'=>'Объект'),
        array('name'=>'name',
            'header'=>'Место установки'),
        array('name'=>'dt',
            'class'=>'DataColumn',
            'header'=>'Дата',
            //'value'=>'"<span " . ((in_array(date("D",strtotime($data["dt"])),array("Mon","Sat","Sun")))?"style=\'background-color:red\'>":">") . $data["dt"] . "<span>"',
            'evaluateHtmlOptions'=>true,
            'htmlOptions'=>array('class'=>'"{$data[\'class\']}"'),
            ),
        array('name'=>'sum',
            'class'=>'DataColumn',
            'header'=>'Сумма выручки',
            'evaluateHtmlOptions'=>true,
            'htmlOptions'=>array('class'=>'"{$data[\'class\']}"'),
            ),
    ),
));
?>
</div>
<?php $this->endWidget() ?>
<?php endif;?>
<style>
    .weekend {
        background-color: antiquewhite !important;
    }
    .summary {
            display: none;
    }
</style>>