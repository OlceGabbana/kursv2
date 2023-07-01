$(document).ready(function () {
  $("#addCategoryButton").click(function () {
    // Отображаем модальное окно
    Swal.fire({
      title: "Добавить категорию",
      html: $("#addCategoryModal").html(),
      showCancelButton: true,
      confirmButtonText: "Добавить",
      cancelButtonText: "Отмена",
      preConfirm: () => {
        // Получаем значение из поля ввода
        const categoryName =
          Swal.getPopup().querySelector("#categoryName").value;

        // Отправляем запрос на сервер с помощью AJAX
        return $.ajax({
          url: "vendor/categories/add_category.php",
          type: "POST",
          data: {
            categoryName: categoryName,
          },
        });
      },
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire("Успех!", "Категория успешно добавлена.", "success").then(function() {
          location.reload();
        });
      }
    });
  });
});
$(document).ready(function () {
  $("#editCategoryButton").click(function () {
    // Показываем модальное окно только после загрузки категорий
    loadCategories(function () {
      openModal();
    });
  });

  // Загрузка списка категорий через AJAX
  function loadCategories(callback) {
    $.ajax({
      url: "vendor/categories/load_categories.php",
      type: "GET",
      dataType: "json",
      success: function (response) {
        // Очистка списка категорий
        $("#categorySelect").empty();

        // Добавление опций для выбора категории
        response.categories.forEach(function (category) {
          var option = $("<option>")
            .val(category.id_category)
            .text(category.name_category);
          $("#categorySelect").append(option);
        });

        // Вызываем колбэк после загрузки категорий
        if (typeof callback === "function") {
          callback();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText); // Выводим ошибку в консоль
        Swal.fire("Ошибка!", "Не удалось загрузить категории.", "error");
      },
    });
  }

  // Открытие модального окна
  function openModal() {
    // Отображаем модальное окно
    Swal.fire({
      title: "Изменить категорию",
      html: $("#editCategoryModal").html(),
      showCancelButton: true,
      confirmButtonText: "Изменить",
      cancelButtonText: "Отмена",
      preConfirm: function () {
        // Получаем значения из полей ввода
        var selectedCategory =
          Swal.getPopup().querySelector("#categorySelect").value;
        var newCategoryName =
          Swal.getPopup().querySelector("#newCategoryName").value;

        // Отправляем запрос на сервер с помощью AJAX
        return $.ajax({
          url: "vendor/categories/edit_category.php",
          type: "POST",
          data: {
            selectedCategory: selectedCategory,
            newCategoryName: newCategoryName,
          },
        });
      },
    }).then(function (result) {
      if (result.isConfirmed) {
        Swal.fire("Успех!", "Категория успешно изменена.", "success").then(function() {
          location.reload();
        });
      }
    });
  }
});
$(document).ready(function () {
  $("#deleteCategoryButton").click(function() {
    // Загрузка списка категорий через AJAX
    loadCategories(function(categories) {
      // Отображение модального окна после успешной загрузки категорий
      openModal(categories);
    });
  });

  // Загрузка списка категорий через AJAX
  function loadCategories(callback) {
    $.ajax({
      url: 'vendor/categories/load_categories.php',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (typeof callback === 'function') {
          callback(response.categories);
        }
      },
      error: function() {
        Swal.fire('Ошибка!', 'Не удалось загрузить категории.', 'error');
      }
    });
  }

  // Открытие модального окна
  function openModal(categories) {
    // Отображаем модальное окно
    Swal.fire({
      title: 'Удалить категорию',
      html: buildModalContent(categories),
      showCancelButton: true,
      confirmButtonText: 'Удалить',
      cancelButtonText: 'Отмена',
      preConfirm: function() {
        // Получаем выбранное значение категории
        var selectedCategory = Swal.getPopup().querySelector('#categorySelect').value;

        // Отправляем запрос на сервер с помощью AJAX
        return $.ajax({
          url: 'vendor/categories/delete_category.php',
          type: 'POST',
          data: {
            selectedCategory: selectedCategory
          }
        });
      }
    }).then(function(result) {
      if (result.isConfirmed) {
        Swal.fire('Успех!', 'Категория успешно удалена.', 'success').then(function() {
          location.reload();
        });
      }
    });
  }

  // Формирование HTML-кода модального окна
  function buildModalContent(categories) {
    var selectHtml = '<select id="categorySelect">';
    categories.forEach(function(category) {
      selectHtml += '<option value="' + category.id_category + '">' + category.name_category + '</option>';
    });
    selectHtml += '</select>';

    return selectHtml;
  }
});
