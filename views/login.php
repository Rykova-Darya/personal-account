<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="" />
  <!-- <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="../index.css?<?= time(); ?>">
  <link rel="stylesheet" href="../public/login/styles/styles.css?<?= time(); ?>">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Вход</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <button class="btn"><span class="btn-name">Войти в личный кабинет</span></button>
      <div class="login hidden">
        <button id="close-login" class="close-form"></button>
        <h1>Войти</h1>
        <form id="form-login" method="POST">
          <div class="label-container">
            <label for="email-login">Email:</label>
            <input type="email" id="email-login" name="email" placeholder="Введите адрес электронной почты">
            <div id="email-login-error" class="error-message"></div>
          </div>
          <div class="label-container">
            <label for="password-login">Пароль:</label>
            <input type="password" id="password-login" name="password" placeholder="Введите пароль" autocomplete="new-password">
            <div id="password-login-error" class="error-message"></div>
          </div>
          <input type="hidden" id="action" name="action" value="send-login">
          <div class="btn-container">
            <input id="submit-login" class="btn-submit" type="submit" value="Войти">
          </div>
        </form>
        <div class="btn-container"><button class="btn-signup">Зарегистрироваться</button></div>
      </div>
      <div class="signup hidden">
        <button id="close-signup" class="close-form"></button>
        <h1 class="title">Зарегистрироваться</h1>
        <form id="form-signup" method="POST">
          <div class="label-container">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Введите адрес электронной почты">
            <div id="email-error" class="error-message"></div>
          </div>
          <div class="label-container">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" placeholder="Придумайте пароль" autocomplete="new-password">
            <div id="password-error" class="error-message"></div>
          </div>
          <div class="label-container">
            <label for="newPassword">Повторите Пароль:</label>
            <input type="password" id="newPassword" name="newPassword" placeholder="Повторите пароль" autocomplete="new-password">
            <div id="newPassword-error" class="error-message"></div>
          </div>
          <input type="hidden" id="action-signup" name="action" value="signup">
          <div class="btn-container">
            <input id="btn-submit" class="btn-submit" type="submit" value="Зарегистрироваться">
          </div>
        </form>
        <div class="btn-container"><button class="btn-login">Войти</button></div>
      </div>
    </div>
  </div>

  <script src="../index.js?<?= time() ?>"></script>
  <script src="../public/login/scripts/script.js?<?= time() ?>"></script>
  <!-- <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>