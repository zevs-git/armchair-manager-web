<?php
$this->breadcrumbs=array(
	'Дилеры'=>array('index'),
	$model->name,
);
?>

<?php $this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Прамаетры дилера",
));?>

<h3>Дилер: "<?php echo $model->name; ?>"</h3>
<?php $this->renderPartial('form_start',array('model'=>$model))?>
<?php echo CHtml::link('[Редактировать]', $this->createUrl("/$this->id/update/$model->id"));?>
<br>
<?php if (!isset($is_save)) {$is_save = (isset($_REQUEST[is_save])) ? $_REQUEST[is_save] : NULL; }?>

<?php if (!is_null($is_save)): ?>
        <div id="data-info" class="alert <?php echo ($is_save == true) ? 'alert-success' : 'alert-error' ?>">
            <i class="icon-file"></i>
            <span class="info">
    <?php echo ($is_save == 'true') ? "Данные сохранены. Учетная запись '$username' создана успешно. Пароль: '$pass'. Пользователю отправлены данные для входа  в систему на электронную почту." : "Ошибка при сохранении. Проверьте корректность данных." ?>
            </span>
        </div>
<?php endif; ?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
        'type' => 'condensed bordered striped', //striped bordered and/or condensed
	'attributes'=>array(
		'id',
		'name',
		'country',
                'region',
                'city',
                'fname',
            'mname',
            'phone',
            'email',
            'comment',
	),
)); ?>
<?php $this->endWidget()?>
