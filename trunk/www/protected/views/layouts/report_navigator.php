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
        var ids = ['region', 'city', 'object_id'];
        $('#' + active + '-label').addClass('bold');
        ids.forEach(function(entry) {
            if (ids.indexOf(active) < ids.indexOf(entry)) {
                $('#' + entry).val('');
                loadList(entry);
                $('#' + entry + '-label').removeClass('bold');
            }
        });
        if (($('#region').val() || $('#city').val() || $('#object_id').val())) {
            $('#sub_btn').show();
        } else {
            $('#sub_btn').hide();
        }
    }
    
    function loadList(type) {
        $.ajax({
            url: '<?php echo $this->createAbsoluteUrl('reportPage/getListData') ?>',
            dataType: 'html',
            data: 'datatype=' + type + 
                        //'&country=' + $('#country').val() +
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
    $(document).ready(function() {
        //$('#country').change(selectOp);
        $('#region').change(selectOp);
        $('#city').change(selectOp);
        $('#object_id').change(selectOp);
        //$('#hide-btn').click(hideParams);
        
        $('#params_data .portlet-decoration').click(hideParams);
        
        $('#sub_btn').hide();

    });

</script>
<div class="row-fluid">
    <div class="span12">

        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "Параметры отчета <a style='float:right' id='hide-btn' class='btn btn-small' href='#'><i class='icon-minus-sign'></i> </a>",
            'htmlOptions'=>array('id'=>'params_data','style'=>'cursor: pointer;'),
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
            <span class="span1">Период с:</span>
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
            <?php
            /*$crit = (Yii::app()->user->getId() == "pulkovo") ? "id in (1,2)" : NULL;
            $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'country', 'country'));*/
            ?>
            <?//php echo CHtml::dropDownList('country', 'country', $list, array('class' => 'span4', 'id' => 'country', 'empty' => 'Выберите страну')); ?>
            <span class="span1" id="region-label">Регион:</span>
            <?php
            $crit = (Yii::app()->user->getId() == "pulkovo") ? "id in (1,2)" : NULL;
            $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'region', 'region'));
            ?>
            <?php echo CHtml::dropDownList('region', 'region', $list, array('class' => 'span4', 'id' => 'region', 'empty' => 'Выберите регион')); ?>
            <br />
            <br />
            <span class="span1" id="city-label">Город:</span>
            <?php
            $crit = "1 = 1";
            $crit .= !empty($_REQUEST['region'])?(" AND region = '" . $_REQUEST['region'] . "'"):NULL;
            $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'city', 'city'));
            ?>
            <?php echo CHtml::dropDownList('city', 'city', $list, array('class' => 'span4', 'id' => 'city', 'empty' => 'Выберите город')); ?>
            <br />
            <br />
            <span class="span1" id="object_id-label">Объект:</span>
            <?php
            $crit = "1 = 1";
            $crit .= !empty($_REQUEST['region'])?(" AND region = '" . $_REQUEST['region'] . "'"):NULL;
            $crit .= !empty($_REQUEST['city'])?(" AND city = '" . $_REQUEST['city'] . "'"):NULL;
            $list = CHtml::listData(Object::model()->findAll($crit), 'id', 'obj');
            ?>
            <?php
            echo CHtml::dropDownList('object_id', 'id', $list, array('class' => 'span4', 'id' => 'object_id', 'empty' => 'Выберите объект'));
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