<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Postares';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postare-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Postare', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subiect_id',
            'continut:ntext',
            'data_creare',
            'creat_de',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
