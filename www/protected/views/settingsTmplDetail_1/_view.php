<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tmpl_id')); ?>:</b>
	<?php echo CHtml::encode($data->tmpl_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('var_id')); ?>:</b>
	<?php echo CHtml::encode($data->var_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acc_lvl')); ?>:</b>
	<?php echo CHtml::encode($data->acc_lvl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default')); ?>:</b>
	<?php echo CHtml::encode($data->default); ?>
	<br />


</div>