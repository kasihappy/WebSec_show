<?php
header('Content-Type: application/json');
session_start();

// 允许跨域请求（根据需求调整）
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents('php://input'), true);
$name = $input['name'] ?? '';
$passwd = $input['passwd'] ?? '';

// 这里应该是实际的用户验证逻辑
// 模拟验证
if (!empty($name)) {
    // 实际应用中应该查询数据库验证用户名和密码
    // 这里只是示例
    if ($name === 'admin' && $passwd === '1234') {
    echo json_encode(['success' => true, 'message' => '登录成功']);
    } else {
        echo json_encode(['success' => false, 'message' => '用户名或密码错误']);
    }
} else {
    echo json_encode(['success' => false, 'message' => '用户名或密码错误']);
}