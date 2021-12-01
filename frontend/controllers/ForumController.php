<?php

namespace frontend\controllers;

use app\models\Categorie;
use app\models\CategorieSearch;
use app\models\Forum;
use app\models\ForumSearch;
use app\models\ForumVizualizari;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ForumController implements the CRUD actions for Forum model.
 */
class ForumController extends Controller
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
     * Lists all Forum models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ForumSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Forum model.
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
     * Creates a new Forum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!\Yii::$app->user->getIsGuest()){
            $model = new Forum();

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $model->creat_de = \Yii::$app->user->identity->id;
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['forum/index']);
    }

    /**
     * Updates an existing Forum model.
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
     * Deletes an existing Forum model.
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
     * Finds the Forum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Forum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Forum::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionViewCategorii($id_forum){
        // adaugare vizualizare in tabelul forum_vizualizari
        $this->adaugaVizualizare($id_forum);

        $query = Categorie::find()->where(['forum_id' => $id_forum]);
        $searchModel = new CategorieSearch();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'titlu' => SORT_ASC
                ]
            ],
        ]);

        return $this->render('view-categorii', [
            'model' => $this->findModel($id_forum),
           'dataProvider' => $provider,
            'searchModel' => $searchModel
        ]);
    }

    public static function getForumCategorii($forum){
        $categorii          = Categorie::find()->where(['forum_id' => $forum])->select('id')->all();
        $categorii_ids      = [];

        foreach ($categorii as $categorie){
            array_push($categorii_ids, $categorie["id"]);
        }

        return $categorii_ids;
    }

    public function adaugaVizualizare($forum_id){
        $viualizare = new ForumVizualizari();
        $viualizare->forum_id = (int) $forum_id;
        $viualizare->ip       = Yii::$app->request->getUserIP();

        $viualizare->save();
    }
}
