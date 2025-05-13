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
$code = strtolower($input['code'] ?? '');
if (empty($code)) {
    echo json_encode(['success' => false, 'message' => '缺少参数']);
    exit;
}
if (isset($input['captchaId'])) {
    $captchaId = $input['captchaId'];
    if ($captchaId !== $_SESSION['img_id_0']) {
        echo json_encode(['success' => false, 'message' => '验证码ID不匹配'.$_SESSION['img_id_0']]);
        exit;
    }

    $captcha = $_SESSION['img_number'];
    // 验证码是否正确
    $isCorrect = $code === $captcha;

    // 验证后删除验证码，防止重复使用
    unset($_SESSION['img_number']);
    // unset($_SESSION['img_id']);
    
    if (!$isCorrect) {
        echo json_encode(['success' => false, 'message' => '验证码错误']);
        exit;
    }
}

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