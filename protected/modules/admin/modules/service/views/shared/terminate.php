<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denisboldinov
 * Date: 7/3/12
 * Time: 10:12 AM
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'banner-terminate-form',
    'enableAjaxValidation' => false,
)); ?>

    <h1>Текущий услуга
        подключена <?php echo Yii::app()->dateFormatter->format('d MMMM y', $model->created_at) ?></h1>

    <div class="row">
        <?php echo $form->labelEx($terminateForm, 'terminated_at'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
        array(
            'model' => $terminateForm,
            'attribute' => 'terminated_at',
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
            'htmlOptions' => array('value' => (empty($terminateForm->terminated_at) ? date('Y-m-d') : $terminateForm->terminated_at)),
        )); ?>
        <?php echo $form->error($terminateForm, 'terminated_at'); ?>
    </div>

    <?php echo $form->hiddenField($terminateForm, 'enabled', array('value' => 0)) ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отключить услугу'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>