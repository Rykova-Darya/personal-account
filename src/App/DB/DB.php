<?php

namespace App\DB;

class DB
{
  private $pdo;
  private $host = '172.17.0.2';
  private $bdname = 'personal-account';
  private $user = 'postgres';
  private $pass = '12344321';

  public function __construct()
  {
    try {
      $this->pdo = new \PDO("pgsql:host=" . $this->host . ";dbname=" . $this->bdname . ";user=" . $this->user . ";password=" . $this->pass);
      $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      die($e->getMessage());
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
    $stmt->execute();
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
}
