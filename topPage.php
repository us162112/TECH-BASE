<html>

	<head>
		<meta http-equiv="content-type" charset="utf-8">
  <title>過去問共有掲示板</title>
  <link rel="stylesheet" href="topPage.css"> 
	</head>

	<body>
  <div class="header">
			<div class="header-logo">過去問共有掲示板</div>
  </div>

  <div class="medium">
   <div class="login">
			<form action="topPage.php" method="post">
				<input type="text" name="name" placeholder="ユーザ名"><br>
				<input type="password" name="pwd" placeholder="パスワード"><br>
				<input type="submit" name="login" value="ログイン">
			</form>
   </div>

   <div class="new">
			<form action="newAccount.php" method="post">
   	<input type="submit" name="makeAccount" value="新規登録"><br>
			</form>
   </div>
  </div>
  
  <div class="footer">
   <div class="footer-logo">過去問共有掲示板</div>
   <div class="footer-list">
				<ul>
     <li><a href="cancel.php">退会される方はこちら</a></li>
     <li></li>
    </ul>
   </div>
  </div>
	</body>

</html>

<?php
 if(!empty($_POST['login'])){
 	if(empty($_POST['name'])){
		 echo "<script>alert('ユーザ名を入力してください');</script>"; //ダイアログで出力
  }else if(empty($_POST['pwd'])){
   echo "<script>alert('パスワードを入力してください');</script>";
  }else{
   try{
   	$name=$_POST['name'];
	 		$pwd=$_POST['pwd'];
    $fp=fopen("login.txt","w");
    fwrite($fp,$name.",".$pwd);
    fclose($fp);
    header("Location:login.php");
    exit();
   }catch(PDOException $e){
    print $e->getMessage()."-".$e->getLine().PHP_EOL;
   }
	 }
 }
?>
