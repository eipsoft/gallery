<?php

namespace app\modules\gallery\controllers\frontend;

use Yii;
use app\modules\gallery\common\models\GalleryImage;
use app\modules\gallery\common\models\GalleryImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * GalleryImageController implements the CRUD actions for GalleryImage model.
 */
class GalleryImageController extends Controller
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
     * Lists all GalleryImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $imagesModels = GalleryImage::find()->all();
        $images = [];
        foreach ($imagesModels as $imageModel) {
            $images[] = [
                'id' => $imageModel->id,
                'lowsrc' => $imageModel->thumbnail,
                'fullsrc' => $imageModel->path,
                'description' => $imageModel->description,
                'category' => implode(',', array_map(function($tag) {
                    return $tag->name;
                }, $imageModel->tags)),
                'timestamp' => $imageModel->created_date,
                'rating' => $imageModel->averageRating,
            ];
        }
        $images = Json::encode($images, JSON_PRETTY_PRINT);

        return $this->render('index', [
            'images' => $images,
        ]);
    }

    /**
     * Displays a single GalleryImage model.
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
     * Creates a new GalleryImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GalleryImage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GalleryImage model.
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
     * Deletes an existing GalleryImage model.
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
     * Finds the GalleryImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GalleryImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GalleryImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
