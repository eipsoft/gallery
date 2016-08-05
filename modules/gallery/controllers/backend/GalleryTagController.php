<?php

namespace app\modules\gallery\controllers\backend;

use Yii;
use app\modules\gallery\common\models\GalleryTag;
use app\modules\gallery\common\models\GalleryTagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * GalleryTagController implements the CRUD actions for GalleryTag model.
 */
class GalleryTagController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all GalleryTag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GalleryTagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // validate if there is a editable input saved via AJAX
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $tagId = Yii::$app->request->post('editableKey');
            $model = GalleryTag::findOne($tagId);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            $tag = current($_POST['GalleryTag']);
            $post = ['GalleryTag' => $tag];

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                if (!$model->save()) {
                    if (!empty($model->errors)) {
                        //get only first error and then break
                        foreach ($model->errors as $arError) {
                            $error = $arError[0];
                            $out = Json::encode(['output' => '', 'message' => $error]);
                            break;
                        }
                    }
                }

               
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GalleryTag model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GalleryTag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->request->post('tags')) {
            GalleryTag::addMultiTags(Yii::$app->request->post('tags'));
            return $this->redirect('index');
        } else {
            return $this->render('create');
        }
    }

    /**
     * Updates an existing GalleryTag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GalleryTag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GalleryTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GalleryTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GalleryTag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
