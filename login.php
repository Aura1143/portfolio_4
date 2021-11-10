<!DOCTYPE html>
<html lang="ja">
  <head>
	  <meta charset="utf-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1" />
	  <!-- Bootstrap v5.0.0 -->
	  <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
	    crossorigin="anonymous">
	  <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
	    crossorigin="anonymous">
    </script>
	  <title>Home</title>
  </head>
  <style type="text/css">
	* {
    margin: 0;
    padding: 0;
	}
	.layout {
	  position: relative;
	}
	.layout a {
	  position: absolute;
	  margin: 5px;
	}
	.layout img {
	  width: 100%;
	  height: 100vh;
	  background-repeat: no-repeat;
	  background-size: cover;
	  background-position: center;
  }
  </style>
  <body>

  <?php
  require_once('config.php');
  // エラーチェック
  ini_set('display_errors',true);
  // セッション管理開始
  session_start();

  try{
    // PDO（ PHP Data Object ）でDB接続
    $pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    // usernameとpasswordが一致する場合 = 1 しない場合 = 0 が返るSQLを作成
    $sql = 'SELECT COUNT(*) FROM user WHERE username = :username AND password = :password';
    $stmt = $pdo->prepare($sql);
    // POSTの値をSQLに代入
    $stmt -> bindParam(':username',$_POST['username']);
    $stmt -> bindParam(':password',$_POST['password']);
    // SQL実行
    $stmt -> execute();
    // 実行結果を取得
    $cnt = $stmt->fetchColumn();

    if($cnt == 1){
    $result = true;
    // 成功
    // セッションにユーザー名を保管
    $_SESSION['USERNAME'] = $_POST['username'];

    $success = "<script type='text/javascript'>alert('ログイン成功\\nこんにちは！管理者さん！');</script>";
    echo $success;
  ?>
    <div class="layout">
	    <div class="d-flex justify-content-end">
		    <a class="btn btn-outline-light" href="index.html" role="button">Logout</a>
		    <img src="success.jpg" />
	    </div>
    </div>
  <?php
    }else {
    // 失敗
    $failure = "<script type='text/javascript'>alert('ログイン失敗\\nユーザー名またはパスワードが正しくありません。');</script>";
    echo $failure;
  ?>
    <div class="layout">
	    <div class="d-flex justify-content-end">
		    <a class="btn btn-outline-light" href="index.html" role="button">back</a>
		    <img src="failure.jpg" />
	    </div>
    </div>
  <?php
    $result = false;
    }
    return $result;
    // セッション変数を空にする
    $_SESSION = [];
    // 最終的にセッションを破棄
    session_destroy();

  }catch(PDOException $e){
    // 通信エラーの場合
    echo $e->getMessage() . PHP_EOL;
    exit();
  }
  ?>
  </body>
</html>
