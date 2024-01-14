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

  // функция для отображения вьюшки и шаблона. по дефолту установлен шаблон main
  // сначало выполняется код вьюшки потом шаблона, весь вывод вьюшки сохраняется в переменную и вставляется в определенное место шаблона.
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
}
?>