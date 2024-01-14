<?php

namespace App\Auth;

use App\Controller\Controller;

class Auth extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function auth()
  {
    error_log('0000000000000000000000000000000');
    error_log(json_encode($_SESSION));
    $this->display('login');
  }

  public function login()
  {
    $this->display('login');
  }

  public function start()
  {
    $this->redirect('login');
  }

  public function send_login()
  {
    if (isset($_POST['action'])) {
      if ($_POST['action'] === 'send-login') {
        $result = $this->authorization($_POST['email'], $_POST['password']);
        // $result = $_POST;
        echo json_encode($result);

      }
    } else {
      echo json_encode(array('success' => false, 'text' => 'Проверьте введенные данные.'));
    }
  }

  public function signup()
  {
    if (isset($_POST['action'])) {
      if ($_POST['action'] === 'signup') {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $new_password = htmlspecialchars($_POST['newPassword']);

        if ($new_password === $password) {
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('emai' => false));
            exit;
          }
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->db->enrollee_registration($email, $hashed_password);
        if ($result) {
          // error_log('DDDDDDDDDDDDDDDDDDDDDDDDDDDDD');
          // $_SESSION['user_email'] = $email;
          //TODO Если метод возвращает тру, то писать, что данные успешно отправлены и выводить кнопку войти в личный кабинет
          echo json_encode($result);
          // $this->redirect("info");  
          exit;
        } else {
          echo json_encode(array('success' => false, 'text' => 'Проверьте введенные данные.'));
        }

      }
    } else {

      echo json_encode(array('success' => false, 'text' => 'Проверьте введенные данные.'));
    }
  }

  public function authorization($login, $password) {
    $user_data = $this->db->check_user($login, $password);
    if ($user_data !== false) {
      $_SESSION['user_login'] = $user_data['login'];
      $_SESSION['user_password'] = $user_data['password'];
      return true;
    } else {
      return false;
    }
  }
  //TODO написать метод, который будет записыватьв сессию данные. И вызывать его в методе auth
}
