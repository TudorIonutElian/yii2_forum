<?php

namespace frontend\controllers;

use app\models\ForumAbonament;
use app\models\ForumDocumente;
use app\models\Postare;
use app\models\PostareSearch;
use app\models\Subiect;
use app\models\SubiectSearch;
use frontend\models\RaspunsSubiectForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SubiectController implements the CRUD actions for Subiect model.
 */
class SubiectController extends Controller
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
     * Lists all Subiect models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubiectSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subiect model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = new RaspunsSubiectForm();
        if(\Yii::$app->request->isPost){

            $request = Yii::$app->request;

            $postare = new Postare();
            $postare->subiect_id = (int)$id;

            $form = $request->getBodyParam("RaspunsSubiectForm");
            $postare->continut = $form["raspuns"];
            $postare->creat_de = Yii::$app->user->identity->id;
            $postare->position = Postare::find()->where(['subiect_id' => $id])->max('position') + 1;

            if($postare->save()){
                $documente = UploadedFile::getInstances($model, 'document');
                if($documente != null){
                    $model->document = UploadedFile::getInstances($model, 'document');
                    foreach ($model->document as $document) {
                        $time = time();
                        $file_name_final = strtolower($document->baseName . $time);
                        $document->saveAs('forum_documente/' . $file_name_final. '.' . $document->extension);

                        // salvare titlu documente in baza de date
                        $forum_documente = new ForumDocumente();
                        $forum_documente->postare_id = $postare->id;
                        $forum_documente->file_name  = $file_name_final.'.' . $document->extension;
                        $forum_documente->validate();
                        $forum_documente->save();
                    }
                }

                // verificare daca userul s-a abonat
                if(isset($form["abonament"])){
                    $abonament = (int) $form["abonament"];
                    $this->adaugaAbonament($abonament, $id);
                }

                // trimitere email utilizatorilor daca exista abonamente
                $this->notificareMesajNou();


            }
            return $this->redirect(['subiect/view', 'id' => $id]);

        }

        // REQUEST IS GET HERE
        $query = Postare::find()->where(['subiect_id' => $id])->orderBy('position');
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $userHasSubscriptionResult = $this->checkAbonament($id, Yii::$app->user->identity);
        //verificare daca userul este abonat

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $provider,
            'subscription'  => $userHasSubscriptionResult
        ]);
    }

    /**
     * Creates a new Subiect model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subiect();

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
     * Updates an existing Subiect model.
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
     * Deletes an existing Subiect model.
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
     * Finds the Subiect model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Subiect the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subiect::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public static function getSubiecteMesaje($subiecte){
        $subiecte_ids   = [];

        foreach ($subiecte as $subiect){
            array_push($subiecte_ids, $subiect["id"]);
        }

        return $subiecte_ids;
    }

    /* ---------- FUNCTIE PENTRU CREAREA UNUI ABONAMENT ---------- */
    public function adaugaAbonament($abonament, $id = 1){
        if($abonament === 1){
            // verificare daca mai exista deja un abonament
            $abonament_existent = ForumAbonament::find()
                                                ->where([
                                                    'ab_subiect_id' => $id,
                                                    'ab_email' => Yii::$app->user->identity->email])
                                                ->one();
            if($abonament_existent === null){
                $abonament = new ForumAbonament();
                $abonament->ab_subiect_id = $id;
                $abonament->ab_email      = Yii::$app->user->identity->email;
                $abonament->save();
            }
        }

        return $this->redirect(['subiect/view', 'id' => $id]);
    }

    // verificarea unui abonament
    public function checkAbonament($subiect_id, $user){
        $userHasSubscription = ForumAbonament::find()
            ->where([
                'ab_subiect_id' => $subiect_id,
                'ab_email' => $user->email])
            ->select('id')
            ->one();

        if($userHasSubscription != null){
            return true;
        }

        return false;
    }

    // Afisare abonament
    public static function renderSubscribed($subscription, $form, $model){
        if($subscription == true){
            echo
            '<div class="=subscription">
                  <span class="already_subscribed">Sunteti abonat la subiect.</span><br>
                  <span>Daca doriti sa va dezabonati de la acest subiect sau oricare altul, o puteti face  din contul dvs.</span>
            </div>';
        }else{
            echo
            '<div class="new_subscription">
              <span class="subscribe_to_subiect">Nu sunteti abonat</span><br>
              <span>'.$form->field($model, 'abonament')->checkbox().'</span>
            </div>';
        }


    }

    // trimitere email
    public function notificareMesajNou(){
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'notificareMesajNou-html', 'text' => 'notificareMesajNou-text']
            )
            ->setFrom('no-reply@app.com')
            ->setTo('ionuteliantudor@gmail.com')
            ->setSubject('Mesaj nou la subiectul 1')
            ->send();
    }
}
