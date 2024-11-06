// Устанавливаем CSRF-токен для использования в AJAX-запросах
const csrfToken = "<?= Yii::$app->request->getCsrfToken() ?>";

// Функция для обновления списка офферов без перезагрузки страницы
function refreshOffersList() {
  $.ajax({
    url: "/offer/index",
    type: "GET",
    dataType: "html",
    success: function (data) {
      $("#offers-table tbody").html(data);
    },
    error: function () {
      alert("Произошла ошибка при обновлении списка офферов");
    },
  });
}

// Обработчик для сохранения изменений в форме редактирования
$(document).on("click", "#saveChanges", function () {
  var form = $("#editModal form");

  $.ajax({
    url: form.attr("action"),
    type: "POST",
    data: form.serialize(),
    success: function (response) {
      if (response.success) {
        alert("Изменения сохранены!");
        $("#editModal").modal("hide");
        refreshOffersList(); // Обновляем список офферов после успешного сохранения
      } else {
        // Обработка ошибок валидации
        if (response.errors) {
          for (var field in response.errors) {
            response.errors[field].forEach(function (message) {
              alert(message); // Выводим каждое сообщение об ошибке
            });
          }
        } else {
          alert("Ошибка при сохранении изменений: " + response.message);
        }
      }
    },
    error: function (xhr) {
      // Обработка HTTP ошибки 409 (конфликт)
      if (xhr.status === 409) {
        var response = JSON.parse(xhr.responseText);
        if (response.errors) {
          for (var field in response.errors) {
            response.errors[field].forEach(function (message) {
              alert(message); // Выводим ошибки для полей
            });
          }
        }
      } else {
        alert("Произошла ошибка при сохранении изменений");
      }
    },
  });
});

// Обработчик для открытия формы редактирования при клике на строку оффера
$(document).on("click", ".offer-row", function (e) {
  if ($(e.target).hasClass("delete-offer")) return; // Игнорируем клик по кнопке удаления

  var offerId = $(this).data("id");

  $.ajax({
    url: "/offer/update",
    type: "GET",
    data: { id: offerId },
    success: function (data) {
      $("#editModal .modal-body").html(data);
      $("#editModal").modal("show");
    },
    error: function () {
      alert("Не удалось загрузить данные для редактирования");
    },
  });
});

// Обработчик для удаления оффера
$(document).on("click", ".delete-offer", function (e) {
  e.preventDefault();
  var url = $(this).attr("href");

  if (confirm("Вы уверены, что хотите удалить этот оффер?")) {
    $.ajax({
      url: url,
      type: "POST",
      data: { _csrf: csrfToken },
      success: function (response) {
        if (response.success) {
          alert("Оффер успешно удален!");
          refreshOffersList(); // Обновляем список после удаления
        } else {
          alert("Ошибка при удалении оффера: " + response.message);
        }
      },
      error: function () {
        alert("Произошла ошибка при удалении");
      },
    });
  }
});

// Обработчик применения фильтров
$(document).on("click", "#apply-filter", function (e) {
  e.preventDefault();

  var search = $("#search").val();

  $.ajax({
    url: "/offer/index",
    type: "GET",
    data: { search: search },
    success: function (data) {
      $("#offers-table tbody").html(data);
    },
    error: function () {
      alert("Произошла ошибка при загрузке данных");
    },
  });
});

// Обработчик сортировки столбцов таблицы
$(document).on("click", ".sort", function (e) {
  e.preventDefault();

  var $this = $(this);
  var sortField = $this.data("sort");
  var currentOrder = $this.data("order");
  var newOrder = currentOrder === "asc" ? "desc" : "asc";

  // Обновление стрелок визуально для сортировки
  $(".sort").each(function () {
    $(this).text("▲").data("order", "asc");
  });
  $this.text(newOrder === "asc" ? "▲" : "▼").data("order", newOrder);

  var search = $("#search").val();

  $.ajax({
    url: "/offer/index",
    type: "GET",
    data: { search: search, sort: sortField, order: newOrder },
    success: function (data) {
      $("#offers-table tbody").html(data);
    },
    error: function () {
      alert("Произошла ошибка при загрузке данных");
    },
  });
});

// Обработчик для отправки формы создания оффера
$(document).ready(function () {
  $("#offer-form").on("beforeSubmit", function (e) {
    e.preventDefault();
    var form = $(this);

    $.ajax({
      url: form.attr("action"),
      type: "POST",
      data: form.serialize(),
      success: function (response) {
        if (response.success) {
          alert("Оффер успешно сохранен!");
          $("#editModal").modal("hide");
          window.location.href = "/offer/index"; // Перенаправляем после успешного создания
        } else {
          form.yiiActiveForm("updateMessages", response.errors, true); // Обновление сообщений об ошибках
        }
      },
      error: function () {
        alert("Произошла ошибка при отправке данных");
      },
    });

    return false;
  });
});
