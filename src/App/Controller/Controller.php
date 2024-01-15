<?php 
namespace App\Controller;

use App\DB\DB;

class Controller
{
  protected $db;
  protected $view;
  protected $title;

  function __construct()
  {
    session_start();

    $this->db = new DB;

  }

  protected function display($view)
  {
    ob_start();
    include 'views/' . $view . '.php';
    $this->view = ob_get_clean();
    echo $this->view;
    exit;
  }

  protected function json($data)
  {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
  }

  public function redirect($url)
  {
    header('Location: /' . $url);
    exit;
  }

  public function debug($arr) {
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
  }

  public function err_log($log) {
    error_log('============================' . PHP_EOL);
    error_log(json_encode($log) . PHP_EOL);
    error_log('============================' . PHP_EOL);
  }

  public function download_file($file_path)
  {
    $file_path = '../download_files/' . $file_path;

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));

    readfile($file_path);
    exit;
  }
}

?>