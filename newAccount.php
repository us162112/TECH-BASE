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
		<form action="newAccount.php" method="post">
   <p>ユーザ名	<input type="text" name="name" placeholder="ユーザ名"></p>
   <p>パスワード	<input type="password" name="pwd" placeholder="パスワード"></p>
   <p>パスワードの再確認	<input type="password" name="judge" placeholder="再度入力してください"></p>
			<input type="submit" name="subAc" value="送信"><br>
		</form>
  
<?php
 if(!empty($_POST['subAc'])){
	 if(empty($_POST['name'])){
		 echo "<script>alert('ユーザ名を入力してください');</script>";
	 }else if(empty($_POST['pwd'])){
		 echo "<script>alert('パスワードを入力してください');</script>";
	 }else if(empty($_POST['judge'])){
	 	echo "<script>alert('確認用のパスワードを入力してください');</script>";
	 }else if($_POST['pwd']!=$_POST['judge']){
	 	echo "<script>alert('入力されたパスワードが異なっています');</script>";
	 }else{
			try{
  	 $name=$_POST['name'];
				$pwd=$_POST['pwd'];
   	$judge=$_POST['judge'];
    $fp=fopen("junk.txt","w");
    fwrite($fp,$name.",".$pwd);
    fclose($fp);
    header("Location:checkAccount.php");
    exit();
   }catch(PDOException $e){
    print $e->getMessage()."-".$e->getLine().PHP_EOL;
   }
	 }
 }
?>
</div>

  <div class="footer">
   <div class="footer-logo">過去問共有掲示板</div>
  </div>
	</body>

</html>

