<?php
$this->breadcrumbs = array(
    'Пользователи' => array('index'),
    'Список',
);

$this->menu = array(
    array('label' => 'Создать', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Список</h1>

<?php echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'filter' => null,
    'columns' => array(
        'id',
        array(
            'class' => 'CLinkColumn',
            'labelExpression' => '$data->name',
            'urlExpression' => 'Yii::app()->createUrl("/admin/user/view/", array("id" => $data->id))',
        ),
        'roleLabel:Уровень доступа',
        'email',
        /*
        'created_at',
        'updated_at',
        */
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
