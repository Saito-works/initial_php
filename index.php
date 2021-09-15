<?php
    //データベースに接続、情報の取得
    $dsn = 'mysql:host=localhost;dbname=question;charset=utf8';
    $user = 'question_user';
    $pass = '1a2b3c';
    
    
    //データベースに追加
    if(!empty($_POST['question']))try{
      $dbh = new PDO($dsn,$user,$pass);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $question = $_POST['question'];
      
      date_default_timezone_set('Asia/Tokyo');
      $date = date('Y-m-d H:i:s');
      
      
      $sql = "INSERT INTO question_info (
        Question , time_at
      ) VALUES (
        '$question','$date')";
      
      $res = $dbh->query($sql);
      
      header('Location: http://localhost/Have_a_Question/index.php');
      
      
      
      
    } catch(PDOException $e) {
      echo '接続失敗<br>'. $e->getMessage();
      exit();
    };
    
    
    
    //データベースに接続、情報の取得
    $dsn = 'mysql:host=localhost;dbname=question;charset=utf8';
    $user = 'question_user';
    $pass = '1a2b3c';
    
    try{
      $dbh = new PDO($dsn,$user,$pass);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo '接続成功';
      
      //SQLの準備
      $sql = 'SELECT * FROM question_info';
      //実行
      $stmt = $dbh->query($sql);
      //結果の受け取り
      $result = $stmt->fetchall(PDO::FETCH_ASSOC);
      
      
      
    } catch(PDOException $e) {
      echo '接続失敗<br>'. $e->getMessage();
      exit();
    };
    
  
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=chrome">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>Have a Question</title>
  </head>
  <body>
    <header>
      <div class="head">
        <h1>質問受付中</h1>
      </div>
    </header>

    <main>
      <div class="blank">

      </div>
        <?php foreach($result as $column): ?>
            <?php //以下に質問内容を表示している
            echo '<div class="question">
                    <h2>'.$column["Question"].'</h2>'.
                    '<div class="date">'.$column["time_at"].'</div>
                  </div>'; 
            ?>
      <?php endforeach; ?>
      <div class="blank">

      </div>
    </main>
    <footer>
      <div class="border"></div>
      <div class="footer">
        <form action="index.php" method="POST">
            <div class="input">
              <input type="text" name="question" value="" autocomplete="off">
              <button type="submit" id="ajax">質問する</button>
            </div>
        </form>
      </div>
    </footer>
  </body>
</html>
<script>
    $(function(){
      // 「Ajax通信」ボタンをクリックしたら発動
      $('#ajax').on('click',function(){
        $.ajax({
          url:'./ajax.php',
          type:'POST',
          data:{
            'question':$('#question').val()
          }
        })
        // Ajax通信が成功したら発動
        .done( (data) => {
          $('.question').html(data);
        })
        // Ajax通信が失敗したら発動
        .fail( (jqXHR, textStatus, errorThrown) => {
          alert('Ajax通信に失敗しました。');
          console.log("jqXHR          : " + jqXHR.status); // HTTPステータスを表示
          console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラーなどのエラー情報を表示
          console.log("errorThrown    : " + errorThrown.message); // 例外情報を表示
        })
        });
      });
    });
  </script>
