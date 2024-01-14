<?php

namespace App\InLK;

use App\Controller\Controller;

class InLk extends Controller
{

  protected $educational_degrees;
  protected $csrf_token;
  protected $user_data;
  protected $enrollees_list;
  protected $download_file;


  public function __construct()
  {
    parent::__construct();
    //TODO добавить проверку
    if (!isset($_SESSION['user_login']) || !isset($_SESSION['user_password'])) {
      $this->redirect('login');
      exit;
    }
  }

  public function info()
  {
    //Если данных в t_enrollee нет в бд на юзера, то делать редирект на account.
    if ($this->db->check_data_enrolee() !== false) {
      $this->account();
    } else {
      $this->educational_degrees = $this->db->getEducational_degrees();
      $this->csrf_token = $this->generate_csrf_token();

      $this->display('info');
    }

  }

  public function account() {
    //Добавить скрытие страницы account
    if ($this->db->check_data_enrolee_status() !== true) {
      $this->info();
      exit;
    }
    $this->user_data = $this->db->get_user_info();
    $this->err_log($this->db->get_user_info());
    $this->display('account');
  }

  public function enrolles_list() {
    if (!isset($_SESSION['is_emploee'])) {
      $this->redirect('info');
      exit;
    }
    $this->enrollees_list = $this->db->get_enrollees_list();
    $this->display('enrolles_list');
  }
  public function logout()
  {
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

  public function send_questionnaire()
  {
    if (isset($_POST['action'])) {
      if ($_POST['action'] === 'send_questionnaire') {
        if (!isset($_FILES["file_path"]) || $_FILES["file_path"]["error"] != UPLOAD_ERR_OK) {
          echo ("Ошибка при загрузке файла.");
          exit;
        }

        $allowed_extensions = array("jpeg", "jpg", "pdf");
        $file_extension = pathinfo($_FILES["file_path"]["name"], PATHINFO_EXTENSION);

        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
          echo ("Недопустимый формат файла. Разрешены только .jpeg, .jpg и .pdf.");
          exit;
        }

        $real_file_name =  $_FILES["file_path"]["name"];
        $target_directory = "download_files/";
        $file_name = uniqid() . "_" . basename($_FILES["file_path"]["name"]);
        $target_path = $target_directory . $file_name;

        $date = date_create_from_format('d.m.Y', $_POST['birthday']);
        if ($date) {
          $birthday = date_format($date, 'Y-m-d');
        }

        $params = array(
          'surname' => htmlspecialchars($_POST['surname']),
          'name' => htmlspecialchars($_POST['name']),
          'patronymic' => htmlspecialchars($_POST['patronymic']),
          'birthday' => $birthday,
          'gender' => $_POST['gender'] ? $_POST['gender'] : 0,
          'education' => $_POST['education'],
          'file_path' => $file_name,
          'real_file_name' => $real_file_name,
          'token' => $_POST['token'],
        );

        if (move_uploaded_file($_FILES["file_path"]["tmp_name"], $target_path)) {
          $id_educ_doc = $this->db->set_educational_doc($file_name, $real_file_name);
          $params['file_path'] = $id_educ_doc;
          if ($id_educ_doc !== false) {
            //Записываем данные в базу про анкету
            if ($this->db->get_enrollee_date($params)) {
              //redirect на страницу клиента
              $this->redirect('account');
            }

          } else {
            echo "Ошибка при сохранении файла.";
          }
         ;
          //Здесь вызываем метод загрузки в бд
        } else {
          echo "Ошибка при сохранении файла.";
        }
      }
    }
    $this->err_log(json_encode($params));
  }

  private function generate_csrf_token()
  {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
  }

}
