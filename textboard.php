<html>
<head>
<title>プログラミングブログ</title>
</head>
<body>
<h1>プログラミングブログ</h1>

<?php
//編集依頼された時
if ($_POST['edit1']){

	//上書きされたテキストファイルを呼び出す
	$filename3 = 'file.txt';
	$file3 = file($filename3);

	//削除したい投稿のパスワード（column3[4]）を取得
	foreach($file3 as $array3){
		$column3 = explode("<>",$array3);

		if($column3[0] == $_POST['edit1']){
			break;
		}
	}

	//確認用パスワードが編集したい投稿のパスワード（column3[4]）と一致した場合
	if(trim($_POST['edit_password1']) === trim($column3[4])){
		$edittext3 = $column3;

		$edit_mode3 = 1;//入力フォームを編集モードにする
		$edit_num3 = $_POST['edit1'];//編集したい投稿の投稿番号

	}else{
		$error = 1;//フォームの下に「!!パスワードが一致しません!!」と表示させるための処理
	}
}
?>

<!--入力フォーム-->
<form method="post" action="textboard.php">
	
	※記号「<>」は使用しないでください。<br/><br/>
	名前：<br/>
        <input type="name" name="name0" value="<?= $edittext3[1] ?>"><br/>
	コメント：<br/>
        <textarea cols="40" rows="10" name="comment0"><?= $edittext3[2] ?></textarea><br/>
	パスワード：<br/>
	<input type="name" name="password0" value="<?= $edittext3[4] ?>"><br/><br/>
	<input type="submit" name="send0" value="送信"><br/><br/><br/>

	<input type="submit" name="delete0" value="投稿を削除"><br/><br/>
	<input type="submit" name="edit0" value="投稿を編集">

	<input type="hidden" name="edit_mode0" value="<?= $edit_mode3 ?>">
	<input type="hidden" name="edit_num0" value="<?= $edit_num3 ?>">

</form>


<?php

if ($_POST['edit_mode0'] != 1){
	//名前とコメントが書き込まれた場合の、テキストファイルに書き込む処理 新規投稿
	if ($_POST['name0'] && $_POST['comment0'] && $_POST['password0'] && $_POST['send0']){

		//テキストファイルを呼び出す
		$filename1 = 'file.txt';
		$fp1 = fopen($filename1, 'a');

		//投稿番号の設定
		$file1 = file($filename1);
		$turn1 = count($file1);

		//名前の設定
		$name1 = $_POST['name0'];

		//コメントの設定
		$comment1 = $_POST['comment0'];

		//投稿時間の設定
		$time1 = date("Y/m/d H:i:s");

		//パスワードの設定
		$password1 = $_POST['password0'];

		//表示形式の設定
		$column1 = array($turn1+1, $name1, $comment1, $time1, $password1);

		//テキストファイルに書き込み
		fwrite($fp1, $column1[0]."<>".$column1[1]."<>".$column1[2]."<>".$column1[3]."<>".$column1[4]."<>\n");

		fclose($fp1);

	}elseif($_POST['delete0']){
?>
		<!--入力フォーム-->
		<form method="post" action="textboard.php">
		削除したい投稿の投稿番号：<br/>
		<input type="name" name="delete1"><br/>
		削除したい投稿のパスワード：<br/>
		<input type="name" name="delete_password1"><br/><br/>
		<input type="submit" value="送信"><br/>
		</form>
<?php
	
	}elseif($_POST['edit0']){
?>
		<!--入力フォーム-->
		<form method="post" action="textboard.php">
		編集したい投稿の投稿番号：<br/>
		<input type="name" name="edit1"><br/>
		編集したい投稿のパスワード：<br/>
		<input type="name" name="edit_password1"><br/><br/>
		<input type="submit" value="送信"><br/>
		</form>
<?php
	}
}



//削除依頼された時
if ($_POST['delete1'] && $_POST['delete_password1']){

	//上書きされたテキストファイルを呼び出す
	$filename2 = 'file.txt';
	$file2 = file($filename2);

	//削除したい投稿のパスワード（pre_column2[4]）を取得
	foreach($file2 as $pre_array2){
		$pre_column2 = explode("<>",$pre_array2);
		if($pre_column2[0] == $_POST['delete1']){
			$check2 = $pre_column2[4];
		}
	}

	//確認用パスワードが削除したい投稿のパスワードと一致した場合
	if(trim($_POST['delete_password1']) === trim($check2)){
		//削除指定された投稿だけ抜いてファイルを再保存
		$fp2 = fopen($filename2, 'w');
		$turn2=1;//投稿番号
		foreach($file2 as $key2 => $array2){
			$column2 = explode("<>", $array2);
			if ($_POST['delete1']-1 != $key2){
				fwrite($fp2, $turn2."<>".$column2[1]."<>".$column2[2]."<>".$column2[3]."<>".$column2[4]."<>\n");
				$turn2++;
			}
		}
		fclose($fp2);
	}else{
		$error = 1;
	}
}


//削除と編集でパスワードが一致しない場合の処理
if($error == 1){
	echo "!!パスワードが一致しません!!"."<br/><br/><br/>";
	$error = 0;
}


//編集した投稿をファイルに上書き
if($_POST['edit_mode0'] == 1){

	//上書きされたテキストファイルを呼び出す
	$filename5 = 'file.txt';
	$file5 = file($filename5);
	$fp5 = fopen($filename5, 'w');

	//名前の設定
	$name5 = $_POST['name0'];

	//コメントの設定
	$comment5 = $_POST['comment0'];

	//投稿時間の設定
	$time5 = date("Y/m/d H:i:s");

	//パスワードの設定
	$password5 = $_POST['password0'];

	//編集指定された投稿だけ書き換えてファイルを再保存
	foreach($file5 as $array5){
		$column5 = explode("<>", $array5);

		if ($_POST['edit_num0'] != $column5[0]){//呼び出した投稿番号が編集番号と違う場合
			fwrite($fp5, $column5[0]."<>".$column5[1]."<>".$column5[2]."<>".$column5[3]."<>".$column5[4]."<>\n");//既存の投稿をファイルに入れる
		}else{//呼び出した投稿番号が編集番号と同じ場合
			fwrite($fp5, $column5[0]."<>".$name5."<>".$comment5."<>".$time5."<>".$password5."<>\n");//編集した投稿をファイルに入れる
		}
	}
	fclose($fp5);
	$edit_mode3 = 0;//入力フォームを新規投稿モードに直す
}


//掲示板の表示
//上書きされたテキストファイルを呼び出す
$filename4 = 'file.txt';
$fp4 = fopen($filename4, 'a');
$file4 = file($filename4);

//掲示板の表示
foreach($file4 as $array4){
	$column4 = explode("<>" ,$array4);
	echo $column4[0]."：".$column4[1]."<br/>".$column4[2]."<br/>".$column4[3]."<br/><br/>";
}

fclose($fp4);
?>
</body>
</html>