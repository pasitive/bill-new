<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'htmlOptions' => array('class' => 'well'),
)); ?>

<?php echo $form->textFieldRow($model, 'id', array('size' => 10, 'maxlength' => 10)); ?>

<?php echo $form->dropDownListRow($model, 'name', CHtml::listData(
        Client::model()->my()->findAll(), 'name', 'name'),
    array('empty' => Yii::app()->params->emptySelectLabel)
); ?>

<?php echo $form->textFieldRow($model, 'address', array('size' => 60, 'maxlength' => 255)); ?>

<?php echo $form->dropDownListRow(
    $model,
    'is_corporate',
    array('1' => 'Да', '0' => 'Нет'),
    array('empty' => Yii::app()->params->emptySelectLabel)
); ?>

<p>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => ' Поиск')); ?>
</p>

<?php $this->endWidget(); ?>