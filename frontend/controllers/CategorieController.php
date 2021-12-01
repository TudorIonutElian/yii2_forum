<?php

namespace frontend\controllers;

use app\models\Categorie;
use app\models\CategorieSearch;
use app\models\ForumVizualizari;
use app\models\Subiect;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategorieController implements the CRUD actions for Categorie model.
 */
class CategorieController extends Controller
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
     * Lists all Categorie models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorieSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categorie model.
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
     * Creates a new Categorie model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($forum_id)
    {
        $model = new Categorie();
        if ($this->request->isPost) {
            $request = $this->request->post();
            $categorieData = $this->request->getBodyParam("Categorie");

            $categorie = new Categorie();
            $categorie->forum_id = (int) $forum_id;
            $categorie->titlu = $categorieData["titlu"];
            $categorie->descriere = $categorieData["descriere"];
            $categorie->creat_de = Yii::$app->user->identity->id;
            $categorie->save();

            return $this->redirect(['forum/view-categorii', 'id_forum' => $forum_id]);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Categorie model.
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
     * Deletes an existing Categorie model.
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
     * Finds the Categorie model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Categorie the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categorie::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionViewSubiecte($id_categorie){
        // adaugare vizualizare in tabelul forum_vizualizari
        $this->adaugaVizualizare($id_categorie);

        $query = Subiect::find()->where(['categorie_id' => $id_categorie]);
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

        return $this->render('view-subiecte', [
            'dataProvider' => $provider,
            'searchModel' => $searchModel,
            'model' => $this->findModel($id_categorie)
        ]);
    }

    public static function getCategoriiSubiecte($categorii){
        $subiecte_ids   = [];

        foreach ($categorii as $categorie){
            array_push($subiecte_ids, $categorie["id"]);
        }

        return $subiecte_ids;
    }

    // adauga vizualizare noua in tabelul forum_vizualizari
    public function adaugaVizualizare($categorie_id){
        $viualizare = new ForumVizualizari();
        $viualizare->categorie_id = (int) $categorie_id;
        $viualizare->ip       = Yii::$app->request->getUserIP();

        $viualizare->save();
    }
}
