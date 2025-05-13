<?php
  $uri = $_SERVER['REQUEST_URI']; //获取uri

  // 获取最后的参数
  $uri = explode('/', $uri);
  $uri = end($uri);
  $uri = explode('?', $uri);
  $uri = $uri[0];

  switch($uri){
    case "":        include "app/pages/pannel.php"; break;
    case "login":   include "app/pages/login.php";  break;
    case "logout":  include "app/pages/logout.php"; break;
    case "query":   include "app/api/query.php";    break;
    case "pannel":  include "app/pages/pannel.php"; break;
    case "add":     include "app/pages/addpost.php";break;
    case "clear":   include "app/api/clear.php";    break;
    case "setting": include "app/pages/setting.php";break;
    case "report":  include "app/pages/report.php"; break;
    case "logs":    include "app/pages/csp-reports.log"; break;
    default:        include "app/pages/404.php";    break;
  }