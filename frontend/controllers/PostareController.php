<?php

namespace frontend\controllers;

use app\models\Postare;
use app\models\PostareSearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostareController implements the CRUD actions for Postare model.
 */
class PostareController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Postare models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostareSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Postare model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Postare model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Postare();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Postare model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Postare model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Postare model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Postare the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Postare::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public static function afisareContinut($continut){
        $finalContinut = [];
        if(str_starts_with($continut, '[quote]')){
            $quotedText = self::get_string_between($continut, '[quote]', '[/quote]');
            $postText   = strstr($continut, '[/quote]');
            $postText   = substr($postText, 8);

            $finalContinut["quotedText"]    = $quotedText;
            $finalContinut["postText"]    = $postText;

            return $finalContinut;
        }

        $finalContinut["continut"] = $continut;
        return $finalContinut;
    }

    public static function renderContinutText($continut){
        $continutFinalPostare   = "";
        if(array_key_exists("quotedText", $continut)){
            $continutFinalPostare .= '<div class="quotedText"><span class="left_quote">&laquo;</span>'.$continut["quotedText"].'<span class="right_quote">&raquo;</span></div>';
            $continutFinalPostare .= '<div>'.$continut["postText"].'</div>';
        }else{
            $continutFinalPostare  = $continut["continut"];
        }

        return $continutFinalPostare;
    }

    public static function renderLinkuriDocumente($documente){
        $divDocumente = "";
        if($documente != null){
            foreach ($documente as $document){
                $divDocumente .= "<a href=\"forum_documente/$document->file_name\" class='btn btn-sm btn-outline-secondary py-0 mr-1' target='_blank'>$document->file_name</a>";
            };
        }
        return $divDocumente;
    }
    public static function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }
}
