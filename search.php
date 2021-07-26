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

        <?php
          //このページは検索結果ページなので、ここだけ検索欄の値を保持したままにする
          if($title = filter_input(INPUT_GET, 'title')){
            print('<input type="search" class="col-md-5" name="title" value="'.$title.'">');
          }else{
            print('<input type="search" class="col-md-5" name="title" placeholder="タイトル名を入力">');
          }
          if($name = filter_input(INPUT_GET, 'name')){
            print('<input type="search" class="col-md-5" name="name" value="'.$name.'">');
          }else{
            print('<input type="search" class="col-md-5" name="name" placeholder="作成者名を入力">');
          }
        ?>
        <button type="submit" class="col-md-2 btn btn-outline-primary">検索</button>
      </div>
    </form>
  </div>

  <br>

  <?php
    /* ============== SQLを使用し検索ワードを検索 ================ */
    /* ============== 検索結果を表示 ================ */
    $title = "";
    $name = "";
    if(!$title = filter_input(INPUT_GET, 'title')){
      $title = "%";
    }
    if(!$name = filter_input(INPUT_GET, 'name')){
      $name = "%";
    }

    $mysqli = new mysqli('mysql153.phy.lolipop.lan', 'LAA1321771', 'Soccer3639', 'LAA1321771-wordnote');
    if($mysqli->connect_error){
      echo $mysqli->connect_error;
      exit();
    }else{

      $mysqli->set_charset("utf8");

      $sql = "SELECT * FROM title_name WHERE title LIKE ? AND name LIKE ?";
      
      if($stmt = $mysqli->prepare($sql)){
        $titlep = "%".$title."%";
        $namep = "%".$name."%";
        $stmt->bind_param("ss", $titlep, $namep);
        $stmt->execute();

        print('<div class="container-fluid">');
        print('<form method="GET" action="./check.php">');
        print('<div class="row">');
        $mysqli2 = new mysqli('mysql153.phy.lolipop.lan', 'LAA1321771', 'Soccer3639', 'LAA1321771-wordnote');
        $stmt->bind_result($id, $t, $n);
        while($stmt->fetch()){
          print('<div class="border border-3 rounded p-2 col-md-3">');
          print('<div class="row">');
          print('<span class="col-md-12">id</span>');
          print('</div>');
          print('<div class="row">');
          print('<div class="col-md-12">');
          print('<p class="border rounded p-2">'.$id.'</p>');
          print('</div>');
          print('</div>');
          print('<div class="row">');
          print('<span class="col-md-12">タイトル</span>');
          print('</div>');
          print('<div class="row">');
          print('<div class="col-md-12">');
          print('<p class="border rounded p-2">'.$t.'</p>');
          print('</div>');
          print('</div>');
          print('<div class="row">');
          print('<span class="col-md-12">作成者</span>');
          print('</div>');
          print('<div class="row">');
          print('<div class="col-md-12">');
          print('<p class="border rounded p-2">'.$n.'</p>');
          print('</div>');
          print('</div>');
          print('<div class="row">');
          print('<div class="col-md-12">');
          print('<input type="button" class="btn btn-lg btn-outline-primary form-control" value="詳しく見る/閉じる" onclick="tableswitch('.$id.')"/></button>');
          print('</div>');
          print('</div>');
          print('<div class="row">');
          print('<div class="col-md-12">');
          print('<div id="table'.$id.'">');
          print('<table class="table table-hover">');
          print('<thead  ">');
          print('<tr><th>表面</th><th>裏面</th></tr>');
          print('</thead>');
          print('<tbody>');
          $sql = "SELECT * FROM data".$id;
          $result = $mysqli2->query($sql);

          while($row = $result->fetch_assoc()){
            print('<tr><td>'.$row["frontdata"].'</td><td>'.$row["backdata"].'</td></tr>');
          }
          $result->close();
          print('</tbody>');
          print('</table>');
          print('</div>');
          print('</div>');
          print('</div>');
          print('<div class="row">');
          print('<div class="col-md-12">');
          print('<br>');
          print('<button type="submit" class="btn btn-lg btn-outline-primary form-control" name="id" value='.$id.'>これに決定</button><br>');
          print('</div>');
          print('</div>');

          print('</div>');
        }
        $mysqli2->close();
        $stmt->close();

        print('</div>');
        print("</form>");
        print('</div>');

      }

      $mysqli->close();
    }



  ?>

  <script src="search.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
