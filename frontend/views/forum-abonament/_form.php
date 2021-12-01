<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ForumAbonament */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forum-abonament-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ab_subiect_id')->textInput() ?>

    <?= $form->field($model, 'ab_email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
