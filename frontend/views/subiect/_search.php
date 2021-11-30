<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubiectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subiect-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'categorie_id') ?>

    <?= $form->field($model, 'titlu') ?>

    <?= $form->field($model, 'descriere') ?>

    <?= $form->field($model, 'data_creare') ?>

    <?php // echo $form->field($model, 'creat_de') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
