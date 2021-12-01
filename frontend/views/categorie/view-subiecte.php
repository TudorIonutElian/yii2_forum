<?php

use app\models\ForumAbonament;
use app\models\ForumVizualizari;
use app\models\Postare;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var TYPE_NAME $dataProvider */
/** @var TYPE_NAME $searchModel */
/** @var mixed $model */

$this->title = $model->titlu;
$this->params['breadcrumbs'][] = ['label' =>'Forumuri', 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = ['label' =>'Categorii', 'url' => ['categorie/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>
<p>
    <?= Html::a('Adauga subiect nou', ['subiect/create', 'id_categorie' => $model->id], ['class' => 'btn btn-success']) ?>
</p>

<?=

GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Titlu',
            'attribute' => 'titlu',
            'format' => 'raw',
            'value' => function($model){
                return Html::a($model->titlu, ['subiect/view', 'id' => $model->id]);
            }
        ],
        'descriere',
        [
            'label' => 'Creat de',
            'format' => 'raw',
            'value' => function($model){
                return '
                        <div class="text-center">
                            <div>Creata de <span class="categorie_added_by">'.$model->user->username.'</span></div>
                            <div>la data de '.$model->data_creare.'</div>
                        </div>
                    ';
            }
        ],
        [
            'label' => 'Vizualizari',
            'value' => function($model){
                return ForumVizualizari::find()->where(['subiect_id' => $model->id])->count();
            }
        ],
        [
            'label' => 'Numar mesaje',
            'format' => 'raw',
            'value' => function($model){
                return Postare::find()->where(['subiect_id' => $model->id])->count();
            }
        ],
        [
            'label' => 'Abonamente',
            'value' => function($model){
                return ForumAbonament::find()->where(['ab_subiect_id' => $model->id])->count();
            }
        ]

        //['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
