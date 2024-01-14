<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../index.css?<?= time(); ?>">
  <link rel="stylesheet" href="../public/info/styles/styles.css?<?= time(); ?>">
  <title>Анкета</title>
</head>

<body>
  <div class="container info-block">
    <button id="logout" class="btn-logout">Выйти</button>
    <div class="row info">
      <h1>Анкета</h1>
      <form id="form-signup" method="POST" action="/send_questionnaire" enctype="multipart/form-data">
        <div class="label-container">
          <label for="surname">Фамилия *</label>
          <input type="text" id="surname" name="surname" placeholder="Введите свою фамилию" required>
          <div id="surname-error" class="error-message"></div>
        </div>
        <div class="label-container">
          <label for="name">Имя *</label>
          <input type="text" id="name" name="name" placeholder="Введите свою фамилию" required>
          <div id="name-error" class="error-message"></div>
        </div>
        <div class="label-container">
          <label for="patronymic">Отчетсво:</label>
          <input type="text" id="patronymic" name="patronymic" placeholder="При наличии введите отчество">
          <div id="patronymic-error" class="error-message"></div>
        </div>
        <div class="label-container">
          <label for="patronymic">Дата рождения *</label>
          <input type="вфеу" id="birthday" name="birthday" placeholder="Укажите дату рождения" required>
          <div id="birthday-error" class="error-message"></div>
        </div>
        <p class="label-gender">Пол *</p>
        <div class="label-container gender">
          <label for="male">Мужской</label>
          <input type="radio" id="male" name="gender" value="1" required>

          <label for="female">Женский</label>
          <input type="radio" id="female" name="gender" value="2" required>
          <div id="gender-error" class="error-message"></div>
        </div>
        <div class="label-container">
          <label for="type-education">Укажите уровень образования *</label>
          <select id="type-education" name="education" required>
            <?php foreach ($this->educational_degrees as $degree) : ?>
              <?php var_dump($degree); ?>
              <option value="<?= $degree['id']; ?>"><?= $degree['type']; ?></option>
            <?php endforeach; ?>
          </select>
          <div id="gender-error" class="error-message"></div>
        </div>
        <div class="label-container">
          <label for="fileInput" class=" file-upload-button">Загрузите документ об образовании *</label>
          <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
          <input type="file" id="fileInput" name="file_path" accept=".jpeg, .jpg, .pdf" class="file-upload-input " required>
          <div id="fileInput-error" class="error-message"></div>
        </div>
        <input type="hidden" id="" name="action" value="send_questionnaire">
        <input type="hidden" id="" name="token" value="<?= $this->csrf_token ?>">
        <div class="btn-container">
          <input id="btn-submit" class="btn-submit" type="submit" value="Отправить">
        </div>
      </form>
    </div>

  </div>

  <script src="../index.js?<?= time() ?>"></script>
  <!-- <script src="../public/info/scripts/script.js?<?= time() ?>"></script> -->
  <script src="../public/info/scripts/scripts.js"></script>
</body>

</html>