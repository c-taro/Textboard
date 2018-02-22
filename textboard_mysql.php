<html>
<head>
<title>プログラミングブログ</title>
</head>
<body>
<h1>プログラミングブログ</h1>




<?php
	header("Content-type: text/html; charset=utf-8");

try{
	/* MySQL データベースに接続する */
	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$pass = 'パスワード';
	$pdo = new PDO($dsn,$user,$pass,array(PDO::ATTR_EMULATE_PREPARES=>false));
	
	// SQL作成	
	$sql = 'CREATE TABLE table_name(id INT AUTO_INCREMENT NOT NULL PRIMARY KEY, name VARCHAR(15), comment TEXT, time DATETIME, password char(16))engine=innodb default charset=utf8';
	//SQL実行
	$stmt = $pdo->query($sql);
}catch(PDOException $e){
	echo "接続失敗しました。<br />";
	echo $e->getMessage();
	die();
}




//投稿を編集したい時
if ($_POST['edit_id1'] && $_POST['edit_password1']){


	$edit_password3 = mysql_real_escape_string($_POST['edit_password1']);
	$edit_id3 = mysql_real_escape_string($_POST['edit_id1']);
	

	$sql = "SELECT * FROM table_name WHERE id='$edit_id3' && password='$edit_password3';";
	$stmt = $pdo->query($sql);

	//編集したい投稿のパスワードを取得
	foreach($stmt as $array3){
		if($array3[id] == $edit_id3){
			break;
		}
	}

	//確認用パスワードが編集したい投稿のパスワードと一致した場合
	if(trim($edit_password3) === trim($array3['password'])){
		$edit_mode3 = 1;//入力フォームを編集モードにする
	}else{
		$error = 1;//フォームの下に「!!パスワードが一致しません!!」と表示させるための処理
	}
}elseif($_POST['send_edit1']){
	$error = 2;//フォームの下に「!!入力漏れがあります!!」と表示させるための処理
}
?>




<!--入力フォーム-->
<form method="post" action="textboard_mysql.php">

	名前：<br/>
        <input type="name" name="name0" value="<?= $array3['name'] ?>"><br/>
	コメント：<br/>
        <textarea cols="40" rows="10" name="comment0"><?= $array3['comment'] ?></textarea><br/>
	パスワード：<br/>
	<input type="name" name="password0" value="<?= $array3['password'] ?>"><br/><br/>
	<input type="submit" name="send0" value="送信"><br/><br/><br/>

	<input type="submit" name="delete0" value="投稿を削除"><br/><br/>
	<input type="submit" name="edit0" value="投稿を編集">

	<input type="hidden" name="edit_mode0" value="<?= $edit_mode3 ?>">
	<input type="hidden" name="edit_id0" value="<?= $edit_id3 ?>">

</form>




<?php

if ($_POST['edit_mode0'] != 1){

	//名前、コメント、パスワードが送信された場合の、テキストファイルに書き込む処理 新規投稿
	if ($_POST['name0'] && $_POST['comment0'] && $_POST['password0'] && $_POST['send0']){

		//名前の設定
		$name = $_POST['name0'];

		//コメントの設定
		$comment = $_POST['comment0'];

		//投稿時間の設定
		$date = date('Y/m/d H:i:s');

		//パスワードの設定
		$password = $_POST['password0'];

		//mysqlデータベースのテーブルにデータ挿入
		$stmt = $pdo->query('SET NAMES utf8');
		$sql = $pdo->prepare("INSERT INTO table_name(name,comment,time,password) VALUES(:name,:comment,:time,:password);");
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
		$sql->bindParam(':time',$date,PDO::PARAM_STR);
		$sql->bindParam(':password',$password,PDO::PARAM_STR);
		$sql->execute();

	}elseif($_POST['delete0']){
?>
		<!--入力フォーム-->
		<form method="post" action="textboard_mysql.php">
		削除したい投稿の投稿番号：<br/>
		<input type="name" name="delete_id1"><br/>
		削除したい投稿のパスワード：<br/>
		<input type="name" name="delete_password1"><br/><br/>
		<input type="submit" name="send_delete1" value="送信"><br/>
		</form>
<?php
	
	}elseif($_POST['edit0']){
?>
		<!--入力フォーム-->
		<form method="post" action="textboard_mysql.php">
		編集したい投稿の投稿番号：<br/>
		<input type="name" name="edit_id1"><br/>
		編集したい投稿のパスワード：<br/>
		<input type="name" name="edit_password1"><br/><br/>
		<input type="submit" name="send_edit1" value="送信"><br/>
		</form>
<?php
	}elseif($_POST['send0']){
		$error = 2;//フォームの下に「!!入力漏れがあります!!」と表示させるための処理
	}
}




//投稿を削除したい時の、パスワードの確認と削除するかの確認
if ($_POST['delete_id1'] && $_POST['delete_password1']){

	$delete_id2 = $_POST['delete_id1'];
	$delete_password2 = $_POST['delete_password1'];

	$sql = "SELECT * FROM table_name WHERE id = :delete_id2 && password = :delete_password2";
	$stmt = $pdo->prepare($sql);
	$stmt -> bindParam(":delete_id2",$delete_id2,PDO::PARAM_STR);
	$stmt -> bindParam(":delete_password2",$delete_password2,PDO::PARAM_STR);	
	$stmt -> execute();

	//削除したい投稿（pre_column2）を取得
	foreach($stmt as $pre_array2){
		$pre_column2 = $pre_array2;
		if($pre_column2['id'] == $delete_id2){
			$check2 = $pre_column2;
		}
	}

	//確認用パスワードが削除したい投稿のパスワードと一致した場合
	if(trim($delete_password2) === trim($check2['password'])){

		//削除するかの確認
		echo $check2['id']."：".$check2['name']."<br/>".$check2['comment']."<br/>".$check2['time']."<br/><br/>";
?>
		<form method="post">
		この投稿を本当に削除しますか？<br/>
		<input type="submit" name="yes2" value="はい">
		<input type="submit" value="いいえ">
		<input type="hidden" name="delete_id2_2" value="<?= $delete_id2 ?>">
		<input type="hidden" name="delete_password2_2" value="<?= $delete_password2 ?>">

		</form>
<?php
	}else{
		$error = 1;
	}
}elseif($_POST['send_delete1']){
	$error = 2;//フォームの下に「!!入力漏れがあります!!」と表示させるための処理
}

//投稿の削除
if($_POST['yes2']){

	$delete_id2_3 = $_POST['delete_id2_2'];
	$delete_password2_3 = $_POST['delete_password2_2'];

	$sql = "DELETE FROM table_name WHERE id = '$delete_id2_3'";
	$stmt = $pdo -> query($sql);

}




//削除あるいは編集でパスワードが一致しない場合
if($error == 1){
	echo "!!パスワードが一致しません!!"."<br/><br/><br/>";
	$error = 0;
}
//新規投稿、削除、編集で入力漏れがある場合
if($error == 2){
	echo "!!入力漏れがあります!!"."<br/><br/><br/>";
	$error = 0;
}




//編集した投稿をファイルに上書き
if($_POST['edit_mode0'] == 1){

	$edit_id5 = $_POST['edit_id0'];

	//名前の設定
	$name5 = $_POST['name0'];

	//コメントの設定
	$comment5 = $_POST['comment0'];

	//投稿時間の設定
	$time5 = date("Y/m/d H:i:s");

	//パスワードの設定
	$password5 = $_POST['password0'];

	$sql = "UPDATE table_name SET name = '$name5' ,comment = '$comment5',password = '$password5' WHERE id = '$edit_id5';"; 
	$stmt = $pdo->query($sql);

	$edit_mode3 = 0;//入力フォームを新規投稿モードに直す
}




//掲示板の表示
//上書きされたテキストファイルを呼び出す
$sql = 'SELECT * FROM table_name';
$stmt = $pdo->query($sql);

//掲示板の表示
foreach($stmt as $row){
	echo "<hr>".$row['id']."：".$row['name']."<br />".$row['comment']."<br/>".$row['time']."<br /><br/>";
}

//接続を終わらせる
$pdo = null;

?>
</body>
</html>