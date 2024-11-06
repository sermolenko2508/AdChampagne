<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** 
 * Представление для страницы создания оффера.
 * 
 * @var yii\web\View $this - текущий объект представления
 * @var app\models\Offer $model - модель данных оффера
 */

// Устанавливаем заголовок страницы
$this->title = 'Создать оффер';
?>

<!-- Заголовок страницы -->
<h1><?= Html::encode($this->title) ?></h1>

<?php 
// Начало формы с настройками валидации
$form = ActiveForm::begin([
    'id' => 'offer-form', // Уникальный идентификатор формы
    'enableAjaxValidation' => false, // Отключена AJAX-валидация
    'enableClientValidation' => true, // Включена клиентская валидация
    'action' => ['offer/create'], // Путь для отправки формы
]); 
?>

<!-- Поле ввода для названия оффера с атрибутом id -->
<?= $form->field($model, 'name')->textInput(['id' => 'offer-name', 'maxlength' => true]) ?>

<!-- Поле ввода для email представителя с атрибутом id -->
<?= $form->field($model, 'email')->textInput(['id' => 'offer-email', 'maxlength' => true]) ?>

<!-- Поле ввода для телефона представителя с атрибутом id -->
<?= $form->field($model, 'phone')->textInput(['id' => 'offer-phone', 'maxlength' => true]) ?>

<!-- Кнопка отправки формы -->
<div class="form-group">
    <?= Html::submitButton('Создать', ['class' => 'btn btn-success', 'id' => 'submit-offer']) ?>
</div>

<?php ActiveForm::end(); ?>
