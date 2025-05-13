<?php
    session_start();
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    $code = strtolower($input['code'] ?? '');

    if (empty($code)) {
        echo json_encode(['success' => false, 'message' => '缺少参数']);
        exit;
    }

    $captcha = $_SESSION['img_number'];

    // 验证码是否正确
    $isCorrect = $code === $captcha;

    // 验证后删除验证码，防止重复使用
    unset($_SESSION['img_number']);

    echo json_encode(['success' => $isCorrect]);
    exit;