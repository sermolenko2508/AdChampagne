<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Offer;
use yii\data\Pagination;

class OfferController extends Controller
{
    public function actionIndex()
    {
        $query = Offer::find();

        $search = Yii::$app->request->get('search');
        $sortField = Yii::$app->request->get('sort', 'id');
        $sortOrder = Yii::$app->request->get('order', 'asc');

        if ($search) {
            $query->andWhere(['or',
                ['like', 'name', $search],
                ['like', 'email', $search]
            ]);
        }

        $query->orderBy([$sortField => $sortOrder === 'asc' ? SORT_ASC : SORT_DESC]);

        $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $offers = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_offers_table', ['offers' => $offers]);
        }

        return $this->render('index', [
            'offers' => $offers,
            'pagination' => $pagination,
        ]);
    }

    public function actionCreate()
    {
        $model = new Offer();

        if (Yii::$app->request->isAjax && !Yii::$app->request->post()) {
            return $this->renderPartial('_form', ['model' => $model]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->statusCode = 409;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => false, 'errors' => $model->errors];
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && !Yii::$app->request->post()) {
            return $this->renderPartial('_form', ['model' => $model]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->statusCode = 409;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => false,
                'errors' => $model->getErrors(),
            ];
        }

        return $this->render('update', ['model' => $model]);
    }
    

    public function actionDelete($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->response->statusCode = 200;
            return ['success' => true, 'message' => 'Оффер успешно удален'];
        }

        Yii::$app->response->statusCode = 409;
        return ['success' => false, 'message' => 'Не удалось удалить оффер'];
    }

    protected function findModel($id)
    {
        if (($model = Offer::findOne($id)) !== null) {
            return $model;
        }
        Yii::$app->response->statusCode = 404;
        throw new NotFoundHttpException('Оффер не найден');
    }
}
