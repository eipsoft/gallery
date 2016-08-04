<?php

namespace app\modules\gallery\controllers\backend;

use Yii;
use app\modules\gallery\models\GalleryImage;
use app\modules\gallery\models\User;
use app\modules\gallery\models\GalleryImageSearch;
use app\modules\gallery\libraries\UploadHandler;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $searchModel = new GalleryImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

        $model->load(Yii::$app->request->post());
        $galleryFolderName = $this->module->folder;
        $subFolderName = 'user' . $model->user_id;
        $folderPath = "/{$galleryFolderName}/{$subFolderName}/";

        if(Yii::$app->request->isPost){
            //Try to get file info
            $upload_image = \yii\web\UploadedFile::getInstance($model, 'upload_image');

            //If received, then I get the file name and asign it to $model->image in order to store it in db
            if(!empty($upload_image)){
                $image_name = Yii::$app->security->generateRandomString() . '.' . $upload_image->extension;
                $model->path = $folderPath . $image_name;
            }

            //I proceed to validate model. Notice that will validate that 'image' is required and also 'image_upload' as file, but this last is optional
            if ($model->validate() && $model->save()) {

                //If all went OK, then proceed to save the image in filesystem
                $webrootDir = Yii::getAlias('@webroot');
                if (!is_dir($webrootDir . $folderPath)) {
                    mkdir($webrootDir . $folderPath, 0755, true);
                }
                if(!empty($upload_image)){
                    $upload_image->saveAs($webrootDir . $folderPath . '/' . $image_name);
                }              

                $model->addTags(Yii::$app->request->post('tags'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $className = $this->module->userClass;
        $users = User::getAllUsers();
        return $this->render('create', [
            'model' => $model,
            'users' => $users,
        ]);
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
        $oldImage = $model->path;

        $model->load(Yii::$app->request->post());

        $galleryFolderName = $this->module->folder;
        $subFolderName = 'user' . $model->user_id;
        $folderPath = "/{$galleryFolderName}/{$subFolderName}/";

        if(Yii::$app->request->isPost){
            $fileParamName = 'GalleryImage';
            //if (isset($_FILES[]))
            //Try to get file info
            $upload_image = \yii\web\UploadedFile::getInstance($model, 'upload_image');

            //If received, then I get the file name and asign it to $model->image in order to store it in db
            if(!empty($upload_image)){
                $image_name = Yii::$app->security->generateRandomString() . '.' . $upload_image->extension;
                $model->path = $folderPath . $image_name;
            }

            //I proceed to validate model. Notice that will validate that 'image' is required and also 'image_upload' as file, but this last is optional
            if ($model->validate() && $model->save()) {

                //If all went OK, then proceed to save the image in filesystem
                $webrootDir = Yii::getAlias('@webroot');
                if (!is_dir($webrootDir . $folderPath)) {
                    mkdir($webrootDir . $folderPath, 0755, true);
                }
                if(!empty($upload_image)){
                    $upload_image->saveAs($webrootDir . $folderPath . '/' . $image_name);
                }
                if ($oldImage != $model->path) {
                    @unlink($webrootDir . $oldImage);
                }                

                $model->addTags(Yii::$app->request->post('tags'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $className = $this->module->userClass;
        $users = User::getAllUsers();
        $tags = $model->getTagsForWidget();
        return $this->render('update', [
            'model' => $model,
            'users' => $users,
            'tags' => $tags,            
        ]);
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
