<?php
session_start();

// 检查用户是否登录
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// 数据库配置
$db_host = 'localhost';
$db_name = 'kasilab';
$db_user = 'kasihappy';
$db_pass = 'what_can_i_say';

// 连接数据库
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// 检查连接
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 获取表单数据
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $user_id = $_SESSION['username'];
    
    // 验证输入
    $errors = [];
    if (empty($title)) {
        $errors[] = '标题不能为空';
    }
    
    if (empty($content)) {
        $errors[] = '内容不能为空';
    }
    
    if (strlen($title) > 255) {
        $errors[] = '标题不能超过255个字符';
    }
    
    // 如果没有错误，保存到数据库
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO posts (author, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $user_id, $content);
        
        if ($stmt->execute()) {
            $success = '帖子发布成功！';
            // 清空表单
            $title = $content = '';
        } else {
            $errors[] = '发布失败: ' . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>发布新帖子</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            min-height: 200px;
            resize: vertical;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: #d9534f;
            margin-bottom: 15px;
        }
        .success {
            color: #5cb85c;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>发布新帖子</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="post.php">
            <div class="form-group">
                <label for="title">标题</label>
                <input type="text" id="title" name="title" value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="content">内容</label>
                <textarea id="content" name="content" required><?php echo isset($content) ? htmlspecialchars($content) : ''; ?></textarea>
            </div>
            
            <button type="submit">发布帖子</button> <button onclick="window.location.href='index.php'">返回首页</button>
        </form>
    </div>
</body>
</html>
<?php
// 关闭数据库连接
$conn->close();
?>