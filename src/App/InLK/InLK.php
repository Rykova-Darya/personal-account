<?php 
namespace App\InLK;

use App\Controller\Controller;

class InLk extends Controller {
  public function __construct() {
    parent::__construct();
    //TODO добавить проверку
        if (!isset($_SESSION['user_login']) || !isset($_SESSION['user_password'])) {
          $this->redirect('auth');
          exit;
        }
  }

  public function info()
  {
    error_log('МЕТОД INLK');
    $this->display('info');
  }

  public function logout() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $json_data = file_get_contents("php://input");
      
      error_log($json_data);
      $data = json_decode($json_data, true);
      if ($data['action']) {
        if ($data['action'] === 'logout') {
          session_unset();

          return true;

          // $this->redirect('auth');
        } else {
          return false;
        }
      }
    }

  }
}