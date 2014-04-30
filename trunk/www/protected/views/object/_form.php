<?php
/* @var $this ObjectController */
/* @var $model Object */
/* @var $form CActiveForm */
?>

<?php

 $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                'language' => 'ru',
                'id' => 'date_to',
                'name' => 'date_to',
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'dd.mm.yy',
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;display:none'
                ),
            ));
 
?>
                
<style>
    div.form > form .row {
        margin-bottom: 10px;
    }
</style>
<div class="form">
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'object-form',
        'type' => 'inline',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Обязательные поля отмечены символом <span class="required">*</span>.</p>
        
	<?php echo $form->errorSummary($model); ?>

        <div class="row">
		<?php echo $form->labelEx($model,'city',array('class'=>'span2')); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute'=>'city',
                        'name'=>'city',
                        'source'=> 'js: autoCompleteTags',
                        'options'=>array(
                                'delay'=>100,
                                'minLength'=>1,
                                'showAnim'=>'fold',
                                'select' => 'js:select'
                        ),
                ));
                ?>
		<?php echo $form->error($model,'city'); ?>
	</div>
        
        <div class="row">
            <?php if (Yii::app()->user->checkAccess('Superadmin')): ?> 
                <?php echo $form->labelEx($model,'departament_id',array('class'=>'span2',)); ?>
                <?php $list = CHtml::listData(Departament::model()->findAll(), 'id', 'name'); ?>
                <?php echo $form->dropDownList($model, 'departament_id', $list); ?>
            <?php else:?>
                <?php echo $form->hiddenField($model,'departament_id',array('class'=>'span4','maxlength'=>20,'value'=>Yii::app()->getModule('user')->user()->departament_id)); ?>
            <?php endif;?>
            <?php echo $form->error($model,'departament_id'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'country',array('class'=>'span2',)); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255,'id'=>'country','readonly'=>true)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'region',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'region',array('size'=>60,'maxlength'=>255,'id'=>'region','readonly'=>true)); ?>
		<?php echo $form->error($model,'region'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'street',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'house',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'house',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'house'); ?>
	</div>

	<div class="row">
            <?php echo $form->labelEx($model, 'type.descr',array('class'=>'span2')); ?>        
            <?php $list = CHtml::listData(ObjectType::model()->findAll(), 'id', 'descr'); ?>
            <?php echo $form->dropDownList($model, 'type_id', $list); ?>
            <?php echo $form->error($model, 'type_id',array('class'=>'alert alert-block alert-error')); ?>
        </div>

	<div class="row">
		<?php echo $form->labelEx($model,'obj',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'obj',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'obj'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'face',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'face',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'face'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255,'id'=>'comment')); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'time_start',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'time_start',array('size'=>60,'maxlength'=>255,'id'=>'time_start')); ?>
		<?php echo $form->error($model,'time_start'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'time_end',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'time_end',array('size'=>60,'maxlength'=>255,'id'=>'time_end')); ?>
		<?php echo $form->error($model,'time_end'); ?>
	</div>
       

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить',array('class'=>'btn btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
  <script>
      var city_sel = false;
      function autoCompleteTags( request, response ) {
        $.ajax({
          url: "http://ws.geonames.org/searchJSON",
          dataType: "jsonp",
          data: {
            username: "magicrest",
            lang: "ru",
            featureClass: "P",
            style: "full",
            maxRows: 12,
            name_startsWith: request.term
          },
          success: function( data ) {
            response( $.map( data.geonames, function( item ) {
              return {
                label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
                value: item.name
              }
            }));
          }
        });
    };
    
    function select(event, ui) {
        if (ui.item) {
            var arr = ui.item.label.split(/\s*,\s*/);
            $('#country').val(arr[2]);
            $('#region').val(arr[1]);
            city_sel = true;
        }
    }
  $(function() {
      $('#city').keydown( function() {
           city_sel = false;
      });
      $('#city').change(function() {
          if (!city_sel) {
               $('#city').val('');
               $('#country').val('');
               $('#region').val('');
          }
      });
      
      $('#time_start').timepicker({
                hourGrid: 4,
                minuteGrid: 10,
                timeFormat: 'hh:mm tt'
      });
      
      $('#time_end').timepicker({
                hourGrid: 4,
                minuteGrid: 10,
                timeFormat: 'hh:mm tt'
      });
  });
  </script>