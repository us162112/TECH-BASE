<?php
 try{

		//mission3-1
		$dsn="データベース名"; //どのデータベースにアクセスするか
		$user="ユーザー名"; //データベースのユーザー
  $password="パスワード"; //パスワード
  $pdo= new PDO($dsn,$user,$password); //データベースにアクセスできるように準備する
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //mission3-3
  $sql='SHOW TABLES'; //テーブルを表示することを指定
  $results=$pdo->query($sql); //テーブルを取得
  $fp=fopen("table.txt","r");
  $schoolName=fgets($fp);
  $flag=0;
  foreach($results as $row){ //取得したテーブル名を1行ごとに表示
   if($row[0]==$schoolName){
    $flag=1;
   }
  }

  if(!$flag){
   //mission3-2
   $sql="CREATE TABLE ".$schoolName."のtable"
."("
."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date TEXT,"
."password TEXT"
.");"; //データベースにテーブルを作成
   $stmt=$pdo->query($sql); //実行後に結果に関する情報を得たい場合に記述。おまじない
  }

 }catch(PDOException $e){
  print $e->getMessage()."-".$e->getLine().PHP_EOL;
 }
?>



<?php
 try{

  if(!empty($_POST['edit'])&&!empty($_POST['pw_e'])&&!empty($_POST['sub_edit'])){  //編集
   $pwd=$_POST['pw_e'];
   $edit=$_POST['edit'];
   $flag=0;
   
   //mission3-6
   $sql='SELECT * FROM '.$schoolName; //テーブルの中からデータの取り出し
   $results=$pdo->query($sql); //データの情報の取得
   foreach($results as $row){ //1データずつ表示
    if($row['id']==$edit&&$row['password']==$pwd){
     $number=$row['id'];
     $name=$row['name'];
     $comment=$row['comment'];
     $pass=$row['password'];
     $flag=1;
    }
   }

   if($flag==0){
    echo "<script>alert('パスワードが違います');</script>";
   }
   $flag=0;
   echo "<hr>";
  }

 }catch(PDOException $e){
  print $e->getMessage()."-".$e->getLine().PHP_EOL;
 }
?>



<html>

	<head>
		<meta http-equiv="content-type" charset="utf-8">
  <title><?php $schoolName?></title>
  <link rel="stylesheet" href="mission.css">
	</head>

	<body>
  <div class="header">
			<div class="header-logo">過去問共有掲示板</div>
  </div>

<div class="medium">
		<form action="mission_6.php" method="post">

			<input type="text" name="name" value="<?php echo "$name";?>" placeholder="名前" size="10"><br>
			<input type="text" name="comment" value="<?php echo "$comment";?>" placeholder="コメント" size="50"><br>
   <input type="password" name="pw_c" placeholder="パスワードを設定してください。" value="<?php echo "$pass";?>" size="50">
			<input type="submit" name="sub_com" value="送信"><br>
   <input type="hidden" name="editmode" value="<?php echo "$number";?>" size="10"><br><br> <!--あとで隠す-->

			<input type="text" name="delete" placeholder="削除対象番号" size="10"><br>
   <input type="password" name="pw_d" placeholder="パスワードを入力してください。" size="50">
   <input type="submit" name="sub_del" value="削除"><br><br>

   <input type="text" name="edit" placeholder="編集対象番号" size="10"><br>
   <input type="password" name="pw_e" placeholder="パスワードを入力してください。" size="50">
   <input type="submit" name="sub_edit" value="編集"><br>
   
		</form>

<?php
//コメントを全件表示
 try{

  //mission3-6
  $sql='SELECT * FROM '.$schoolName; //テーブルの中からデータの取り出し
  $results=$pdo->query($sql); //データの情報の取得
  foreach($results as $row){ //1データずつ表示
   echo $row['id'].','.$row['name'].','.$row['comment'].','.$row['date'].$row['password'].'<br>';
  }
  echo "<hr>";

 }catch(PDOException $e){
  print $e->getMessage()."-".$e->getLine().PHP_EOL;
 }
?>

<?php

try{

 if(!empty($_POST['editmode'])){

  //mission3-7
  $id=$_POST['editmode']; //編集したい投稿番号
  $nm=$_POST['name']; //編集後の名前
  $kome=$_POST['comment']; //編集後のコメント
  $date=date("Y年m月d日 H時i分s秒");
  if(!empty($_POST['pw_c'])){
   $pwd=$_POST['pw_c'];
  }else{

   //mission3-6
   $sql='SELECT * FROM '.$schoolName; //テーブルの中からデータの取り出し
   $results=$pdo->query($sql); //データの情報の取得
   foreach($results as $row){ //1データずつ表示
    if($row['id']==$id){
					$pwd=$row['password'];
    }
   }
   echo "<hr>";
  }

  $sql="update ".$schoolName." set name='$nm', comment='$kome', date='$date', password='$pwd' where id=$id"; //編集結果を格納
  $result=$pdo->query($sql); //編集を適用

  //mission3-6
  $sql='SELECT * FROM '.$schoolName; //テーブルの中からデータの取り出し
  $results=$pdo->query($sql); //データの情報の取得
  foreach($results as $row){ //1データずつ表示
   echo $row['id'].','.$row['name'].','.$row['comment'].','.$row['date'].'<br>';
  }
  echo "<hr>";

 }else if(!empty($_POST['comment'])&&!empty($_POST['name'])&&!empty($_POST['sub_com'])){

  if(!empty($_POST['pw_c'])){

   //mission3-5
   $sql=$pdo->prepare("INSERT INTO ".$schoolName." (name,comment,date,password) VALUES (:name,:comment,:date,:pwd)"); //テーブルに格納する準備
   $name=$_POST['name']; //投稿者名
   $comment=$_POST['comment']; //投稿内容
   $date=date("Y年m月d日 H時i分s秒");
   $pwd=$_POST['pw_c']; //投稿パスワード
   $sql->bindParam(':name',$name,PDO::PARAM_STR); //bindParamはexecute()した時点で変数に値が入っていれば問題なく動くが、execute()後に変数が文字列になる
   $sql->bindParam(':comment',$comment,PDO::PARAM_STR); //bindValueはこの記述の時に既に変数に値が入っていなければならない。
   $sql->bindParam(':date',$date,PDO::PARAM_STR); //PDO::PARAM_ で変数の型を指定する。 INT=整数型 STR=文字列型
   $sql->bindParam(':pwd',$pwd,PDO::PARAM_STR); //bindした時の名前とVALUESで宣言した名前は一緒に
   $sql->execute(); //実行
   echo"<hr>";

   //mission3-6
   $sql='SELECT * FROM '.$schoolName; //テーブルの中からデータの取り出し
   $results=$pdo->query($sql); //データの情報の取得
   foreach($results as $row){ //1データずつ表示
    echo $row['id'].','.$row['name'].','.$row['comment'].','.$row['date'].'<br>';
   }
   echo "<hr>";

  }else{
   echo "<script>alert('パスワードを設定してください。');</script>";
  }

 }else if(!empty($_POST['delete'])&&!empty($_POST['pw_d'])&&!empty($_POST['sub_del'])){

  //mission3-8
  $id=$_POST['delete']; //削除したい投稿番号
  $pwd=$_POST['pw_d'];
  $flag=0;
  $sql='SELECT * FROM '.$schoolName; //テーブルの中からデータの取り出し
  $results=$pdo->query($sql); //データの情報の取得
  foreach($results as $row){ //1データずつ表示
   if($row['id']==$id&&$row['password']==$pwd){
    $del="delete from ".$schoolName." where id=$id"; //削除結果を格納
    $result=$pdo->query($del); //削除を適用
    $flag=1;
   }
  }

  if($flag==0){
   echo "<script>alert('パスワードが違います');</script>";
  }
  $flag=0;
  echo "<hr>";

  //mission3-6
  $sql='SELECT * FROM '.$schoolName; //テーブルの中からデータの取り出し
  $results=$pdo->query($sql); //データの情報の取得
  foreach($results as $row){ //1データずつ表示
   echo $row['id'].','.$row['name'].','.$row['comment'].','.$row['date'].'<br>';
  }
  echo "<hr>";

 }

}catch(PDOException $e){
 print $e->getMessage()."-".$e->getLine().PHP_EOL;
}
?>
</div>

  <div class="footer">
   <div class="footer-logo">過去問共有掲示板</div>
   <div class="footer-list">
    <a href="top.php">投稿を終了する</a>
   </div>
  </div>

	</body>

</html>

