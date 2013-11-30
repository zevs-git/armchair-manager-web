<?php
/* @var $this DeviceStatusController */
/* @var $data DeviceStatus */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('device_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->device_id), array('view', 'id'=>$data->device_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dt')); ?>:</b>
	<?php echo CHtml::encode($data->dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cashbox_state')); ?>:</b>
	<?php echo CHtml::encode($data->cashbox_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cash_in_state')); ?>:</b>
	<?php echo CHtml::encode($data->cash_in_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('error_number')); ?>:</b>
	<?php echo CHtml::encode($data->error_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('door_state')); ?>:</b>
	<?php echo CHtml::encode($data->door_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alarm_state')); ?>:</b>
	<?php echo CHtml::encode($data->alarm_state); ?>
	<br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('mas_state')); ?>:</b>
	<?php echo CHtml::encode($data->mas_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gsm_state_id')); ?>:</b>
	<?php echo CHtml::encode($data->gsm_state_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gsm_level')); ?>:</b>
	<?php echo CHtml::encode($data->gsm_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sim_in')); ?>:</b>
	<?php echo CHtml::encode($data->sim_in); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pwr_in_id')); ?>:</b>
	<?php echo CHtml::encode($data->pwr_in_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pwr_ext')); ?>:</b>
	<?php echo CHtml::encode($data->pwr_ext); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_date')); ?>:</b>
	<?php echo CHtml::encode($data->update_date); ?>
	<br />


</div>