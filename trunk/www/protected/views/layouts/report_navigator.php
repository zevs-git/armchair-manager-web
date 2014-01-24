<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<style>
    @media print {
    body * {
      visibility: hidden;
    }
    .to-print * {
      visibility: visible;
    }
    .to-print {
      position: absolute;
      left: 0;
      top: 0;
    }
  }
</style>
<div class="row-fluid">
    <div class="span2">
        <div class="sidebar-nav">
            <?php
            $this->widget('bootstrap.widgets.TbMenu', array(
                'type' => 'list', // '', 'tabs', 'pills' (or 'list')
                'stacked' => false, // whether this is a stacked menu
                'items' => array(
                    array('label' => 'Характеристика работы', 'url' => array('StatusReport'), 'active' => ($this->action->id == 'StatusReport')),
                    array('label' => 'Массаж', 'url' => array('MassageReport'), 'active' => ($this->action->id == 'MassageReport')),
                    array('label' => 'Инкассация', 'url' => array('IncassatorReport'), 'active' => ($this->action->id == 'IncassatorReport')),
                    array('label' => 'Выручка', 'url' => array('SumaryReport'), 'active' => ($this->action->id == 'SumaryReport')),
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
                'homeLink' => CHtml::link('Администрирование', yii::app()->createUrl('//Object')),
                'htmlOptions' => array('class' => 'breadcrumb')
            ));
            ?><!-- breadcrumbs -->
        <?php endif ?>


        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "Параметры отчета",
        ));
        ?>

        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'object-form',
            'type' => 'horizontal',
            //'htmlOptions' => array('class' => 'well'),
            'enableAjaxValidation' => false,
        ));
        ?>
            <h4>Период</h4>
            
            <span>Дата начала:</span>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language' => 'ru',
            'id'=>'date_from',
            'name' => 'date_from',
            'options' => array(    
                'showAnim' => 'fold',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        if (isset($_REQUEST['date_from'])) {
            echo "<script>$('#date_from').val('" . $_REQUEST['date_from'] . "') </script>";
        } else {
            echo "<script>$('#date_from').val('" . date('Y-m-d') . "') </script>";
        }
        ?>
        <span>Дата окончания:</span>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'language' => 'ru',
            'id'=>'date_to',
            'name' => 'date_to',
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        if (isset($_REQUEST['date_to'])) {
            echo "<script>$('#date_to').val('" . $_REQUEST['date_to'] . "') </script>";
        } else {
            echo "<script>$('#date_to').val('" . date('Y-m-d') . "') </script>";
        }
        ?>
        <br />
        <br />
        <span>Объект:</span>
        <?php $list = CHtml::listData(Object::model()->findAll(), 'id', 'obj'); ?>
        <?php echo CHtml::dropDownList('object_id', 'id', $list, array('class' => 'span4')); ?>
        
        <br />
        <br />
        
	<?php echo CHtml::submitButton('Построить отчет',array('class'=>'btn btn btn-primary')); ?>
	
        <?php $this->endWidget() ?>
        <?php $this->endWidget() ?>

        <!-- Include content pages -->
        <?php echo $content; ?>

    </div><!--/span-->
</div><!--/row-->


<?php $this->endContent(); ?>