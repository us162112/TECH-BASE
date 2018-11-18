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
	<body>
		<form action="cancel.php" method="post">

			<input type="text" name="name" placeholder="ユーザ名" size="10"><br>
   <input type="password" name="pwd" placeholder="パスワードを入力してください。" size="50">
   <input type="submit" name="del" value="削除"><br><br>
   <hr>
   
		</form>

<?php
 try{
 	//mission3-1
 	$dsn="データベース名"; //どのデータベースにアクセスするか
		$user="ユーザー名"; //データベースのユーザー
  $password="パスワード"; //パスワード
  $pdo= new PDO($dsn,$user,$password); //データベースにアクセスできるように準備する
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if(!empty($_POST['name'])&&!empty($_POST['pwd'])&&!empty($_POST['del'])){
   //mission3-6
   $sql='SELECT * FROM account'; //テーブルの中からデータの取り出し
   $results=$pdo->query($sql); //データの情報の取得
   $name=$_POST['name'];
   $pwd=$_POST['pwd'];
   $flag=0;
   foreach($results as $row){ //1データずつ表示
    if(($row['name']==$name)&&($row['password']==$pwd)){
     $del="delete from account where id=$row[0]"; //削除結果を格納
     $result=$pdo->query($del); //削除を適用
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
</div>

  <div class="footer">
   <div class="footer-logo">過去問共有掲示板</div>
  </div>
	</body>


</html>

