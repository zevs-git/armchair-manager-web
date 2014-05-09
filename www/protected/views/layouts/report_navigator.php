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
    .ui-widget{font-family:Verdana,Arial,sans-serif;font-size: 0.9em;}
    .bold {
        font-weight: 700;
    }
</style>
<script>
    function selectOp(id) {
        var active = $(this).attr('name');
        var ids = ['country','region', 'city', 'object_id'];
        $('#' + active + '-label').addClass('bold');
        ids.forEach(function(entry) {
            if (ids.indexOf(active) < ids.indexOf(entry)) {
                $('#' + entry).val('');
                loadList(entry);
                $('#' + entry + '-label').removeClass('bold');
            }
        });
        
        showBTN();
    }
    
    function loadList(type) {
        $.ajax({
            url: '<?php echo $this->createAbsoluteUrl('reportPage/getListData') ?>',
            dataType: 'html',
            data: 'datatype=' + type + 
                        '&country=' + $('#country').val() +
                        '&region=' + $('#region').val() +
                        '&city=' + $('#city').val(),
            success: function(data) {
                $('#'+type).html(data);
            }
        });
    }
    function hideParams() {
        if ($('#parameters').is(':visible')) {
            $('#parameters').hide('slideUp');
            $('#hide-btn i').attr('class', 'icon-plus-sign');
        } else {
            $('#parameters').show('slideDown');
            $('#hide-btn i').attr('class', 'icon-minus-sign');
        }
    }
    function showBTN() {
        if (($('#country').val() || $('#region').val() || $('#city').val() || $('#object_id').val() || $('#staff').val())) {
            $('#sub_btn').show();
        } else {
            $('#sub_btn').hide();
        }
        
    }
    $(document).ready(function() {
        $('#country').change(selectOp);
        $('#region').change(selectOp);
        $('#city').change(selectOp);
        $('#object_id').change(selectOp);
        //$('#hide-btn').click(hideParams);
        $('#type').change(showBTN);
        $('#staff').change(showBTN);
        $('#sort_by_time').change(showBTN);
        
        
        $('#params_data .portlet-decoration').click(hideParams);
        
        $('#sub_btn').hide();
        $('#date_from').change(showBTN);
        $('#date_to').change(showBTN);

    });

</script>
<div class="row-fluid">
    <div class="span22">

        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "Параметры отчета <a style='float:right' id='hide-btn' class='btn btn-small' href='#'><i class='icon-minus-sign'></i> </a>",
            'htmlOptions'=>array('id'=>'params_data','style'=>'cursor: pointer;','class'=>'portlet'),
        ));
        ?>
        <div id="parameters">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'object-form',
                'type' => 'horizontal',
                //'htmlOptions' => array('class' => 'well'),
                'enableAjaxValidation' => false,
            ));
            ?>
            <br />
            <span class="span2">Период с:</span>
            <?php
            $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                'language' => 'ru',
                'id' => 'date_from',
                'name' => 'date_from',
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'dd.mm.yy',
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            if (isset($_REQUEST['date_from'])) {
                echo "<script>$('#date_from').val('" . $_REQUEST['date_from'] . "') </script>";
            } else {
                echo "<script>$('#date_from').val('" . date('d.m.Y') . "') </script>";
            }
            ?>
            <span>по:</span>
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
                    'style' => 'height:20px;'
                ),
            ));
            if (isset($_REQUEST['date_to'])) {
                echo "<script>$('#date_to').val('" . $_REQUEST['date_to'] . "') </script>";
            } else {
                echo "<script>$('#date_to').val('" . date('d.m.Y') . ' 23:59' . "') </script>";
            }
            ?>
            <br />
            <br />
             <span class="span2" id="region-label">Страна:</span>
            <?php
            $crit = NULL;
            $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'country', 'country'));
            ?>
            <?php echo CHtml::dropDownList('country', 'country', $list, array('class' => 'span3', 'id' => 'country', 'empty' => 'Выберите страну')); ?>
            <br />
            <br />
            <span class="span2" id="region-label">Регион:</span>
            <?php
            $crit = (Yii::app()->user->checkAccess('Superadmin'))?'':'departament_id = ' . Yii::app()->getModule('user')->user()->departament_id;
            $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'region', 'region'));
            ?>
            <?php echo CHtml::dropDownList('region', 'region', $list, array('class' => 'span3', 'id' => 'region', 'empty' => 'Выберите регион')); ?>
            <br />
            <br />
            <span class="span2" id="city-label">Город:</span>
            <?php
            $crit = (Yii::app()->user->checkAccess('Superadmin'))?"1 = 1":'departament_id = ' . Yii::app()->getModule('user')->user()->departament_id;
            $crit .= !empty($_REQUEST['region'])?(" AND region = '" . $_REQUEST['region'] . "'"):NULL;
            $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'city', 'city'));
            ?>
            <?php echo CHtml::dropDownList('city', 'city', $list, array('class' => 'span3', 'id' => 'city', 'empty' => 'Выберите город')); ?>
            <br />
            <br />
            <span class="span2" id="object_id-label">Объект:</span>
            <?php
            $crit = (Yii::app()->user->checkAccess('Superadmin'))?"1 = 1":'departament_id = ' . Yii::app()->getModule('user')->user()->departament_id;
            $crit .= !empty($_REQUEST['region'])?(" AND region = '" . $_REQUEST['region'] . "'"):NULL;
            $crit .= !empty($_REQUEST['city'])?(" AND city = '" . $_REQUEST['city'] . "'"):NULL;
            $list = CHtml::listData(Object::model()->findAll($crit), 'id', 'obj');
            ?>
            
            <?php
            echo CHtml::dropDownList('object_id', 'id', $list, array('class' => 'span3', 'id' => 'object_id', 'empty' => 'Выберите объект'));

            ?>
            
            <?php if ( in_array($this->action->id,array('StaffReport','IncassatorReport'))):?>
            <br />
            <br />
            <span class="span2" id="type-label">ФИО:</span>
            <?php 
                $crit = (Yii::app()->user->checkAccess('Superadmin'))?"1 = 1":'departament_id = ' . Yii::app()->getModule('user')->user()->departament_id;
                if ($this->action->id == 'IncassatorReport') $crit .= " AND staff_type_id = 0";
                $list = CHtml::listData(Staff::model()->findAll($crit), 'id', 'FIO');
            
                echo CHtml::dropDownList('staff_id', 'staff_id', $list, array('class' => 'span3', 'id' => 'staff','empty' => 'Выберите персонал')); ?>
            
            <?php endif; ?>
            
            <?php if ($this->action->id == 'MassageReport'):?>
            <br />
            <br />
            <span class="span2" id="type-label">Тип отчета:</span>
            <?php echo CHtml::dropDownList('rep_type', 'rep_type', array('0'=>'Таблица','1'=>'График'), array('class' => 'span3', 'id' => 'type',)); ?>
            <br />
            <br />
            <span class="span2" id="type-label">Сортировать по времени:</span>
            <?php echo CHtml::checkBox('sort_by_time',!empty($_REQUEST['sort_by_time']),array('id' => 'sort_by_time',)); ?>
            
            <?php endif; ?>
            
            <?php
            if (isset($_REQUEST['country'])) {
                echo "<script>$('#country').val('" . $_REQUEST['country'] . "') </script>";
            }
            if (isset($_REQUEST['region'])) {
                echo "<script>$('#region').val('" . $_REQUEST['region'] . "') </script>";
            }
            if (isset($_REQUEST['city'])) {
                echo "<script>$('#city').val('" . $_REQUEST['city'] . "') </script>";
            }
            if (isset($_REQUEST['object_id'])) {
                echo "<script>$('#object_id').val('" . $_REQUEST['object_id'] . "') </script>";
            }
            if (isset($_REQUEST['rep_type'])) {
                echo "<script>$('#type').val('" . $_REQUEST['rep_type'] . "') </script>";
            }
            if ($this->showRep) {
                echo "<script>hideParams();</script>";
            }
            ?>
            <br />
            <br />
            <div class="btn-toolbar">
                <?php echo CHtml::submitButton('Построить отчет', array('class' => 'btn btn btn-primary','id'=>'sub_btn')); ?>
            </div>

            <?php $this->endWidget() ?>
            <?php $this->endWidget() ?>
        </div>
        <!-- Include content pages -->
        <?php echo $content; ?>
    </div><!--/span-->
</div><!--/row-->


<?php $this->endContent(); ?>