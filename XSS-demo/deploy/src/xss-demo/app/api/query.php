<?php
require_once 'app/utils/doBeforePageStartsWithoutLogin.php';
require_once 'app/utils/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // 读取POST数据
  $json_data = file_get_contents('php://input');
  $data = json_decode($json_data, true);



  // generate query
  $query = '';

  switch ($data['action']) {
    case 'SELECT': {
      $query .= "SELECT * FROM ";

      // 生成SELECT表名
      $tables = toArray($data['fields']);
      $result = array_reduce($tables, function($carry, $item) {
        return $carry . ($carry ? ', ' : '') . $item[0];
      });
      $query .= $result;

      break;
    }
    case 'INSERT': {
      $query .= "INSERT INTO ";

      // 生成INSERT表名
      $table = toArray($data['fields']);
      $table = $table[0][0];
      $query .= $table;

      // 生成INSERT字段
      $values = toArray($data['value']);
      $result = array_reduce($values, function($carry, $item) {
        return $carry . ($carry ? ', ' : '') . $item[0];
      });
      $query .= " (". $result . ") VALUES (";

      // 生成INSERT值
      $result = array_reduce($values, function($carry, $item) {
        return $carry . ($carry ? ', ' : '') . "'" . $item[1] . "'";
      });
      $query .= $result . ")";

      break;
    }
    case 'UPDATE': break;
    case 'DELETE': break;
    default:
      throwError('Invalid action!');
  }

  // generate condition
  if (isset($data['condition'])) {
    $condition = ' WHERE';
    foreach ($data['condition'] as $key => $value){
      switch ($value['joint']) {
        case 'AND': $condition .= " AND "; break;
        case 'OR': $condition .= " OR "; break;
        case '': $condition .= " "; break;
        default: throwError('Illegal joint!');
      }

      switch ($value['type']) {
        case 'EXISTS': {
          $condition .= "EXISTS (";
          $condition .= "SELECT * FROM " . $key . " WHERE ";
          $flag = 1;
          foreach ($value as $k => $v) {
            if($k === 'type') {
              $flag = 0;
              continue;
            }
            if ($k === 'joint') {
              $condition .= ") ";
              break;
            }
            if ($flag !== 0) {
              $condition .= "AND ";
            }
            if ($flag === 0) $flag = 1;
            $condition .=  $k . " = '" . $v . "' ";
          }
          break;
        }
        case 'COMMON': {
          foreach ($value as $k => $v) {
            if($k === 'type') {
              $flag = 0;
              continue;
            }
            if ($k === 'joint') {
              break;
            }
            if ($flag !== 0) {
              $condition .= "AND ";
            }
            if ($flag === 0) $flag = 1;
            $condition .=  $k . " = '" . $v . "' ";
          }
          break;
        }
        case 'LIKE': {
          foreach ($value as $k => $v) {
            if($k === 'type') {
              $flag = 0;
              continue;
            }
            if ($k === 'joint') {
              break;
            }
            if ($flag !== 0) {
              $condition .= "AND ";
            }
            if ($flag === 0) $flag = 1;
            $condition .=  $k . " like '%" . $v . "%' ";
          }
          break;
        }
        default: throwError('Illegal type!');
      }
    }
    $query .= $condition;
  }

  // 执行sql语句
  $result = $db->query($query);
  if ($result->num_rows > 0) {
    switch ($data['api']) {
      case 'login': {
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        returnJson($row);
        break;
      }
      case 'getPosts': {
        $res = array();
        while($row = $result->fetch_assoc()) {
          $res[] = $row;
        }
        returnJson($res, $store_xss_defense);
        break;
      }
    }
  } else {
    if ($data['action'] === 'SELECT') {
      throwError("no data found!");
    } else {
      returnJson("");
    }
  }
} else {
  throwError("method not allowed!");
}