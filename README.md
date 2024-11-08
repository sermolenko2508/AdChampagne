# CRM-панель для управления офферами

## Описание проекта

CRM-панель для управления офферами создана для учета клиентов, подающих заявки в рамках маркетинговых кампаний. Данное мини-приложение позволяет создавать, редактировать, удалять и просматривать записи об офферах.

## Функциональные требования

### 1. CRUD-операции над офферами

- Оффер должен иметь следующие поля:
  - **ID** (генерируется автоматически)
  - **Название оффера** (обязательное поле)
  - **Email представителя** (обязательное и уникальное поле, проверка формата)
  - **Телефон представителя** (необязательно)
  - **Дата добавления** (сохраняется автоматически)

### 2. Список офферов

- Отображение на главной странице списка офферов с сортировкой по **ID** и **названию оффера**.
- Фильтрация по **названию оффера** и **email представителя** с использованием **jQuery (AJAX-запросы)**.
- Пагинация по 10 записей на страницу.

### 3. Редактирование и удаление

- Открытие формы редактирования при клике на оффер для изменения данных.
- Подтверждение удаления перед удалением записи.

### 4. Валидация и уведомления

- Серверные и клиентские проверки обязательных полей при создании и редактировании оффера.
- Отображение сообщений об ошибках при валидации.
- Уведомление пользователя о результатах операций с помощью **jQuery**.

## Технические требования

### Backend

- Реализовано на **PHP 7** с использованием **Yii 2** (архитектура MVC).
- Подключение к базе данных **MySQL**.

### Frontend

- Использование **HTML5** и **CSS3**.
- **jQuery** для реализации AJAX-запросов для фильтрации, создания, редактирования и удаления офферов без перезагрузки страницы.

### База данных

- Таблица **offers** должна содержать поля:

  - **id** (int, PK, auto-increment)
  - **name** (varchar)
  - **email** (varchar, unique)
  - **phone** (varchar)
  - **created_at** (timestamp)

- SQL-скрипт для создания таблицы и заполнения её тестовыми записями:

```sql
CREATE TABLE offers (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `phone` VARCHAR(20),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO offers (`name`, `email`, `phone`) VALUES
('Оффер 1', 'offer1@example.com', '1234567890'),
('Оффер 2', 'offer2@example.com', '0987654321'),
('Оффер 3', 'offer3@example.com', '1122334455'),
('Оффер 4', 'offer4@example.com', '2233445566'),
('Оффер 5', 'offer5@example.com', '3344556677'),
('Оффер 6', 'offer6@example.com', '4455667788'),
('Оффер 7', 'offer7@example.com', '5566778899'),
('Оффер 8', 'offer8@example.com', '6677889900'),
('Оффер 9', 'offer9@example.com', '7788990011'),
('Оффер 10', 'offer10@example.com', '8899001122'),
('Оффер 11', 'offer11@example.com', '9900112233'),
('Оффер 12', 'offer12@example.com', '0011223344'),
('Оффер 13', 'offer13@example.com', '1122334455'),
('Оффер 14', 'offer14@example.com', '2233445566'),
('Оффер 15', 'offer15@example.com', '3344556677');
```

## Инструкция по запуску проекта локально

1. **Клонирование репозитория**:

   ```bash
   https://github.com/sermolenko2508/AdChampagne.git
   cd offer-manager
   ```

2. **Установка зависимостей**:

   ```bash
   composer install
   ```

3. **Настройка базы данных**:

   - Отредактируйте файл `config/db.php`, указав ваши параметры подключения к базе данных.

4. **Заполнение тестовыми данными**:
   Выполните SQL-скрипт (см. выше) через ваш инструмент управления базой данных (например, **phpMyAdmin** или **MySQL Workbench**).

5. **Запуск встроенного сервера PHP**:

   ```bash
   php yii serve
   ```

   Приложение будет доступно по адресу: [http://localhost:8080](http://localhost:8080)

## Описание архитектурных решений

- Приложение разработано с использованием архитектуры MVC, обеспечивающей разделение логики представления, обработки и данных.
- Используются AJAX-запросы для реализации динамической работы без перезагрузки страницы.
- Для уведомления пользователя используются стандартные методы **jQuery** и встроенные механизмы **Yii 2** для валидации и отображения ошибок.

## Используемые технологии

- **PHP 7**, **Yii 2** (Framework)
- **MySQL** (База данных)
- **HTML5**, **CSS3**, **jQuery** (Frontend)
