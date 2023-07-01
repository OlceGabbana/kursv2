// Отображение модального окна изменения товара
function showEditModal(dishId) {
    // Загрузка данных товара через AJAX
    $.ajax({
      url: "vendor/dishes/get_dish_data.php",
      type: "GET",
      data: { dishId: dishId },
      dataType: "json",
      success: function(response) {
        // Заполнение формы данными товара
        $("#dishId").val(response.dish.id_dish);
        $("#dishName").val(response.dish.name_dish);
        $("#dishPrice").val(response.dish.price_dish);
        $("#dishImagePath").val(response.dish.file_path_dish);
        $("#dishDescription").val(response.dish.desc_dish);
  
        // Заполнение списка категорий
        $("#dishCategory").empty();
        response.categories.forEach(function(category) {
          var option = $("<option>")
            .val(category.id_category)
            .text(category.name_category);
          $("#dishCategory").append(option);
        });
  
        // Установка выбранной категории
        $("#dishCategory").val(response.dish.id_category);
  
        // Отображение модального окна
        $("#editDishModal").css("display", "block");
      },
      error: function() {
        Swal.fire("Ошибка!", "Не удалось загрузить данные товара.", "error");
      }
    });
  }
  
  // Закрытие модального окна
  $(".close").click(function() {
    $("#editDishModal").css("display", "none");
  });
  
  // Обработка отправки формы изменения товара
  $("#editDishForm").submit(function(event) {
    event.preventDefault();
  
    // Получение данных из формы
    var dishId = $("#dishId").val();
    var dishName = $("#dishName").val();
    var dishPrice = $("#dishPrice").val();
    var dishImagePath = $("#dishImagePath").val();
    var dishDescription = $("#dishDescription").val();
    var dishCategory = $("#dishCategory").val();
  
    // Отправка данных на сервер с помощью AJAX
    $.ajax({
      url: "vendor/dishes/update_dish.php",
      type: "POST",
      data: {
        dishId: dishId,
        dishName: dishName,
        dishPrice: dishPrice,
        dishImagePath: dishImagePath,
        dishDescription: dishDescription,
        dishCategory: dishCategory
      },
      success: function() {
        Swal.fire("Успех!", "Товар успешно изменен.", "success").then(function() {
          location.reload();
        });
      },
      error: function() {
        Swal.fire("Ошибка!", "Не удалось изменить товар.", "error");
      }
    });
  });
  