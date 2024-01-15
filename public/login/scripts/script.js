document.addEventListener("DOMContentLoaded", function () {
  let btn = document.querySelector(".btn");
  let formLogin = document.querySelector(".login");
  let closeLogin = document.querySelector("#close-login");
  let closeSignup = document.querySelector("#close-signup");
  let btnSignup = document.querySelector(".btn-signup");
  let btnLogin = document.querySelector(".btn-login");
  let formSignup = document.querySelector(".signup");

  btn.addEventListener("click", function (e) {
    btn.classList.add("hidden");
    formLogin.classList.remove("hidden");
  });
  handleFormClose(closeLogin, formLogin, btn);
  handleFormClose(closeSignup, formSignup, btn);

  handleSwitchForm(btnSignup, formLogin, formSignup);
  handleSwitchForm(btnLogin, formSignup, formLogin);

  //Валидация формы регистрации
  document.getElementById("email").addEventListener("input", clearErrorOnInput);
  document
    .getElementById("password")
    .addEventListener("input", clearErrorOnInput);
  document
    .getElementById("newPassword")
    .addEventListener("input", clearErrorOnInput);

  document
    .getElementById("btn-submit")
    .addEventListener("click", function (event) {
      console.log("fgjkhkjhk");
      clearError("email-error");
      clearError("password-error");
      clearError("newPassword-error");

      let emailInput = document.getElementById("email");
      let passwordInput = document.getElementById("password");
      let newPasswordInput = document.getElementById("newPassword");

      let email = emailInput.value;
      let password = passwordInput.value;
      let newPassword = newPasswordInput.value;

      if (!isValidEmail(email)) {
        displayError("email-error", "Неверный формат email");
        addErrorClass(emailInput);
        event.preventDefault();
      } else {
        removeErrorClass(emailInput);
      }

      if (password.length < 6) {
        displayError(
          "password-error",
          "Пароль должен содержать минимум 6 символов"
        );
        addErrorClass(passwordInput);
        event.preventDefault();
      } else {
        removeErrorClass(passwordInput);
      }

      if (newPassword !== password) {
        displayError("newPassword-error", "Пароли не совпадают");
        addErrorClass(newPasswordInput);
        event.preventDefault();
      } else {
        removeErrorClass(newPasswordInput);
      }
    });

  //Валидация формы входа
  document
    .getElementById("email-login")
    .addEventListener("input", clearErrorOnInput);
  document
    .getElementById("password-login")
    .addEventListener("input", clearErrorOnInput);

  document
    .getElementById("submit-login")
    .addEventListener("click", function (event) {
      clearError("email-login-error");
      clearError("password-login-error");
      clearError("newPassword-login-error");

      let emailInput = document.getElementById("email-login");
      let passwordInput = document.getElementById("password-login");
      let email = emailInput.value;
      let password = passwordInput.value;

      if (!isValidEmail(email)) {
        displayError("email-login-error", "Неверный формат email");
        addErrorClass(emailInput);
        event.preventDefault();
      } else {
        removeErrorClass(emailInput);
      }

      if (password.length < 6) {
        displayError(
          "password-login-error",
          "Пароль должен содержать минимум 6 символов"
        );
        addErrorClass(passwordInput);
        event.preventDefault();
      } else {
        removeErrorClass(passwordInput);
      }
    });

    sendFormData("form-login", "/send-login", function (data) {
      console.log(data);
      if (data === 'enrolles-list') {
        window.location.href = "/enrolles-list";
      } else {
        window.location.href = "/info";
      } ;
    });
    sendFormData("form-signup", "/signup", function (data) {
      if (data === true) {
        let form = document.getElementById("form-signup");
        console.log(form.parentNode);
        form.classList.add("hidden");
        document.querySelector(".title").innerText = "Вы зарегистрированы!";
        // console.log(form);
        console.log('')
      }
    });
   

});

function handleFormClose(closeForm, form, btn) {
  closeForm.addEventListener("click", function (e) {
    form.classList.add("hidden");
    btn.classList.remove("hidden");
  });
}

function handleSwitchForm(btn, firstForm, secondForm) {
  btn.addEventListener("click", function (e) {
    firstForm.classList.add("hidden");
    secondForm.classList.remove("hidden");
  });
}

//Функции валидации формы
function isValidEmail(email) {
  let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function sendFormData(form_id, url, callback) {
  document
    .getElementById(form_id)
    .addEventListener("submit", async function (e) {
      e.preventDefault();
      let formData = new FormData(this);
      console.log({ dataSENDFORM: formData });
      try {
        let data = await sendHttpRequest(url, formData);
        console.log({ data: data });

        if (callback && typeof callback === "function") {
          callback(data);
        }
      } catch (error) {
        console.error(error);
      }
    });
}

