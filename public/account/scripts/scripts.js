document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("logout").addEventListener("click", function (e) {

    sendSimpleHttpRequest("/logout", { action: "logout" }).then(
      (responseData) => {
       window.location.reload();
      }
    );
  });
});