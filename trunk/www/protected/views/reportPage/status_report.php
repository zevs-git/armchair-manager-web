<?php if (isset($data)):?>
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Отчет \"Характеристика работы кресел\""
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
    <h3 align="center">Характеристика работы кресел</h3>
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

$this->Widget('ext.Highcharts.HighchartsWidget', array(
    'options' => array(
        'title' => array(
            'text' => ''
        ),
        'xAxis' => array(
            "categories" => $data['device'],
        ),
        'plotOptions' => array(
            'series' => array(
                'stacking' => 'percent'
            )
        ),
        'tooltip' => array(
            'pointFormat' => '<span style="color:{series.color}">{series.name}</span>: <b>{point.percentage:.0f}%</b><br/>',
        //'shared'=>true
        ),
        'series' => array(
            array(
                'type' => 'bar',
                'name' => 'Ошибки', //title of data
                'data' => $data['e'],
                'color' => 'red',
            ),
            array(
                'type' => 'bar',
                'name' => 'Не в сети', //title of data
                'data' => $data['c'],
                'color' => 'grey',
            ),
            array(
                'type' => 'bar',
                'name' => 'Масаж', //title of data
                'data' => $data['m'], //data resource according to datebase column
                'color' => '#8bbc21',
            ),
            array(
                'color' => '#2f7ed8',
                'type' => 'bar',
                'name' => 'Простой', //title of data
                'data' => $data['p'],
            ),
        )
    )
));
?>
</div>
<?php $this->endWidget() ?>
<?php endif;?>