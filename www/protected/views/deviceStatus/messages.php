<?php
/* @var UserMessages $model */
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'messages-grid',
    'itemsCssClass' => 'table table-striped table-bordered',
    'htmlOptions' => array('class' => 'no-summay', 'style' => 'text-align: center;font-size: 12px; margin: -30px; margin-top: -50px;'),
    'dataProvider' => $model->search($id),
    'rowCssClassExpression' => '$data->rowClass',
    //'filter'=>$model,
    'columns' => array(
        array('name' => 'dt',
            'htmlOptions' => array('style' => 'padding: 0px;')
        ),
        array(
            'name' => 'device.object.obj',
            'htmlOptions' => array('style' => 'padding: 0px;')
        ),
        array(
            'name' => 'device_id',
            'value' => '"[" . $data->device_id . "] " . $data->device->comment',
            'htmlOptions' => array('style' => 'padding: 0px;')
        ),
        array('name' => 'message.descr',
            'htmlOptions' => array('style' => 'padding: 0px;')
        ),
        array(
            'name' => 'state.descr',
            'type' => 'raw',
            'value'=>'$data->rowState',
            'htmlOptions' => array('style' => 'padding: 0px;')
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{ok}{to_work}{to_user}{delete}',
            'htmlOptions' => array('style' => 'padding: 0px; text-align: center;'),
            //'visible'=> false,//'$data->state_id < 0',
            'buttons' => array(
                'ok' => array(
                    'label' => 'Отработано',
                    'icon' => 'icon-ok',
                    'url' => 'Yii::app()->createUrl("UserMessages",array("Success"=>$data->id))',
                    'visible'=>'$data->state_id < 3',
                    'options' => array(
                        'ajax' => array(
                                'type' => 'POST',
                                'url' => "js:$(this).attr('href')",
                                //'update' => '#id_view',
                                //'beforeSend' => 'function() { $("#loader").show(); }',
                                'complete' => "function() {
                                    $.fn.yiiGridView.update('messages-grid', {
                                        complete: function() {
                                    }});
                                }",
                        ),
                        'class' => 'btn btn-mini btn-success',
                    ),
                ),
                'to_work' => array(
                    'label' => 'Взять в работу',
                    'icon' => 'icon-plus',
                    'url' => 'Yii::app()->createUrl("UserMessages",array("Accept"=>$data->id))',
                    'visible'=>'$data->state_id < 3',
                    'options' => array(
                        'ajax' => array(
                                'type' => 'POST',
                                'url' => "js:$(this).attr('href')",
                                //'update' => '#id_view',
                                //'beforeSend' => 'function() { $("#loader").show(); }',
                                'complete' => "function() {
                                    $.fn.yiiGridView.update('messages-grid', {
                                        complete: function() {
                                    }});
                                }",
                        ),
                        'class' => 'btn btn-mini btn-primary',
                    ),
                ),
                'to_user' => array(
                    'label' => 'Передать в работу пользователю...',
                    'icon' => 'icon-random',
                    'url' => 'Yii::app()->createUrl("UserMessages",array("Users"=>$data->id))',
                    'visible'=>'$data->state_id < 3',
                    'options' => array(
                        'ajax' => array(
                                'type' => 'POST',
                                'url' => "js:$(this).attr('href')",
                                'update' => '#id_view-users',
                                'beforeSend' => 'function() { $("#modal-users").dialog("open"); }',
                                'complete' => "function() {
                                }",
                        ),
                        'class' => 'btn btn-mini btn-info',
                    ),
                ),
                'delete' => array(
                    'label' => 'Удалить',
                    'url' => 'Yii::app()->createUrl("UserMessages",array("Delete"=>$data->id))',
                    'icon' => 'icon-remove',
                    'options' => array(
                        'ajax' => array(
                                'type' => 'POST',
                                'url' => "js:$(this).attr('href')",
                                //'update' => '#id_view',
                                //'beforeSend' => 'function() { $("#loader").show(); }',
                                'complete' => "function() {
                                    $.fn.yiiGridView.update('messages-grid', {
                                        complete: function() {
                                    }});
                                }",
                        ),
                        'class' => 'btn btn-mini btn-danger',
                    ),
                ),
            ),
        ),
    ),
));
?>