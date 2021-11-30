<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Subiect */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subiect-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categorie_id')->textInput() ?>

    <?= $form->field($model, 'titlu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descriere')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_creare')->textInput() ?>

    <?= $form->field($model, 'creat_de')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
