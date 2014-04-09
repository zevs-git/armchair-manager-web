<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'departament-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
        

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
		<?php echo $form->labelEx($model,'region'); ?>
		<?php echo $form->textField($model,'region',array('size'=>60,'id'=>'region','readonly'=>true,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'region'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'fname'); ?>
		<?php echo $form->textField($model,'fname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fname'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'lname'); ?>
		<?php echo $form->textField($model,'lname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lname'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<?php if (!Yii::app()->request->isAjaxRequest): ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>
	
	<?php else: ?>
	<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
		<div class="ui-dialog-buttonset">
		<?php			$this->widget('zii.widgets.jui.CJuiButton', array(
				'name'=>'submit_'.rand(),
				'caption'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
				'htmlOptions'=>array(
					'ajax' => array(
						'url'=>$model->isNewRecord ? $this->createUrl('create') : $this->createUrl('update', array('id'=>$model->id)),
						'type'=>'post',
						'data'=>'js:jQuery(this).parents("form").serialize()',
						'success'=>'function(r){
							if(r=="success"){
								window.location.reload();
							}
							else{
								$("#DialogCRUDForm").html(r).dialog("option", "title", "'.($model->isNewRecord ? 'Create' : 'Update').' Departament").dialog("open"); return false;
							}
						}', 
					),
				),
			));
		?>
		</div>
	</div>
	<?php endif; ?>

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
  });
  </script>