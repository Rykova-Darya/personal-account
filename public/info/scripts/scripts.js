document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("logout").addEventListener("click", function (e) {
    // Пример использования:

    sendSimpleHttpRequest("/logout", { action: "logout" }).then(
      (responseData) => {
       window.location.reload();
      }
    );
  });

  //Валидация формы
  //TODO необходимо реализовать валидацию для полей пол, образование и загрузка документа
      const addInputListener = (id, errorId) => {
        const inputElement = document.getElementById(id);
        inputElement.addEventListener("input", clearErrorOnInput);

        return inputElement;
      };

      const validateInput = (input, errorId, errorMsg) => {
        clearError(errorId);

        if (input.value.length <= 0) {
          displayError(errorId, errorMsg);
          addErrorClass(input);
          return false;
        }

        removeErrorClass(input);
        return true;
      };

      const surnameInput = addInputListener("surname", "surname-error");
      const nameInput = addInputListener("name", "name-error");
      const birthdayInput = addInputListener("birthday", "birthday-error");

      document
        .getElementById("btn-submit")
        .addEventListener("click", function (event) {
          const isSurnameValid = validateInput(
            surnameInput,
            "surname-error",
            "Поле не должно быть пустым"
          );
          const isNameValid = validateInput(
            nameInput,
            "name-error",
            "Поле не должно быть пустым"
          );
          const isBirthdayValid = validateInput(
            birthdayInput,
            "birthday-error",
            "Укажите дату рождения"
          );;

          if (!isSurnameValid || !isNameValid || !isBirthdayValid) {
            event.preventDefault();
          }
        });

        document.querySelector('.file-upload-input').addEventListener('change', () => {
          document.querySelector(".file-upload-button").innerText = "Файл успешно загружен";
        });
});
