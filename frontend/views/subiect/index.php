<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SubiectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subiecte';
$this->params['breadcrumbs'][] = ['label' => 'Forumuri', 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['subiect/index']];
?>
<div class="subiect-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Subiect', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'titlu',
            'descriere',
            'data_creare',
            //'creat_de',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
