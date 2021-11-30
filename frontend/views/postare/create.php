<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Postare */

$this->title = 'Create Postare';
$this->params['breadcrumbs'][] = ['label' => 'Postares', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postare-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
