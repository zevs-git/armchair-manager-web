<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>    

        <?php if (isset($this->breadcrumbs)): ?>
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
                'homeLink' => CHtml::link('Администрирование',yii::app()->createUrl('//Object')),
                'htmlOptions' => array('class' => 'breadcrumb')
            ));
            ?><!-- breadcrumbs -->
        <?php endif;?>

        <!-- Include content pages -->
<?php echo $content; ?>


<?php $this->endContent(); ?>