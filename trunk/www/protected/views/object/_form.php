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
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<script src="/js/jquery.geocomplete.min.js"></script>
<div style="width:40%; float: left;">
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
		<label class="span2 required" for="location">Местоположение<span class="required">*</span></label>
                <input size="60" id="location" name="location" type="text">
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'city',array('class'=>'span2')); ?>
                <?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255,'id'=>'city')); ?>
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
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255,'id'=>'country')); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'region',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'region',array('size'=>60,'maxlength'=>255,'id'=>'region')); ?>
		<?php echo $form->error($model,'region'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'street',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'street',array('id'=>'street','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'house',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'house',array('id'=>'house','size'=>60,'maxlength'=>255)); ?>
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
</div>
<div>
    <div class="map_canvas" style="width: 600px;height: 400px;margin: 10px 20px 10px 0;"></div>
</div>
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
<script>
      $(function(){
        $("#location").geocomplete({
          map: ".map_canvas",
          details: "#geoform"
        }).bind("geocode:result", function(event, result){
            console.log(result);
            $('#country').val(geoform.country.value);
            $('#region').val(geoform.administrative_area_level_1.value);
            $('#street').val(geoform.route.value);
            $('#house').val(geoform.street_number.value);
            $('#city').val(geoform.locality.value);
        });
      });
</script>
<form name="geoform" id="geoform" style="display: none">
      <fieldset>
        <h3>Address-Details</h3>

        <label>Name</label>
        <input name="name" type="text" value="">

        <label>POI Name</label>
        <input name="point_of_interest" type="text" value="">

        <label>Latitude</label>
        <input name="lat" type="text" value="">

        <label>Longitude</label>
        <input name="lng" type="text" value="">

        <label>Location</label>
        <input name="location" type="text" value="">

        <label>Location Type</label>
        <input name="location_type" type="text" value="">

        <label>Formatted Address</label>
        <input name="formatted_address" type="text" value="">

        <label>Bounds</label>
        <input name="bounds" type="text" value="">

        <label>Viewport</label>
        <input name="viewport" type="text" value="">

        <label>Route</label>
        <input name="route" type="text" value="">

        <label>Street Number</label>
        <input name="street_number" type="text" value="">

        <label>Postal Code</label>
        <input name="postal_code" type="text" value="">

        <label>Locality</label>
        <input name="locality" type="text" value="">

        <label>Sub Locality</label>
        <input name="sublocality" type="text" value="">

        <label>Country</label>
        <input name="country" type="text" value="">

        <label>Country Code</label>
        <input name="country_short" type="text" value="">

        <label>State</label>
        <input name="administrative_area_level_1" type="text" value="">

        <label>ID</label>
        <input name="id" type="text" value="">

        <label>Reference</label>
        <input name="reference" type="text" value="">

        <label>URL</label>
        <input name="url" type="text" value="">

        <label>Website</label>
        <input name="website" type="text" value="">
      </fieldset>
    </form>