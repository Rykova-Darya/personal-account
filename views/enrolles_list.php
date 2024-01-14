<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../index.css?<?= time(); ?>">
  <link rel="stylesheet" href="../public/enrollees-list/styles/styles.css?<?= time(); ?>">
  <title>Список абитуриентов</title>
</head>

<body>
  <div class="container info-block">
    <button id="logout" class="btn-logout">Выйти</button>
    <div class="row info info-list">
      <h1 class="title">Список абитуриентов</h1>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>ФИО</th>
              <th>Email</th>
              <th>Дата рождения</th>
              <th>Уровень образования</th>
              <th>Документ об образовании</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($this->enrollees_list as $enrollee) : ?>
              <?php $file_path =$enrollee['file_path'] ?>
              <tr>
                <td><?= $enrollee['fio']; ?></td>
                <td><?= $enrollee['login']; ?></td>
                <td><?= $enrollee['birthday']; ?></td>
                <td><?= $enrollee['type']; ?></td>
                <td class="doc"><button class="download_file" onclick="downloadFile('<?= $file_path; ?>')"></button></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <script src="../index.js?<?= time() ?>"></script>
  <!-- <script src="../public/info/scripts/script.js?<?= time() ?>"></script> -->
  <script src="../public/account/scripts/scripts.js"></script>
</body>

</html>