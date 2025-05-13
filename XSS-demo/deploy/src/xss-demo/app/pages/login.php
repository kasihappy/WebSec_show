<?php
require_once 'app/utils/doBeforePageStartsWithoutLogin.php';
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>账户登录</title>
    <link rel="stylesheet" href="app/css/style.css">
    <script src="app/js/js.js"></script>
  </head>

  <body>
    <div class="card-container">
      <form>
        <div id="login-title"><h3>身份认证</h3> </div>
        <div class="input-group">
          <input type="text" name="name" id="name" placeholder="学工号/手机号/邮箱" required>
        </div>
        <div class="input-group">
          <input type="password" name="passwd" id="passwd" placeholder="密码" required>
        </div>
        <div class="input-group" id="captcha-input">
          <input type="text" name="code" id="code" placeholder="请输入验证码">
        </div>
        <div class="input-group" id="captcha-img"></div>
        <input type="hidden" name="id" id="captcha-id">
        
        <p id="captcha-info">验证码只包含字母,不区分大小写</p>
        <div><button class="button" id="login-submit"><span>登录</span></button></div>
      </form>
    </div>
  </body>
<script>
  // 登录ajax
  var submitButton = document.getElementById('login-submit');

  submitButton.addEventListener('click', function(e) {
    e.preventDefault();

    var data = {
      action: 'SELECT',
      fields: {
        user: ''
      },
      condition: {
        captcha: {
          type: 'EXISTS',
          code: document.getElementById('code').value,
          id: document.getElementById('captcha-id').value,
          joint: ''
        },
        user: {
          type: 'COMMON',
          name: document.getElementById('name').value,
          passwd: document.getElementById('passwd').value,
          joint: 'AND'
        }
      },
      api: 'login'
    }

    fetch('query', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
      // console.log('Success:', data);
      if (data.status === 'success') {
        location.href = 'pannel';
      } else {
        alert(data.descrp);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });
</script>
</html>
<?php
require_once 'app/utils/doWhenPageEnds.php';
?>