<?php
 $flists=file("school.txt");
 $lists=explode(",",$flists[0]);
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
		<form action="schoolCheck.php" method="post">
   <p><?php echo "ユーザ名:".$lists[0]; ?></p>
   <p><?php echo "パスワード:".$lists[1]; ?></p>
   <h5>こちらの内容でお間違えないですか</h5>
			<input type="submit" name="yes" value="はい">
  </form> 
  
  <form action="newSchool.php" method="post">
   <input type="submit" name"no" value="いいえ">
  </form>
</div>

  <div class="footer">
   <div class="footer-logo">過去問共有掲示板</div>
  </div>
	</body>

</html>