<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Forum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forum-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titlu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descriere')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Adauga Forumul', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
