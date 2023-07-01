var bucket;
AllSum("allsum1");

//Добавление продукта
function addProduct(numb) {
  if (localStorage.length < 16) {
    let n = localStorage.getItem(numb);
    if (n !== null) {
      localStorage.setItem(numb, parseInt(n) + 1);
    } else if (n == null) {
      localStorage.setItem(numb, 1);
    }
    AllSum("allsum1");
    showCart("modal_content_table");
  } else {
    alert("Место в корзине закончилось.");
  }
}

//Удаление продукта
function delProduct(numb) {
  let n = localStorage.getItem(numb);
  if (n == null) {
    console.log("Такого товара в корзине нет");
  } else if (n !== null) {
    localStorage.setItem(numb, parseInt(n) - 1);
    n = localStorage.getItem(numb);
    if (n == 0) {
      if (confirm("Убрать товар из корзины?")) {
        localStorage.removeItem(numb);
      } else {
        localStorage.setItem(numb, 1);
      }
    }
    AllSum("allsum1");
    showCart("modal_content_table");
  }
}

//сортировка localstorage
function SortLS() {
  var localStorageArray = new Array();
  var ls_length = localStorage.length;
  for (i = 0; i < ls_length; i++) {
    localStorageArray[i] = [
      localStorage.key(i),
      localStorage.getItem(localStorage.key(i)),
    ];
  }
  localStorageArray.sort();
  localStorage.clear();
  for (i = 0; i < ls_length; i++) {
    localStorage.setItem(localStorageArray[i][0], localStorageArray[i][1]);
  }
}

//Вывод выбраных товаров
function showCart(id) {
  let cartInfo = "";
  if (localStorage.length !== 0)
    document.getElementById("delBuscket").innerHTML = '<button class="delBuscket" onclick="clearBasket()">Очистить корзину</button>';
  else {
    cartInfo = `<tr><td>В корзине пока ничего нет!</td></tr>`;
    // document.getElementById('checkout_button').
  }

  const name_dish = document.querySelectorAll(".name_dish");
  const price_dish = document.querySelectorAll(".price_dish");
  for (let i = 0; i < localStorage.length; i++) {
    for (let id_res = 0; id_res < name_dish.length; id_res++) {
      let price_dish_info = price_dish[id_res].textContent;

      price_dish_info = price_dish_info.slice(0, -2);

      if (localStorage.key(i) == id_res) {
        cartInfo +=
          `<tr> 
                        <td>` +
          name_dish[id_res].textContent +
          `</td>
                        <td>` +
          parseFloat(price_dish_info * localStorage.getItem(id_res)).toFixed(
            2
          ) +
          `</td>
                        <td>` +
          localStorage.getItem(id_res) +
          `</td>
                        <td>
                            <button value="1" onclick="addProduct(${id_res})" class="bucket_button">+</button>
                            <button value="1" onclick="delProduct(${id_res})" class="bucket_button">-</button>
                        </td>
                    </tr>`;
      }
    }
  }

  document.getElementById(id).innerHTML = cartInfo;

  allPrice("total-price");
}

//Очистка корзины
function clearBasket() {
  if (localStorage.length == 0) {
    alert("Корзина уже пустая");
  } else if (confirm("Вы уверены, что хотите очистить корзину?")) {
    let lengthStorage = localStorage.length;
    for (let i = 0; i < lengthStorage; i++) {
      let n = localStorage.key(0);
      localStorage.removeItem(n);
    }
    alert("Корзина очищена");
  }
  showCart("modal_content_table");
  AllSum("allsum1");
}

//Расчет итоговой стоимости
function allPrice(id) {
  let Price = 0;
  const price_dish = document.querySelectorAll(".price_dish");

  for (let i = 0; i < localStorage.length; i++) {
    let key = localStorage.key(i);
    if (price_dish[key]) {
      let price_dish_info = price_dish[key].textContent;
      Price +=
        parseFloat(price_dish_info) * parseInt(localStorage.getItem(key));
    }
  }

  document.getElementById(id).value = Price.toFixed(2);
}

//Расчет количества товаров в корзине
function AllSum(id) {
  var allsum = 0;
  for (let i = 0; i < localStorage.length; i++) {
    let key = localStorage.key(i);
    allsum += parseInt(localStorage.getItem(key));
  }
  document.getElementById(id).innerHTML = allsum;
  SortLS();
}

//Открытие модального окна
function OpenModalBtn(btn) {
  showCart("modal_content_table");
  var modal = document.getElementById("modal");
  var openModalBtn = document.getElementById(btn);
  var closeModalBtn = document.getElementsByClassName("close")[0];
  var cartItems = 0;

  // Открыть модальное окно при клике на кнопку "Открыть корзину"
  openModalBtn.addEventListener("click", function () {
    modal.style.display = "block";
  });

  // Закрыть модальное окно при клике на кнопку "Закрыть" или за пределами модального окна
  closeModalBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  window.addEventListener("click", function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });
}

function coalert() {
  Swal.fire({
    title: "Ваш заказ принят в обработку!",
    text: "Скоро мы с вами свяжемся!",
    icon: "success",
  }).then((result) => {
    if (result.isConfirmed) {
      let lengthStorage = localStorage.length;
      for (let i = 0; i < lengthStorage; i++) {
        let n = localStorage.key(0);
        localStorage.removeItem(n);
      }
      AllSum("allsum1");
      var modal = document.getElementById("modal");
      modal.style.display = "none";
    }
  });
}

function close_modal(id) {
  document.getElementById(id).style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function open_modal(id) {
  document.getElementById(id).style.display = "block";
  document.getElementById("overlay").style.display = "block";
}

OpenModalBtn('openModalBtn_order');


//запись в базу
function addDB() {
  var myArray = localStorage;
  var xhr = new XMLHttpRequest();
  var url = 'myfile.php';
  xhr.open('POST', url, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
  if (xhr.readyState === 4 && xhr.status === 200) {
      console.log(xhr.responseText); // Обработка ответа от сервера
  }
  };

  var params = 'myArray=' + encodeURIComponent(JSON.stringify(myArray));
  xhr.send(params);
  
}