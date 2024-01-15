<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../index.css?<?= time(); ?>">
  <link rel="stylesheet" href="../public/account/styles/styles.css?<?= time(); ?>">
  <title>Личный кабинет</title>
</head>

<body>
  <div class="container info-block">
    <button id="logout" class="btn-logout">Выйти</button>
    <div class="row info info-account">
      <h1 class="title">Здравсвуйте, <?= $this->user_data['surname']; ?> <?= $this->user_data['name']; ?> <?= ($this->user_data['patronymic'] !== null) ? $this->user_data['patronymic'] : ''; ?>!</h1>
      <h3 class="tb-title">Ваши данные:</h3>
      <table>
        <tbody>
          <tr>
            <td>День рождения:</td>
            <td><?= $this->user_data['birthday2']; ?></td>
          </tr>
          <tr>
            <td>Уровень образования:</td>
            <td><?= $this->user_data['ed_name']; ?></td>
          </tr>
          <tr>
            <td>Электронная почта:</td>
            <td><?= $this->user_data['login']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>

  <script src="../index.js?<?= time() ?>"></script>
  <script src="../public/account/scripts/scripts.js"></script>
</body>

</html>