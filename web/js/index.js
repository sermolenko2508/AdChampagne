// Устанавливаем CSRF-токен для использования в AJAX-запросах
const csrfToken = "<?= Yii::$app->request->getCsrfToken() ?>";

// Функция для обновления списка офферов без перезагрузки страницы
function refreshOffersList() {
  sendAjaxRequest("/offer/index", "GET", {}, function (data) {
    $("#offers-table tbody").html(data);
  });
}

$(document).on("click", "#saveChanges", function (e) {
  e.preventDefault();
  const form = $("#editModal form");
  let isValid = true;
  let errorMessage = "";

  form
    .find("input[required], textarea[required], select[required]")
    .each(function () {
      if (!$(this).val().trim()) {
        isValid = false;
        errorMessage += `Поле "${
          $(this).attr("placeholder") || $(this).attr("name")
        }" обязательно для заполнения.\n`;
        $(this).addClass("is-invalid");
      } else {
        $(this).removeClass("is-invalid");
      }
    });

  if (!isValid) {
    alert(errorMessage);
    return;
  }

  sendAjaxRequest(
    form.attr("action"),
    "POST",
    form.serialize(),
    function (response) {
      if (response.success) {
        $("#editModal").modal("hide");
        refreshOffersList();
      } else {
        alert("Произошла ошибка при сохранении изменений.");
      }
    }
  );
});

// Обработчик для открытия формы создания оффера
$(document).on("click", "#create-offer", function () {
  sendAjaxRequest("/offer/create", "GET", {}, function (data) {
    $("#editModal .modal-body").html(data);
    $("#editModalLabel").text("Создать оффер");
    $("#editModal").modal("show");
  });
});

// Обработчик для открытия формы редактирования при клике на строку оффера
$(document).on("click", ".offer-row", function (e) {
  if ($(e.target).hasClass("delete-offer")) return;

  const offerId = $(this).data("id");

  sendAjaxRequest("/offer/update", "GET", { id: offerId }, function (data) {
    $("#editModal .modal-body").html(data);
    $("#editModalLabel").text("Редактировать оффер");
    $("#editModal").modal("show");
  });
});

// Обработчик для удаления оффера
$(document).on("click", ".delete-offer", function (e) {
  e.preventDefault();
  const url = $(this).attr("href");

  if (confirm("Вы уверены, что хотите удалить этот оффер?")) {
    sendAjaxRequest(url, "POST", { _csrf: csrfToken }, function (response) {
      if (response.success) {
        refreshOffersList();
      }
    });
  }
});

// Обработчик применения фильтров
$(document).on("click", "#apply-filter", function (e) {
  e.preventDefault();

  const search = $("#search").val();
  sendAjaxRequest("/offer/index", "GET", { search: search }, function (data) {
    $("#offers-table tbody").html(data);
  });
});

// Обработчик сортировки столбцов таблицы
$(document).on("click", ".sort", function (e) {
  e.preventDefault();

  const $this = $(this);
  const sortField = $this.data("sort");
  const currentOrder = $this.data("order");
  const newOrder = currentOrder === "asc" ? "desc" : "asc";

  $(".sort").each(function () {
    $(this).text("▲").data("order", "asc");
  });
  $this.text(newOrder === "asc" ? "▲" : "▼").data("order", newOrder);

  const search = $("#search").val();
  sendAjaxRequest(
    "/offer/index",
    "GET",
    { search: search, sort: sortField, order: newOrder },
    function (data) {
      $("#offers-table tbody").html(data);
    }
  );
});

// Обработчик отправки формы создания оффера
$(document).ready(function () {
  $("#offer-form").on("beforeSubmit", function (e) {
    e.preventDefault();
    const form = $(this);

    if (!form.find(".has-error").length) {
      sendAjaxRequest(
        form.attr("action"),
        "POST",
        form.serialize(),
        function () {
          $("#editModal").modal("hide");
          window.location.href = "/offer/index";
        }
      );
    }

    return false;
  });
});
