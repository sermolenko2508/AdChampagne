<?php
use yii\helpers\Html;

?>

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
