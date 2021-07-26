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
        <h1 class="display-1 text-center">複単語帳</h1>
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

    /*  ============== 作成ボタンを押した時の処理 ================ */
    /* フォームの値を受け取る                                     */


    $title = filter_input(INPUT_GET, 'title');
    $name = filter_input(INPUT_GET, 'name');

    //入力ミスcheck
    $inputmiss = false;

    //入力を表裏で単語ごとに分割
    $frontdata = array();
    $backdata = array();

    $inputformtype = filter_input(INPUT_GET, 'inputform');

    //form1の入力データ処理
    if(strcmp($inputformtype, "inputform1") == 0){
      $inputdata = filter_input(INPUT_GET, 'inputdata1');

      mb_regex_encoding('UTF-8');
      $inputdata = mb_ereg_replace("　", " ", $inputdata);
      $inputdata = mb_ereg_replace("\r\n", "\n", $inputdata);
      $inputdata = mb_ereg_replace("\r", "\n", $inputdata);

      $inputdatasplit = array();

      foreach(mb_split(" ",$inputdata) as $spacedata){
          foreach(mb_split("\n", $spacedata) as $word){
            if(strcmp($word, "\n") !== -1){
              $inputdatasplit[] = $word;
            }
          }
        }

      //空か奇数
      if(count($inputdatasplit) === 0 || count($inputdatasplit) % 2 === 1){
        $inputmiss = true;
      }else{

        $flg = true;
        foreach($inputdatasplit as $word){

          if($flg){
            $frontdata[] = $word;
          }else{
            $backdata[] = $word;
          }
          $flg = !$flg;
        }
      }

    //form2の入力データ処理
    }else if(strcmp($inputformtype, "inputform2") == 0){
      $inputdata1 = filter_input(INPUT_GET, 'inputdata21');
      $inputdata2 = filter_input(INPUT_GET, 'inputdata22');

      mb_regex_encoding('UTF-8');
      $inputdata1 = mb_ereg_replace("\r\n", "\n", $inputdata1);
      $inputdata1 = mb_ereg_replace("\r", "\n", $inputdata1);

      $inputdata2 = mb_ereg_replace("\r\n", "\n", $inputdata2);
      $inputdata2 = mb_ereg_replace("\r", "\n", $inputdata2);

      foreach(mb_split("\n",$inputdata1) as $linedata1){
        foreach(mb_split("\n", $linedata1) as $word){
          if(strcmp($word, "\n") !== -1){
            $frontdata[] = $word;
          }
        }
      }

      foreach(mb_split("\n",$inputdata2) as $linedata2){
        foreach(mb_split("\n", $linedata2) as $word){
          if(strcmp($word, "\n") !== -1){
            $backdata[] = $word;
          }
        }
      }

      //空か数が違う
      if(count($frontdata) === 0 || count($frontdata) !== count($backdata)){
        $inputmiss = true;
      }

    //フォーム3の入力データの処理
    }else{
      $inputdata = filter_input(INPUT_GET, 'inputdata3');

      mb_regex_encoding('UTF-8');
      $inputdata = mb_ereg_replace("\r\n", "\n", $inputdata);
      $inputdata = mb_ereg_replace("\r", "\n", $inputdata);

      $inputdatasplit = array();

      foreach(mb_split("\n",$inputdata) as $linedata){
        foreach(mb_split("\n", $linedata) as $word){
          if(strcmp($word, "\n") !== -1){
            $inputdatasplit[] = $word;
          }
        }
      }

      //空か奇数
      if(count($inputdatasplit) === 0 || count($inputdatasplit) % 2 === 1){
        $inputmiss = true;
      }else{

        $flg = true;
        foreach($inputdatasplit as $word){
          if($flg){
            $frontdata[] = $word;
          }else{
            $backdata[] = $word;
          }
          $flg = !$flg;
        }
      }

    }

  ?>



  <?php
    /*  ============== 作成ボタンを押した後の登録確認画面の作成 ================ */
    //入力ミスがなく、入力データあり
    if(!$inputmiss && count($frontdata) > 0 && count($backdata) > 0){
      print('<div class="container border border-5 rounded p-2">');
      print('<div class="row">');
      print('<h3 class="text-center col-md-12">作成データ確認</h3>');
      print('</div>');
      print('<div class="row">');
      print('<span class="col-md-12">タイトル</span>');
      print('</div>');
      print('<div class="row">');
      print('<div class="col-md-12">');
      print('<p class="border rounded p-2">'.$title.'</p>');
      print('</div>');
      print('</div>');
      print('<div class="row">');
      print('<span class="col-md-12">作成者</span>');
      print('</div>');
      print('<div class="row">');
      print('<div class="col-md-12">');
      print('<p class="border rounded p-2">'.$name.'</p>');
      print('</div>');
      print('</div>');
      print('<div class="row">');
      print('<div class="col-md-12">');
      print('<table class="table table-hover">');
      print('<thead>');
      print('<tr><th>表面</th><th>裏面</th></tr>');
      print('</thead>');
      print('<tbody>');
      for($i = 0; $i < count($frontdata); $i++){
        print('<tr><td>'.$frontdata[$i].'</td><td>'.$backdata[$i].'</td></tr>');
      }
      print('</tbody>');
      print('</table>');
      print('</div>');
      print('</div>');
      print('<div class="row">');
      print('<div class="col-md-12">');
      print('<p>これで登録してよければ登録ボタンを押してください</p>');
      print('</div>');
      print('</div>');
      print('<div class="row">');
      print('<div class="col-md-12">');
      print('<button class="btn btn-lg btn-outline-primary form-control" onclick="location.href=\'./register.php\'">登録</button>');
      print('</div>');
      print('</div>');
      print('<div class="row">');
      print('<div class="col-md-12">');
      print('<p>修正する場合は、下記のフォームの内容を修正し、作成ボタンを押してください</p>');
      print('</div>');
      print('</div>');


      print('</div>');

      $_SESSION['title'] = $title;
      $_SESSION['name'] = $name;
      $_SESSION['frontdata'] = $frontdata;
      $_SESSION['backdata'] = $backdata;


    }

   ?>



  <!--  ============== 単語帳作成画面の作成 ================ -->
  <div class="container border border-5 rounded p-2">
    <div class="row">
      <h3 class="text-center col-md-12">単語帳をつくる</h3>
    </div>

    <form method="GET" action="./index.php">

    <?php
    print('<div class="row">');
    print('<div class="form-group col-md-12">');
    if($title = filter_input(INPUT_GET, "title")){
      print('<label>タイトル</label><input type="text" class="form-control" name="title" value="'.$title.'" required="required">');
    }else{
      print('<label>タイトル</label><input type="text" class="form-control" name="title" required="required">');
    }
    print('</div>');
    print('</div>');
    print('<div class="row">');
    print('<div class="form-group col-md-12">');
    if($name = filter_input(INPUT_GET, "name")){
      print('<label>作成者</label><input type="text" class="form-control" name="name" value="'.$name.'" required="required">');
    }else{
      print('<label>作成者</label><input type="text" class="form-control" name="name" required="required">');
    }
    print('</div>');
    print('</div>');
    print('<br>');
    print('<div class="row">');
    print('<div class="col-md-12">');
    print('<h5>入力方法を以下の3つから選べます</h5>');
    print('</div>');
    print('</div>');
    print('<div class="row">');
    if(!$inputform = filter_input(INPUT_GET, "inputform")){
        $inputform = "inputform1";
    }
    print('<div class="col-md-4">');
    if(strcmp($inputform, "inputform1") == 0){
      print('<label><input type="radio" name="inputform" value="inputform1" onclick="inputformchange();" checked="checked" />表スペース裏</label>');
    }else{
      print('<label><input type="radio" name="inputform" value="inputform1" onclick="inputformchange();" />表スペース裏</label>');
    }
    print('</div>');
    print('<div class="col-md-4">');
    if(strcmp($inputform, "inputform2") == 0){
      print('<label><input type="radio" name="inputform" value="inputform2" onclick="inputformchange();" checked="checked" />表裏別々</label>');
    }else{
      print('<label><input type="radio" name="inputform" value="inputform2" onclick="inputformchange();" />表裏別々</label>');
    }
    print('</div>');
    print('<div class="col-md-4">');
    if(strcmp($inputform, "inputform3") == 0){
      print('<label><input type="radio" name="inputform" value="inputform3" onclick="inputformchange();" checked="checked" />表改行裏</label>');
    }else{
      print('<label><input type="radio" name="inputform" value="inputform3" onclick="inputformchange();" />表改行裏</label>');
    }
    print('</div>');
    print('</div>');

     ?>

      <div id="form1">
        <div class="row">
          <div class="col-md-12">
          <ul>
            <li>「表 裏」の形式で入力してください</li>
            <li>表と裏の間のスペースは半角でも全角でも大丈夫です</li>
            <li>「単語スペース単語スペース単語」と入力すると意図しない動作をする可能性があります</li>
          </ul>
        </div>
      </div>

      <?php
        print('<div class="row">');
        print('<div class="form-group col-md-12">');
        if($inputdata1 = filter_input(INPUT_GET, "inputdata1")){
          print('<textarea class="form-control" rows="30" name="inputdata1">'.$inputdata1.'</textarea>');
        }else{
          print('<textarea class="form-control" rows="30" name="inputdata1" placeholder="apple&nbsp;りんご&#010;banana&nbsp;バナナ"></textarea>');
        }
        print('</div>');
        print('</div>');
       ?>

    </div>

    <div id="form2">
      <div class="row">
        <div class="col-md-12">
          <ul>
            <li>表の内容と裏の内容を別々のエリアに改行しながら入力してください</li>
          </ul>
        </div>
      </div>

      <?php
        print('<div class="row">');
        print('<div class="form-group col-md-6">');
        if($inputdata21 = filter_input(INPUT_GET, "inputdata21")){
          print('<textarea class="form-control" rows="30" name="inputdata21">'.$inputdata21.'</textarea>');
        }else{
          print('<textarea class="form-control" rows="30" name="inputdata21" placeholder="apple&#010;banana"></textarea>');
        }
        print('</div>');
        print('<div class="form-group col-md-6">');

        if($inputdata22 = filter_input(INPUT_GET, "inputdata22")){
          print('<textarea class="form-control" rows="30" name="inputdata22">'.$inputdata22.'</textarea>');
        }else{
          print('<textarea class="form-control" rows="30" name="inputdata22" placeholder="りんご&#010;バナナ"></textarea>');
        }
        print('</div>');
        print('</div>');
       ?>

    </div>

    <div id="form3">
      <div class="row">
        <div class="col-md-12">
          <ul>
            <li>表と裏の内容を改行しながら入力してください</li>
          </ul>
        </div>
      </div>

      <?php
        print('<div class="row">');
        print('<div class="form-group col-md-12">');
        if($inputdata3 = filter_input(INPUT_GET, "inputdata3")){
          print('<textarea class="form-control" rows="30" name="inputdata3">'.$inputdata3.'</textarea>');
        }else{
          print('<textarea class="form-control" rows="30" name="inputdata3" placeholder="apple&#010;りんご&#010;banana&#010;バナナ"></textarea>');
        }
        print('</div>');
        print('</div>');
       ?>

    </div>

    <?php
      //入力データに誤があった場合
      if($inputmiss && $title){
        print('<div class="row">');
        print('<div class="form-group col-md-12">');
        print('<p class="p-3 mb-2 bg-danger text-white">入力されていないまたは表面と裏面の数が合いません</p>');
        print('</div>');
        print('</div>');
      }
     ?>
     <br>
     <div class="row">
       <div class="col-md-12">
         <button type="submit" class="btn btn-lg btn-outline-primary form-control">作成</button>
       </div>
     </div>
   </form>
  </div>


  <script src="form.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
</html>
