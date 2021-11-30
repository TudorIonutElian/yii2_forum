<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subiect */

$this->title = 'Create Subiect';
$this->params['breadcrumbs'][] = ['label' => 'Subiects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subiect-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
