<?php

namespace App\DB;

class DB
{
  private $pdo;
  private $host = '172.17.0.2';
  private $bdname = 'personal-account';
  private $user = 'postgres';
  private $pass = '12344321';
  private $user_id;

  public function __construct()
  {
    try {
      $this->pdo = new \PDO("pgsql:host=" . $this->host . ";dbname=" . $this->bdname . ";user=" . $this->user . ";password=" . $this->pass);
      $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      die($e->getMessage());
    }

    if (isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
    }
  }

  public function getUser($login)
  {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM t_user WHERE login = :login");
      
      $stmt->bindParam(':login', $login);
      $stmt->execute();
      $result = $stmt->fetch();
      error_log(json_encode($result));
      return $result;
    } catch (\PDOException $e) {
      die('Ошибка запроса: ' . $e->getMessage());
    }
  }

  public function enrollee_registration($email, $pass) {
    $stmt = $this->pdo->prepare("INSERT INTO t_user (login, password) VALUES (:email, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pass);
    //TODO Здесь нужно добавить проверку на наличие уже такого email в базе. Если он есть возвращать фолз и выводить ошибку
    if ($stmt->execute()) {
      if ($stmt->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function check_user($login, $password) {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM t_user WHERE login = :login");
      $stmt->bindParam(':login', $login);
      $stmt->execute();
      $result = $stmt->fetch();
      error_log(json_encode($result));
      if ($result) {
        if (password_verify($password, $result['password'])) {
          return $result;
        } else {
          return false;
        }
      } else {
        return false;
      }

    } catch (\PDOException $e) {
      die('Ошибка запроса: ' . $e->getMessage());
    }
  }

  public function getEducational_degrees() {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM t_educational_degree");
      $stmt->execute();
      $result = $stmt->fetchAll();
      error_log(json_encode($result));
      return $result;
    } catch (\PDOException $e) {
      die('Ошибка запроса: ' . $e->getMessage());
    }
  }

  public function set_educational_doc($path, $real_file_name) {
    $stmt = $this->pdo->prepare("INSERT INTO t_educational_doc (file_path, real_file_name) VALUES (:file_path, :real_file_name)");
    $stmt->bindParam(':file_path', $path);
    $stmt->bindParam(':real_file_name', $real_file_name);
    $result = $stmt->execute();
    if ($result) {
      if ($stmt->rowCount() > 0) {
        $id_educational_doc = $this->pdo->lastInsertId();
        return $id_educational_doc;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function get_enrollee_date($params) {
    $stmt = $this->pdo->prepare("INSERT INTO t_enrollee (user_fk, surname, name, patronymic, birthday, gender, educational_fk, educational_doc_fk, token) 
                                 VALUES (:user_fk, :surname, :name, :patronymic, :birthday, :gender, :educational_fk, :educational_doc_fk, :token)");
    $stmt->bindParam(':user_fk', $this->user_id);
    $stmt->bindParam(':surname', $params['surname']);
    $stmt->bindParam(':name', $params['name']);
    $stmt->bindParam(':patronymic', $params['patronymic']);
    $stmt->bindParam(':birthday', $params['birthday']);
    $stmt->bindParam(':gender', $params['gender']);
    $stmt->bindParam(':educational_fk', $params['education']);
    $stmt->bindParam(':educational_doc_fk', $params['file_path']);
    $stmt->bindParam(':token', $params['token']);
    $result = $stmt->execute();
    if ($result) {
      if ($stmt->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function check_data_enrolee() {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM t_enrollee WHERE user_fk = :user_id");
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->execute();
      $result = $stmt->rowCount();
      if ($result > 0) {
          return $result;
        } else {
          return false;
        }
      } catch (\PDOException $e) {
      die('Ошибка запроса: ' . $e->getMessage());
    }
  }

  public function get_user_info() {
    try {
      $stmt = $this->pdo->prepare("SELECT te.*, to_char(te.birthday, 'DD.MM.YYYY') as birthday2, tu.login, ted.file_path, tedd.type as ed_name FROM t_enrollee te
                                  LEFT JOIN t_user tu ON user_fk = user_id
                                  LEFT JOIN t_educational_doc ted ON  te.educational_doc_fk = ted.id
                                  LEFT JOIN t_educational_degree tedd ON te.educational_fk = tedd.id
                                  WHERE user_fk = :user_id");
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->execute();
      $data_user = $stmt->fetch();
      $result = $stmt->rowCount();
      if ($result > 0) {
        return $data_user;
      } else {
        return false;
      }
    } catch (\PDOException $e) {
      die('Ошибка запроса: ' . $e->getMessage());
    }
  }

  public function get_enrollees_list() {
    try {
      $stmt = $this->pdo->prepare("SELECT login, (surname || ' ' || ' ' || name || ' ' || patronymic) as fio, to_char(birthday, 'DD.MM.YYYY') as birthday,  file_path, type  FROM t_user tu
                                    LEFT JOIN t_enrollee ON user_id = user_fk
                                    LEFT JOIN t_educational_doc ted ON educational_doc_fk = ted.id
                                    LEFT JOIN t_educational_degree tedd ON educational_fk = tedd.id
                                    WHERE is_emploee = false AND user_id = user_fk");
      $stmt->execute();
      $data_users = $stmt->fetchAll();
      $result = $stmt->rowCount();
      if ($result > 0) {
        return $data_users;
      } else {
        return false;
      }
    } catch (\PDOException $e) {
      die('Ошибка запроса: ' . $e->getMessage());
    }
    
  }

  public function check_data_enrolee_status() {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM t_enrollee WHERE user_fk = :user_id");
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->execute();
      $result = $stmt->rowCount();
      if ($result > 0) {
        return true;
      } else {
        return false;
      }
    } catch (\PDOException $e) {
      die('Ошибка запроса: ' . $e->getMessage());
    }
  }


}
