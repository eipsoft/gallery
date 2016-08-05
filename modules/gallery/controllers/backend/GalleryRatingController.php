<?php

namespace app\modules\gallery\controllers\backend;

use Yii;
use app\modules\gallery\common\models\GalleryRating;
use app\modules\gallery\common\models\GalleryRatingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GalleryRatingController implements the CRUD actions for GalleryRating model.
 */
class GalleryRatingController extends Controller
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
     * Lists all GalleryRating models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GalleryRatingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing GalleryRating model only with ajax request.
     * @return string empty string
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) {
            $user_id = Yii::$app->request->post('user_id');
            $image_id = Yii::$app->request->post('image_id');
            $value = Yii::$app->request->post('value');
            GalleryRating::setRating($user_id, $image_id, $value);            
        }
        return '';       
    }

    /**
     * Deletes an existing GalleryRating model.
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
     * Finds the GalleryRating model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GalleryRating the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GalleryRating::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
