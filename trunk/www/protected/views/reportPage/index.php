
<?php
echo $dataProvider->getId();
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
        ));

$this->Widget('ext.ActiveHighcharts.HighchartsWidget', array(
    'dataProvider' => $dataProvider,
    'template' => '{items}',
    'options' => array(
        'title' => array(
            'text' => 'Характеристика работы кресел'
        ),
        'xAxis' => array(
            "categories" => 'device_id'
        ),
        'plotOptions'=>array(
                'series'=>array(
                    'stacking'=>'percent'
                )
            ),
        'tooltip'=>array(
                'pointFormat'=>'<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                //'shared'=>true
            ),
        'series' => array(
            array(
                'type' => 'bar',
                'name' => 'Масаж', //title of data
                'dataResource' => 'mp', //data resource according to datebase column
            ),
            array(
                'type' => 'bar',
                'name' => 'Простой', //title of data
                'dataResource' => 'pp', //data resource according to datebase column
            ),
            array(
                'type' => 'bar',
                'name' => 'Не в сети', //title of data
                'dataResource' => 'cp', //data resource according to datebase column
            ),
            array(
                'type' => 'bar',
                'name' => 'Ошибки', //title of data
                'dataResource' => 'ep', //data resource according to datebase column
            ),
        )
    )
));
?>
