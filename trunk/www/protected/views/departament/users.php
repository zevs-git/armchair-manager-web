<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs = array(
    'Дилеры' => array('index'),
    $model->id,
);
?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Прамаетры дилера",
));
?>
<h3>Дилер: "<?php echo $model->name; ?>"</h3>
<?php $this->renderPartial('form_start', array('model' => $model)) ?>

<div class="form">

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$users->searchByDepId($model->id),
        'itemsCssClass' => 'table table-striped table-bordered',
	'filter'=>$users,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'profile.lastname',
		),
                array(
			'name'=>'profile.firstname',
		),
                array(
			'name'=>'profile.staff_state',
                        'value'=>'User::itemAlias("StaffState",$data->profile->staff_state)',
                        'filter'=> User::itemAlias("StaffState"),
                    
		),
		'lastvisit_at',
		array(
			'name'=>'role',
                        'value'=>'$data->gerRoleDescr()',
			'filter'=> CHtml::listData(User::getRolesList(),'name','descr'),
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		)
	),
)); ?>

</div><!-- form -->
<?php $this->endWidget() ?>
