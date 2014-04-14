<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $users->searchByDepId($model->id),
    'itemsCssClass' => 'table table-striped table-bordered',
    'filter' => $users,
    'columns' => array(
        array(
            'name' => 'username',
        ),
        array(
            'name' => 'role',
            'value' => '$data->gerRoleDescr()',
            'filter' => CHtml::listData(User::getRolesList(), 'name', 'descr'),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => "{insert}",
            'buttons' => array(
                "insert" => array(
                    'label' => "выбрать",
                    'url' => 'Yii::app()->createUrl("UserMessages",array("AcceptToUser"=>$data->id)) . "?task_id=' . $task_id . ' "',
                    'options' => array(
                        'ajax' => array(
                                'type' => 'POST',
                                'url' => "js:$(this).attr('href')",
                                'beforeSend' => "function() { $('#modal-users').dialog('close');}",
                                'complete' => "function() {
                                    $.fn.yiiGridView.update('messages-grid', {
                                        complete: function() {
                                    }});
                                }",
                        ),
                        "class" => "btn btn-mini btn-success",
                        "id"=>rand(10000000000, 999999999999),
                    )
                ),
            )
        ),
    ),
));
?>