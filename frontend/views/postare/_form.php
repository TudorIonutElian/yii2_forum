<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Postare */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="postare-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subiect_id')->textInput() ?>

    <?= $form->field($model, 'continut')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'data_creare')->textInput() ?>

    <?= $form->field($model, 'creat_de')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
