<?php
$this->breadcrumbs=array(
	'Adv Platforms'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Обновление',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Список', 'url'=>array('index')),
);
?>

<h1>Обновить рекламную площадку <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>