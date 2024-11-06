<?php
use yii\helpers\Html;

/**
 * Частичный шаблон для отображения строки таблицы с офферами.
 * Ожидается, что переменная $offers будет передана из контроллера и содержать массив объектов офферов.
 */
?>

<?php foreach ($offers as $offer): ?>
    <tr class="offer-row" data-id="<?= $offer->id ?>">
        <!-- Отображение ID оффера -->
        <td><?= Html::encode($offer->id) ?></td>
        
        <!-- Отображение названия оффера -->
        <td><?= Html::encode($offer->name) ?></td>
        
        <!-- Отображение email представителя -->
        <td><?= Html::encode($offer->email) ?></td>
        
        <!-- Отображение телефона представителя -->
        <td><?= Html::encode($offer->phone) ?></td>
        
        <!-- Отображение даты создания оффера -->
        <td><?= Html::encode($offer->created_at) ?></td>
        
        <!-- Кнопка удаления оффера -->
        <td>
            <?= Html::a('Удалить', ['delete', 'id' => $offer->id], [
                'class' => 'btn btn-danger delete-offer',
                'data-id' => $offer->id,
            ]) ?>
        </td>
    </tr>
<?php endforeach; ?>
