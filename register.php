<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>HTML5で作成したサイト</title>
</head>
<body>
<?php

  /* ============== データベースに登録 ================ */
  if(session_status() == PHP_SESSION_ACTIVE){
    $title = $_SESSION['title'];
    $name = $_SESSION['name'];
    $frontdata = $_SESSION['frontdata'];
    $backdata = $_SESSION['backdata'];
    $id = 0;

    $mysqli = new mysqli('mysql153.phy.lolipop.lan', 'LAA1321771', 'Soccer3639', 'LAA1321771-wordnote');
    if($mysqli->connect_error){
      echo $mysqli->connect_error;
      exit();
    }else{
      $mysqli->set_charset("utf8");

      $sql = "INSERT INTO title_name (id, title, name) VALUES (NULL, ?, ?)";
      if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param('ss', $title, $name);

        $stmt->execute();
        $stmt->close();
      }


      $sql = "SELECT id FROM title_name ORDER BY id DESC LIMIT 1";
      $result = $mysqli->query($sql);
      $row = $result->fetch_assoc();
      $id = $row['id'];

      $sql = "CREATE TABLE data".$row['id']."(
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        frontdata VARCHAR(256),
        backdata VARCHAR(256))";

      $mysqli->query($sql);

      for($i = 0; $i < count($frontdata); $i++){
        $sql = "INSERT INTO data".$row['id']." (id, frontdata, backdata) VALUES (NULL, ?, ?)";
        if($stmt = $mysqli->prepare($sql)){
          $stmt->bind_param('ss', $frontdata[$i], $backdata[$i]);

          $stmt->execute();
          $stmt->close();
        }
      }



    }

    $mysqli->close();
    /* ============== 登録情報をアラートで表示 ================ */
    print('<script>alert("id：'.$id.", タイトル：".$title.", 名前：".$name.'で登録しました");');
    print('location.href = \'./check.php?id='.$id.'\';</script>');


  }else{
    //不正なアクセス
    print('<script>alert("不正なアクセスです");');
    print('location.href = \'./index.php\';</script>');
  }


?>






</body>
</html>
