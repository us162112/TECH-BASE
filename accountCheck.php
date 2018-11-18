<html>

	<head>
		<meta http-equiv="content-type" charset="utf-8">
  <title>過去問共有掲示板</title>
  <link rel="stylesheet" href="stylesheet.css">
 </head>

	<body>
  <div class="header">
			<div class="header-logo">過去問共有掲示板</div>
  </div>
  
<div class="medium">
<?php

			try{
    $fp=fopen("junk.txt","r");
    $data=fgets($fp);
    $lists=explode(',',$data);
    $name=$lists[0];
    $pwd=$lists[1];
  		//mission3-1
  		$dsn="データベース名"; //どのデータベースにアクセスするか
  		$user="ユーザー名"; //データベースのユーザー
    $password="パスワード"; //パスワード
    $pdo= new PDO($dsn,$user,$password); //データベースにアクセスできるように準備する
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    //mission3-3
    $sql='SHOW TABLES'; //テーブルを表示することを指定
    $results=$pdo->query($sql); //テーブルを取得
    $flag=0;
    foreach($results as $row){ //取得したテーブル名を1行ごとに表示
     if($row[0]=="account"){
      $flag=1;
     }
    }

    if(!$flag){
     //mission3-2
     $sql="CREATE TABLE account"
."("
."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
."name char(32),"
."date TEXT,"
."password TEXT"
.");"; //データベースにテーブルを作成
     $stmt=$pdo->query($sql); //実行後に結果に関する情報を得たい場合に記述。おまじない
    }

    //アカウントの照合
    //mission3-6
    $sql='SELECT * FROM account'; //テーブルの中からデータの取り出し
    $results=$pdo->query($sql); //データの情報の取得
    $flag=1;
    foreach($results as $row){ //1データずつ表示
			  if($row['name']==$name){
      $flag=0;
						//echo "<script>alert('このユーザ名は既に使用されています');</script>";
      header("Location:accountUserExist.php");
      exit();
  
     }else if($row['password']==$pwd){
      $flag=0;
					 //echo "<script>alert('このパスワードは既に使用されています');</script>";
      header("Location:accountPasswordExist.php");
      exit();
     }
    }

    if($flag){
		   //mission3-5
     $sql=$pdo->prepare("INSERT INTO account (name,date,password) VALUES (:name,:date,:pwd)"); //テーブルに格納する準備
     $date=date("Y年m月d日 H時i分s秒");
     $sql->bindParam(':name',$name,PDO::PARAM_STR); //bindParamはexecute()した時点で変数に値が入っていれば問題なく動くが、execute()後に変数が文字列になる
     //bindValueはこの記述の時に既に変数に値が入っていなければならない。
     $sql->bindParam(':date',$date,PDO::PARAM_STR); //PDO::PARAM_ で変数の型を指定する。 INT=整数型 STR=文字列型
     $sql->bindParam(':pwd',$pwd,PDO::PARAM_STR); //bindした時の名前とVALUESで宣言した名前は一緒に
     $sql->execute(); //実行
     //echo "<script>alert('登録が完了しました!!');</script>";
     header("Location:accountCompletion.php");
     exit();
    }
   }catch(PDOException $e){
    print $e->getMessage()."-".$e->getLine().PHP_EOL;
   }
?>
</div>

  <div class="footer">
   <div class="footer-logo">過去問共有掲示板</div>
  </div>
	</body>

</html>
