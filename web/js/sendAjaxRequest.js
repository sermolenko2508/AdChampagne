function sendAjaxRequest(url, type, data, successCallback) {
  $.ajax({
    url: url,
    type: type,
    data: data,
    statusCode: {
      200: function (response) {
        if (successCallback) successCallback(response);
      },
      409: function (xhr) {
        const response = xhr.responseText ? JSON.parse(xhr.responseText) : {};
        if (response.errors) {
          for (const field in response.errors) {
            response.errors[field].forEach(function (message) {
              alert(message);
            });
          }
        } else {
          alert(
            "Произошла ошибка: " + (response.message || "Неизвестная ошибка")
          );
        }
      },
      500: function () {
        alert("Произошла серверная ошибка. Пожалуйста, попробуйте позже.");
      },
      default: function () {
        alert("Произошла ошибка. Пожалуйста, попробуйте снова.");
      },
    },
  });
}
