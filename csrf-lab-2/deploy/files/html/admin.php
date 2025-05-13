<?php
// admin.php - 临时管理员页面

// 启动会话
session_start();

// 检查是否已经授权为临时管理员
if (!isset($_SESSION['is_temp_admin']) || time() >= $_SESSION['temp_admin_expire']) {
    // 这里可以添加你的授权逻辑，例如：
    // - 检查特定的密码或令牌
    // - 验证用户身份
    // 为了示例，我们简单地设置一个会话变量
    $_SESSION['is_temp_admin'] = true;
    $_SESSION['temp_admin_expire'] = time() + 5; // 5秒后过期
}


// 检查临时管理员权限是否有效
if ($_SESSION['is_temp_admin'] && time() < $_SESSION['temp_admin_expire']) {
    // 用户有临时管理员权限
    $allowed = true;
} else {
    // 权限无效或已过期
    $allowed = false;
    $_SESSION['is_temp_admin'] = false;
}

// 获取要加载的URL
$url = isset($_GET['url']) ? $_GET['url'] : '';

// 安全过滤URL
if ($url) {
    // 简单的URL验证 - 在实际应用中应该更严格
    $url = filter_var($url, FILTER_SANITIZE_URL);
    
    // 检查URL是否有效
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        $url = '';
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=index.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>临时管理员面板</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .iframe-container {
            margin-top: 20px;
            border: 1px solid #ddd;
            height: 600px;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        .error {
            color: red;
            padding: 10px;
            background-color: #ffeeee;
            border: 1px solid #ffcccc;
        }
        .info {
            color: #31708f;
            background-color: #d9edf7;
            border: 1px solid #bce8f1;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>临时管理员面板</h1>
        
        <?php if ($allowed): ?>
            <div class="info">
                5秒后自动跳转回主页。
            </div>
            
            <?php if ($url): ?>
                <div class="iframe-container">
                    <iframe src="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>" title="管理员视图"></iframe>
                </div>
            <?php else: ?>
                <div class="error">
                    未提供有效的URL参数或URL无效。请使用?url=参数指定要加载的URL。
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="error">
                您没有临时管理员权限或权限已过期。请联系系统管理员获取访问权限。
            </div>
        <?php endif; ?>
    </div>
</body>
</html>