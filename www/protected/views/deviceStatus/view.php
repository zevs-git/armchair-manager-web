<?php /*<img id="loader" 
         style="width: 100px; height: 100px; position: absolute; left: 50%; margin-left: -50px; top:40%;"
         src="/images/loading.gif" />*/
?>

<?php
$this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'tabs',
    'id'=>'DetailTabs',
    //'stacked' => false,
    'tabs' => array(
        array('id' => 'Detail', 'label' => 'Статус','url'=>'dasad', 'content' =>''),
        array('id' => 'DeviceLog', 'label' => 'Лог', 'content' => '','active' => true),
        array('id' => 'DeviceConfig', 'label' => 'Управлене', 'content' =>''),
    ),
    'events'=>array('shown'=>'js:loadContent'),
));
?>


<script type="text/javascript">
    var baseURL = '<?php echo Yii::app()->createUrl("DeviceStatus/{action}", array("id"=>'-100',"asDialog"=>1))?>';
    if (!('device_id' in window)) {
        device_id = <?php echo $id; ?>
    }    
    function loadContent(e) {
        var tabId = e.target.getAttribute("href");
        if (!tabId) {
            tabId = 'Detail';
        }
        var ctUrl = baseURL.replace('{action}',tabId.replace('#','')).replace('-100',device_id);
        jQuery(tabId).html('Загрузка данных ...');
        //$("#loader").show();
        if (ctUrl != '') {
            $.ajax({
                url: ctUrl,
                type: 'POST',
                dataType: 'html',
                cache: false,
                complete: function (xhr) {
                        $("#loader").hide();
                    },
                success: function(html)
                {
                    jQuery(tabId).html(html);
                    //$("#loader").hide();
                },
                error: function() {
                    jQuery(tabId).html(html);
                    //$("#loader").hide();
                }
            });
        }
        return false;
    }
    jQuery( document ).ready(function() {
        if (device_id >= 0) jQuery('a[href="#Detail"]').tab('show');
    });
</script>
