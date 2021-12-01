<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ForumAbonamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Abonamente subiecte forum';
$this->params['breadcrumbs'][] = ['label' => 'Forumuri', 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-abonament-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                    'label' => 'Titlu subiect',
                    'attribute' => 'ab_subiect_id',
                    'value' => function($model){
                        return $model->subiect->titlu;
                    }
            ],
            'ab_email:email',

            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($data) {
                            return Html::a('Sterge abonament', $data, ['class' => 'btn btn-sm btn-danger', 'data-method' => 'post']);
                        },
                    ]
            ],
        ],
        'emptyText' => 'Nu aveti niciun abonament activ.'
    ]);
    ?>


</div>
