<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row-fluid">
    <div class="span2">
        <div class="sidebar-nav">
            <?php
            $this->widget('bootstrap.widgets.TbMenu', array(
                'type' => 'list', // '', 'tabs', 'pills' (or 'list')
                'stacked' => false, // whether this is a stacked menu
                'items' => array(
                    array('label'=>'Объекты', 'url'=>array('//Object'), 'active'=>(get_class($this) == 'ObjectController')),
                    array('label'=>'Устройства', 'url'=>array('//Device'), 'active'=>(get_class($this) == 'DeviceController')),
                    array('label'=>'Персонал', 'url'=>array('//Staff'), 'active'=>(get_class($this) == 'StaffController')),
                ),
            ));
            ?>
        </div>

    </div><!--/span-->
    
    
    <div class="span10">

        <?php if (isset($this->breadcrumbs)): ?>
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
                'homeLink' => CHtml::link('Администрирование',yii::app()->createUrl('//Object')),
                'htmlOptions' => array('class' => 'breadcrumb')
            ));
            ?><!-- breadcrumbs -->
        <?php endif ?>

        <!-- Include content pages -->
<?php echo $content; ?>

    </div><!--/span-->
</div><!--/row-->


<?php $this->endContent(); ?>