<?php
$this->breadcrumbs=array(
	'Статические показатели'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
);
?>

<h1>Создать статический показатель</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>