<?php

use app\models\ForumDocumente;
use frontend\controllers\PostareController;
use frontend\controllers\SubiectController;
use frontend\models\RaspunsSubiectForm;
use kartik\file\FileInput;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Subiect */
/** @var object $dataProvider */
/** @var object $searchModel */
/** @var boolean $subscription */

$this->title = $model->titlu;
$this->params['breadcrumbs'][] = ['label' => 'Subiecte', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="subiect-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
                [
                        'label' => 'Adaugat de',
                        'format' => 'raw',
                        'contentOptions' => [
                            'style' => [
                                'width' => '20%',
                                'vertical-align' => 'middle'
                            ],
                        ],
                        'value' => function($model){
                            return '    
                                <div class="postare_user_data">
                                    <div 
                                        class="postare_user" 
                                        data-postare_id="'.$model->id.'"
                                    >
                                        '.$model->user->username.'
                                    </div>
                                    <div 
                                        class="postare_time" 
                                        data-postare_id="'.$model->id.'">
                                        '.$model->data_creare.'
                                    </div>
                                </div>
                            
                            ';
                        }
                ],
                [
                    'label' => 'Continut',
                    'format' => 'raw',
                    'contentOptions' => [
                        'style' => [
                            'min-width' => '80%',
                            'word-wrap' => 'wrap',
                            'text-align' => 'justify',
                        ],
                    ],
                    'value' => function($model){
                        $documente = ForumDocumente::find()
                                                    ->where(['postare_id' => $model->id])
                                                    ->select('file_name')
                                                    ->all();

                        $divDocumente           = PostareController::renderLinkuriDocumente($documente);
                        $continutPostare        = PostareController::afisareContinut($model->continut);
                        $continutFinalPostare   = PostareController::renderContinutText($continutPostare);


                        return '<div class="postare_right text-wrap">
                                    <div class="postare_bar">
                                        <div></div>
                                        <div>
                                            <button 
                                                class="btn btn-sm btn-secondary btn-quote"
                                                data-postare_id="'.$model->id.'"
                                                >
                                                QUOTE
                                            </button>
                                            <span class="btn btn-sm btn-info font-weight-bold">#'.$model->position.'</span>
                                        </div>
                                    </div>
                                    <div 
                                        class="postare_body"
                                        data-postare_id="'.$model->id.'"                                    
                                    >
                                        <div 
                                                class="postare_continut"
                                                data-postare_id="'.$model->id.'"
                                            >'.$continutFinalPostare.'
                                         </div>
                                    </div>
                                    <div class="postare_documente">
                                        '.$divDocumente.'
                                    </div>
                        </div>';
                    }
                ]
            //['class' => 'yii\grid\ActionColumn'],
        ],
        'emptyText' => 'Se pare ca subiectul nu are niciun mesaj. Puteti începe sa adaugati mesaje.'
    ]); ?>

    <?php if(!Yii::$app->user->getIsGuest()) :?>
        <?php $model = new RaspunsSubiectForm(); ?>
        <div class="form-raspuns">
            <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

            <div class="row">
                <div class="col-12">
                    <?php SubiectController::renderSubscribed($subscription, $form, $model) ;?>
                </div>
                <div class="col-12" id="raspuns_textarea">
                    <?= $form->field($model, 'raspuns')->textarea(['rows' => 12]) ?>
                </div>
                <div class="col-12" id="raspuns_incarcare_documente">
                    <?= $form->field($model, 'document[]')->widget(FileInput::classname(), [
                        'options' => ['multiple' => true]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Salveaza raspunsul', ['class' => 'btn btn-outline-success']); ?>
                <?= Html::a('Adaugati documente', '', ['class' => 'btn btn-outline-primary', 'id' => 'showHideUpload']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>


</div>

<script>
    let uploadSection = $('#raspuns_incarcare_documente');
    uploadSection.hide();
    $('#showHideUpload').click(function (e){
        e.preventDefault();
        let textAreaSection = $('#raspuns_textarea');

        if(textAreaSection.hasClass('col-12')){
            textAreaSection.removeClass('col-12');
            textAreaSection.addClass('col-6');

            uploadSection.removeClass('col-12');
            uploadSection.addClass('col-6');

        }else if(textAreaSection.hasClass('col-6')){
            textAreaSection.removeClass('col-6');
            textAreaSection.addClass('col-12');
        }

        uploadSection.toggle();
    })

    $('.btn-quote').click(function (e){
        let attributeValue = e.target.attributes["data-postare_id"].value;
        let username = $('.postare_user').filter(function(){
            let usernameText = $(this).attr("data-postare_id") === attributeValue;
            return usernameText;
        });

        let time = $('.postare_time').filter(function(){
            let timeText = $(this).attr("data-postare_id") === attributeValue;
            return timeText;
        });

        let continut = $('.postare_continut').filter(function(){
            let continutText = $(this).attr("data-postare_id") === attributeValue;
            return continutText;
        });


        let fullQuoteText = `[quote]${username[0].innerText} - ${time[0].innerText}, a scris : ${continut[0].innerText} [/quote]`;


        // identificare quote left
        let positionOfLeftQuote = fullQuoteText.indexOf("«");
        let positionOfRightQuote = fullQuoteText.indexOf("»");


        let finalText = $('#raspunssubiectform-raspuns');
        if(positionOfLeftQuote === -1){
            finalText.val(fullQuoteText);
        }else{
            let leftText   = fullQuoteText.substring(0, positionOfLeftQuote);
            let rightText  = fullQuoteText.substring(positionOfRightQuote+1);

            finalText.val(`${leftText} ${rightText}`);
        }
    });
</script>
