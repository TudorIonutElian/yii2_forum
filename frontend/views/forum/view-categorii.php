<?php

use app\models\Categorie;
use app\models\ForumVizualizari;
use app\models\Postare;
use app\models\Subiect;
use frontend\controllers\CategorieController;
use frontend\controllers\PostareController;
use frontend\controllers\SubiectController;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var TYPE_NAME $dataProvider */
/** @var TYPE_NAME $searchModel */

/** @var mixed $model */
$this->title = $model->titlu;
$this->params['breadcrumbs'][] = ['label' =>'Forumuri', 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>


<p>
    <?= Html::a('Adauga categorie noua', ['categorie/create', 'forum_id' => $model->id], ['class' => 'btn btn-success']) ?>
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
                return Html::a($model->titlu, ['categorie/view-subiecte', 'id_categorie' => $model->id]);
            }
        ],
        'descriere',
        [
            'label' => 'Creata de',
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
            'label' => 'Statistica',
            'format' => 'raw',
            'contentOptions' => [
                'style' => [
                    'width' => '20%',
                    'vertical-align' => 'middle'
                ],
            ],
            'value' => function($model){
                $subiecte           = Subiect::find()->where(['categorie_id' => $model->id])->select('id')->all();
                $numar_subiecte     = Subiect::find()->where(['categorie_id' => $model->id])->count();
                $subiecte_ids       = PostareController::getIdSubiecte($subiecte);
                $numar_mesaje       = Postare::find()->where(['in', 'subiect_id', $subiecte_ids])->count();


                return '
                                <div>
                                    <div class="numar_subiecte">
                                        <div class="numar_subiecte__numar"> '.$numar_subiecte.' </div>
                                        <div class="numar_subiecte__text">Subiecte</div>
                                    </div>  
                                    <div class="numar_mesaje">
                                        <div class="numar_mesaje__numar"> '.$numar_mesaje.' </div>
                                        <div class="numar_mesaje__text">Mesaje</div>
                                    </div>                                    
                                </div>
                            ';
            }
        ],
        [
            'label' => 'Vizualizari',
            'value' => function($model){
                return ForumVizualizari::find()->where(['categorie_id' => $model->id])->count();
            }
        ],
        [
            'label' => 'Ultimul subiect',
            'format' => 'raw',
            'value' => function($model){
                $ultimul_subiect = Subiect::find()
                    ->where(['categorie_id' => $model->id])
                    ->orderBy(['data_creare' => 'DESC'])
                    ->select(['id', 'titlu', 'creat_de', 'data_creare'])
                    ->one();

                if($ultimul_subiect != null){
                    return '
                                <div>
                                    <div>
                                        '.Html::a($ultimul_subiect->titlu, ['subiect/view', 'id' => $ultimul_subiect->id]).'
                                    </div>  
                                    <div>
                                        Adaugat de <span class="categorie_added_by">'.$ultimul_subiect->user->username.'</span>
                                    </div>   
                                    <div>
                                        Mesaje '.$ultimul_subiect->getPostares()->count().'
                                    </div>                                    
                                </div>
                            ';
                }
                return 'Nu exista subiecte adaugate.';
            }
        ],

        //['class' => 'yii\grid\ActionColumn'],
    ],
    'emptyText' => 'Forumul nu are categorii adaugate.'
]); ?>
