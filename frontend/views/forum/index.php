<?php

use app\models\Categorie;
use app\models\ForumVizualizari;
use app\models\Subiect;
use frontend\controllers\CategorieController;
use frontend\controllers\ForumController;
use frontend\controllers\SubiectController;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ForumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Forums';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adauga forum nou', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'label' => 'Titlu',
                    'attribute' => 'titlu',
                    'contentOptions' => [
                        'style' => [
                            'width' => '20%',
                            'text-align' => 'center'
                        ],
                    ],
                    'format' => 'raw',
                    'value' => function($model){
                        return Html::a($model->titlu, ['forum/view-categorii', 'id_forum' => $model->id]);
                    }
            ],
            [
                    'label' => 'Descriere',
                    'attribute' => 'descriere',
                    'value' => 'descriere',
                    'contentOptions' => [
                        'style' => [
                            'width' => '25%',
                            'text-align' => 'center'
                        ],
                    ],
            ],
            [
                'label' => 'Creat de',
                'format' => 'raw',
                'contentOptions' => [
                    'style' => [
                        'width' => '20%',
                        'vertical-align' => 'middle'
                    ],
                ],
                'value' => function($model){
                    return '
                        <div class="text-center">
                            <div>Creat de <span class="forum_added_by">'.$model->user->username.'</span></div>
                            <div>La '.$model->data_creare.'</div>
                        </div>
                    ';
                }
            ],
            [
                    'label' => 'Statistica',
                    'format' => 'raw',
                    'contentOptions' => [
                        'style' => [
                            'width' => '15%',
                            'vertical-align' => 'middle'
                        ],
                    ],
                    'value' => function($model){
                        $numar_categorii = Categorie::find()->where(['forum_id' => $model->id])->count();
                        $categorii       = Categorie::find()->where(['forum_id' => $model->id])->select('id')->all();
                        $categorii_ids   = CategorieController::getCategoriiSubiecte($categorii);

                        $subiecte        = Subiect::find()->where(['in', 'categorie_id', $categorii_ids])->select('id')->all();
                        $numar_subiecte  = Subiect::find()->where(['in', 'categorie_id', $categorii_ids])->count();
                        $subiecte_ids    = SubiectController::getSubiecteMesaje($subiecte);

                        $numar_postari         = \app\models\Postare::find()->where(['in', 'subiect_id', $subiecte_ids])->count();



                        return '
                                <div>
                                    <div class="numar_categorii">
                                        <div class="numar_categorii__numar">'.$numar_categorii.'</div>
                                        <div class="numar_categorii__text">Categorii</div>
                                    </div>
                                    <div class="numar_subiecte">
                                        <div class="numar_subiecte__numar">'.$numar_subiecte.'</div>
                                        <div class="numar_subiecte__text">Subiecte</div>
                                    </div>
                                     <div class="numar_postari">
                                        <div class="numar_postari__numar">'.$numar_postari.'</div>
                                        <div class="numar_postari__text">Postari</div>
                                    </div>
                                   
                                </div>
                            ';
                    }
            ],
            [
                    'label' => 'Vizualizari',
                    'value' => function($model){
                        return ForumVizualizari::find()->where(['forum_id' => $model->id])->count();
                    }
            ],
            [
                    'label' => 'Ultimul subiect',
                    'format' => 'raw',
                    'contentOptions' => [
                        'style' => [
                            'width' => '15%',
                            'vertical-align' => 'middle'
                        ],
                    ],
                    'value' => function($model){
                        $categorii_ids      = ForumController::getForumCategorii($model->id);
                        $ultimul_subiect    = Subiect::find()
                                                        ->where(['in', 'categorie_id', $categorii_ids])
                                                        ->select(['id', 'titlu', 'creat_de'])
                                                        ->orderBy(['data_creare' => 'DESC'])
                                                        ->one();
                        if($ultimul_subiect != null){
                            return '
                                <div>Titlu: '.Html::a($ultimul_subiect->titlu, ['subiect/view', 'id' => $ultimul_subiect->id]).'</div>
                                <div>Adaugat de '.$ultimul_subiect->user->username.'</div>
                                <div>Mesaje '.count($ultimul_subiect->postares).'</div>
                            ';
                        }
                        return '<span class="forum_no_subiecte">Nu exista subiecte adaugate</span>';
                    }
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
