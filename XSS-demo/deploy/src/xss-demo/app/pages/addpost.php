<?php
require_once 'app/utils/doBeforePageStartsWithLogin.php';
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>add your post here</title>
  </head>
  <body>
    <div class="post-container">
      <form>
        <div class="post-title">
          <input type="text" name="title" placeholder="title">
        </div>
        <div class="post-content">
          <textarea name="content" placeholder="content"></textarea>
        </div>
        <div class="post-submit">
          <button class="submit-button" id="post-submit-button"">submit</button>
        </div>
      </form>
    </div>
  </body>
  <script>
    window.onload = function() {
      // 发帖ajax
      var submitButton = document.getElementById('post-submit-button');

      submitButton.addEventListener('click', function(e) {
        e.preventDefault();

        var data = {
          action: 'INSERT',
          fields: {
            posts: ''
          },
          value: {
            title: document.getElementsByName('title')[0].value,
            content: document.getElementsByName('content')[0].value,
            user_id: <?php echo $_SESSION['user_id']; ?>,
            deleted: 0
          },
          api: 'addPost'
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
    }

  </script>
</html>

<?php
require_once 'app/utils/doWhenPageEnds.php';
?>