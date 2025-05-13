<?php
session_start();
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>账户登录</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
      }
      .card-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        width: 300px;
      }
      .input-group {
        margin-bottom: 15px;
      }
      input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
      }
      button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }
      button:hover {
        background-color: #45a049;
      }
      #captcha-info {
        font-size: 12px;
        color: #666;
        margin-bottom: 15px;
      }
      #login-title {
        text-align: center;
        margin-bottom: 20px;
      }
      .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
      }
      /* 新增样式：验证码容器 */
      .captcha-container {
        display: flex;
        gap: 10px;
        align-items: center;
      }
      #captcha-input {
        flex: 1;
      }
      #captcha-img {
        width: 100px;
        height: 40px;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        cursor: pointer;
        user-select: none;
        font-weight: bold;
        letter-spacing: 2px;
      }
    </style>
  </head>

  <body>
    <div class="card-container">
      <form id="loginForm">
        <div id="login-title"><h3>身份认证</h3> </div>
        <div class="input-group">
          <input type="text" name="name" id="name" placeholder="学工号/手机号/邮箱" required>
        </div>
        <div class="input-group">
          <input type="password" name="passwd" id="passwd" placeholder="密码" required>
        </div>
        <div class="input-group captcha-container">
          <div id="captcha-input">
            <input type="text" name="code" id="code" placeholder="请输入验证码" required>
            <input type="hidden" name="captcha-id" id="captcha-id" value="<?php echo $_SESSION['img_id_1']; ?>">
            <div id="code-error" class="error-message"></div>
          </div>
          <img id="captcha-img">
        </div>
        
        <p id="captcha-info">验证码只包含字母,不区分大小写</p>
        <div><button type="button" class="button" id="login-submit"><span>登录</span></button></div>
      </form>
    </div>

    <script>
  // 获取验证码图片
  async function fetchCaptcha() {
    try {
      // 显示验证码图片
      document.getElementById('captcha-img').src = 'captcha.php';
    } catch (error) {
      console.error('获取验证码失败:', error);
    }
  }

  // 初始化验证码
  fetchCaptcha();

  // 点击验证码图片刷新验证码
  document.getElementById('captcha-img').addEventListener('click', fetchCaptcha);

  document.getElementById('login-submit').addEventListener('click', async function(e) {
    e.preventDefault();
    
    // 获取表单数据
    const code = document.getElementById('code').value;
    const captchaId = document.getElementById('captcha-id').value;
    const errorElement = document.getElementById('code-error');
    
    try {
        const name = document.getElementById('name').value;
        const passwd = document.getElementById('passwd').value;
        const captchaId = document.getElementById('captcha-id').value;
        const code = document.getElementById('code').value;
        
        const loginResponse = await fetch('/login1.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            name: name,
            passwd: passwd,
            captchaId: captchaId,
            code: code
          })
        });
        
        const loginResult = await loginResponse.json();
        
        if (loginResult.success) {
          alert('登录成功');
          // 这里可以跳转到其他页面
        } else {
          alert('登录失败: ' + loginResult.message);
        }
    } catch (error) {
      console.error('登录过程出错:', error);
      errorElement.textContent = '网络错误，请重试';
    }
  });
</script>
  </body>
</html>