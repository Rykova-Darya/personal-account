document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("logout").addEventListener("click", function (e) {
    // Пример использования:

    sendSimpleHttpRequest("/logout", { action: "logout" }).then(
      (responseData) => {
       window.location.reload();
      }
    );
  });
});