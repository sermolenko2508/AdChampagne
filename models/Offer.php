<?php

namespace app\models;

use yii\db\ActiveRecord;

class Offer extends ActiveRecord
{
    public static function tableName()
    {
        return 'offers';
    }

    public function rules()
    {
        return [
            // Обязательные поля
            [['name', 'email'], 'required', 'message' => '{attribute} не может быть пустым'],
            // Валидация email
            ['email', 'email', 'message' => 'Email должен быть корректным адресом'],
            // Уникальность email
            ['email', 'unique', 'targetClass' => self::class, 'message' => 'Оффер с таким email уже существует'],
            // Валидация телефона (необязательное поле)
            ['phone', 'string', 'max' => 20],
            // Поле created_at сохраняется автоматически
            [['created_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название оффера',
            'email' => 'Email представителя',
            'phone' => 'Телефон представителя',
            'created_at' => 'Дата добавления',
        ];
    }
}


