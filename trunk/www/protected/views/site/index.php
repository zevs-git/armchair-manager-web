<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl; 
?>

<div class="row-fluid">
  <div class="span3 ">
	<div class="stat-block">
	  <ul>
		<!-- <li class="stat-graph inlinebar" id="weekly-visit">8,4,6,5,9,10</li> -->
		<li class="stat-count"><span>50</span><span>Устройств в базе</span></li>
		<li class="stat-percent"><span class="text-success stat-percent"></span></li>
	  </ul>
	</div>
  </div>
  <div class="span3 ">
	<div class="stat-block">
	  <ul>
		<li class="stat-count"><span>46</span><span>Подключено</span></li>
		<li class="stat-percent"><span class="text-success stat-percent">92%</span></li>
	  </ul>
	</div>
  </div>
  <div class="span3 ">
	<div class="stat-block">
	  <ul>
		<li class="stat-count"><span>4</span><span>Неисправно</span></li>
		<li class="stat-percent"><span class="text-error stat-percent">8%</span></li>
	  </ul>
	</div>
  </div>
  <div class="span3 ">
	<div class="stat-block">
	  <ul>
		<li class="stat-count"><span>78 000 RUB</span><span>В купюро-приемниках</span></li>
		<li class="stat-percent"><span><span class="text-success stat-percent">20%</span></li>
	  </ul>
	</div>
  </div>
</div>

<div class="row-fluid">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "CGridview - Striped rows",
        ));
      
      $this->widget('ext.groupgridview.GroupGridView', array(
      'id' => 'grid1',
      'dataProvider' => $model->search(),
      //'mergeColumns' => array('login_date'), 
      'filter' => $model,
      'columns'=>array(
		'device_id',
		'dt',
                'cashbox_state',
		'cash_in_state',
		'error_number',
		'door_state',
		'alarm_state',
		'mas_state',
		'gsm_state_id',
		'gsm_level',
		'sim_in',
		'pwr_in_id',
		'pwr_ext',
		'update_date',
                array(
                    'class' => 'CButtonColumn',
                ),
            ),
          ));
         
        /*$this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'device-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'itemsCssClass' => 'table table-striped',
            'columns'=>array(
		'device_id',
		'dt',
                'cashbox_state',
		'cash_in_state',
		'error_number',
		'door_state',
		'alarm_state',
		'mas_state',
		'gsm_state_id',
		'gsm_level',
		'sim_in',
		'pwr_in_id',
		'pwr_ext',
		'update_date',
                array(
                    'class' => 'CButtonColumn',
                ),
            ),
        ));*/
        ?>
    
       <?php $this->endWidget(); ?>
</div>
	<!--<div class="span2">
    	<input class="knob" data-width="100" data-displayInput=false data-fgColor="#5EB95E" value="35">
    </div>
	<div class="span2">
     	<input class="knob" data-width="100" data-cursor=true data-fgColor="#B94A48" data-thickness=.3 value="29">
    </div>
	<div class="span2">
         <input class="knob" data-width="100" data-min="-100" data-fgColor="#F89406" data-displayPrevious=true value="44">     	
	</div><!--/span-->
</div>