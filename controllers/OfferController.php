<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Offer;
use yii\data\Pagination;

/**
 * OfferController - контроллер для управления операциями CRUD с сущностью Offer.
 */
class OfferController extends Controller
{
    /**
     * Action для отображения списка офферов с поддержкой фильтрации, сортировки и пагинации.
     * @return string
     */
    public function actionIndex()
    {
        $query = Offer::find();

        // Получение параметров фильтрации и сортировки из запроса
        $search = Yii::$app->request->get('search');
        $sortField = Yii::$app->request->get('sort', 'id'); // Поле для сортировки (по умолчанию: ID)
        $sortOrder = Yii::$app->request->get('order', 'asc'); // Порядок сортировки (по умолчанию: возрастание)

        // Применение фильтрации по названию оффера или email представителя
        if ($search) {
            $query->andWhere(['or',
                ['like', 'name', $search],
                ['like', 'email', $search]
            ]);
        }

        // Применение сортировки
        $query->orderBy([$sortField => $sortOrder === 'asc' ? SORT_ASC : SORT_DESC]);

        // Настройка пагинации
        $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $offers = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        // Рендеринг данных через AJAX-запрос
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_offers_table', ['offers' => $offers]);
        }

        // Рендеринг основной страницы
        return $this->render('index', [
            'offers' => $offers,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Action для создания нового оффера.
     * Обрабатывает POST-запрос и возвращает JSON-ответ при использовании AJAX.
     * @return string|yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Offer();

        // Обработка данных из POST-запроса и валидация модели
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => true];
            }
            Yii::$app->session->setFlash('success', 'Оффер создан успешно');
            return $this->redirect(['index']);
        }

        // Возвращение ошибок валидации при AJAX-запросе
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            Yii::$app->response->statusCode = 409; // Код состояния для ошибки валидации
            return ['success' => false, 'errors' => $model->errors];
        }

        // Рендеринг страницы создания оффера
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Action для обновления существующего оффера.
     * @param int $id ID оффера для обновления.
     * @return string|yii\web\Response
     * @throws NotFoundHttpException если оффер не найден.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Обработка данных из POST-запроса и валидация модели
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => true];
                }
                Yii::$app->session->setFlash('success', 'Оффер обновлен успешно');
                return $this->redirect(['index']);
            } else {
                // Возвращение ошибок валидации при AJAX-запросе
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    Yii::$app->response->statusCode = 409; // Код состояния для ошибки валидации
                    return [
                        'success' => false,
                        'errors' => $model->getErrors(),
                    ];
                }
            }
        }

        // Рендеринг формы для редактирования при AJAX-запросе
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_form', ['model' => $model]);
        }

        // Рендеринг страницы редактирования
        return $this->render('update', ['model' => $model]);
    }

    /**
     * Action для удаления оффера.
     * @param int $id ID оффера для удаления.
     * @return array JSON-ответ.
     * @throws NotFoundHttpException если оффер не найден.
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        try {
            $model = $this->findModel($id);
            if ($model->delete()) {
                return ['success' => true, 'message' => 'Оффер успешно удален'];
            } else {
                return ['success' => false, 'message' => 'Не удалось удалить оффер'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Ошибка: ' . $e->getMessage()];
        }
    }

    /**
     * Метод для поиска модели по ID.
     * @param int $id ID оффера.
     * @return Offer найденная модель.
     * @throws NotFoundHttpException если модель не найдена.
     */
    protected function findModel($id)
    {
        if (($model = Offer::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Оффер не найден');
    }
}
