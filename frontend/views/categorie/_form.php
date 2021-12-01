<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Categorie */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categorie-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'titlu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descriere')->textarea(['rows' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salveaza datele categoriei', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
