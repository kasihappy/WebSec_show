<?php
require_once 'app/utils/doBeforePageStartsWithLogin.php';

$reflect_value = '';
if (isset($_GET['search'])) $reflect_value = $_GET['search'];
switch ($reflect_xss_defense) {
  case 1: {
    $reflect_value = preg_replace('/script/','', $reflect_value);
  } break;
  case 2: {
    $reflect_value = preg_replace('/script/i','', $reflect_value);
  } break;
  case 3: {
    $reflect_value = preg_replace('/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i','', $reflect_value);
  } break;
  default : break;
}

$nonce = "";
switch ($csp_xss_defense) {
  case 1: {
    $nonce = generateNonce();
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-$nonce'; connect-src 'self'");
  } break;
  case 2: {
    $nonce = generateNonce();
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-$nonce'; connect-src 'self'; report-uri report");
  } break;
  default: break;
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>private pannel</title>
    <script nonce="<?= $nonce ?>">
      // 保存原始的 alert 函数
      const originalAlert = window.alert;

      // 重新定义 alert 函数
      window.alert = function (message) {
        originalAlert('Flag: flag{WA0w!_y4_r3al1y_Gr4sP_XSS!}')
      };
    </script>
  
  </head>
  <body>
    <div class="defense-info">
      <p>当前防御策略，如果发现与你的设置不匹配，请刷新</p>  
      <div class="xss">
        反射型XSS <?= $reflect_xss_defense ?><br>
        存储型XSS <?= $store_xss_defense ?><br>
        CSP <?= $csp_xss_defense ?><br>
      </div>
    </div>
    <br><br>
    <div class="user-info">
      <div class="user-info-role">
          role: <?php echo $_SESSION['role'];?>
      </div>
      <div class="user-info-name">
          Hello: <?php echo $_SESSION['name'];?>
      </div>
    </div>
    <div class="search-box">
      <input type="text" class="search-box-input" placeholder="搜索标题或内容"
             value="<?php echo $reflect_value?>">
      <span><button class="search-box-submit">GO!</button></span>
      <div class="search-box-content">
      </div>
    </div>

    <div class="posts-card-container">
    </div>

    <div class="other-hrefs">
      <a href="logout">logout</a> <br/>
      <a href="setting">设置</a> <br/>
      <a href="clear">清空数据库</a> <br/>
      <a href="add">发表帖子</a>
    </div>
  </body>
  <script nonce="<?= $nonce ?>">

    // 显示帖子ajax
    function showPosts(data){
      fetch('query', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        var container = document.querySelector('.posts-card-container');
        container.innerHTML = '';
        if (data.status === 'success') {

          // 向页面插入帖子内容
          var container = document.querySelector('.posts-card-container');
          container.innerHTML = '';
          var posts =data.data;
          for (const key in posts) {
            var jsonPost = posts[key];
            if (jsonPost.deleted === 1) continue;
            var newCard = document.createElement('div');
            newCard.className = 'post-card';
            var cardHeader = document.createElement('div');
            cardHeader.className = 'card-header';
            var cardContent = document.createElement('div');
            cardContent.className = 'card-content';

            // 存储型xss的攻击和防御
            <?php if ($store_xss_defense !== 1) { ?>
            cardHeader.innerHTML = `title: ${jsonPost.title}`;
            cardContent.innerHTML = `content: ${jsonPost.content}`;
            <?php } else { ?>
            cardHeader.innerText = `title: ${jsonPost.title}`;
            cardContent.innerText = `content: ${jsonPost.content}`;
            <?php } ?>
            newCard.appendChild(cardHeader);
            newCard.appendChild(cardContent);
            container.appendChild(newCard);
          }
        } else {
          console.error(data.descrp);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }

    // 页面初始化，显示所有帖子
    window.onload = function(){
      var data = {
        action: 'SELECT',
        fields: {
          posts: ''
        },
        api: "getPosts"
      }
      showPosts(data);
    }

    // 搜索功能
    document.querySelector('.search-box-submit').onclick = function(){
      var searchText = document.querySelector('.search-box-input').value;

      // 更新url
      const currentUrl = new URL(window.location.href);
      currentUrl.searchParams.set('search', searchText);
      history.pushState({}, '', currentUrl.toString());

      // DOM型XSS的攻击和防御
      var resultBar = document.querySelector('.search-box-content');
      <?php if ($dom_xss_enable) {?>
      resultBar.innerHTML = "你搜索的："+searchText+"结果如下";
      <?php } else {?>
      resultBar.innerText = "你搜索的："+searchText+"结果如下";
      <?php } ?>

      var data = {
        action: 'SELECT',
        fields: {
          posts: ''
        },
        condition: {
          posts1: {
            type: 'LIKE',
            title: searchText,
            joint: ''
          },
          posts2: {
            type: 'LIKE',
            content: searchText,
            joint: 'OR'
          }
        },
        api: "getPosts"
      };
      showPosts(data);
    }
  </script>
</html>
<?php
require_once 'app/utils/doWhenPageEnds.php';
?>