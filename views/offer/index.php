<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Список офферов';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('modal') ?>

<div class="row mb-3">
    <div class="col-md-8">
        <?= Html::textInput('search', '', [
            'id' => 'search',
            'class' => 'form-control',
            'placeholder' => 'Поиск по названию оффера или email представителя'
        ]) ?>
    </div>
    <div class="col-md-4 d-flex justify-content-between">
        <?= Html::button('Поиск', [
            'id' => 'apply-filter',
            'class' => 'btn btn-primary me-2'
        ]) ?>
        <?= Html::button('Создать оффер', [
        'id' => 'create-offer',
        'class' => 'btn btn-success'
        ]) ?>
    </div>
</div>

<table class="table table-bordered" id="offers-table">
    <thead>
        <tr>
            <th>ID <a href="#" class="sort" data-sort="id" data-order="asc">▲</a></th>
            <th>Название <a href="#" class="sort" data-sort="name" data-order="asc">▲</a></th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Дата добавления</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($offers as $offer): ?>
        <tr class="offer-row" data-id="<?= $offer->id ?>">
            <td><?= Html::encode($offer->id) ?></td>
            <td><?= Html::encode($offer->name) ?></td>
            <td><?= Html::encode($offer->email) ?></td>
            <td><?= Html::encode($offer->phone) ?></td>
            <td><?= Html::encode($offer->created_at) ?></td>
            <td>
                <?= Html::a('Удалить', ['delete', 'id' => $offer->id], [
                    'class' => 'btn btn-danger delete-offer',
                    'data-id' => $offer->id,
                ]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
