<?php
$this->breadcrumbs = array(
    'Сайты' => array('index'),
    $model->domain,
);

$this->menu = array(
    array('label' => 'Создать', 'url' => array('create')),
    array('label' => 'Обновить', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Список', 'url' => array('index')),
    array('label' => 'Удалить', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Вы действительно хотите удалить эту запись?')),

    array('label' => "Запросы"),
    array('label' => 'Добавить запрос', 'url' => array('/admin/site/phrase/create')),

    array('label' => "Добавить услугу"),
    array('label' => 'Оплата по позициям', 'url' => array('/admin/service/position/subscribe', 'siteId' => $model->id)),
);
?>

<h1>Просмотр</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'client.name',
        'domain:url',
        'created_at',
        'updated_at',
    ),
)); ?>

<h2>Запросы</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'site-phrase-grid',
    'dataProvider' => new CArrayDataProvider($model->sitePhrases),
    'filter' => null,
    'columns' => array(
        'id',
        'phrase',
        'price',
        'active:boolean'
    ),
)); ?>

<h2>Подключенные услуги</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'site-service-grid',
    'dataProvider' => new CArrayDataProvider($model->siteServices),
    'filter' => null,
    'columns' => array(
        array(
            'type' => 'raw',
            'value' => 'CHtml::link(Service::getLabel($data->service_id), array("/admin/service/".Service::getControllerName($data->service_id)."/input", "siteId" => $data->site_id))'
        ),
    ),
)); ?>