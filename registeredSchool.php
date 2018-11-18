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
  $flag=0;
  foreach($results as $row){ //取得したテーブル名を1行ごとに表示
   if($row[0]=="account"){
    $flag=1;
   }
  }
  if(!$flag){
   //mission3-2
   $sql="CREATE TABLE school"
."("
."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
."name char(32),"
."date TEXT,"
."password TEXT"
.");"; //データベースにテーブルを作成
   $stmt=$pdo->query($sql); //実行後に結果に関する情報を得たい場合に記述。おまじない
  }
 }catch(PDOException $e){
  print $e->getMessage()."-".$e->getLine().PHP_EOL;
 }
?>

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
		<form action="registeredSchool.php" method="post">

			<select name="school">
				<option value="学校名を選んでください" selected="selected">学校名を選んでください</option>
				<?php
     $sql='SELECT * FROM school'; //テーブルの中からデータの取り出し
     $results=$pdo->query($sql); //データの情報の取得
					foreach($results as $row){
    ?>
						<option value="<?php echo "$row[1]";?>"><?php echo "$row[1]";?></option>
    <?php
					}
    ?>
   </select>
   <br>
			<input type="password" name="pwd" placeholder="パスワード"> <input type="submit" name="login" value="ログイン"><br>
			
   <hr>
   
		</form>

<?php
	try{
  $certification=0;
  if(!empty($_POST['login'])){
  	if($_POST['school']=="学校名を選んでください"){
  	 echo "<script>alert('学校名を選んでください');</script>";
  	}else if(empty($_POST['pwd'])){
 			echo "<script>alert('パスワードを入力してください');</script>";
 	 }else{

		  //mission3-6
    $sql='SELECT * FROM school'; //テーブルの中からデータの取り出し
    $results=$pdo->query($sql); //データの情報の取得
    foreach($results as $row){ //1データずつ表示
     if(($_POST['school']==$row[1])&&($_POST['pwd']==$row[3])){
				  $school=$_POST['school'];
      $certification=1;
     }
    }

    if(!$certification){
     echo "<script>alert('パスワードが違います');</script>";
    }else{
     echo "<script>alert('認証に成功しました');</script>";
			  $fp=fopen("table.txt","w");
					fwrite($fp,$school);
     fclose($fp);
	   }

   }

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

<?php
	if($certification){
		header("Location:mission_6.php");
		exit(1);
 }
?>
