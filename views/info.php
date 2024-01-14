<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../index.css?<?= time(); ?>">
  <link rel="stylesheet" href="../public/info/styles/styles.css?<?= time(); ?>">
  <title>Личный кабинет</title>
</head>

<body>
  <div class="container info-block">
    <button id="logout" class="btn-logout">Выйти</button>
    <div class="row">
      <h1>Анкета</h1>
      <form id="form-signup" method="POST">
        <div class="label-container">
          <label htmlFor="surname">Фамилия:</label>
          <input type="text" id="surname" name="surname" placeholder="Введите свою фамилию">
          <div id="email-error" class="error-message"></div>
        </div>
        <input type="hidden" id="" name="action" value="signup">
        <div class="btn-container">
          <input id="btn-submit" class="btn-submit" type="submit" value="Зарегистрироваться">
        </div>
      </form>
    </div>

  </div>

  <script src="../index.js?<?= time() ?>"></script>
  <!-- <script src="../public/info/scripts/script.js?<?= time() ?>"></script> -->
  <script src="../public/info/scripts/scripts.js"></script>
</body>

</html>