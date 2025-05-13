<?php
// 开启会话并检查用户是否登录
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.html?error=请先登录");
    exit();
}

// 显示欢迎信息
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>帖子列表</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .post {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        .post-id {
            font-size: 0.8em;
            color: #666;
        }
        .author {
            font-weight: bold;
            color: #2c3e50;
        }
        .content {
            margin-top: 10px;
            line-height: 1.5;
        }
        .loading {
            text-align: center;
            padding: 20px;
        }
        .error {
            color: red;
            text-align: center;
            padding: 20px;
        }
        .dashboard {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }
        .user-info {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .logout-btn {
            display: inline-block;
            padding: 5px 5px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        .logout-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="welcome">
            <h1>欢迎, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        </div>
        
        <div class="user-info">
            <p><strong>用户ID:</strong> <?php echo $_SESSION['user_id']; ?>   <a href="logout.php" class="logout-btn">退出登录</a></p>
            <p><strong>角色:</strong> <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>
        </div>
        
        <div id="flag-section">
            <button id="check-flag-btn">检测并获取flag</button> <button id="post-page-btn" onclick="window.location.href='post.php'">跳转发帖页面</button>
            <div id="flag-result" style="margin-top: 10px;"></div>

        </div>
        
    </div>
    <h1>帖子列表</h1>
    <div id="posts-container">
        <div class="loading">加载中...</div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const postsContainer = document.getElementById('posts-container');
        
        fetch('api.php')
            .then(response => response.json())
            .then(posts => {
                postsContainer.innerHTML = '';
                
                if (posts.length === 0) {
                    postsContainer.innerHTML = '<div class="post">暂无帖子</div>';
                    return;
                }
                
                posts.forEach(post => {
                    const postElement = document.createElement('div');
                    postElement.className = 'post';
                    postElement.innerHTML = `
                        <div>
                            <span class="author">作者: ${post.author || '匿名'}</span>
                            <span class="post-id">(ID: ${post.id})</span>
                            <button class="delete-btn" data-id="${post.id}">删除</button>
                        </div>
                        <div class="content">${post.content || '无内容'}</div>
                    `;
                    postsContainer.appendChild(postElement);
                });
                
                // 添加删除按钮事件监听
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const postId = this.getAttribute('data-id');
                        deletePost(postId);
                    });
                });
            })
            .catch(error => {
                console.error('获取帖子出错:', error);
                postsContainer.innerHTML = `
                    <div class="error">
                        加载帖子失败: ${error.message}<br>
                        请刷新页面重试或联系管理员。
                    </div>
                `;
            });
            
        // 删除帖子的函数
        function deletePost(postId) {
            if (!confirm('确定要删除这条帖子吗？')) return;

            fetch(`api.php?action=confirm`, {
                method: 'GET'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('确认失败');
                }
                fetch(`api.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${postId}&action=delete`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('删除失败');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('删除成功');
                    location.reload(); // 刷新页面
                })
                .catch(error => {
                    console.error('删除出错:', error);
                    alert('删除失败: ' + error.message);
                });
            })
        }
    });
</script>
<script>
document.getElementById('check-flag-btn').addEventListener('click', function() {
    fetch('api.php?action=check_flag')
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('flag-result');
            if (data.success) {
                resultDiv.innerHTML = `
                    <div style="color: green;">
                        ${data.message}<br>
                        Flag: <strong>${data.flag}</strong>
                    </div>
                `;
            } else if (data.error) {
                resultDiv.innerHTML = `<div style="color: red;">错误: ${data.error}</div>`;
            } else {
                resultDiv.innerHTML = `<div>${data.message}</div>`;
            }
        })
        .catch(error => {
            document.getElementById('flag-result').innerHTML = 
                `<div style="color: red;">请求失败: ${error.message}</div>`;
        });
});
</script>

<style>
    /* 添加删除按钮样式 */
    .delete-btn {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #ff4444;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }
    
    .delete-btn:hover {
        background-color: #cc0000;
    }
</style>
<style>
#flag-section {
    margin: 20px 0;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: #f9f9f9;
}

#check-flag-btn {
    padding: 8px 15px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#check-flag-btn:hover {
    background-color: #45a049;
}

#post-page-btn {
    padding: 8px 15px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#post-page-btn:hover {
    background-color: #45a049;
}
</style>
</body>
</html>