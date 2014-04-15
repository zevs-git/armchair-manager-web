<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Вход';
?>
<style>
    .user-container {
        width: 365px;
        text-align: center;
        -webkit-box-shadow: 2px 2px 16px 0px rgba(50, 50, 50, 0.74);
        -moz-box-shadow:    2px 2px 16px 0px rgba(50, 50, 50, 0.74);
         box-shadow:         2px 2px 16px 0px rgba(50, 50, 50, 0.74);
         margin: 0 auto;
        
    }
    .user-container h3 {
        font-size: 13px;
        margin: 0;
        color: grey;
    }
    div.rememberMe {
        margin-bottom: 15px;
    }
    .form {
        text-align: left;
        margin: 20px;
        margin-top: 0;
    }
    label {
        vertical-align: sub;
        color: grey;
        font-weight: 700;
    }
    .red-line {
        background-color: #bd362f;
        height: 31px;
        width: 415px;
        margin-left: -35px;
        padding: 5px;
    }
    .red-line span {
        color: white;
        font-size: 17px;
        vertical-align: -webkit-baseline-middle;
    }
    #triangle-topright-left {
        width: 0;
        height: 0;
        border-top: 30px solid #812823;
        border-left: 30px solid transparent;
        margin: 0;
        margin-left: -35px;
    }
    #triangle-topright-right {
        width: 0;
        height: 0;
        border-top: 30px solid #812823;
        border-right:  30px solid transparent;
        float: right;
        position: relative;
        left: 35px;
    }
    .row input[type=text], .row input[type=password]  {
        width: 95%;
        background-color: #F0F0F0;
        -webkit-border-radius: 13px;
        -moz-border-radius: 13px;
        border-radius: 13px;
    }
    
</style>
<div class="row-fluid">
	
    <div class="span6 offset3">
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		//'title'=>"Пожалуйста, введите ваши учетные данные для входа:",
            'htmlOptions'=>array('class'=>'user-container')
	));
	
?>
    <div class="header-img">
        <img src="/images/logo/mr-logo.png"> 
        <h3>ПРОФЕССИОНАЛЬНЫЕ МАССАЖНЫЕ СИСТЕМЫ</h3>
    </div>
    <div class="red-line">
        <span>Введите ваши учетные данные для входа:</span>
    </div>
    <div style="text-align: left;">
        <div id="triangle-topright-right"> </div>
        <div id="triangle-topright-left"> </div>
    </div>
    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    
        <div class="row">
            <?php echo $form->textField($model,'username',array('placeholder'=>"Логин")); ?>
        </div>
    
        <div class="row">
            <?php echo $form->passwordField($model,'password',array('placeholder'=>"Пароль")); ?>
        </div>
    
        <div class="row rememberMe">
            <?php echo $form->checkBox($model,'rememberMe'); ?>
            <?php echo $form->label($model,'rememberMe',array('style'=>'display: inline;')); ?>
        </div>
    
        <div class="row buttons">
            <?php echo CHtml::submitButton('Войти',array('class'=>'btn btn btn-danger')); ?>
        </div>
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php $this->endWidget();?>

    </div>

</div>