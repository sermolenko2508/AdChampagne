<?php
use yii\widgets\ActiveForm;

/** 
 * Форма для создания и редактирования оффера.
 * 
 * @var yii\widgets\ActiveForm $form - объект формы
 * @var app\models\Offer $model - модель данных оффера
 */

// Начало формы с настройкой на поддержку валидации на стороне клиента и через AJAX.
$form = ActiveForm::begin([
    'id' => 'offer-form', // Уникальный идентификатор формы
    'enableAjaxValidation' => true, // Включена валидация через AJAX
    'enableClientValidation' => true, // Включена клиентская валидация
]); 

// Поле для ввода названия оффера с меткой, включающей обязательность (знак '*').
echo $form->field($model, 'name')
    ->textInput(['maxlength' => true]) // Ограничение на максимальную длину ввода
    ->label('Название оффера <span style="color: red">*</span>', ['encode' => false]); // Метка с HTML для обязательности

// Поле для ввода email представителя с аналогичной настройкой обязательности.
echo $form->field($model, 'email')
    ->textInput(['maxlength' => true])
    ->label('Email представителя <span style="color: red">*</span>', ['encode' => false]);

// Поле для ввода телефона представителя. Это поле не обязательно, поэтому нет красной звезды.
echo $form->field($model, 'phone')
    ->textInput(['maxlength' => true])
    ->label('Телефон представителя');

ActiveForm::end();
?>
