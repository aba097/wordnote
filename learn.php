<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="./learn.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <title>複単語帳</title>
</head>
<body>
<?php

  /* ============== 学習画面を表示 ================ */
  /* ============== 何問目かをGETで保持し、問題ごとにページ遷移 ================ */

  if(session_status() == PHP_SESSION_ACTIVE){
    $idx = $_SESSION['idx'];
    $frontdata = $_SESSION['frontdata'];
    $backdata = $_SESSION['backdata'];

    $now = filter_input(INPUT_GET, 'now');
    if(!$now || $now < 0 || $now >= count($idx)){
      $now = 0;
    }


    print('<div class="container-fluid">');
    print('<div class="parent">');
    print('<div class="row">');
    print('<div class="col-md-12">');
    /* ============== 単語はnone←→blockを切り替えて表示 ================ */
    print('<div id="front" onclick="change();">');
    print('<div class="pt-5 pb-5 display-1 d-flex justify-content-center word">'.$frontdata[$idx[$now]].'</div>');
    print('</div>');
    print('</div>');
    print('</div>');

    print('<div class="row">');
    print('<div class="col-md-12">');
    /* ============== 単語はnone←→blockを切り替えて表示 ================ */
    print('<div id="back" onclick="change();">');
    print('<div class="bg-light pt-5 pb-5 display-1 d-flex justify-content-center word">'.$backdata[$idx[$now]].'</div>');
    print('</div>');
    print('</div>');
    print('</div>');

    /* ============== 何問目かの情報をGETで渡す ================ */
    print('<div class="row">');
    if($now !== 0){
      print('<div class="col-md-6">');
      print('<button class="btn btn-lg btn-outline-primary form-control" onclick="location.href=\'./learn.php?now='.($now - 1).'\'">前へ</button>');
      print('</div>');
    }

    if($now != (count($idx) - 1)){
      if($now === 0){
        print('<div class="col-md-12">');
        print('<button class="btn btn-lg btn-outline-primary form-control" onclick="location.href=\'./learn.php?now='.($now + 1).'\'">次へ</button>');
        print('</div>');
      }else{
        print('<div class="col-md-6">');
        print('<button class="btn btn-lg btn-outline-primary form-control" onclick="location.href=\'./learn.php?now='.($now + 1).'\'">次へ</button>');
        print('</div>');
      }

    }

    if($now == (count($idx) - 1)){
      print('<div class="col-md-6">');
      print('<button class="btn btn-lg btn-outline-primary form-control" onclick="location.href=\'./learn.php?now=0\'">最初へ</button>');
      print('</div>');
    }

    print('</div>');

    print('<div class="row">');
    print('<div class="col-md-12">');
    print('<button class="btn btn-lg btn-outline-primary form-control" onclick="location.href=\'./index.php\'">終了</button>');
    print('</div>');
    print('</div>');

    print('</div>');
    print('</div>');

  }

?>

  <script src="learn.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
