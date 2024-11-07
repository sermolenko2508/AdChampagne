<?php
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'offer-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
]); 

echo $form->field($model, 'name')
    ->textInput(['maxlength' => true, 'required' => true])
    ->label('Название оффера <span style="color: red">*</span>', ['encode' => false]);

echo $form->field($model, 'email')
    ->textInput(['maxlength' => true, 'required' => true])
    ->label('Email представителя <span style="color: red">*</span>', ['encode' => false]);

echo $form->field($model, 'phone')
    ->textInput(['maxlength' => true])
    ->label('Телефон представителя');

ActiveForm::end();
?>
