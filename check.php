<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <title>複単語帳</title>
</head>
<body>
  <!-- ============== タイトルと検索欄 ================ -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-1 text-center" onclick="location.href='./index.php'">複単語帳</h1>
      </div>
    </div>
    <form method="GET" action="./search.php">
      <div class="row">
        <input type="search" class="col-md-5" name="title" placeholder="タイトル名を入力">
        <input type="search" class="col-md-5" name="name" placeholder="作成者名を入力">
        <button type="submit" class="col-md-2 btn btn-outline-primary">検索</button>
      </div>
    </form>
  </div>

  <br>

  <?php
    /* ============== DBから、選択されたidのテーブルをデータをとってくる ================ */
    $talbe_id = 0;

    $idx = array();
    $frontdata = array();
    $backdata = array();

    if(!$table_id = filter_input(INPUT_GET, 'id')){
      //不正アクセスalertでとばす
      print('<script>alert("不正なアクセスです");');
      print('location.href = \'./index.php\';</script>');
      exit();
    }


    $mysqli = new mysqli('mysql153.phy.lolipop.lan', 'LAA1321771', 'Soccer3639', 'LAA1321771-wordnote');
    if($mysqli->connect_error){
      echo $mysqli->connect_error;
      exit();
    }else{

      $mysqli->set_charset("utf8");

      $sql = "SELECT * FROM data".$table_id;
      $result = $mysqli->query($sql);

      $cnt = 0;
      while($row = $result->fetch_assoc()){
        $idx[] = $cnt;
        $cnt++;
        $frontdata[] = $row["frontdata"];
        $backdata[] = $row["backdata"];

      }
      $result->close();
      $mysqli->close();
    }

    /* ============== 改めて単語帳の内容表示 ================ */
    /* ============== 押しやすいように上下にスタートボタン配置 ================ */

    print('<div class="container-fluid">');
    print('<div class="row">');
    print('<div class="col-md-12">');
    print('<button class="btn btn-lg btn-outline-primary form-control" onclick="location.href=\'./learn.php?now=0\'">スタート</button>');
    print('</div>');
    print('</div>');
    print('<div class="row">');
    print('<div class="col-md-12">');
    print('<table class="table table-hover">');
    print('<tr><th>表面</th><th>裏面</th></tr>');

    for($i = 0; $i < count($frontdata); $i++){
      print('<tr><td>'.$frontdata[$i].'</td><td>'.$backdata[$i].'</td></tr>');
    }

    print('</table>');
    print('</div>');
    print('</div>');

    shuffle($idx);

    $_SESSION['idx'] = $idx;
    $_SESSION['frontdata'] = $frontdata;
    $_SESSION['backdata'] = $backdata;
    print('<div class="row">');
    print('<div class="col-md-12">');
    print('<button class="btn btn-lg btn-outline-primary form-control" onclick="location.href=\'./learn.php?now=0\'">スタート</button>');
    print('</div>');
    print('</div>');

    print('</div>');
   ?>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
