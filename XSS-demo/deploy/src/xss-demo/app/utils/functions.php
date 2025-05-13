<?php
require_once 'config.php';

function throwError($descrip)
{
  echo json_encode(array(
    'status' => 'error',
    'descrp' => $descrip
  ));
  die();
}

function returnJson($data, $store_xss_defense = 0)
{
  if ($store_xss_defense === 2) {
    // 遍历数组中的每个对象
    foreach ($data as &$obj) {
      // 遍历对象的每个属性
      foreach ($obj as $key => &$value) {
          // 对属性值进行 HTML 转义
          $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
      }
    }
  }
  echo json_encode(array(
    'status' => 'success',
    'data' => $data
  ));
}

// toArray， 将一个关联数组转化成二维数组以便遍历
// 真是伟大的发明 —— kasihappy
function toArray($dict)
{
  $res = array();
  foreach ($dict as $key => $value) {
    array_push($res, array($key, $value));
  }
  return $res;
}

// 生成随机数和一个nonce，用于CSP
function generateNonce($length = 16) {
  $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $nonce = '';
  for ($i = 0; $i < $length; $i++) {
      $nonce .= $chars[mt_rand(0, strlen($chars) - 1)];
  }
  return base64_encode($nonce);
}
