<?php
// 开启会话
session_start();

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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 获取用户输入
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // 验证输入
    if (empty($username) || empty($password)) {
        header("Location: login.html?error=用户名和密码不能为空");
        exit();
    }
    
    // 准备SQL语句防止SQL注入
    $stmt = $conn->prepare("SELECT id, name, passwd, role FROM user WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        // 用户存在，验证密码
        $user = $result->fetch_assoc();
        
        // 假设密码是明文存储的（实际应用中应该使用哈希密码）
        if ($password === $user['passwd']) {
            // 密码正确，设置会话变量
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            // 生成随机 token (使用安全的随机字节生成方式)
            $token = bin2hex(random_bytes(32));

            // 存储 token 到 session
            $_SESSION['csrf_token'] = $token;

            // 重定向到欢迎页面或仪表盘
            header("Location: index.php");
            exit();
        } else {
            // 密码错误
            header("Location: login.html?error=密码错误");
            exit();
        }
    } else {
        // 用户不存在
        header("Location: login.html?error=用户名不存在");
        exit();
    }
    
    // $stmt->close();
}

$conn->close();
?>