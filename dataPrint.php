<?php
	try{
		//mission3-1
		$dsn="データベース名"; //どのデータベースにアクセスするか
		$user="ユーザー名"; //データベースのユーザー
  $password="パスワード"; //パスワード
  $pdo= new PDO($dsn,$user,$password); //データベースにアクセスできるように準備する
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
		<form action="dataPrint.php" method="post">

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
			<input type="password" name="pwd" placeholder="パスワード"> <input type="submit" name="print" value="表示"><br>
			
   <hr>
   
		</form>

<?php
 try{
  $school=$_POST['school'];
 //mission3-6
  $sql='SELECT * FROM '.$school; //テーブルの中からデータの取り出し
  $results=$pdo->query($sql); //データの情報の取得
  foreach($results as $row){ //1データずつ表示
   echo $row['id'].','.$row['name'].','.$row['comment'].','.$row['date'].$row['password'].'<br>';
  }
  echo "<hr>";

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


