<?php
// 设置页面标题和字符编码
$page_title = "文件目录列表";
$ignore_files = ['index.php', '.htaccess', '.gitignore', 'README.md', 'kasilab.sql', 'verify.php', 'login.php', 'getflag.php', 'captcha.php', 'login1.php', 'login2.php']; // 要忽略的文件列表

// 获取当前目录下的所有文件和目录
$files = scandir('.');
$files = array_diff($files, ['.', '..']);
$files = array_diff($files, $ignore_files);

// 按文件类型排序：目录在前，文件在后
usort($files, function($a, $b) {
    $isDirA = is_dir($a);
    $isDirB = is_dir($b);
    
    if ($isDirA && !$isDirB) return -1;
    if (!$isDirA && $isDirB) return 1;
    
    return strnatcasecmp($a, $b);
});
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .file-list {
            list-style: none;
        }
        .file-item {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        .file-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
        .file-item:last-child {
            border-bottom: none;
        }
        .file-item a {
            text-decoration: none;
            color: #3498db;
            flex-grow: 1;
            display: flex;
            align-items: center;
        }
        .file-item a:hover {
            color: #2980b9;
        }
        .icon {
            margin-right: 10px;
            font-size: 1.2em;
        }
        .folder .icon {
            color: #f39c12;
        }
        .file .icon {
            color: #3498db;
        }
        .file-size {
            color: #95a5a6;
            font-size: 0.9em;
            margin-left: 10px;
        }
        .empty-message {
            text-align: center;
            color: #95a5a6;
            padding: 20px;
        }
        .last-modified {
            color: #7f8c8d;
            font-size: 0.8em;
            margin-left: auto;
            padding-left: 15px;
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            .last-modified {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($page_title); ?></h1>
        
        <?php if (empty($files)): ?>
            <div class="empty-message">当前目录为空</div>
        <?php else: ?>
            <ul class="file-list">
                <?php foreach ($files as $file): ?>
                    <li class="file-item <?php echo is_dir($file) ? 'folder' : 'file'; ?>">
                        <a href="<?php echo htmlspecialchars($file); ?>">
                            <span class="icon">
                                <?php echo is_dir($file) ? '📁' : '📄'; ?>
                            </span>
                            <?php echo htmlspecialchars($file); ?>
                            <?php if (!is_dir($file)): ?>
                                <span class="file-size">(<?php echo format_size(filesize($file)); ?>)</span>
                            <?php endif; ?>
                        </a>
                        <span class="last-modified" title="最后修改时间">
                            <?php echo date("Y-m-d H:i", filemtime($file)); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// 格式化文件大小
function format_size($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return '1 byte';
    } else {
        return '0 bytes';
    }
}
?>