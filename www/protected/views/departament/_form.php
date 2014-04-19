<style>
    div.form > form .row {
        margin-bottom: 10px;
    }
</style>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'departament-form',
         'type' => 'inline',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name',array('class'=>'span4')); ?>
		<?php echo $form->textField($model,'name',array('class'=>'span4','size'=>50,'maxlength'=>50)); ?>
	</div>
        

        <div class="row">
		<?php echo $form->labelEx($model,'city',array('class'=>'span4')); ?>
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
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'region',array('class'=>'span4')); ?>
		<?php echo $form->textField($model,'region',array('class'=>'span4','size'=>60,'id'=>'region','readonly'=>true,'maxlength'=>255)); ?>
	</div>

        <div class="row">
		<?php echo $form->labelEx($model,'comment',array('class'=>'span4')); ?>
		<?php echo $form->textField($model,'comment',array('class'=>'span4','size'=>60,'maxlength'=>255)); ?>
	</div>
        
        <div class="form-actions" <?=(!$model->isNewRecord)?"style='display:none'":""?>>
            <h4>Учетная запись администратора</h4>
        <div class="row">
		<?php echo $form->labelEx($model,'username',array('class'=>'span4')); ?>
		<?php echo $form->textField($model,'username',array('class'=>'span4','size'=>60,'maxlength'=>255)); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'fname',array('class'=>'span4')); ?>
		<?php echo $form->textField($model,'fname',array('class'=>'span4','size'=>60,'maxlength'=>255)); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'lname',array('class'=>'span4')); ?>
		<?php echo $form->textField($model,'lname',array('class'=>'span4','size'=>60,'maxlength'=>255)); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'email',array('class'=>'span4')); ?>
		<?php echo $form->textField($model,'email',array('class'=>'span4','size'=>60,'maxlength'=>255)); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'phone',array('class'=>'span4')); ?>
		<?php echo $form->textField($model,'phone',array('class'=>'span4','size'=>60,'maxlength'=>255)); ?>
	</div>
	</div>

	<?php if (!Yii::app()->request->isAjaxRequest): ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
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