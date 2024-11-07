<?php
use yii\helpers\Html;

$this->title = 'Редактировать оффер: ' . $model->name;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
    'action' => ['offer/update', 'id' => $model->id],
]) ?>
