<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

// Установка заголовка страницы
$this->title = 'Список офферов';
?>

<!-- Заголовок страницы -->
<h1><?= Html::encode($this->title) ?></h1>

<!-- Кнопка для создания нового оффера -->
<p><?= Html::a('Создать оффер', ['create'], ['class' => 'btn btn-success']) ?></p>

<!-- Включение модального окна для редактирования оффера -->
<?= $this->render('modal') ?>

<!-- Поля для поиска с использованием AJAX -->
<div class="row mb-3">
    <div class="col-md-8">
        <?= Html::textInput('search', '', [
            'id' => 'search',
            'class' => 'form-control',
            'placeholder' => 'Поиск по названию оффера или email представителя'
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= Html::button('Поиск', [
            'id' => 'apply-filter',
            'class' => 'btn btn-primary'
        ]) ?>
    </div>
</div>

<!-- Таблица для отображения списка офферов -->
<table class="table table-bordered" id="offers-table">
    <thead>
        <tr>
            <!-- Заголовки с кнопками сортировки -->
            <th>ID <a href="#" class="sort" data-sort="id" data-order="asc">▲</a></th>
            <th>Название <a href="#" class="sort" data-sort="name" data-order="asc">▲</a></th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Дата добавления</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <!-- Отображение списка офферов -->
        <?php foreach ($offers as $offer): ?>
        <tr class="offer-row" data-id="<?= $offer->id ?>">
            <!-- Поля оффера с использованием защиты от XSS через Html::encode -->
            <td><?= Html::encode($offer->id) ?></td>
            <td><?= Html::encode($offer->name) ?></td>
            <td><?= Html::encode($offer->email) ?></td>
            <td><?= Html::encode($offer->phone) ?></td>
            <td><?= Html::encode($offer->created_at) ?></td>
            <td>
                <!-- Кнопка удаления оффера с классом для обработки через JS -->
                <?= Html::a('Удалить', ['delete', 'id' => $offer->id], [
                    'class' => 'btn btn-danger delete-offer',
                    'data-id' => $offer->id,
                ]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Пагинация для перемещения по страницам -->
<?= LinkPager::widget(['pagination' => $pagination]) ?>
