<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sett_id')); ?>:</b>
	<?php echo CHtml::encode($data->sett_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('var_id')); ?>:</b>
	<?php echo CHtml::encode($data->var_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo CHtml::encode($data->value); ?>
	<br />


</div>