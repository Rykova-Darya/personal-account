<?php
namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use App\Auth\Auth;
use App\Controller\Controller;
use App\InLK\InLK;

error_reporting(E_ALL);
ini_set("display_errors", 0);
header("Content-type: text/html; charset=utf-8");

require_once "config.php";

error_log(json_encode(file_exists("Controllers/MainController/Controller.php")));

$page = isset($_GET['page']) ? $_GET['page'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : $page;

switch ($page) {
  case 'login': $c = new Auth; $c->auth(); break;
  case 'send-login': $c = new Auth; $c->send_login(); break;
  case 'signup': $c = new Auth; $c->signup(); break;
  case 'info': $c = new InLk; $c->info(); break;
  case 'logout' : $c = new InLk; $c->logout(); break;
  case 'send_questionnaire' : $c = new InLk; $c->send_questionnaire(); break;
  case 'account' : $c = new InLk; $c->account(); break;
  case 'enrolles-list' : $c = new InLk; $c->enrolles_list(); break;
  default : $c = new InLk; $c->info(); break;
}

?>