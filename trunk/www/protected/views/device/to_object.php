<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs = array(
    'Устройства' => array('index'),
    $model->id=>array('/device/'.$model->id),
    'Поставить на объект'
);
?>

<?php $this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Настройки устройства",
));?>
<h3>Устройство: [<?php echo $model->IMEI; ?>]</h3>
<?php $this->renderPartial('form_start',array('model'=>$model))?>

<style>
    div.form > form .row {
        margin-bottom: 10px;
    }
</style>

<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'device-form',
        'type' => 'inline',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
    
        <div class="row">
            <?php echo $form->labelEx($model, 'object_id',array('class'=>'span4')); ?>

            <?php $list = CHtml::listData(Object::model()->findAll((Yii::app()->user->checkAccess('Superadmin'))?'':'departament_id = ' . Yii::app()->getModule('user')->user()->departament_id ), 'id', 'obj'); ?>
            <?php echo $form->dropDownList($model, 'object_id', $list, array('class' => 'span4')); ?>
        </div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Сохранить',
		)); ?>
	</div>
<?php $this->endWidget(); ?>
</div>

<?php $this->endWidget()?>
