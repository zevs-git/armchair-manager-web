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
            'name' => 'profile.lastname',
        ),
        array(
            'name' => 'profile.firstname',
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
                        "onclick" => "selectUser($(this).attr('href')); return false;",
                        /* 'ajax' => array(
                          'type' => 'POST',
                          'url' => "js:$(this).attr('href')",
                          'beforeSend' => "function() { $('#modal-users').dialog('close');}",
                          'complete' => "function() {
                          alert('yes');
                          //$.fn.yiiGridView.update('messages-grid');
                          $('#user-btn').unbind();
                          }",
                          ), */
                        "class" => "btn btn-mini btn-success user",
                    )
                ),
            )
        ),
    ),
));
?>