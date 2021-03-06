<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'contract-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'well'),
)); ?>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'number', array('size' => 60, 'maxlength' => 255)); ?>

<?php echo $form->dropDownListRow($model, 'client_id', CHtml::listData(Client::model()->my()->findAll(), 'id', 'name'), array('empty' => '--выбрать--')); ?>

<?php echo $form->labelEx($model, 'created_at'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
    array(
        'model' => $model,
        'attribute' => 'created_at',
        'language' => 'ru',
        'options' => array(
            'showAnim' => 'fold',
            'dateFormat' => 'yy-mm-dd',
            'changeMonth' => true,
            'changeYear' => true,
            'showOn' => 'button',
            'buttonImage' => '/images/calendar.png',
            'buttonImageOnly' => true,
        ),
    )); ?>
<?php echo $form->error($model, 'created_at'); ?>

<?php echo CHtml::label('Файлы', 'attachments'); ?>
<?php
$this->widget('CMultiFileUpload', array(
    'model' => $model,
    'attribute' => 'attachments',
    'accept' => str_replace(',', '|', $model->fileType),
));
?>

<?php echo $form->checkboxRow($model, 'status'); ?>

<p>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Сохранить')); ?>
</p>

<?php $this->endWidget(); ?>