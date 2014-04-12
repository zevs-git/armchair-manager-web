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
    <h3 align="center">Отчет по массажу</h3>
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
foreach  ($data as $obj_data) {
    //$obj = array_shift(array_slice($obj_data,0,1));
    //print_r($obj_data) . "<br>";
    ?><h4 align="center">Объект "<?php echo $obj_data['obj_name'][0]?>"</h4><?php
    $this->Widget('ext.Highcharts.HighchartsWidget', array(
        'options' => array(
            'title' => array(
                'text' => ''
            ),
            'xAxis' => array(
                "categories" => $obj_data['device'],
            ),
            /*'plotOptions' => array(
                'series' => array(
                    'stacking' => 'percent'
                )
            ),*/
            'tooltip' => array(
                //'pointFormat' => '<span style="color:{series.color}">{series.name}</span>: <b>{toHHMMSS(point.y)}</b><br/>',
                'formatter' => 'js:function() { return valFormat(this)}'
            //'shared'=>true
            ),
            'series' => array(
                array(
                    'type' => 'bar',
                    'name' => 'Время массажа', //title of data
                    'data' => $obj_data['time'],
                    'color' => '#8bbc21',
                ),
            )
        )
    ));
}
?>
</div>
<?php $this->endWidget() ?>
<?php endif;?>
<script>
$(document).ready(function() {
    setTimeout(function() { $.each($("tspan"), function(i,val) {
        if(val.innerHTML == 'Highcharts.com') val.style.display = 'none';
        if(val.innerHTML == 'Values') val.innerHTML = 'Время массажа';
        }
    );
    },1000);
});
function valFormat(el){ 
    var time = toHHMMSS(el.y);
    return '<span style="color:{series.color}">' + el.series.name +'</span>: <b>'+ toHHMMSS(el.y) + '</b><br/>'; 
}
function toHHMMSS(seconds) {
    var h, m, s, result='';
    // HOURs
    h = Math.floor(seconds/3600);
    seconds -= h*3600;
    if(h){
        result = h<10 ? '0'+h+':' : h+':';
    }
    // MINUTEs
    m = Math.floor(seconds/60);
    seconds -= m*60;
    result += m<10 ? '0'+m+':' : m+':';
    // SECONDs
    s=seconds%60;
    result += s<10 ? '0'+s : s;
    return result;
}
</script>