<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
session_start();
// 数据库配置
$db_host = 'localhost';
$db_name = 'kasilab';
$db_user = 'kasihappy';
$db_pass = 'what_can_i_say';
$FLAG_PATH = '/flag'; // flag文件路径
$ADMIN_USERNAME = 'admin'; // 管理员用户名
// 连接数据库
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// 检查连接
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => '数据库连接失败: ' . $conn->connect_error]);
    exit;
}

// 设置字符集
$conn->set_charset("utf8mb4");

function getCurrentUser() {
    // 这里使用session作为示例，实际项目中应该使用更安全的认证方式如JWT
    if (isset($_SESSION['is_temp_admin']) && $_SESSION['is_temp_admin'] && time() < $_SESSION['temp_admin_expire']) {
        return 'admin';
    }
    return $_SESSION['username'] ?? null;
}

// 处理请求
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET' && isset($_GET['action']) && $_GET['action'] == 'confirm') {
    $_SESSION['is_confirm'] = true;
    exit;
}

// 在api.php的switch前添加登录处理
if ($method == 'POST' && isset($_GET['action']) && $_GET['action'] == 'login') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['username']) || empty($data['username'])) {
        http_response_code(400);
        echo json_encode(['error' => '用户名不能为空']);
        exit;
    }
    
    // 简化版登录，实际项目应该验证密码等
    $_SESSION['username'] = $data['username'];
    echo json_encode(['success' => true, 'username' => $data['username']]);
    exit;
}

// 添加登出功能
if ($method == 'POST' && isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    echo json_encode(['success' => true]);
    exit;
}

// 添加获取当前用户功能
if ($method == 'GET' && isset($_GET['action']) && $_GET['action'] == 'current_user') {
    $currentUser = getCurrentUser();
    if ($currentUser) {
        echo json_encode(['username' => $currentUser]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => '未登录']);
    }
    exit;
}

if ($method == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $post_id = (int)$_POST['id'];
    
    if ($post_id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => '无效的帖子ID']);
        exit;
    }
    
    // 检查用户是否登录
    $currentUser = getCurrentUser();
    if (!$currentUser) {
        http_response_code(401);
        echo json_encode(['error' => '未登录，请先登录']);
        exit;
    }

    if (isset($_SESSION['is_confirm']) && $_SESSION['is_confirm'] == true) {
        unset($_SESSION['is_confirm']);
    } else {
        http_response_code(403);
        echo json_encode(['error' => '请先确认删除操作']);
        exit;
    }
    
    // 获取帖子信息并检查作者
    $stmt = $conn->prepare("SELECT author FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->bind_result($author);
    $stmt->fetch();
    $stmt->close();
    
    if (!$author) {
        http_response_code(404);
        echo json_encode(['error' => '帖子不存在']);
        exit;
    }
    
    // 检查当前用户是否是帖子作者
    if ($currentUser !== $author) {
        http_response_code(403);
        echo json_encode(['error' => '无权删除此帖子，只能删除自己发布的帖子']);
        exit;
    }
    
    // 执行删除
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => '帖子删除成功']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => '删除失败: ' . $stmt->error]);
    }
    
    $stmt->close();
    exit;
}


switch ($method) {
    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] == 'check_flag') {
            // 检查admin的帖子是否存在
            $stmt = $conn->prepare("SELECT COUNT(*) FROM posts WHERE author = ?");
            $stmt->bind_param("s", $ADMIN_USERNAME);
            $stmt->execute();
            $stmt->bind_result($admin_post_count);
            $stmt->fetch();
            $stmt->close();
            
            if ($admin_post_count > 0) {
                echo json_encode(['success' => false, 'message' => 'admin的帖子仍存在']);
                break;
            }
            
            // 检查flag文件是否存在
            if (!file_exists($FLAG_PATH)) {
                http_response_code(404);
                echo json_encode(['error' => 'flag文件不存在']);
                break;
            }
            
            // 读取flag内容
            $flag_content = file_get_contents($FLAG_PATH);
            if ($flag_content === false) {
                http_response_code(500);
                echo json_encode(['error' => '读取flag失败']);
                break;
            }
            
            // 返回flag
            echo json_encode([
                'success' => true,
                'flag' => trim($flag_content),
                'message' => '恭喜获取flag!'
            ]);
            break;
        }
        // 获取所有帖子
        $query = "SELECT id, author, content FROM posts ORDER BY id DESC";
        $result = $conn->query($query);
        
        if (!$result) {
            http_response_code(500);
            echo json_encode(['error' => '获取帖子失败: ' . $conn->error]);
            break;
        }
        
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        
        echo json_encode($posts);
        break;
        
    case 'POST':
        // 创建新帖子
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['author']) || !isset($data['content'])) {
            http_response_code(400);
            echo json_encode(['error' => '作者和内容不能为空']);
            break;
        }
        
        // 准备语句防止SQL注入
        $stmt = $conn->prepare("INSERT INTO posts (author, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $data['author'], $data['content']);
        
        if (!$stmt->execute()) {
            http_response_code(500);
            echo json_encode(['error' => '创建帖子失败: ' . $stmt->error]);
            $stmt->close();
            break;
        }
        
        $post_id = $stmt->insert_id;
        $stmt->close();
        
        echo json_encode([
            'id' => $post_id,
            'author' => $data['author'],
            'content' => $data['content']
        ]);
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => '不支持的请求方法']);
        break;
}

// 关闭数据库连接
$conn->close();
?>