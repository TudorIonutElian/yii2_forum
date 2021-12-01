<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ForumAbonament */

$this->title = 'Update Forum Abonament: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Forum Abonaments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="forum-abonament-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
