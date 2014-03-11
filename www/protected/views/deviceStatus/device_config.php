<div id='success' class="alert alert-success" style='display:none'>
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  Команда отправлена.
</div>
<div id='error' class="alert alert-error" style='display:none'>
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  Не удалось отправить команду.
</div>

<div class="btn-toolbar" style='text-align: center'>
        <div style='margin: 10px'>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'htmlOptions'=>array('id'=> 'massage_but_'. rand(100000, 9999999),'style'=>'width:250px'),
        'label' => 'Включить массаж',
        //'icon' => 'plus-sign',
        'type' => 'success',
        'buttonType' => 'ajaxLink',
        'url' => $this->createUrl('ExecMassage',array('id'=>$model->device_id)),
        'ajaxOptions' => array(
            'data'   => 'js:"min="+$("#min").val()+"&sec="+$("#sec").val()',
            'beforeSend' => 'function(r){$("#success").hide();$("#error").hide();}',
            'success' => 'function(r){$("#success").show();}',
            'error'   => 'function(r){$("#error").show();}',
        ),
    ));
    ?>
    </div>
    <div style='margin: 10px;font-size: 14px'>
        <span>на</span> <input id="min" type="text" style="width: 25px;" maxlength="3" value="10"/> минут <input id="sec" type="text" style="width: 20px;" maxlength="2" value="0"/> секунд
    </div>
    
    <div style='margin: 10px'>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'htmlOptions'=>array('id'=> 'settings_but_'. rand(100000, 9999999),'style'=>'width:250px'),
        'label' => 'Обновить настройки',
        //'icon' => 'plus-sign',
        'type' => 'primary',
        'buttonType' => 'ajaxLink',
        'url' => $this->createUrl('UpdateSettings',array('id'=>$model->device_id)),
        'ajaxOptions' => array(
            //'url' => $this->createUrl('UpdateSettings',array('id'=>$model->device_id)),
            'beforeSend' => 'function(r){$("#success").hide();$("#error").hide();}',
            'success' => 'function(r){$("#success").show();}',
            'error'   => 'function(r){$("#error").show();}',
        ),
    ));
    ?>
    </div>
    <div style='margin: 10px'>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'htmlOptions'=>array('id'=> 'restart_but_'. rand(100000, 9999999),'style'=>'width:250px'),
        'label' => 'Рестарт устройства',
        //'icon' => 'plus-sign',
        'type' => 'danger',
        'buttonType' => 'ajaxLink',
        'url' => $this->createUrl('DeviceRestart',array('id'=>$model->device_id)),
        'ajaxOptions' => array(
            //'url' => $this->createUrl('UpdateSettings',array('id'=>$model->device_id)),
            'beforeSend' => 'function(r){$("#success").hide();$("#error").hide();}',
            'success' => 'function(r){$("#success").show();}',
            'error'   => 'function(r){$("#error").show();}',
        ),
    ));
    ?>
    </div>
</div>